<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rompace Admin - @yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body style="font-family:'Inter',sans-serif; margin:0; padding:0; background:#0d1117; display:flex; min-height:100vh;">

    <!-- Sidebar -->
    <div style="width:240px; background:#161b22; border-right:1px solid #21262d; position:fixed; top:0; left:0; height:100vh; display:flex; flex-direction:column; z-index:50;">

        <!-- Logo -->
        <div style="padding:24px 20px; border-bottom:1px solid #21262d;">
            <div style="display:flex; align-items:center; gap:10px;">
                <img src="{{ asset('logo.png') }}" alt="Rompace" style="height:36px;">
                <div>
                    <p style="color:white; font-weight:800; font-size:15px; margin:0;">Rompace</p>
                    <p style="color:#8b949e; font-size:11px; margin:0;">Admin Panel</p>
                </div>
            </div>
        </div>

        <!-- Nav links -->
        <nav style="padding:16px 12px; flex:1;">
            <a href="{{ route('admin.dashboard') }}"
               style="display:flex; align-items:center; gap:10px; padding:10px 14px; border-radius:10px; text-decoration:none; font-size:14px; font-weight:500; margin-bottom:4px; {{ request()->routeIs('admin.dashboard') ? 'background:rgba(114,14,158,0.2); color:white;' : 'color:#8b949e;' }}"
               onmouseover="this.style.background='rgba(255,255,255,0.06)'; this.style.color='white';"
               onmouseout="if(!{{ request()->routeIs('admin.dashboard') ? 'true' : 'false' }}){ this.style.background='transparent'; this.style.color='#8b949e'; }">
                <i class="fa-solid fa-gauge" style="width:16px;"></i> Dashboard
            </a>
            <a href="{{ route('admin.users') }}"
               style="display:flex; align-items:center; gap:10px; padding:10px 14px; border-radius:10px; text-decoration:none; font-size:14px; font-weight:500; margin-bottom:4px; {{ request()->routeIs('admin.users*') ? 'background:rgba(114,14,158,0.2); color:white;' : 'color:#8b949e;' }}"
               onmouseover="this.style.background='rgba(255,255,255,0.06)'; this.style.color='white';"
               onmouseout="if(!{{ request()->routeIs('admin.users*') ? 'true' : 'false' }}){ this.style.background='transparent'; this.style.color='#8b949e'; }">
                <i class="fa-solid fa-users" style="width:16px;"></i> Users
                <span style="margin-left:auto; background:#21262d; color:#8b949e; font-size:11px; font-weight:600; padding:2px 8px; border-radius:999px;">{{ \App\Models\User::where('is_admin',false)->count() }}</span>
            </a>
            <a href="{{ route('admin.payments') }}"
               style="display:flex; align-items:center; gap:10px; padding:10px 14px; border-radius:10px; text-decoration:none; font-size:14px; font-weight:500; margin-bottom:4px; color:#8b949e;"
               onmouseover="this.style.background='rgba(255,255,255,0.06)'; this.style.color='white';"
               onmouseout="this.style.background='transparent'; this.style.color='#8b949e';">
                <i class="fa-solid fa-credit-card" style="width:16px;"></i> Payments
            </a>
            <a href="{{ route('admin.packages') }}"
               style="display:flex; align-items:center; gap:10px; padding:10px 14px; border-radius:10px; text-decoration:none; font-size:14px; font-weight:500; margin-bottom:4px; color:#8b949e;"
               onmouseover="this.style.background='rgba(255,255,255,0.06)'; this.style.color='white';"
               onmouseout="this.style.background='transparent'; this.style.color='#8b949e';">
                <i class="fa-solid fa-box" style="width:16px;"></i> Packages
            </a>
            <a href="{{ route('admin.pages') }}"
   style="display:flex; align-items:center; gap:10px; padding:10px 14px; border-radius:10px; text-decoration:none; font-size:14px; font-weight:500; margin-bottom:4px; {{ request()->routeIs('admin.pages*') ? 'background:rgba(114,14,158,0.2); color:white;' : 'color:#8b949e;' }}"
   onmouseover="this.style.background='rgba(255,255,255,0.06)'; this.style.color='white';"
   onmouseout="if(!{{ request()->routeIs('admin.pages*') ? 'true' : 'false' }}){ this.style.background='transparent'; this.style.color='#8b949e'; }">
    <i class="fa-solid fa-file-lines" style="width:16px;"></i> Pages
</a>
        </nav>

        <!-- Bottom: logged in admin -->
        <div style="padding:16px 20px; border-top:1px solid #21262d;">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:12px;">
                <div style="width:34px; height:34px; border-radius:50%; background:#720e9e; display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:13px;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <p style="color:white; font-size:13px; font-weight:600; margin:0;">{{ auth()->user()->name }}</p>
                    <p style="color:#8b949e; font-size:11px; margin:0;">Administrator</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="width:100%; background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:#ef4444; font-size:13px; font-weight:600; padding:8px; border-radius:8px; cursor:pointer;">
                    <i class="fa-solid fa-right-from-bracket" style="margin-right:6px;"></i> Sign Out
                </button>
            </form>
        </div>
    </div>

    <!-- Main content -->
    <div style="margin-left:240px; flex:1; display:flex; flex-direction:column; min-height:100vh;">

        <!-- Top bar -->
        <div style="background:#161b22; border-bottom:1px solid #21262d; padding:16px 28px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:40;">
            <h1 style="color:white; font-size:18px; font-weight:700; margin:0;">@yield('title')</h1>
            <div style="display:flex; align-items:center; gap:12px;">
                <a href="{{ route('discover') }}" target="_blank"
                    style="background:rgba(255,255,255,0.06); border:1px solid #21262d; color:#8b949e; font-size:13px; font-weight:500; padding:7px 14px; border-radius:8px; text-decoration:none;">
                    <i class="fa-solid fa-arrow-up-right-from-square" style="margin-right:6px;"></i> View Site
                </a>
            </div>
        </div>

        <!-- Page content -->
        <div style="padding:28px; flex:1;">
            @if(session('success'))
                <div style="background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3); border-radius:12px; padding:12px 16px; margin-bottom:20px; color:#22c55e; font-size:14px;">
                    <i class="fa-solid fa-circle-check" style="margin-right:8px;"></i> {{ session('success') }}
                </div>
            @endif
            @yield('content')
        </div>
    </div>

</body>
</html>