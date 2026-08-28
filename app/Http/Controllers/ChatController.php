<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $allMessages = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        if ($allMessages->isEmpty()) {
            return view('chat.index', ['conversations' => []]);
        }

        $lastMessageByContact = [];
        foreach ($allMessages as $msg) {
            $contactId = $msg->sender_id === $user->id ? $msg->receiver_id : $msg->sender_id;
            if (!isset($lastMessageByContact[$contactId])) {
                $lastMessageByContact[$contactId] = $msg;
            }
        }

        $contactIds = array_keys($lastMessageByContact);

        $contacts = User::whereIn('id', $contactIds)->get()->keyBy('id');

        $unreadCounts = Message::where('receiver_id', $user->id)
            ->where('read', false)
            ->whereIn('sender_id', $contactIds)
            ->selectRaw('sender_id, count(*) as count')
            ->groupBy('sender_id')
            ->pluck('count', 'sender_id');

        $conversations = [];
        foreach ($lastMessageByContact as $contactId => $lastMessage) {
            $contact = $contacts->get($contactId);
            if (!$contact) continue;

            $conversations[] = [
                'contact'     => $contact,
                'lastMessage' => $lastMessage,
                'unreadCount' => $unreadCounts->get($contactId, 0),
            ];
        }

        return view('chat.index', compact('conversations'));
    }

    public function open($id)
    {
        $contact = User::findOrFail($id);
        $user    = auth()->user();

        Message::where('sender_id', $contact->id)
            ->where('receiver_id', $user->id)
            ->where('read', false)
            ->update(['read' => true]);

        $messages = Message::where(function ($q) use ($user, $contact) {
                $q->where('sender_id', $user->id)->where('receiver_id', $contact->id);
            })->orWhere(function ($q) use ($user, $contact) {
                $q->where('sender_id', $contact->id)->where('receiver_id', $user->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chat.conversation', compact('contact', 'user', 'messages'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'body'        => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'body'        => $request->body,
            'read'        => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id'         => $message->id,
                'body'       => $message->body,
                'created_at' => $message->created_at->format('H:i'),
                'is_mine'    => true,
            ]
        ]);
    }

    public function deleteMessage($id)
    {
        $message = Message::findOrFail($id);

        if ($message->sender_id !== auth()->id()) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
        }

        $message->delete();

        return response()->json(['success' => true]);
    }

    public function deleteConversation($id)
    {
        $user = auth()->user();

        Message::where(function ($q) use ($user, $id) {
                $q->where('sender_id', $user->id)->where('receiver_id', $id);
            })->orWhere(function ($q) use ($user, $id) {
                $q->where('sender_id', $id)->where('receiver_id', $user->id);
            })
            ->delete();

        return response()->json(['success' => true]);
    }

    public function unreadCheck($id)
    {
        $allRead = Message::where('sender_id', auth()->id())
            ->where('receiver_id', $id)
            ->where('read', false)
            ->count() === 0;

        return response()->json(['all_read' => $allRead]);
    }
}