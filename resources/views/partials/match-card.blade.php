@php $profile = $match['profile']; @endphp

<div style="background:#1f2c34; border-radius:20px; overflow:hidden; border:1px solid {{ $match['isNew'] ? 'rgba(34,197,94,0.3)' : '#2a3942' }}; box-shadow:0 4px 16px rgba(0,0,0,0.3); transition:transform 0.2s, box-shadow 0.2s;"
     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 32px rgba(0,0,0,0.4)';"
     onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.3)';">

    <!-- Photo -->
    <div class="h-[170px] sm:h-[260px]" style="position:relative; overflow:hidden;">
        @if($profile->avatar)
            <img src="{{ asset('storage/' . $profile->avatar) }}"
                 style="width:100%; height:100%; object-fit:cover;">
        @else
            <div style="width:100%; height:100%; background:linear-gradient(135deg,#1a1a2e,#16213e); display:flex; align-items:center; justify-content:center;">
                <div style="width:70px; height:70px; border-radius:50%; background:rgba(255,255,255,0.05); display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-user" style="font-size:30px; color:rgba(255,255,255,0.2);"></i>
                </div>
            </div>
        @endif

        <!-- Online dot -->
        <div style="position:absolute; top:12px; right:12px; background:#22c55e; width:10px; height:10px; border-radius:50%; border:2px solid #1f2c34;"></div>

        <!-- New badge -->
        @if($match['isNew'])
            <div style="position:absolute; top:12px; left:12px; background:rgba(34,197,94,0.2); border:1px solid rgba(34,197,94,0.4); border-radius:999px; padding:4px 10px; display:flex; align-items:center; gap:4px;">
                <div style="width:6px; height:6px; background:#22c55e; border-radius:50%;"></div>
                <span style="color:#22c55e; font-size:11px; font-weight:700;">New Match!</span>
            </div>
        @else
            <div style="position:absolute; top:12px; left:12px; background:rgba(236,72,153,0.15); border:1px solid rgba(236,72,153,0.3); border-radius:999px; padding:4px 10px; display:flex; align-items:center; gap:4px;">
                <i class="fa-solid fa-heart" style="color:#f472b6; font-size:9px;"></i>
                <span style="color:#f472b6; font-size:11px; font-weight:600;">Matched</span>
            </div>
        @endif

        <!-- Gradient overlay -->
        <div style="position:absolute; bottom:0; left:0; right:0; background:linear-gradient(to top, rgba(0,0,0,0.9) 0%, transparent 100%); padding:16px 14px 10px;">
            <h3 style="color:white; font-size:16px; font-weight:700; margin:0 0 2px;">{{ $profile->name }}, {{ $profile->age }}</h3>
            @if($profile->city)
                <p style="color:rgba(255,255,255,0.6); font-size:11px; margin:0;">
                    <i class="fa-solid fa-location-dot" style="margin-right:3px;"></i>
                    {{ $profile->city }}
                </p>
            @endif
        </div>
    </div>

    <!-- Card body -->
    <div style="padding:12px 14px 14px;">
        <!-- Matched time -->
        <p style="color:#8696a0; font-size:12px; margin:0 0 12px; text-align:center;">
            <i class="fa-solid fa-clock" style="margin-right:4px;"></i>
            Matched {{ $match['matchedAt']->diffForHumans() }}
        </p>

        <!-- Buttons -->
        <div class="flex gap-1.5 sm:gap-2">
            <a href="{{ route('chat.open', $profile->id) }}"
                class="flex-1 flex items-center justify-center gap-1 sm:gap-1.5 rounded-lg sm:rounded-[10px] px-1 py-2 sm:px-2.5 sm:py-2.5 text-[11px] sm:text-[13px] font-bold text-white no-underline"
                style="background:linear-gradient(135deg,#720e9e,#9b1bc7); transition:opacity 0.2s;"
                onmouseover="this.style.opacity='0.85'"
                onmouseout="this.style.opacity='1'">
                <i class="fa-solid fa-message"></i> <span class="whitespace-nowrap">Chat</span>
            </a>
            <a href="{{ route('profile.view', $profile->id) }}"
                class="flex-1 flex items-center justify-center gap-1 sm:gap-1.5 rounded-lg sm:rounded-[10px] px-1 py-2 sm:px-2.5 sm:py-2.5 text-[11px] sm:text-[13px] font-semibold text-[#d1d7db] no-underline"
                style="background:transparent; border:1.5px solid rgba(255,255,255,0.2); transition:all 0.2s;"
                onmouseover="this.style.background='rgba(255,255,255,0.08)'; this.style.color='white';"
                onmouseout="this.style.background='transparent'; this.style.color='#d1d7db';">
                <i class="fa-solid fa-eye"></i> <span class="whitespace-nowrap">View</span>
            </a>
        </div>
    </div>
</div>