<div id="card-{{ $profile->id }}"
     style="background:#1f2c34; border-radius:6px; overflow:hidden; box-shadow:0 4px 16px rgba(0,0,0,0.3); transition:transform 0.2s, box-shadow 0.2s; border:1px solid #2a3942; position:relative;"
     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 32px rgba(0,0,0,0.4)'; this.style.borderColor='rgba(255,255,255,0.15)';"
     onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.3)'; this.style.borderColor='#2a3942';">

    <!-- Photo -->
    <div class="rp-card-photo"
         style="position:relative; height:240px; overflow:hidden; cursor:pointer;"
         onclick="window.location.href='{{ route('profile.view', $profile->id) }}'">
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
        @if(!$isPremium)
            <div style="position:absolute; top:10px; left:10px; background:rgba(245,158,11,0.9); backdrop-filter:blur(4px); padding:4px 10px; border-radius:999px; display:flex; align-items:center; gap:5px;">
                <i class="fa-solid fa-crown" style="font-size:10px; color:#111b21;"></i>
                <span style="color:#111b21; font-size:10px; font-weight:700;">Premium</span>
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
            <button
                id="fav-btn-{{ $profile->id }}"
                onclick="toggleFav({{ $profile->id }}, this)"
                style="background:none; border:none; cursor:pointer; color:{{ in_array($profile->id, $favouriteIds) ? '#fbbf24' : '#8696a0' }}; font-size:18px; padding:2px; transition:all 0.2s;"
                title="{{ in_array($profile->id, $favouriteIds) ? 'Remove from favourites' : 'Add to favourites' }}">
                <i id="fav-icon-{{ $profile->id }}" class="fa-{{ in_array($profile->id, $favouriteIds) ? 'solid' : 'regular' }} fa-star"></i>
            </button>
        </div>

        <div style="display:flex; gap:6px;">
            <a href="{{ route('profile.view', $profile->id) }}"
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
        </div>
    </div>
</div>