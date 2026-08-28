@extends('layouts.app-auth')
@section('title', 'Messages')

@section('content')
<div style="max-width:700px; margin:0 auto; padding:24px 16px;">

    <!-- Header -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
        <div>
            <h1 style="color:white; font-size:22px; font-weight:800; margin:0 0 2px;">Messages</h1>
            <p style="color:#8696a0; font-size:13px; margin:0;" id="convCount">{{ count($conversations) }} conversation{{ count($conversations) !== 1 ? 's' : '' }}</p>
        </div>
    </div>

    <!-- Search -->
    <div style="position:relative; margin-bottom:16px;">
        <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#8696a0; font-size:14px;"></i>
        <input type="text" placeholder="Search conversations..." id="searchInput" oninput="filterConversations()"
            style="width:100%; background:#1f2c34; border:1px solid #2a3942; color:white; font-size:14px; padding:11px 14px 11px 40px; border-radius:12px; outline:none; box-sizing:border-box;"
            onfocus="this.style.borderColor='rgba(255,255,255,0.25)'"
            onblur="this.style.borderColor='#2a3942'">
    </div>

    <!-- Conversations -->
    <div style="background:#1f2c34; border-radius:20px; border:1px solid #2a3942; overflow:hidden;" id="conversationList">
        @forelse($conversations as $conv)
            @php
                $contact     = $conv['contact'];
                $lastMessage = $conv['lastMessage'];
                $unread      = $conv['unreadCount'];
                $isMine      = $lastMessage->sender_id === auth()->id();
            @endphp
            <div class="conv-item" data-name="{{ strtolower($contact->name) }}" data-contact-id="{{ $contact->id }}"
               style="display:flex; align-items:center; gap:14px; padding:14px 18px; border-bottom:1px solid #2a3942; position:relative;"
               onmouseover="this.style.background='rgba(255,255,255,0.03)'; this.querySelector('.conv-delete').style.opacity='1';"
               onmouseout="this.style.background='none'; this.querySelector('.conv-delete').style.opacity='0';">

                <a href="{{ route('chat.open', $contact->id) }}" style="display:flex; align-items:center; gap:14px; text-decoration:none; flex:1; min-width:0;">
                    <!-- Avatar -->
                    <div style="position:relative; flex-shrink:0;">
                        @if($contact->avatar)
                            <img src="{{ asset('storage/' . $contact->avatar) }}"
                                 style="width:52px; height:52px; border-radius:50%; object-fit:cover; border:2px solid {{ $unread > 0 ? '#720e9e' : '#2a3942' }};">
                        @else
                            <div style="width:52px; height:52px; border-radius:50%; background:#720e9e; display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:18px;">
                                {{ strtoupper(substr($contact->name, 0, 1)) }}
                            </div>
                        @endif
                        <!-- Online dot -->
                        <div style="position:absolute; bottom:2px; right:2px; width:12px; height:12px; background:#22c55e; border-radius:50%; border:2px solid #1f2c34;"></div>
                    </div>

                    <!-- Content -->
                    <div style="flex:1; min-width:0;">
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:3px;">
                            <p style="color:{{ $unread > 0 ? 'white' : '#d1d7db' }}; font-size:15px; font-weight:{{ $unread > 0 ? '700' : '600' }}; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:200px;">
                                {{ $contact->name }}
                            </p>
                            <span style="color:#8696a0; font-size:12px; flex-shrink:0; margin-left:8px;">
                                {{ $lastMessage->created_at->diffForHumans(null, true) }}
                            </span>
                        </div>
                        <div style="display:flex; align-items:center; justify-content:space-between; gap:8px;">
                            <p style="color:{{ $unread > 0 ? '#d1d7db' : '#8696a0' }}; font-size:13px; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; flex:1;">
                                @if($isMine)
                                    <i class="fa-solid fa-check{{ $lastMessage->read ? '-double' : '' }}" style="color:{{ $lastMessage->read ? '#60a5fa' : '#8696a0' }}; font-size:11px; margin-right:4px;"></i>
                                @endif
                                {{ Str::limit($lastMessage->body, 45) }}
                            </p>
                            @if($unread > 0)
                                <span style="background:#22c55e; color:white; font-size:11px; font-weight:700; min-width:20px; height:20px; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; padding:0 5px; flex-shrink:0;">
                                    {{ $unread }}
                                </span>
                            @endif
                        </div>
                    </div>
                </a>

                <!-- Delete button -->
                <button class="conv-delete" onclick="deleteConversation({{ $contact->id }}, this)"
                    style="opacity:0; transition:opacity 0.15s; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); color:#ef4444; width:34px; height:34px; border-radius:10px; cursor:pointer; flex-shrink:0; display:flex; align-items:center; justify-content:center;"
                    title="Delete conversation">
                    <i class="fa-solid fa-trash" style="font-size:13px;"></i>
                </button>
            </div>
        @empty
            <div style="padding:60px 20px; text-align:center;" id="emptyConversations">
                <div style="width:64px; height:64px; background:rgba(255,255,255,0.04); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                    <i class="fa-solid fa-message" style="font-size:28px; color:rgba(255,255,255,0.15);"></i>
                </div>
                <p style="color:white; font-size:16px; font-weight:600; margin:0 0 6px;">No messages yet</p>
                <p style="color:#8696a0; font-size:14px; margin:0 0 20px;">Start a conversation from someone's profile</p>
                <a href="{{ route('discover') }}"
                   style="display:inline-block; background:#720e9e; color:white; font-weight:600; font-size:14px; padding:10px 24px; border-radius:999px; text-decoration:none;">
                    Discover People
                </a>
            </div>
        @endforelse
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

    /* Always show delete button on touch devices since hover doesn't apply */
    @media (hover: none) {
        .conv-delete { opacity: 1 !important; }
    }
</style>

@push('scripts')
<script>
    const csrfToken = '{{ csrf_token() }}';

    function filterConversations() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('.conv-item').forEach(item => {
            const name = item.getAttribute('data-name');
            item.style.display = name.includes(query) ? 'flex' : 'none';
        });
    }

    async function deleteConversation(contactId, btn) {
        const result = await Swal.fire({
            title: 'Delete this conversation?',
            text: 'All messages will be permanently deleted.',
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
            const res = await fetch('/chat/conversation/' + contactId, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            });
            const data = await res.json();

            if (data.success) {
                const row = btn.closest('.conv-item');
                row.style.opacity = '0';
                setTimeout(() => {
                    row.remove();
                    updateConvCount();
                    checkEmptyState();
                }, 150);

                Swal.fire({
                    toast: true,
                    position: 'bottom',
                    icon: 'success',
                    title: 'Conversation deleted',
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
                    title: 'Could not delete conversation.',
                    showConfirmButton: false,
                    timer: 2200,
                    background: '#1f2c34',
                    color: '#ffffff',
                    customClass: { popup: 'rp-swal-toast' },
                });
            }
        } catch (e) {
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

    function updateConvCount() {
        const remaining = document.querySelectorAll('.conv-item').length;
        const el = document.getElementById('convCount');
        if (el) el.textContent = remaining + ' conversation' + (remaining !== 1 ? 's' : '');
    }

    function checkEmptyState() {
        const remaining = document.querySelectorAll('.conv-item').length;
        if (remaining === 0 && !document.getElementById('emptyConversations')) {
            document.getElementById('conversationList').innerHTML = `
                <div style="padding:60px 20px; text-align:center;" id="emptyConversations">
                    <div style="width:64px; height:64px; background:rgba(255,255,255,0.04); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                        <i class="fa-solid fa-message" style="font-size:28px; color:rgba(255,255,255,0.15);"></i>
                    </div>
                    <p style="color:white; font-size:16px; font-weight:600; margin:0 0 6px;">No messages yet</p>
                    <p style="color:#8696a0; font-size:14px; margin:0 0 20px;">Start a conversation from someone's profile</p>
                    <a href="{{ route('discover') }}"
                       style="display:inline-block; background:#720e9e; color:white; font-weight:600; font-size:14px; padding:10px 24px; border-radius:999px; text-decoration:none;">
                        Discover People
                    </a>
                </div>
            `;
        }
    }
</script>
@endpush
@endsection