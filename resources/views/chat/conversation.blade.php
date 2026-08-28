@extends('layouts.app-auth')
@section('title', 'Chat with ' . $contact->name)

@section('content')
<div style="max-width:700px; margin:0 auto; padding:24px 16px;">

    <a href="{{ route('chat.index') }}"
        style="display:inline-flex; align-items:center; gap:8px; color:#8696a0; text-decoration:none; font-size:14px; margin-bottom:16px;"
        onmouseover="this.style.color='white'" onmouseout="this.style.color='#8696a0'">
        <i class="fa-solid fa-arrow-left"></i> Back to Messages
    </a>

    <div style="background:#1f2c34; border-radius:20px; overflow:hidden; border:1px solid #2a3942;">

        <!-- Header -->
        <div style="padding:14px 18px; border-bottom:1px solid #2a3942; display:flex; align-items:center; gap:12px; background:#182028;">
            @if($contact->avatar)
                <img src="{{ asset('storage/' . $contact->avatar) }}"
                     style="width:42px; height:42px; border-radius:50%; object-fit:cover; border:2px solid #2a3942; flex-shrink:0;">
            @else
                <div style="width:42px; height:42px; border-radius:50%; background:#720e9e; display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:15px; flex-shrink:0;">
                    {{ strtoupper(substr($contact->name, 0, 1)) }}
                </div>
            @endif
            <div style="flex:1;">
                <p style="color:white; font-weight:700; font-size:15px; margin:0;">{{ $contact->name }}</p>
                <p style="color:#22c55e; font-size:12px; margin:2px 0 0;">
                    <i class="fa-solid fa-circle" style="font-size:7px; margin-right:4px;"></i> Online
                </p>
            </div>
            <a href="{{ route('profile.view', $contact->id) }}"
               style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); color:#d1d7db; font-size:13px; padding:7px 14px; border-radius:999px; text-decoration:none; flex-shrink:0;">
                <i class="fa-solid fa-user" style="margin-right:5px;"></i> Profile
            </a>
        </div>

        <!-- Messages -->
        <div id="messagesArea" style="height:460px; overflow-y:auto; padding:16px; display:flex; flex-direction:column; gap:8px; background:#0d1117;">

            @if($messages->isEmpty())
                <div id="emptyState" style="text-align:center; margin:auto;">
                    <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:999px; padding:10px 20px;">
                        <span style="color:#8696a0; font-size:13px;">Start a conversation with <strong style="color:white;">{{ $contact->name }}</strong></span>
                    </div>
                </div>
            @else
                @php $lastDate = null; @endphp
                @foreach($messages as $msg)
                    @php
                        $msgDate = $msg->created_at->format('Y-m-d');
                        $isMine  = $msg->sender_id === auth()->id();
                    @endphp

                    @if($msgDate !== $lastDate)
                        <div style="text-align:center; margin:8px 0;">
                            <span style="background:rgba(255,255,255,0.06); color:#8696a0; font-size:11px; padding:4px 12px; border-radius:999px;">
                                {{ $msg->created_at->isToday() ? 'Today' : ($msg->created_at->isYesterday() ? 'Yesterday' : $msg->created_at->format('M d, Y')) }}
                            </span>
                        </div>
                        @php $lastDate = $msgDate; @endphp
                    @endif

                    <div class="msg-row" data-msg-id="{{ $msg->id }}" data-is-mine="{{ $isMine ? '1' : '0' }}"
                         style="display:flex; justify-content:{{ $isMine ? 'flex-end' : 'flex-start' }}; align-items:flex-end; gap:8px; position:relative;">
                        @if(!$isMine)
                            @if($contact->avatar)
                                <img src="{{ asset('storage/' . $contact->avatar) }}" style="width:28px; height:28px; border-radius:50%; object-fit:cover; flex-shrink:0;">
                            @else
                                <div style="width:28px; height:28px; border-radius:50%; background:#720e9e; display:flex; align-items:center; justify-content:center; color:white; font-size:11px; font-weight:700; flex-shrink:0;">
                                    {{ strtoupper(substr($contact->name, 0, 1)) }}
                                </div>
                            @endif
                        @endif
                        <div style="max-width:68%; position:relative;">
                            @if($isMine)
                                <div class="msg-delete-btn" style="display:none; position:absolute; top:-30px; right:0; background:#ef4444; color:white; font-size:11px; font-weight:600; padding:5px 10px; border-radius:8px; cursor:pointer; white-space:nowrap; z-index:5; box-shadow:0 4px 12px rgba(0,0,0,0.4);">
                                    <i class="fa-solid fa-trash" style="margin-right:4px;"></i> Delete
                                </div>
                            @endif
                            <div class="msg-bubble" style="background:{{ $isMine ? '#720e9e' : '#1f2c34' }}; color:{{ $isMine ? 'white' : '#d1d7db' }}; font-size:14px; padding:10px 14px; border-radius:{{ $isMine ? '16px 16px 4px 16px' : '16px 16px 16px 4px' }}; line-height:1.5; border:{{ $isMine ? 'none' : '1px solid #2a3942' }}; word-break:break-word; {{ $isMine ? 'cursor:pointer;' : '' }} transition:opacity 0.15s;">
                                {{ $msg->body }}
                            </div>
                            <p style="color:#8696a0; font-size:11px; margin:3px 0 0; text-align:{{ $isMine ? 'right' : 'left' }};">
                                {{ $msg->created_at->format('H:i') }}
                                @if($isMine)
                                    <i class="fa-solid fa-check-double msg-tick" style="margin-left:3px; color:{{ $msg->read ? '#60a5fa' : '#8696a0' }};"></i>
                                @endif
                            </p>
                        </div>
                        @if($isMine)
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" style="width:28px; height:28px; border-radius:50%; object-fit:cover; flex-shrink:0;">
                            @else
                                <div style="width:28px; height:28px; border-radius:50%; background:#2a3942; display:flex; align-items:center; justify-content:center; color:white; font-size:11px; font-weight:700; flex-shrink:0;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        @endif
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Input -->
        <div style="padding:12px 14px; border-top:1px solid #2a3942; background:#182028; display:flex; align-items:center; gap:10px;">
            <input type="text" id="messageInput" placeholder="Type a message..."
                style="flex:1; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); color:white; font-size:14px; padding:11px 16px; border-radius:12px; outline:none;"
                onfocus="this.style.borderColor='rgba(255,255,255,0.3)'"
                onblur="this.style.borderColor='rgba(255,255,255,0.1)'"
                onkeydown="if(event.key==='Enter' && !event.shiftKey){ event.preventDefault(); sendMessage(); }">
            <button onclick="sendMessage()" id="sendBtn"
                style="width:44px; height:44px; background:#720e9e; border:none; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; flex-shrink:0; transition:background 0.2s;"
                onmouseover="this.style.background='#9b1bc7'" onmouseout="this.style.background='#720e9e'">
                <i class="fa-solid fa-paper-plane" style="color:white; font-size:15px;"></i>
            </button>
        </div>
    </div>
</div>

<style>
    .rp-swal-popup { border-radius: 14px !important; }
    .rp-swal-title { font-size: 16px !important; margin-top: 8px !important; }
    .rp-swal-text  { font-size: 12px !important; color: #8696a0 !important; }
    .rp-swal-icon  { width: 44px !important; height: 44px !important; margin: 6px auto 4px !important; }
    .rp-swal-icon .swal2-icon-content { font-size: 24px !important; }
    .rp-swal-btn   { font-size: 13px !important; padding: 6px 16px !important; border-radius: 8px !important; }
    .rp-swal-toast { font-size: 12px !important; padding: 8px 14px !important; border-radius: 999px !important; }
</style>

@push('scripts')
<script>
    const sendUrl    = '{{ route("chat.send") }}';
    const checkUrl   = '{{ route("chat.unread.check", $contact->id) }}';
    const csrfToken  = '{{ csrf_token() }}';
    const receiverId = {{ $contact->id }};
    const myAvatar   = '{{ $user->avatar ? asset("storage/" . $user->avatar) : "" }}';
    const myInitial  = '{{ strtoupper(substr($user->name, 0, 1)) }}';
    const contactInitial = '{{ strtoupper(substr($contact->name, 0, 1)) }}';

    const area = document.getElementById('messagesArea');
    area.scrollTop = area.scrollHeight;

    async function sendMessage() {
        const input = document.getElementById('messageInput');
        const text  = input.value.trim();
        if (!text) return;

        const btn = document.getElementById('sendBtn');
        btn.disabled = true;
        input.value  = '';

        try {
            const res = await fetch(sendUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ receiver_id: receiverId, body: text }),
            });
            const data = await res.json();
            if (data.success) appendMessage(data.message);
        } catch(e) {
            console.error(e);
        }

        btn.disabled = false;
        input.focus();
    }

    function appendMessage(msg) {
        const now = new Date();
        const timeStr = now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0');

        const emptyState = document.getElementById('emptyState');
        if (emptyState) emptyState.remove();

        const row = document.createElement('div');
        row.className = 'msg-row';
        row.dataset.msgId = msg.id;
        row.dataset.isMine = '1';
        row.style.cssText = 'display:flex; justify-content:flex-end; align-items:flex-end; gap:8px; position:relative;';
        row.innerHTML = `
            <div style="max-width:68%; position:relative;">
                <div class="msg-delete-btn" style="display:none; position:absolute; top:-30px; right:0; background:#ef4444; color:white; font-size:11px; font-weight:600; padding:5px 10px; border-radius:8px; cursor:pointer; white-space:nowrap; z-index:5; box-shadow:0 4px 12px rgba(0,0,0,0.4);">
                    <i class="fa-solid fa-trash" style="margin-right:4px;"></i> Delete
                </div>
                <div class="msg-bubble" style="background:#720e9e; color:white; font-size:14px; padding:10px 14px; border-radius:16px 16px 4px 16px; line-height:1.5; word-break:break-word; cursor:pointer; transition:opacity 0.15s;">
                    ${escapeHtml(msg.body)}
                </div>
                <p style="color:#8696a0; font-size:11px; margin:3px 0 0; text-align:right;">
                    ${timeStr} <i class="fa-solid fa-check msg-tick" style="margin-left:3px; color:#8696a0;"></i>
                </p>
            </div>
            ${myAvatar
                ? `<img src="${myAvatar}" style="width:28px; height:28px; border-radius:50%; object-fit:cover; flex-shrink:0;">`
                : `<div style="width:28px; height:28px; border-radius:50%; background:#2a3942; display:flex; align-items:center; justify-content:center; color:white; font-size:11px; font-weight:700; flex-shrink:0;">${myInitial}</div>`
            }
        `;
        area.appendChild(row);
        attachDeleteHandlers(row);
        area.scrollTop = area.scrollHeight;
    }

    // Poll every 5s — update to blue double tick when receiver reads
    setInterval(async () => {
        try {
            const res  = await fetch(checkUrl, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            const data = await res.json();
            if (data.all_read) {
                document.querySelectorAll('.msg-tick').forEach(el => {
                    el.className = 'fa-solid fa-check-double msg-tick';
                    el.style.color = '#60a5fa';
                });
            }
        } catch(e) {}
    }, 5000);

    function escapeHtml(text) {
        const d = document.createElement('div');
        d.appendChild(document.createTextNode(text));
        return d.innerHTML;
    }

    // ── Delete message (click on desktop, long-press on mobile) ──
    function hideAllDeleteButtons() {
        document.querySelectorAll('.msg-delete-btn').forEach(btn => btn.style.display = 'none');
    }

    async function deleteMessage(msgId, row) {
        const result = await Swal.fire({
            title: 'Delete this message?',
            text: 'This cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#374151',
            background: '#1f2c34',
            color: '#ffffff',
            width: 300,
            padding: '1.2em',
            customClass: {
                popup: 'rp-swal-popup',
                title: 'rp-swal-title',
                htmlContainer: 'rp-swal-text',
                confirmButton: 'rp-swal-btn',
                cancelButton: 'rp-swal-btn',
                icon: 'rp-swal-icon',
            },
        });

        if (!result.isConfirmed) return;

        try {
            const res = await fetch('/chat/message/' + msgId, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            });
            const data = await res.json();
            if (data.success) {
                row.style.opacity = '0';
                setTimeout(() => row.remove(), 150);

                Swal.fire({
                    toast: true,
                    position: 'bottom',
                    icon: 'success',
                    title: 'Message deleted',
                    showConfirmButton: false,
                    timer: 1800,
                    timerProgressBar: true,
                    background: '#1f2c34',
                    color: '#ffffff',
                    customClass: { popup: 'rp-swal-toast' },
                });
            } else {
                Swal.fire({
                    toast: true,
                    position: 'bottom',
                    icon: 'error',
                    title: data.error || 'Could not delete message.',
                    showConfirmButton: false,
                    timer: 2200,
                    background: '#1f2c34',
                    color: '#ffffff',
                    customClass: { popup: 'rp-swal-toast' },
                });
            }
        } catch(e) {
            console.error(e);
            Swal.fire({
                toast: true,
                position: 'bottom',
                icon: 'error',
                title: 'Something went wrong.',
                showConfirmButton: false,
                timer: 2200,
                background: '#1f2c34',
                color: '#ffffff',
                customClass: { popup: 'rp-swal-toast' },
            });
        }
    }

    function attachDeleteHandlers(row) {
        if (row.dataset.isMine !== '1') return;

        const bubble    = row.querySelector('.msg-bubble');
        const deleteBtn = row.querySelector('.msg-delete-btn');
        if (!bubble || !deleteBtn) return;

        let pressTimer = null;
        let longPressed = false;

        // Desktop: click bubble toggles delete button
        bubble.addEventListener('click', (e) => {
            if (longPressed) { longPressed = false; return; } // avoid double-trigger after long-press
            const isVisible = deleteBtn.style.display === 'block';
            hideAllDeleteButtons();
            deleteBtn.style.display = isVisible ? 'none' : 'block';
        });

        // Mobile: long-press shows delete button
        bubble.addEventListener('touchstart', () => {
            longPressed = false;
            pressTimer = setTimeout(() => {
                longPressed = true;
                hideAllDeleteButtons();
                deleteBtn.style.display = 'block';
                if (navigator.vibrate) navigator.vibrate(30);
            }, 500);
        });
        bubble.addEventListener('touchend', () => clearTimeout(pressTimer));
        bubble.addEventListener('touchmove', () => clearTimeout(pressTimer));

        // Click the delete button itself
        deleteBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            deleteMessage(row.dataset.msgId, row);
        });
    }

    // Attach handlers to all existing message rows on load
    document.querySelectorAll('.msg-row').forEach(attachDeleteHandlers);

    // Click anywhere else closes open delete buttons
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.msg-bubble') && !e.target.closest('.msg-delete-btn')) {
            hideAllDeleteButtons();
        }
    });
</script>
@endpush
@endsection