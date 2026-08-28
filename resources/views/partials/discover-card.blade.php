<div id="card-{{ $profile->id }}"
     style="background:#1f2c34; border-radius:6px; overflow:hidden; box-shadow:0 4px 16px rgba(0,0,0,0.3); transition:transform 0.2s, box-shadow 0.2s; border:1px solid #2a3942; position:relative;"
     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 32px rgba(0,0,0,0.4)'; this.style.borderColor='rgba(255,255,255,0.15)';"
     onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.3)'; this.style.borderColor='#2a3942';">

    @if($isLocked)
        <div onclick="showPremiumModal()" style="position:absolute; inset:0; background:rgba(0,0,0,0.45); backdrop-filter:blur(3px); z-index:10; display:flex; flex-direction:column; align-items:center; justify-content:center; cursor:pointer; border-radius:16px;">
            <div style="width:48px; height:48px; background:rgba(245,158,11,0.2); border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:10px; border:2px solid rgba(245,158,11,0.4);">
                <i class="fa-solid fa-lock" style="font-size:18px; color:#f59e0b;"></i>
            </div>
            <p style="color:white; font-weight:700; font-size:13px; margin:0 0 2px;">Premium Only</p>
            <p style="color:#8696a0; font-size:11px; margin:0;">Tap to upgrade</p>
        </div>
    @endif

    <!-- Photo -->
    <div class="rp-card-photo"
         style="position:relative; height:240px; overflow:hidden; {{ !$isLocked ? 'cursor:pointer;' : '' }}"
         @if(!$isLocked) onclick="window.location.href='{{ route('profile.view', $profile->id) }}'" @endif>
        @if($profile->avatar)
            <img src="{{ asset('storage/' . $profile->avatar) }}"
                 style="width:100%; height:100%; object-fit:cover;">
        @else
            <div style="width:100%; height:100%; background:linear-gradient(135deg,#1a1a2e,#16213e); display:flex; align-items:center; justify-content:center;">
                <div style="width:64px; height:64px; border-radius:6%; background:rgba(255,255,255,0.05); display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-user" style="font-size:28px; color:rgba(255,255,255,0.2);"></i>
                </div>
            </div>
        @endif
        <div style="position:absolute; top:10px; right:10px; background:#22c55e; width:9px; height:9px; border-radius:50%; border:2px solid #1f2c34;"></div>
        <div style="position:absolute; bottom:0; left:0; right:0; background:linear-gradient(to top, rgba(0,0,0,0.85) 0%, transparent 100%); padding:12px 12px 10px;">
            <h3 style="color:white; font-size:15px; font-weight:700; margin:0 0 2px;">{{ $profile->name }}, {{ $profile->age }}</h3>
            @if($profile->city)
                <p style="color:rgba(255,255,255,0.6); font-size:11px; margin:0;">
                    <i class="fa-solid fa-location-dot" style="margin-right:3px; color:rgba(255,255,255,0.5);"></i>
                    {{ $profile->city }}@if($profile->country), {{ $profile->country }}@endif
                </p>
            @endif
        </div>
    </div>

    <!-- Card body -->
    <div style="padding:10px 12px 12px;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
            <span style="background:rgba(255,255,255,0.08); color:#d1d7db; font-size:10px; font-weight:600; padding:3px 8px; border-radius:999px; border:1px solid rgba(255,255,255,0.1);">
                <i class="fa-solid fa-{{ $profile->gender === 'male' ? 'mars' : 'venus' }}" style="margin-right:3px;"></i>
                {{ ucfirst($profile->gender) }}
            </span>
            @if(!$isLocked)
                <button
                    id="fav-btn-{{ $profile->id }}"
                    onclick="toggleFav({{ $profile->id }}, this)"
                    style="background:none; border:none; cursor:pointer; color:{{ in_array($profile->id, $favouriteIds) ? '#fbbf24' : '#8696a0' }}; font-size:18px; padding:2px; transition:all 0.2s;"
                    title="{{ in_array($profile->id, $favouriteIds) ? 'Remove from favourites' : 'Add to favourites' }}">
                    <i id="fav-icon-{{ $profile->id }}" class="fa-{{ in_array($profile->id, $favouriteIds) ? 'solid' : 'regular' }} fa-star"></i>
                </button>
            @else
                <i class="fa-solid fa-lock" style="color:#4b5563; font-size:12px;"></i>
            @endif
        </div>

        <div style="display:flex; gap:6px;">
            @if($isLocked)
                <button onclick="showPremiumModal()"
                    style="flex:1; background:transparent; border:1px solid rgba(255,255,255,0.08); color:#4b5563; font-weight:600; font-size:12px; padding:7px 4px; border-radius:8px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:4px;">
                    <i class="fa-solid fa-message"></i> Chat
                </button>
                <button onclick="showPremiumModal()"
                    style="flex:1; background:transparent; border:1px solid rgba(255,255,255,0.08); color:#4b5563; font-weight:600; font-size:12px; padding:7px 4px; border-radius:8px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:4px;">
                    <i class="fa-solid fa-heart"></i> Like
                </button>
            @else
                <a href="{{ route('chat.open', $profile->id) }}"
                    style="flex:1; background:transparent; border:1px solid rgba(255,255,255,0.2); color:#d1d7db; font-weight:600; font-size:12px; padding:7px 4px; border-radius:8px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:4px; transition:all 0.2s; text-decoration:none;"
                    onmouseover="this.style.background='rgba(255,255,255,0.08)'; this.style.color='white';"
                    onmouseout="this.style.background='transparent'; this.style.color='#d1d7db';">
                    <i class="fa-solid fa-message"></i> Chat
                </a>
                <button id="like-{{ $profile->id }}" onclick="quickLike({{ $profile->id }}, '{{ $profile->name }}')"
                    style="flex:1; background:transparent; border:1px solid rgba(255,255,255,0.2); color:#d1d7db; font-weight:600; font-size:12px; padding:7px 4px; border-radius:8px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:4px; transition:all 0.2s;"
                    onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.color='white';"
                    onmouseout="this.style.background='transparent'; this.style.color='#d1d7db';">
                    <i class="fa-solid fa-heart"></i> Like
                </button>
            @endif
        </div>
    </div>
</div>