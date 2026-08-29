@extends('layouts.admin')
@section('title', 'Users')

@section('content')

    <!-- Filters -->
    <div style="display:flex; align-items:center; gap:10px; margin-bottom:24px; flex-wrap:wrap;">
        <a href="{{ route('admin.users') }}"
            style="display:flex; align-items:center; gap:6px; padding:8px 16px; border-radius:999px; text-decoration:none; font-size:13px; font-weight:600; {{ !request('type') ? 'background:#720e9e; color:white;' : 'background:#21262d; color:#8b949e;' }}">
            <i class="fa-solid fa-users"></i> All
            <span style="background:rgba(255,255,255,0.2); padding:1px 7px; border-radius:999px; margin-left:2px;">{{ $totalUsers }}</span>
        </a>
        <a href="{{ route('admin.users', ['type' => 'regular']) }}"
            style="display:flex; align-items:center; gap:6px; padding:8px 16px; border-radius:999px; text-decoration:none; font-size:13px; font-weight:600; {{ request('type') === 'regular' ? 'background:#3b82f6; color:white;' : 'background:#21262d; color:#8b949e;' }}">
            <i class="fa-solid fa-user"></i> Regular
            <span style="background:rgba(255,255,255,0.2); padding:1px 7px; border-radius:999px; margin-left:2px;">{{ $regularCount }}</span>
        </a>
        <a href="{{ route('admin.users', ['type' => 'premium']) }}"
            style="display:flex; align-items:center; gap:6px; padding:8px 16px; border-radius:999px; text-decoration:none; font-size:13px; font-weight:600; {{ request('type') === 'premium' ? 'background:#f59e0b; color:#111;' : 'background:#21262d; color:#8b949e;' }}">
            <i class="fa-solid fa-crown"></i> Premium
            <span style="background:rgba(255,255,255,0.2); padding:1px 7px; border-radius:999px; margin-left:2px;">{{ $premiumCount }}</span>
        </a>
        <a href="{{ route('admin.users', ['type' => 'featured']) }}"
            style="display:flex; align-items:center; gap:6px; padding:8px 16px; border-radius:999px; text-decoration:none; font-size:13px; font-weight:600; {{ request('type') === 'featured' ? 'background:#8b5cf6; color:white;' : 'background:#21262d; color:#8b949e;' }}">
            <i class="fa-solid fa-star"></i> Featured
            <span style="background:rgba(255,255,255,0.2); padding:1px 7px; border-radius:999px; margin-left:2px;">{{ $featuredCount }}</span>
        </a>
        <a href="{{ route('admin.users', ['type' => 'deactivated']) }}"
            style="display:flex; align-items:center; gap:6px; padding:8px 16px; border-radius:999px; text-decoration:none; font-size:13px; font-weight:600; {{ request('type') === 'deactivated' ? 'background:#ef4444; color:white;' : 'background:#21262d; color:#8b949e;' }}">
            <i class="fa-solid fa-power-off"></i> Deactivated
            <span style="background:rgba(255,255,255,0.2); padding:1px 7px; border-radius:999px; margin-left:2px;">{{ $deactivatedCount }}</span>
        </a>

        <!-- Search -->
        <form method="GET" action="{{ route('admin.users') }}" style="margin-left:auto; display:flex; gap:8px;">
            @if(request('type'))<input type="hidden" name="type" value="{{ request('type') }}">@endif
            <div style="position:relative;">
                <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#8b949e; font-size:13px;"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..."
                    style="background:#21262d; border:1px solid #30363d; color:white; font-size:13px; padding:8px 14px 8px 36px; border-radius:8px; outline:none; width:220px;">
            </div>
            <button type="submit" style="background:#720e9e; color:white; border:none; padding:8px 16px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer;">Search</button>
        </form>
    </div>

    <!-- Table -->
    <div style="background:#161b22; border:1px solid #21262d; border-radius:16px; overflow:hidden;">
        <div style="padding:16px 20px; border-bottom:1px solid #21262d; display:flex; align-items:center; justify-content:space-between;">
            <h3 style="color:white; font-size:15px; font-weight:700; margin:0;">
                @if(request('type') === 'deactivated') Deactivated Users
                @elseif(request('type') === 'premium') Premium Users
                @elseif(request('type') === 'regular') Regular Users
                @elseif(request('type') === 'featured') Featured Users
                @else All Users
                @endif
            </h3>
            <span style="color:#8b949e; font-size:13px;">{{ $users->total() }} record(s)</span>
        </div>
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:1px solid #21262d;">
                    <th style="text-align:left; padding:14px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">#</th>
                    <th style="text-align:left; padding:14px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">User</th>
                    <th style="text-align:left; padding:14px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">City</th>
                    <th style="text-align:left; padding:14px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Gender</th>
                    <th style="text-align:left; padding:14px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Type</th>
                    <th style="text-align:left; padding:14px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Status</th>
                    <th style="text-align:left; padding:14px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Joined</th>
                    <th style="text-align:left; padding:14px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $user)
                    <tr style="border-bottom:1px solid #21262d;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                        <td style="padding:14px 20px; color:#8b949e; font-size:13px;">{{ $users->firstItem() + $i }}</td>
                        <td style="padding:14px 20px;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" style="width:36px; height:36px; border-radius:50%; object-fit:cover; flex-shrink:0; {{ $user->is_deactivated ? 'filter:grayscale(1); opacity:0.5;' : '' }}">
                                @else
                                    <div style="width:36px; height:36px; border-radius:50%; background:{{ $user->is_deactivated ? '#374151' : '#720e9e' }}; display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:13px; flex-shrink:0;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p style="color:{{ $user->is_deactivated ? '#6b7280' : 'white' }}; font-size:14px; font-weight:600; margin:0; display:flex; align-items:center; gap:6px;">
                                        {{ $user->name }}
                                        @if($user->is_featured)
                                            <i class="fa-solid fa-star" style="color:#8b5cf6; font-size:11px;" title="Featured"></i>
                                        @endif
                                    </p>
                                    <p style="color:#8b949e; font-size:12px; margin:0;">{{ $user->email }}</p>
                                    <p style="color:#8b949e; font-size:12px; margin:0;">{{ $user->phone ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td style="padding:14px 20px; color:#d1d7db; font-size:13px;">{{ $user->city ?? '-' }}</td>
                        <td style="padding:14px 20px;">
                            <span style="background:{{ $user->gender === 'male' ? 'rgba(59,130,246,0.15)' : 'rgba(236,72,153,0.15)' }}; color:{{ $user->gender === 'male' ? '#60a5fa' : '#f472b6' }}; font-size:11px; font-weight:600; padding:3px 10px; border-radius:999px;">
                                {{ ucfirst($user->gender ?? '-') }}
                            </span>
                        </td>
                        <td style="padding:14px 20px;">
                            @if(in_array($user->subscription_plan, ['premium','gold']))
                                <span style="background:rgba(245,158,11,0.15); color:#f59e0b; font-size:11px; font-weight:700; padding:3px 10px; border-radius:999px; border:1px solid rgba(245,158,11,0.3);">
                                    <i class="fa-solid fa-crown" style="margin-right:3px;"></i> Premium
                                </span>
                            @else
                                <span style="background:rgba(255,255,255,0.06); color:#8b949e; font-size:11px; font-weight:600; padding:3px 10px; border-radius:999px;">
                                    Free
                                </span>
                            @endif
                        </td>
                        <td style="padding:14px 20px;">
                            @if($user->is_deactivated)
                                <span style="background:rgba(239,68,68,0.15); color:#ef4444; font-size:11px; font-weight:600; padding:3px 10px; border-radius:999px; border:1px solid rgba(239,68,68,0.3);">
                                    <i class="fa-solid fa-power-off" style="margin-right:3px;"></i> Deactivated
                                </span>
                            @else
                                <span style="background:rgba(34,197,94,0.15); color:#22c55e; font-size:11px; font-weight:600; padding:3px 10px; border-radius:999px; border:1px solid rgba(34,197,94,0.3);">
                                    <i class="fa-solid fa-circle" style="font-size:7px; margin-right:3px;"></i> Active
                                </span>
                            @endif
                        </td>
                        <td style="padding:14px 20px; color:#8b949e; font-size:13px;">{{ $user->created_at->format('M d, Y') }}</td>
                        <td style="padding:14px 20px;">
                            <div style="display:flex; gap:6px; flex-wrap:wrap; align-items:center;">
                                <a href="{{ route('profile.view', $user->id) }}" target="_blank"
                                    style="background:#21262d; border:1px solid #30363d; color:#d1d7db; font-size:12px; font-weight:500; padding:5px 10px; border-radius:6px; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                                    <i class="fa-solid fa-eye"></i> View
                                </a>
                                <form method="POST" action="{{ route('admin.user.toggle', $user->id) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit"
                                        style="background:{{ in_array($user->subscription_plan, ['premium','gold']) ? 'rgba(239,68,68,0.1)' : 'rgba(245,158,11,0.1)' }}; border:1px solid {{ in_array($user->subscription_plan, ['premium','gold']) ? 'rgba(239,68,68,0.3)' : 'rgba(245,158,11,0.3)' }}; color:{{ in_array($user->subscription_plan, ['premium','gold']) ? '#ef4444' : '#f59e0b' }}; font-size:12px; font-weight:500; padding:5px 10px; border-radius:6px; cursor:pointer;">
                                        {{ in_array($user->subscription_plan, ['premium','gold']) ? 'Revoke' : 'Make Premium' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.user.toggleFeatured', $user->id) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit"
                                        style="background:{{ $user->is_featured ? 'rgba(139,92,246,0.1)' : 'rgba(255,255,255,0.06)' }}; border:1px solid {{ $user->is_featured ? 'rgba(139,92,246,0.3)' : 'rgba(255,255,255,0.15)' }}; color:{{ $user->is_featured ? '#8b5cf6' : '#8b949e' }}; font-size:12px; font-weight:500; padding:5px 10px; border-radius:6px; cursor:pointer;">
                                        <i class="fa-{{ $user->is_featured ? 'solid' : 'regular' }} fa-star" style="margin-right:3px;"></i>
                                        {{ $user->is_featured ? 'Unfeature' : 'Feature' }}
                                    </button>
                                </form>
                                @if($user->is_deactivated)
                                    <form method="POST" action="{{ route('admin.user.reactivate', $user->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit"
                                            style="background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3); color:#22c55e; font-size:12px; font-weight:500; padding:5px 10px; border-radius:6px; cursor:pointer;">
                                            <i class="fa-solid fa-rotate-right"></i> Reactivate
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.user.deactivate', $user->id) }}" style="display:inline;" onsubmit="return confirm('Deactivate {{ $user->name }}? They will not be able to log in.');">
                                        @csrf
                                        <button type="submit"
                                            style="background:rgba(249,115,22,0.1); border:1px solid rgba(249,115,22,0.3); color:#f97316; font-size:12px; font-weight:500; padding:5px 10px; border-radius:6px; cursor:pointer;">
                                            <i class="fa-solid fa-power-off"></i> Deactivate
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.user.delete', $user->id) }}" style="display:inline;" onsubmit="return confirm('Permanently delete {{ $user->name }}? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); color:#ef4444; font-size:12px; font-weight:500; padding:5px 10px; border-radius:6px; cursor:pointer;">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align:center; padding:40px; color:#8b949e; font-size:14px;">
                            <i class="fa-solid fa-users" style="font-size:28px; margin-bottom:10px; display:block; opacity:0.3;"></i>
                            No users found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div style="padding:16px 20px; display:flex; align-items:center; justify-content:space-between; border-top:1px solid #21262d;">
            <p style="color:#8b949e; font-size:13px; margin:0;">Showing {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users</p>
            <div style="display:flex; gap:6px;">
                @if($users->onFirstPage())
                    <span style="background:#21262d; color:#4b5563; padding:6px 12px; border-radius:6px; font-size:13px;">← Prev</span>
                @else
                    <a href="{{ $users->previousPageUrl() }}" style="background:#21262d; color:#d1d7db; padding:6px 12px; border-radius:6px; font-size:13px; text-decoration:none;">← Prev</a>
                @endif
                @if($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" style="background:#720e9e; color:white; padding:6px 12px; border-radius:6px; font-size:13px; text-decoration:none;">Next →</a>
                @else
                    <span style="background:#21262d; color:#4b5563; padding:6px 12px; border-radius:6px; font-size:13px;">Next →</span>
                @endif
            </div>
        </div>
    </div>

@endsection