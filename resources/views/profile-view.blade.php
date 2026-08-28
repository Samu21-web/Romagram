@extends('layouts.app-auth')
@section('title', $profile->name)

@section('content')
<div style="max-width:1000px; margin:0 auto; padding:24px 16px;">

    <!-- Back button -->
    <a href="{{ route('discover') }}"
        style="display:inline-flex; align-items:center; gap:8px; color:#8696a0; text-decoration:none; font-size:14px; margin-bottom:16px; transition:color 0.2s;"
        onmouseover="this.style.color='white'" onmouseout="this.style.color='#8696a0'">
        <i class="fa-solid fa-arrow-left"></i> Back to Discover
    </a>

    <!-- Upgrade banner for free users -->
    @if(!$isPremium)
        <div style="background:linear-gradient(to right, rgba(245,158,11,0.15), rgba(245,158,11,0.05)); border:1px solid rgba(245,158,11,0.25); border-radius:16px; padding:14px 20px; margin-bottom:20px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div style="display:flex; align-items:center; gap:12px;">
                <div style="width:38px; height:38px; background:rgba(245,158,11,0.2); border-radius:0%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fa-solid fa-crown" style="color:#f59e0b; font-size:16px;"></i>
                </div>
                <div>
                    <p style="color:white; font-weight:700; font-size:14px; margin:0;">Unlock full access to this profile</p>
                    <p style="color:#8696a0; font-size:13px; margin:2px 0 0;">Get WhatsApp, chat and more with Premium</p>
                </div>
            </div>
            <button onclick="showPremiumModal()"
                style="background:#f59e0b; color:#111b21; font-weight:700; font-size:13px; padding:10px 20px; border:none; border-radius:999px; cursor:pointer; white-space:nowrap; transition:all 0.2s; flex-shrink:0;"
                onmouseover="this.style.background='#d97706';"
                onmouseout="this.style.background='#f59e0b';">
                <i class="fa-solid fa-crown" style="margin-right:6px;"></i> Upgrade to Premium
            </button>
        </div>
    @endif

    <!-- Main profile card -->
    <div style="background:#1f2c34; border-radius:10px; overflow:hidden; border:1px solid #2a3942; box-shadow:0 8px 32px rgba(0,0,0,0.3);">
        <div class="rp-profile-grid" style="display:grid; grid-template-columns:340px 1fr; min-height:520px;">

            <!-- LEFT: Photos -->
            <div style="border-right:1px solid #2a3942;">
                <!-- Main photo -->
                <div class="rp-profile-photo" style="position:relative; height:380px; overflow:hidden; {{ $profile->avatar ? 'cursor:pointer;' : '' }}"
                     @if($profile->avatar) onclick="openLightbox(0)" @endif>
                    @if($profile->avatar)
                        <img src="{{ asset('storage/' . $profile->avatar) }}"
                             style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <div style="width:100%; height:100%; background:linear-gradient(135deg,#1a1a2e,#16213e); display:flex; align-items:center; justify-content:center;">
                            <i class="fa-solid fa-user" style="font-size:80px; color:rgba(255,255,255,0.1);"></i>
                        </div>
                    @endif
                    <!-- Online badge -->
                    <div style="position:absolute; top:14px; right:14px; display:flex; align-items:center; gap:6px; background:rgba(0,0,0,0.6); backdrop-filter:blur(10px); padding:5px 12px; border-radius:999px; border:1px solid rgba(255,255,255,0.1);">
                        <div style="width:7px; height:7px; background:#22c55e; border-radius:50%;"></div>
                        <span style="color:white; font-size:12px; font-weight:600;">Online</span>
                    </div>
                    @if($profile->avatar)
                        <div style="position:absolute; bottom:14px; right:14px; background:rgba(0,0,0,0.6); backdrop-filter:blur(10px); width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; border:1px solid rgba(255,255,255,0.1);">
                            <i class="fa-solid fa-magnifying-glass-plus" style="color:white; font-size:13px;"></i>
                        </div>
                    @endif
                </div>

                <!-- More photos -->
                <div style="padding:12px; background:#182028;">
                    <p style="color:#8696a0; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 10px;">More Photos</p>
                    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:6px;">
                        <div style="aspect-ratio:1; border-radius:8px; overflow:hidden; border:2px solid rgba(255,255,255,0.2); {{ $profile->avatar ? 'cursor:pointer;' : '' }}"
                             @if($profile->avatar) onclick="openLightbox(0)" @endif>
                            @if($profile->avatar)
                                <img src="{{ asset('storage/' . $profile->avatar) }}" style="width:100%; height:100%; object-fit:cover;">
                            @else
                                <div style="width:100%; height:100%; background:#2a3942;"></div>
                            @endif
                        </div>
                        @for($i = 0; $i < 3; $i++)
                            <div style="aspect-ratio:1; border-radius:8px; background:#2a3942; border:1px dashed rgba(255,255,255,0.1); display:flex; align-items:center; justify-content:center;">
                                <i class="fa-solid fa-plus" style="color:rgba(255,255,255,0.15); font-size:14px;"></i>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

<!-- RIGHT: Profile details -->
<div style="padding:28px; display:flex; flex-direction:column; gap:18px;">

    <!-- Name & location -->
    <div>
        <h1 style="color:white; font-size:30px; font-weight:800; margin:0 0 8px;">{{ $profile->name }}, {{ $profile->age }}</h1>
        @if($profile->city)
            <p style="color:#8696a0; font-size:15px; margin:0;">
                <i class="fa-solid fa-location-dot" style="margin-right:6px;"></i>
                {{ $profile->city }}@if($profile->country), {{ $profile->country }}@endif
            </p>
        @endif
    </div>

    <!-- Action buttons -->
    <div class="rp-profile-actions" style="display:grid; grid-template-columns:repeat(3,1fr); gap:10px;">

        <!-- Save -->
        <button id="favBtn" onclick="toggleFavourite({{ $profile->id }})"
            style="display:flex; flex-direction:column; align-items:center; gap:8px; padding:18px 10px; background:{{ $isFavourited ? 'rgba(251,191,36,0.12)' : 'rgba(255,255,255,0.04)' }}; border:1.5px solid {{ $isFavourited ? 'rgba(251,191,36,0.4)' : 'rgba(255,255,255,0.12)' }}; border-radius:6px; cursor:pointer; color:{{ $isFavourited ? '#fbbf24' : '#8696a0' }}; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(251,191,36,0.12)'; this.style.borderColor='rgba(251,191,36,0.4)'; this.style.color='#fbbf24';"
            onmouseout="if(!window.isFaved{{ $profile->id }}){ this.style.background='rgba(255,255,255,0.04)'; this.style.borderColor='rgba(255,255,255,0.12)'; this.style.color='#8696a0'; }">
            <i class="fa-{{ $isFavourited ? 'solid' : 'regular' }} fa-star" style="font-size:24px;" id="favIcon-{{ $profile->id }}"></i>
            <span style="font-size:13px; font-weight:600;" id="favLabel-{{ $profile->id }}">{{ $isFavourited ? 'Saved' : 'Save' }}</span>
        </button>

        <!-- WhatsApp -->
        @if($isPremium)
            <a href="https://wa.me/{{ ltrim($profile->phone, '+') }}" target="_blank"
                style="display:flex; flex-direction:column; align-items:center; gap:8px; padding:18px 10px; background:rgba(37,211,102,0.08); border:1.5px solid rgba(37,211,102,0.25); border-radius:6px; cursor:pointer; color:#25d366; text-decoration:none; transition:all 0.2s;"
                onmouseover="this.style.background='rgba(37,211,102,0.18)'; this.style.borderColor='rgba(37,211,102,0.5)';"
                onmouseout="this.style.background='rgba(37,211,102,0.08)'; this.style.borderColor='rgba(37,211,102,0.25)';">
                <i class="fa-brands fa-whatsapp" style="font-size:24px;"></i>
                <span style="font-size:13px; font-weight:600;">WhatsApp</span>
            </a>
        @else
            <button onclick="showPremiumModal()"
                style="display:flex; flex-direction:column; align-items:center; gap:8px; padding:18px 10px; background:rgba(255,255,255,0.02); border:1.5px solid rgba(255,255,255,0.06); border-radius:6px; cursor:pointer; color:#4b5563; position:relative; transition:all 0.2s;"
                onmouseover="this.style.background='rgba(255,255,255,0.06)';"
                onmouseout="this.style.background='rgba(255,255,255,0.02)';">
                <i class="fa-brands fa-whatsapp" style="font-size:24px;"></i>
                <span style="font-size:13px; font-weight:600;">WhatsApp</span>
                <div style="position:absolute; top:8px; right:8px; background:#f59e0b; width:18px; height:18px; border-radius:6%; display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-lock" style="font-size:8px; color:white;"></i>
                </div>
            </button>
        @endif

        <!-- Chat -->
        @if($isPremium)
            <a href="{{ route('chat.open', $profile->id) }}"
                style="display:flex; flex-direction:column; align-items:center; gap:8px; padding:18px 10px; background:rgba(99,102,241,0.08); border:1.5px solid rgba(99,102,241,0.25); border-radius:6px; cursor:pointer; color:#818cf8; text-decoration:none; transition:all 0.2s;"
                onmouseover="this.style.background='rgba(99,102,241,0.18)'; this.style.borderColor='rgba(99,102,241,0.5)';"
                onmouseout="this.style.background='rgba(99,102,241,0.08)'; this.style.borderColor='rgba(99,102,241,0.25)';">
                <i class="fa-solid fa-message" style="font-size:24px;"></i>
                <span style="font-size:13px; font-weight:600;">Chat</span>
            </a>
        @else
            <button onclick="showPremiumModal()"
                style="display:flex; flex-direction:column; align-items:center; gap:8px; padding:18px 10px; background:rgba(255,255,255,0.02); border:1.5px solid rgba(255,255,255,0.06); border-radius:16px; cursor:pointer; color:#4b5563; position:relative; transition:all 0.2s;"
                onmouseover="this.style.background='rgba(255,255,255,0.06)';"
                onmouseout="this.style.background='rgba(255,255,255,0.02)';">
                <i class="fa-solid fa-message" style="font-size:24px;"></i>
                <span style="font-size:13px; font-weight:600;">Chat</span>
                <div style="position:absolute; top:8px; right:8px; background:#f59e0b; width:18px; height:18px; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-lock" style="font-size:8px; color:white;"></i>
                </div>
            </button>
        @endif
    </div>

    <!-- About section — no repetition -->
    <div style="background:rgba(255,255,255,0.03); border-radius:6px; padding:18px; border:1px solid rgba(255,255,255,0.06); flex:1;">
        <p style="color:#8696a0; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 16px;">
            <i class="fa-solid fa-circle-info" style="margin-right:6px;"></i> About
        </p>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:16px;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:34px; height:34px; background:rgba(255,255,255,0.06); border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fa-solid fa-{{ $profile->gender === 'male' ? 'mars' : 'venus' }}" style="color:#8696a0; font-size:14px;"></i>
                </div>
                <div>
                    <p style="color:#8696a0; font-size:11px; margin:0;">Gender</p>
                    <p style="color:white; font-size:13px; font-weight:600; margin:2px 0 0;">{{ ucfirst($profile->gender) }}</p>
                </div>
            </div>
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:34px; height:34px; background:rgba(255,255,255,0.06); border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fa-solid fa-heart" style="color:#8696a0; font-size:14px;"></i>
                </div>
                <div>
                    <p style="color:#8696a0; font-size:11px; margin:0;">Looking For</p>
                    <p style="color:white; font-size:13px; font-weight:600; margin:2px 0 0;">{{ ucfirst($profile->interested_in) }}</p>
                </div>
            </div>
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:34px; height:34px; background:rgba(255,255,255,0.06); border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fa-solid fa-cake-candles" style="color:#8696a0; font-size:14px;"></i>
                </div>
                <div>
                    <p style="color:#8696a0; font-size:11px; margin:0;">Age</p>
                    <p style="color:white; font-size:13px; font-weight:600; margin:2px 0 0;">{{ $profile->age }} years old</p>
                </div>
            </div>
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:34px; height:34px; background:rgba(255,255,255,0.06); border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fa-solid fa-location-dot" style="color:#8696a0; font-size:14px;"></i>
                </div>
                <div>
                    <p style="color:#8696a0; font-size:11px; margin:0;">Location</p>
                    <p style="color:white; font-size:13px; font-weight:600; margin:2px 0 0;">{{ $profile->city ?? 'Not set' }}</p>
                </div>
            </div>
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:34px; height:34px; background:rgba(255,255,255,0.06); border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fa-solid fa-calendar" style="color:#8696a0; font-size:14px;"></i>
                </div>
                <div>
                    <p style="color:#8696a0; font-size:11px; margin:0;">Member Since</p>
                    <p style="color:white; font-size:13px; font-weight:600; margin:2px 0 0;">{{ $profile->created_at->format('M Y') }}</p>
                </div>
            </div>
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:34px; height:34px; background:rgba(34,197,94,0.1); border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fa-solid fa-circle" style="color:#22c55e; font-size:9px;"></i>
                </div>
                <div>
                    <p style="color:#8696a0; font-size:11px; margin:0;">Status</p>
                    <p style="color:#22c55e; font-size:13px; font-weight:600; margin:2px 0 0;">Online Now</p>
                </div>
            </div>
        </div>

    
    </div>

</div>
        </div>
    </div>
</div>

<!-- Premium Modal -->
<div id="premiumModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.85); z-index:200;">
    <div style="background:#1f2c34; border:1px solid #2a3942; border-radius:0px; padding:10px; max-width:400px; width:90%; text-align:center; box-shadow:0 20px 60px rgba(0,0,0,0.5); position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);">
        <div style="width:70px; height:70px; background:rgba(245,158,11,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px; border:2px solid rgba(245,158,11,0.3);">
            <i class="fa-solid fa-crown" style="font-size:30px; color:#f59e0b;"></i>
        </div>
        <h2 style="font-size:24px; font-weight:800; color:white; margin-bottom:8px;">Upgrade to Premium</h2>
        <p style="color:#8696a0; font-size:15px; margin-bottom:28px; line-height:1.6;">Unlock all profiles, WhatsApp contacts, live chat and more.</p>
        <div style="display:flex; flex-direction:column; gap:12px; margin-bottom:28px; text-align:left;">
            <div style="display:flex; align-items:center; gap:12px; color:#d1d7db; font-size:14px;">
                <i class="fa-solid fa-check" style="color:#22c55e; width:16px;"></i> View unlimited profiles
            </div>
            <div style="display:flex; align-items:center; gap:12px; color:#d1d7db; font-size:14px;">
                <i class="fa-solid fa-check" style="color:#22c55e; width:16px;"></i> WhatsApp direct messaging
            </div>
            <div style="display:flex; align-items:center; gap:12px; color:#d1d7db; font-size:14px;">
                <i class="fa-solid fa-check" style="color:#22c55e; width:16px;"></i> Live chat with matches
            </div>
            <div style="display:flex; align-items:center; gap:12px; color:#d1d7db; font-size:14px;">
                <i class="fa-solid fa-check" style="color:#22c55e; width:16px;"></i> See who liked you
            </div>
        </div>
        <a href="{{ route('pricing') }}"
            style="display:block; background:white; color:#111b21; font-weight:700; font-size:16px; padding:14px; border-radius:999px; text-decoration:none; margin-bottom:12px; text-align:center;">
            <i class="fa-solid fa-crown" style="color:#f59e0b; margin-right:8px;"></i> Upgrade Now
        </a>
        <button onclick="closePremiumModal()"
            style="background:none; border:none; color:#8696a0; font-size:14px; cursor:pointer; padding:8px;">
            Maybe later
        </button>
    </div>
</div>

<!-- Lightbox Modal -->
<div id="lightboxModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.95); z-index:300; align-items:center; justify-content:center; flex-direction:column;">

    <!-- Close button -->
    <button onclick="closeLightbox()"
        style="position:absolute; top:20px; right:20px; width:44px; height:44px; background:rgba(255,255,255,0.1); border:none; border-radius:50%; color:white; font-size:18px; cursor:pointer; display:flex; align-items:center; justify-content:center; z-index:2; transition:background 0.2s;"
        onmouseover="this.style.background='rgba(255,255,255,0.2)'"
        onmouseout="this.style.background='rgba(255,255,255,0.1)'">
        <i class="fa-solid fa-xmark"></i>
    </button>

    <!-- Zoom toggle button -->
    <button onclick="toggleZoom(event)" id="zoomBtn"
        style="position:absolute; top:20px; right:76px; width:44px; height:44px; background:rgba(255,255,255,0.1); border:none; border-radius:50%; color:white; font-size:16px; cursor:pointer; display:flex; align-items:center; justify-content:center; z-index:2; transition:background 0.2s;"
        onmouseover="this.style.background='rgba(255,255,255,0.2)'"
        onmouseout="this.style.background='rgba(255,255,255,0.1)'">
        <i class="fa-solid fa-magnifying-glass-plus" id="zoomIcon"></i>
    </button>

    <!-- Prev/Next nav (only shown if more than 1 photo) -->
    <button onclick="lightboxPrev(event)" id="lightboxPrevBtn"
        style="display:none; position:absolute; left:20px; top:50%; transform:translateY(-50%); width:48px; height:48px; background:rgba(255,255,255,0.1); border:none; border-radius:50%; color:white; font-size:20px; cursor:pointer; align-items:center; justify-content:center; z-index:2;">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    <button onclick="lightboxNext(event)" id="lightboxNextBtn"
        style="display:none; position:absolute; right:20px; top:50%; transform:translateY(-50%); width:48px; height:48px; background:rgba(255,255,255,0.1); border:none; border-radius:50%; color:white; font-size:20px; cursor:pointer; align-items:center; justify-content:center; z-index:2;">
        <i class="fa-solid fa-chevron-right"></i>
    </button>

    <!-- Image container -->
    <div id="lightboxImgWrap" onclick="closeLightboxOnBackdrop(event)"
         style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; overflow:auto; cursor:zoom-in;">
        <img id="lightboxImg" src="" onclick="toggleZoom(event)"
             style="max-width:90%; max-height:85vh; object-fit:contain; border-radius:8px; transition:transform 0.25s ease; transform:scale(1); cursor:zoom-in;">
    </div>

    <!-- Counter -->
    <div id="lightboxCounter" style="position:absolute; bottom:24px; left:50%; transform:translateX(-50%); background:rgba(255,255,255,0.1); color:white; font-size:13px; font-weight:600; padding:6px 16px; border-radius:999px;"></div>
</div>

<style>
    @media (max-width: 768px) {
        .rp-profile-grid {
            grid-template-columns: 1fr !important;
            min-height: unset !important;
        }
        .rp-profile-photo {
            height: 300px !important;
        }
        .rp-profile-actions {
            gap: 8px !important;
        }
    }

    @media (max-width: 480px) {
        .rp-profile-photo {
            height: 260px !important;
        }
    }
</style>

@push('scripts')
<script>
    window.isFaved{{ $profile->id }} = {{ $isFavourited ? 'true' : 'false' }};

    async function toggleFavourite(id) {
        const res = await fetch('/favourite/' + id, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        });
        const data = await res.json();
        window['isFaved' + id] = data.favourited;

        const btn = document.getElementById('favBtn');
        const icon = document.getElementById('favIcon-' + id);
        const label = document.getElementById('favLabel-' + id);

        if (data.favourited) {
            icon.className = 'fa-solid fa-star';
            label.textContent = 'Saved';
            btn.style.background = 'rgba(251,191,36,0.12)';
            btn.style.borderColor = 'rgba(251,191,36,0.4)';
            btn.style.color = '#fbbf24';
        } else {
            icon.className = 'fa-regular fa-star';
            label.textContent = 'Save';
            btn.style.background = 'rgba(255,255,255,0.04)';
            btn.style.borderColor = 'rgba(255,255,255,0.12)';
            btn.style.color = '#8696a0';
        }
    }

    function showPremiumModal() {
        document.getElementById('premiumModal').style.display = 'block';
    }

    function closePremiumModal() {
        document.getElementById('premiumModal').style.display = 'none';
    }

    // ── Lightbox ──
    // Currently just the avatar; extend this array once extra photos are wired into this view.
    const lightboxImages = [
        @if($profile->avatar)
            '{{ asset('storage/' . $profile->avatar) }}',
        @endif
    ];

    let lightboxIndex = 0;
    let isZoomed = false;

    function openLightbox(index) {
        if (lightboxImages.length === 0) return;
        lightboxIndex = index;
        isZoomed = false;
        renderLightbox();
        document.getElementById('lightboxModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightboxModal').style.display = 'none';
        document.body.style.overflow = '';
        isZoomed = false;
    }

    function closeLightboxOnBackdrop(e) {
        if (e.target.id === 'lightboxImgWrap') closeLightbox();
    }

    function renderLightbox() {
        const img = document.getElementById('lightboxImg');
        img.src = lightboxImages[lightboxIndex];
        img.style.transform = 'scale(1)';
        isZoomed = false;
        document.getElementById('zoomIcon').className = 'fa-solid fa-magnifying-glass-plus';

        const hasMultiple = lightboxImages.length > 1;
        document.getElementById('lightboxPrevBtn').style.display = hasMultiple ? 'flex' : 'none';
        document.getElementById('lightboxNextBtn').style.display = hasMultiple ? 'flex' : 'none';
        document.getElementById('lightboxCounter').textContent = hasMultiple
            ? (lightboxIndex + 1) + ' / ' + lightboxImages.length
            : '';
    }

    function lightboxPrev(e) {
        e.stopPropagation();
        lightboxIndex = (lightboxIndex - 1 + lightboxImages.length) % lightboxImages.length;
        renderLightbox();
    }

    function lightboxNext(e) {
        e.stopPropagation();
        lightboxIndex = (lightboxIndex + 1) % lightboxImages.length;
        renderLightbox();
    }

    function toggleZoom(e) {
        e.stopPropagation();
        const img = document.getElementById('lightboxImg');
        isZoomed = !isZoomed;
        img.style.transform = isZoomed ? 'scale(2.2)' : 'scale(1)';
        img.style.cursor = isZoomed ? 'zoom-out' : 'zoom-in';
        document.getElementById('lightboxImgWrap').style.cursor = isZoomed ? 'zoom-out' : 'zoom-in';
        document.getElementById('zoomIcon').className = isZoomed
            ? 'fa-solid fa-magnifying-glass-minus'
            : 'fa-solid fa-magnifying-glass-plus';
    }

    // Keyboard controls
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('lightboxModal');
        if (modal.style.display !== 'flex') return;

        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft' && lightboxImages.length > 1) lightboxPrev(e);
        if (e.key === 'ArrowRight' && lightboxImages.length > 1) lightboxNext(e);
    });
</script>
@endpush
@endsection