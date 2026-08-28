@php
    $isPremium   = in_array(auth()->user()->subscription_plan, ['premium', 'gold']);
    $favCount    = \App\Models\Favourite::where('user_id', auth()->id())->count();
    $unreadCount = \App\Models\Message::where('receiver_id', auth()->id())->where('read', false)->count();
@endphp

<nav style="background:#1f2c34; border-bottom:1px solid #2a3942; padding:14px 28px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:50; box-shadow:0 2px 10px rgba(0,0,0,0.3);">

    <!-- Logo -->
    <a href="{{ route('discover') }}" style="text-decoration:none;">
        <img src="{{ asset('logo.png') }}" alt="Rompace" style="height:44px;">
    </a>

    <!-- Desktop Nav -->
    <div style="display:flex; align-items:center; gap:4px;">
        <a href="{{ route('discover') }}"
           style="display:flex; align-items:center; gap:7px; padding:9px 18px; border-radius:999px; text-decoration:none; font-size:15px; font-weight:600; {{ request()->routeIs('discover') ? 'background:rgba(255,255,255,0.1); color:white;' : 'color:#8696a0;' }}"
           onmouseover="this.style.color='white'; this.style.background='rgba(255,255,255,0.05)'"
           onmouseout="if(!{{ request()->routeIs('discover') ? 'true' : 'false' }}){ this.style.color='#8696a0'; this.style.background='none'; }">
            <i class="fa-solid fa-fire"></i> Discover
        </a>
<a href="{{ route('matches') }}"
   style="display:flex; align-items:center; gap:7px; padding:9px 18px; border-radius:999px; text-decoration:none; font-size:15px; font-weight:500; {{ request()->routeIs('matches') ? 'background:rgba(255,255,255,0.1); color:white;' : 'color:#8696a0;' }}"
   onmouseover="this.style.color='white'; this.style.background='rgba(255,255,255,0.05)'"
   onmouseout="if(!{{ request()->routeIs('matches') ? 'true' : 'false' }}){ this.style.color='#8696a0'; this.style.background='none'; }">
    <i class="fa-solid fa-heart"></i> Matches
</a>
        <a href="{{ route('chat.index') }}"
           style="display:flex; align-items:center; gap:7px; padding:9px 18px; border-radius:999px; text-decoration:none; font-size:15px; font-weight:500; {{ request()->routeIs('chat*') ? 'background:rgba(255,255,255,0.1); color:white;' : 'color:#8696a0;' }}"
           onmouseover="this.style.color='white'; this.style.background='rgba(255,255,255,0.05)'"
           onmouseout="if(!{{ request()->routeIs('chat*') ? 'true' : 'false' }}){ this.style.color='#8696a0'; this.style.background='none'; }">
            <i class="fa-solid fa-message"></i> Chat
            @if($unreadCount > 0)
                <span data-unread-badge style="background:#22c55e; color:white; font-size:11px; font-weight:700; min-width:18px; height:18px; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; padding:0 4px;">
                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                </span>
            @endif
        </a>
        <a href="{{ route('favourites') }}"
           style="display:flex; align-items:center; gap:7px; padding:9px 18px; border-radius:999px; text-decoration:none; font-size:15px; font-weight:500; {{ request()->routeIs('favourites') ? 'background:rgba(255,255,255,0.1); color:white;' : 'color:#8696a0;' }}"
           onmouseover="this.style.color='white'; this.style.background='rgba(255,255,255,0.05)'"
           onmouseout="this.style.color='#8696a0'; this.style.background='none'">
            <i class="fa-solid fa-star"></i> Favourites
            @if($favCount > 0)
                <span data-fav-badge style="background:#fbbf24; color:#111b21; font-size:11px; font-weight:700; min-width:18px; height:18px; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; padding:0 4px;">
                    {{ $favCount }}
                </span>
            @else
                <span data-fav-badge style="background:#fbbf24; color:#111b21; font-size:11px; font-weight:700; min-width:18px; height:18px; border-radius:999px; display:none; align-items:center; justify-content:center; padding:0 4px;">0</span>
            @endif
        </a>

        @if(!$isPremium)
            <a href="{{ route('pricing') }}"
               style="display:flex; align-items:center; gap:7px; padding:9px 18px; border-radius:999px; text-decoration:none; font-size:15px; font-weight:600; background:rgba(245,158,11,0.12); color:#f59e0b; border:1px solid rgba(245,158,11,0.25);"
               onmouseover="this.style.background='rgba(245,158,11,0.2)'; this.style.borderColor='rgba(245,158,11,0.5)';"
               onmouseout="this.style.background='rgba(245,158,11,0.12)'; this.style.borderColor='rgba(245,158,11,0.25)';">
                <i class="fa-solid fa-crown"></i> Upgrade
            </a>
        @endif
    </div>

    <!-- Right side -->
    <div style="display:flex; align-items:center; gap:14px;">

        <!-- Notifications -->
        <button style="position:relative; background:none; border:none; cursor:pointer; color:#8696a0; font-size:20px; padding:6px;"
            onmouseover="this.style.color='white'" onmouseout="this.style.color='#8696a0'">
            <i class="fa-solid fa-bell"></i>
            <span style="position:absolute; top:4px; right:4px; background:#22c55e; width:8px; height:8px; border-radius:50%; border:2px solid #1f2c34;"></span>
        </button>

        <!-- Profile dropdown -->
        <div style="position:relative;" id="profileDropdown">
            <button onclick="toggleProfileMenu()"
                style="display:flex; align-items:center; gap:8px; background:none; border:none; cursor:pointer; padding:4px;">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                         style="width:38px; height:38px; border-radius:50%; object-fit:cover; border:2px solid {{ $isPremium ? '#f59e0b' : 'rgba(255,255,255,0.3)' }};">
                @else
                    <div style="width:38px; height:38px; border-radius:50%; background:#2a3942; border:2px solid {{ $isPremium ? '#f59e0b' : 'rgba(255,255,255,0.2)' }}; display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:15px;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
                <div style="display:flex; flex-direction:column; align-items:flex-start;">
                    <span style="color:#d1d7db; font-size:14px; font-weight:600; line-height:1.2;">{{ auth()->user()->name }}</span>
                    @if($isPremium)
                        <span style="background:rgba(245,158,11,0.2); color:#f59e0b; font-size:10px; font-weight:700; padding:1px 6px; border-radius:999px; border:1px solid rgba(245,158,11,0.3); line-height:1.4;">
                            <i class="fa-solid fa-crown" style="font-size:8px; margin-right:2px;"></i> PREMIUM
                        </span>
                    @endif
                </div>
                <i class="fa-solid fa-chevron-down" style="font-size:11px; color:#8696a0;"></i>
            </button>

            <!-- Dropdown -->
            <div id="profileMenu" style="display:none; position:absolute; right:0; top:56px; background:#1f2c34; border-radius:16px; box-shadow:0 8px 30px rgba(0,0,0,0.5); border:1px solid #2a3942; width:230px; overflow:hidden; z-index:100;">

                <!-- User info -->
                <div style="padding:16px 18px; border-bottom:1px solid #2a3942;">
                    <div style="display:flex; align-items:center; gap:10px;">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                 style="width:42px; height:42px; border-radius:50%; object-fit:cover; border:2px solid {{ $isPremium ? '#f59e0b' : 'rgba(255,255,255,0.2)' }};">
                        @else
                            <div style="width:42px; height:42px; border-radius:50%; background:#720e9e; display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:16px;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p style="font-weight:700; color:white; font-size:14px; margin:0;">{{ auth()->user()->name }}</p>
                            <p style="color:#8696a0; font-size:12px; margin:2px 0 0;">
                                <i class="fa-solid fa-location-dot" style="margin-right:3px;"></i>
                                {{ auth()->user()->city ?? 'Location not set' }}
                            </p>
                        </div>
                    </div>
                    @if($isPremium)
                        <div style="margin-top:10px; background:rgba(245,158,11,0.1); border:1px solid rgba(245,158,11,0.25); border-radius:8px; padding:6px 10px; display:flex; align-items:center; gap:6px;">
                            <i class="fa-solid fa-crown" style="color:#f59e0b; font-size:12px;"></i>
                            <span style="color:#f59e0b; font-size:12px; font-weight:600;">Premium Member</span>
                        </div>
                    @endif
                </div>

                <!-- Menu items -->
                <div style="padding:8px 0;">
                    <a href="{{ route('profile') }}"
                       style="display:flex; align-items:center; gap:12px; padding:11px 18px; color:#d1d7db; text-decoration:none; font-size:14px; transition:all 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.06)'; this.style.color='white';"
                       onmouseout="this.style.background='none'; this.style.color='#d1d7db';">
                        <i class="fa-solid fa-user" style="color:#8696a0; width:16px;"></i> My Profile
                    </a>
                    <a href="{{ route('chat.index') }}"
                       style="display:flex; align-items:center; gap:12px; padding:11px 18px; color:#d1d7db; text-decoration:none; font-size:14px; transition:all 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.06)'; this.style.color='white';"
                       onmouseout="this.style.background='none'; this.style.color='#d1d7db';">
                        <i class="fa-solid fa-message" style="color:#8696a0; width:16px;"></i> Messages
                        @if($unreadCount > 0)
                            <span style="margin-left:auto; background:#22c55e; color:white; font-size:10px; font-weight:700; padding:1px 6px; border-radius:999px;">{{ $unreadCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('favourites') }}"
                       style="display:flex; align-items:center; gap:12px; padding:11px 18px; color:#d1d7db; text-decoration:none; font-size:14px; transition:all 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.06)'; this.style.color='white';"
                       onmouseout="this.style.background='none'; this.style.color='#d1d7db';">
                        <i class="fa-solid fa-star" style="color:#fbbf24; width:16px;"></i> Favourites
                        @if($favCount > 0)
                            <span data-fav-badge style="margin-left:auto; background:#fbbf24; color:#111; font-size:10px; font-weight:700; padding:1px 6px; border-radius:999px; display:inline-flex;">{{ $favCount }}</span>
                        @else
                            <span data-fav-badge style="margin-left:auto; background:#fbbf24; color:#111; font-size:10px; font-weight:700; padding:1px 6px; border-radius:999px; display:none;">0</span>
                        @endif
                    </a>

                    @if(!$isPremium)
                        <a href="{{ route('pricing') }}"
                           style="display:flex; align-items:center; gap:12px; padding:11px 18px; color:#f59e0b; text-decoration:none; font-size:14px; transition:all 0.2s; border-top:1px solid #2a3942; margin-top:4px;"
                           onmouseover="this.style.background='rgba(245,158,11,0.1)';"
                           onmouseout="this.style.background='none';">
                            <i class="fa-solid fa-crown" style="color:#f59e0b; width:16px;"></i>
                            <div>
                                <p style="margin:0; font-weight:700; font-size:14px;">Upgrade to Premium</p>
                                <p style="margin:0; font-size:11px; color:#8696a0;">Unlock all features</p>
                            </div>
                        </a>
                    @endif
                </div>

                <!-- Logout -->
                <div style="border-top:1px solid #2a3942; padding:8px 0;">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            style="width:100%; display:flex; align-items:center; gap:12px; padding:11px 18px; color:#ef4444; background:none; border:none; font-size:14px; cursor:pointer; text-align:left; transition:all 0.2s;"
                            onmouseover="this.style.background='rgba(239,68,68,0.1)'"
                            onmouseout="this.style.background='none'">
                            <i class="fa-solid fa-right-from-bracket" style="width:16px;"></i> Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile hamburger -->
    <button onclick="toggleMobileNav()" class="rp-hamburger"
        style="display:none; background:none; border:none; cursor:pointer; color:white; font-size:22px; padding:4px;">
        <i class="fa-solid fa-bars"></i>
    </button>
</nav>

<!-- Mobile Nav -->
<div id="mobileNavMenu" style="display:none; background:#1f2c34; border-bottom:1px solid #2a3942; padding:16px 24px;">
    <a href="{{ route('discover') }}" style="display:flex; align-items:center; gap:10px; padding:14px 0; color:white; text-decoration:none; font-weight:600; font-size:15px; border-bottom:1px solid #2a3942;">
        <i class="fa-solid fa-fire"></i> Discover
    </a>
<a href="{{ route('matches') }}" style="display:flex; align-items:center; gap:10px; padding:14px 0; color:#d1d7db; text-decoration:none; font-weight:500; font-size:15px; border-bottom:1px solid #2a3942;">
    <i class="fa-solid fa-heart"></i> Matches
</a>
    <a href="{{ route('chat.index') }}" style="display:flex; align-items:center; justify-content:space-between; padding:14px 0; color:#d1d7db; text-decoration:none; font-weight:500; font-size:15px; border-bottom:1px solid #2a3942;">
        <div style="display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-message"></i> Chat
        </div>
        @if($unreadCount > 0)
            <span style="background:#22c55e; color:white; font-size:11px; font-weight:700; min-width:18px; height:18px; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; padding:0 4px;">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </a>
    <a href="{{ route('favourites') }}" style="display:flex; align-items:center; justify-content:space-between; padding:14px 0; color:#d1d7db; text-decoration:none; font-weight:500; font-size:15px; border-bottom:1px solid #2a3942;">
        <div style="display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-star"></i> Favourites
        </div>
        @if($favCount > 0)
            <span data-fav-badge style="background:#fbbf24; color:#111b21; font-size:11px; font-weight:700; min-width:18px; height:18px; border-radius:999px; display:inline-flex; align-items:center; justify-content:center; padding:0 4px;">
                {{ $favCount }}
            </span>
        @else
            <span data-fav-badge style="background:#fbbf24; color:#111b21; font-size:11px; font-weight:700; min-width:18px; height:18px; border-radius:999px; display:none; align-items:center; justify-content:center; padding:0 4px;">0</span>
        @endif
    </a>
    <a href="{{ route('profile') }}" style="display:flex; align-items:center; gap:10px; padding:14px 0; color:#d1d7db; text-decoration:none; font-weight:500; font-size:15px; border-bottom:1px solid #2a3942;">
        <i class="fa-solid fa-user"></i> My Profile
    </a>
    @if(!$isPremium)
        <a href="{{ route('pricing') }}" style="display:flex; align-items:center; gap:10px; padding:14px 0; color:#f59e0b; text-decoration:none; font-weight:600; font-size:15px; border-bottom:1px solid #2a3942;">
            <i class="fa-solid fa-crown"></i> Upgrade to Premium
        </a>
    @endif
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" style="display:flex; align-items:center; gap:10px; padding:14px 0; color:#ef4444; background:none; border:none; font-size:15px; cursor:pointer; width:100%;">
            <i class="fa-solid fa-right-from-bracket"></i> Sign Out
        </button>
    </form>
</div>

<style>
@media(max-width:768px){
    .rp-hamburger { display:block !important; }
    nav > div:nth-child(2),
    nav > div:nth-child(3) { display:none !important; }
}
</style>

<script>
    function toggleProfileMenu() {
        const menu = document.getElementById('profileMenu');
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }
    function toggleMobileNav() {
        const menu = document.getElementById('mobileNavMenu');
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    }
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('profileDropdown');
        if (dropdown && !dropdown.contains(e.target)) {
            document.getElementById('profileMenu').style.display = 'none';
        }
    });
</script>