@extends('layouts.app-auth')
@section('title', 'Upgrade to Premium')

@section('content')
<div style="max-width:900px; margin:0 auto; padding:40px 16px;">

    <!-- Success / Error messages -->
    @if(session('success'))
        <div style="background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3); border-radius:12px; padding:14px 18px; margin-bottom:24px; color:#22c55e; font-size:15px; display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); border-radius:12px; padding:14px 18px; margin-bottom:24px; color:#ef4444; font-size:15px; display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Header -->
    <div style="text-align:center; margin-bottom:48px;">
        <div style="width:64px; height:64px; background:rgba(245,158,11,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; border:2px solid rgba(245,158,11,0.3);">
            <i class="fa-solid fa-crown" style="font-size:28px; color:#f59e0b;"></i>
        </div>
        <h1 style="color:white; font-size:32px; font-weight:800; margin:0 0 12px;">Upgrade to Premium</h1>
        <p style="color:#8696a0; font-size:16px; margin:0;">Unlock all features and find your perfect match</p>
    </div>

    <!-- Features list -->
    <div style="background:#1f2c34; border-radius:20px; padding:24px; margin-bottom:40px; border:1px solid #2a3942;">
        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px;">
            <div style="display:flex; align-items:center; gap:10px; color:#d1d7db; font-size:14px;">
                <i class="fa-solid fa-check" style="color:#22c55e;"></i> Unlimited profiles
            </div>
            <div style="display:flex; align-items:center; gap:10px; color:#d1d7db; font-size:14px;">
                <i class="fa-solid fa-check" style="color:#22c55e;"></i> WhatsApp messaging
            </div>
            <div style="display:flex; align-items:center; gap:10px; color:#d1d7db; font-size:14px;">
                <i class="fa-solid fa-check" style="color:#22c55e;"></i> Live chat
            </div>
            <div style="display:flex; align-items:center; gap:10px; color:#d1d7db; font-size:14px;">
                <i class="fa-solid fa-check" style="color:#22c55e;"></i> See who liked you
            </div>
            <div style="display:flex; align-items:center; gap:10px; color:#d1d7db; font-size:14px;">
                <i class="fa-solid fa-check" style="color:#22c55e;"></i> Priority matching
            </div>
            <div style="display:flex; align-items:center; gap:10px; color:#d1d7db; font-size:14px;">
                <i class="fa-solid fa-check" style="color:#22c55e;"></i> No ads ever
            </div>
        </div>
    </div>

    <!-- Pricing cards -->
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:32px;">
        @foreach($packages as $package)
            <div style="background:#1f2c34; border-radius:20px; padding:28px; border:1px solid {{ $package->slug === 'weekly' ? 'rgba(245,158,11,0.4)' : '#2a3942' }}; position:relative; text-align:center; transition:all 0.2s;"
                 onmouseover="this.style.borderColor='rgba(255,255,255,0.2)'; this.style.transform='translateY(-4px)';"
                 onmouseout="this.style.borderColor='{{ $package->slug === 'weekly' ? 'rgba(245,158,11,0.4)' : '#2a3942' }}'; this.style.transform='';">

                @if($package->slug === 'weekly')
                    <div style="position:absolute; top:-12px; left:50%; transform:translateX(-50%); background:#f59e0b; color:#111; font-size:11px; font-weight:700; padding:4px 14px; border-radius:999px; white-space:nowrap;">
                        MOST POPULAR
                    </div>
                @endif

                <!-- Icon -->
                <div style="width:52px; height:52px; background:rgba(255,255,255,0.06); border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                    <i class="fa-solid fa-{{ $package->slug === 'daily' ? 'sun' : ($package->slug === 'weekly' ? 'calendar-week' : 'calendar') }}"
                       style="font-size:22px; color:{{ $package->slug === 'weekly' ? '#f59e0b' : '#8696a0' }};"></i>
                </div>

                <h3 style="color:white; font-size:20px; font-weight:700; margin:0 0 8px;">{{ $package->name }}</h3>
                <p style="color:#8696a0; font-size:13px; margin:0 0 20px;">{{ $package->description }}</p>

                <div style="margin-bottom:24px;">
                    <span style="color:white; font-size:36px; font-weight:800;">KES {{ number_format($package->price) }}</span>
                    <span style="color:#8696a0; font-size:14px;"> / {{ $package->duration_days }} {{ $package->duration_days === 1 ? 'day' : 'days' }}</span>
                </div>

                <!-- Form submits to initiate and redirects to Paystack -->
                <form method="POST" action="{{ route('payment.initiate') }}">
                    @csrf
                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                    <button type="submit"
                        style="width:100%; background:{{ $package->slug === 'weekly' ? '#f59e0b' : 'rgba(255,255,255,0.08)' }}; color:{{ $package->slug === 'weekly' ? '#111' : 'white' }}; font-weight:700; font-size:15px; padding:13px; border:{{ $package->slug === 'weekly' ? 'none' : '1.5px solid rgba(255,255,255,0.15)' }}; border-radius:12px; cursor:pointer; transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:8px;"
                        onmouseover="this.style.opacity='0.85'"
                        onmouseout="this.style.opacity='1'"
                        onclick="this.innerHTML='<i class=\'fa-solid fa-spinner fa-spin\'></i> Redirecting...'; this.disabled=true; this.closest(\'form\').submit();">
                        <i class="fa-solid fa-lock" style="font-size:13px;"></i>
                        Get {{ $package->name }} Access
                    </button>
                </form>
            </div>
        @endforeach
    </div>

    <!-- Trust badges -->
    <div style="display:flex; align-items:center; justify-content:center; gap:28px; flex-wrap:wrap;">
        <div style="display:flex; align-items:center; gap:8px; color:#8696a0; font-size:13px;">
            <i class="fa-solid fa-shield-halved" style="color:#22c55e;"></i>
            Secure payment via Paystack
        </div>
        <div style="display:flex; align-items:center; gap:8px; color:#8696a0; font-size:13px;">
            <i class="fa-solid fa-mobile-screen" style="color:#22c55e;"></i>
            M-Pesa accepted
        </div>
        <div style="display:flex; align-items:center; gap:8px; color:#8696a0; font-size:13px;">
            <i class="fa-solid fa-credit-card" style="color:#22c55e;"></i>
            Cards accepted
        </div>
        <div style="display:flex; align-items:center; gap:8px; color:#8696a0; font-size:13px;">
            <i class="fa-solid fa-rotate-left" style="color:#22c55e;"></i>
            Cancel anytime
        </div>
    </div>

</div>
@endsection