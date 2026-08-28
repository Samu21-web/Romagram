@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

    <!-- Stats cards -->
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:28px;">

        <!-- Total Users -->
        <div style="background:linear-gradient(135deg,#1e3a5f,#1a2f4a); border:1px solid #1e4070; border-radius:16px; padding:24px; position:relative; overflow:hidden;">
            <div style="position:absolute; top:-20px; right:-20px; width:80px; height:80px; background:rgba(59,130,246,0.1); border-radius:50%;"></div>
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                <p style="color:#93c5fd; font-size:13px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Total Users</p>
                <div style="width:44px; height:44px; background:rgba(59,130,246,0.25); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-users" style="color:#60a5fa; font-size:18px;"></i>
                </div>
            </div>
            <p style="color:white; font-size:36px; font-weight:800; margin:0 0 6px;">{{ $totalUsers }}</p>
            <p style="color:#93c5fd; font-size:13px; margin:0;"><span style="color:#22c55e; font-weight:600;">+{{ $newToday }}</span> joined today</p>
        </div>

        <!-- Premium Users -->
        <div style="background:linear-gradient(135deg,#3d1f00,#2d1500); border:1px solid #7c3a00; border-radius:16px; padding:24px; position:relative; overflow:hidden;">
            <div style="position:absolute; top:-20px; right:-20px; width:80px; height:80px; background:rgba(245,158,11,0.1); border-radius:50%;"></div>
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                <p style="color:#fcd34d; font-size:13px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Premium Users</p>
                <div style="width:44px; height:44px; background:rgba(245,158,11,0.25); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-crown" style="color:#f59e0b; font-size:18px;"></i>
                </div>
            </div>
            <p style="color:white; font-size:36px; font-weight:800; margin:0 0 6px;">{{ $premiumUsers }}</p>
            <p style="color:#fcd34d; font-size:13px; margin:0;">Out of {{ $totalUsers }} total</p>
        </div>

        <!-- New Today -->
        <div style="background:linear-gradient(135deg,#064e3b,#022c22); border:1px solid #065f46; border-radius:16px; padding:24px; position:relative; overflow:hidden;">
            <div style="position:absolute; top:-20px; right:-20px; width:80px; height:80px; background:rgba(34,197,94,0.1); border-radius:50%;"></div>
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                <p style="color:#6ee7b7; font-size:13px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin:0;">New Today</p>
                <div style="width:44px; height:44px; background:rgba(34,197,94,0.25); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-user-plus" style="color:#22c55e; font-size:18px;"></i>
                </div>
            </div>
            <p style="color:white; font-size:36px; font-weight:800; margin:0 0 6px;">{{ $newToday }}</p>
            <p style="color:#6ee7b7; font-size:13px; margin:0;">New registrations</p>
        </div>

        <!-- Total Likes -->
        <div style="background:linear-gradient(135deg,#4c0519,#3b0111); border:1px solid #881337; border-radius:16px; padding:24px; position:relative; overflow:hidden;">
            <div style="position:absolute; top:-20px; right:-20px; width:80px; height:80px; background:rgba(239,68,68,0.1); border-radius:50%;"></div>
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                <p style="color:#fca5a5; font-size:13px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Total Likes</p>
                <div style="width:44px; height:44px; background:rgba(239,68,68,0.25); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-heart" style="color:#ef4444; font-size:18px;"></i>
                </div>
            </div>
            <p style="color:white; font-size:36px; font-weight:800; margin:0 0 6px;">{{ $totalSwipes }}</p>
            <p style="color:#fca5a5; font-size:13px; margin:0;">Profile swipes</p>
        </div>

        <!-- Favourites -->
        <div style="background:linear-gradient(135deg,#3d2f00,#2d2200); border:1px solid #7c5a00; border-radius:16px; padding:24px; position:relative; overflow:hidden;">
            <div style="position:absolute; top:-20px; right:-20px; width:80px; height:80px; background:rgba(251,191,36,0.1); border-radius:50%;"></div>
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                <p style="color:#fde68a; font-size:13px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Favourites</p>
                <div style="width:44px; height:44px; background:rgba(251,191,36,0.25); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-star" style="color:#fbbf24; font-size:18px;"></i>
                </div>
            </div>
            <p style="color:white; font-size:36px; font-weight:800; margin:0 0 6px;">{{ $totalFavourites }}</p>
            <p style="color:#fde68a; font-size:13px; margin:0;">Saved profiles</p>
        </div>

        <!-- Revenue -->
        <div style="background:linear-gradient(135deg,#1e1b4b,#12103a); border:1px solid #3730a3; border-radius:16px; padding:24px; position:relative; overflow:hidden;">
            <div style="position:absolute; top:-20px; right:-20px; width:80px; height:80px; background:rgba(99,102,241,0.1); border-radius:50%;"></div>
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                <p style="color:#a5b4fc; font-size:13px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin:0;">Revenue</p>
                <div style="width:44px; height:44px; background:rgba(99,102,241,0.25); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-money-bill-wave" style="color:#818cf8; font-size:18px;"></i>
                </div>
            </div>
            <p style="color:white; font-size:36px; font-weight:800; margin:0 0 6px;">KES 0</p>
            <p style="color:#a5b4fc; font-size:13px; margin:0;">Total revenue</p>
        </div>
    </div>

    <!-- Bottom grid -->
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">

        <!-- Users by city -->
        <div style="background:#161b22; border:1px solid #21262d; border-radius:16px; padding:24px;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
                <div>
                    <h3 style="color:white; font-size:16px; font-weight:700; margin:0 0 4px;">Users by City</h3>
                    <p style="color:#8b949e; font-size:13px; margin:0;">{{ $usersByCity->count() }} active cities</p>
                </div>
                <a href="{{ route('admin.users') }}"
                    style="background:#21262d; border:1px solid #30363d; color:#8b949e; font-size:12px; font-weight:500; padding:6px 14px; border-radius:8px; text-decoration:none;">
                    View all →
                </a>
            </div>
            @foreach($usersByCity as $city)
                @php $percent = $totalUsers > 0 ? ($city->total / $totalUsers) * 100 : 0; @endphp
                <div style="margin-bottom:16px;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                        <span style="color:#d1d7db; font-size:14px; font-weight:500;">{{ $city->city }}</span>
                        <span style="color:#8b949e; font-size:13px; font-weight:600;">{{ $city->total }} users</span>
                    </div>
                    <div style="background:#21262d; border-radius:999px; height:8px;">
                        <div style="background:linear-gradient(to right,#720e9e,#9b1bc7); height:8px; border-radius:999px; width:{{ $percent }}%; transition:width 0.5s;"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Recent users -->
        <div style="background:#161b22; border:1px solid #21262d; border-radius:16px; padding:24px;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
                <div>
                    <h3 style="color:white; font-size:16px; font-weight:700; margin:0 0 4px;">Recent Users</h3>
                    <p style="color:#8b949e; font-size:13px; margin:0;">Latest registrations</p>
                </div>
                <a href="{{ route('admin.users') }}"
                    style="background:#21262d; border:1px solid #30363d; color:#8b949e; font-size:12px; font-weight:500; padding:6px 14px; border-radius:8px; text-decoration:none;">
                    View all →
                </a>
            </div>
            @foreach($recentUsers as $user)
                <div style="display:flex; align-items:center; gap:12px; padding:12px 0; border-bottom:1px solid #21262d;">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" style="width:42px; height:42px; border-radius:50%; object-fit:cover; flex-shrink:0; border:2px solid #21262d;">
                    @else
                        <div style="width:42px; height:42px; border-radius:50%; background:linear-gradient(135deg,#720e9e,#9b1bc7); display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:15px; flex-shrink:0;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div style="flex:1; min-width:0;">
                        <p style="color:white; font-size:14px; font-weight:600; margin:0;">{{ $user->name }}</p>
                        <p style="color:#8b949e; font-size:12px; margin:3px 0 0;">
                            <i class="fa-solid fa-location-dot" style="margin-right:4px;"></i>{{ $user->city ?? 'No location' }}
                            · {{ $user->created_at->diffForHumans() }}
                        </p>
                    </div>
                    @if(in_array($user->subscription_plan, ['premium','gold']))
                        <span style="background:linear-gradient(135deg,rgba(245,158,11,0.2),rgba(245,158,11,0.1)); color:#f59e0b; font-size:11px; font-weight:700; padding:4px 10px; border-radius:999px; border:1px solid rgba(245,158,11,0.3); white-space:nowrap;">
                            <i class="fa-solid fa-crown" style="margin-right:3px;"></i> Premium
                        </span>
                    @else
                        <span style="background:rgba(255,255,255,0.04); color:#8b949e; font-size:11px; font-weight:600; padding:4px 10px; border-radius:999px; border:1px solid #21262d; white-space:nowrap;">
                            Free
                        </span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

@endsection