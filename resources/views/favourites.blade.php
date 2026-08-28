@extends('layouts.app-auth')
@section('title', 'Favourites')

@section('content')

    <!-- Header -->
    <div style="background:#1f2c34; border-bottom:1px solid #2a3942; padding:16px 24px;">
        <div style="max-width:1200px; margin:0 auto; display:flex; align-items:center; justify-content:space-between;">
            <div>
                <h1 style="font-size:20px; font-weight:800; color:white; margin:0;">Favourites</h1>
                <p style="color:#8696a0; font-size:13px; margin:2px 0 0;">Profiles you have saved</p>
            </div>
            @if(!$favourites->isEmpty())
                <span style="background:rgba(251,191,36,0.12); border:1px solid rgba(251,191,36,0.3); color:#fbbf24; font-size:13px; font-weight:600; padding:6px 14px; border-radius:999px;">
                    <i class="fa-solid fa-star" style="margin-right:5px;"></i>
                    {{ $favourites->count() }} saved
                </span>
            @endif
        </div>
    </div>

    <div style="max-width:1200px; margin:0 auto; padding:24px;">

        @if($favourites->isEmpty())
            <div style="text-align:center; padding:80px 20px;">
                <div style="width:80px; height:80px; background:rgba(255,255,255,0.05); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                    <i class="fa-regular fa-star" style="font-size:32px; color:#8696a0;"></i>
                </div>
                <h3 style="font-size:20px; font-weight:700; color:white; margin-bottom:8px;">No favourites yet</h3>
                <p style="color:#8696a0; font-size:15px; margin-bottom:24px;">Star profiles on the Discover page to save them here.</p>
                <a href="{{ route('discover') }}"
                    style="background:white; color:#111b21; font-weight:700; padding:12px 28px; border-radius:999px; text-decoration:none; font-size:14px;">
                    <i class="fa-solid fa-fire" style="margin-right:8px;"></i> Go to Discover
                </a>
            </div>
        @else
            <div id="favGrid" class="grid grid-cols-2 gap-2.5 sm:[grid-template-columns:repeat(auto-fill,minmax(220px,1fr))] sm:gap-5">
                @foreach($favourites as $profile)
                    <div id="fav-card-{{ $profile->id }}"
                         style="background:#1f2c34; border-radius:20px; overflow:hidden; box-shadow:0 4px 16px rgba(0,0,0,0.3); transition:transform 0.2s, box-shadow 0.2s, opacity 0.4s; border:1px solid #2a3942;"
                         onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 32px rgba(0,0,0,0.4)'; this.style.borderColor='rgba(255,255,255,0.15)';"
                         onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.3)'; this.style.borderColor='#2a3942';">

                        <!-- Photo -->
                        <div class="h-[170px] sm:h-[280px]" style="position:relative; overflow:hidden;">
                            @if($profile->avatar)
                                <img src="{{ asset('storage/' . $profile->avatar) }}"
                                     style="width:100%; height:100%; object-fit:cover;">
                            @else
                                <div style="width:100%; height:100%; background:linear-gradient(135deg,#1a1a2e,#16213e); display:flex; align-items:center; justify-content:center;">
                                    <div style="width:80px; height:80px; border-radius:50%; background:rgba(255,255,255,0.05); display:flex; align-items:center; justify-content:center;">
                                        <i class="fa-solid fa-user" style="font-size:36px; color:rgba(255,255,255,0.2);"></i>
                                    </div>
                                </div>
                            @endif

                            <!-- Online dot -->
                            <div style="position:absolute; top:12px; right:12px; background:#22c55e; width:10px; height:10px; border-radius:50%; border:2px solid #1f2c34;"></div>

                            <!-- Saved badge -->
                            <div style="position:absolute; top:12px; left:12px; background:rgba(251,191,36,0.2); border:1px solid rgba(251,191,36,0.4); border-radius:999px; padding:4px 10px; display:flex; align-items:center; gap:4px;">
                                <i class="fa-solid fa-star" style="color:#fbbf24; font-size:10px;"></i>
                                <span style="color:#fbbf24; font-size:11px; font-weight:600;">Saved</span>
                            </div>

                            <!-- Gradient overlay -->
                            <div style="position:absolute; bottom:0; left:0; right:0; background:linear-gradient(to top, rgba(0,0,0,0.85) 0%, transparent 100%); padding:16px 14px 12px;">
                                <h3 style="color:white; font-size:17px; font-weight:700; margin:0 0 2px;">{{ $profile->name }}, {{ $profile->age }}</h3>
                                @if($profile->city)
                                    <p style="color:rgba(255,255,255,0.6); font-size:12px; margin:0;">
                                        <i class="fa-solid fa-location-dot" style="margin-right:4px;"></i>
                                        {{ $profile->city }}@if($profile->country), {{ $profile->country }}@endif
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Card body -->
                        <div style="padding:14px;">
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
                                <span style="background:rgba(255,255,255,0.08); color:#d1d7db; font-size:11px; font-weight:600; padding:4px 10px; border-radius:999px; border:1px solid rgba(255,255,255,0.1);">
                                    <i class="fa-solid fa-{{ $profile->gender === 'male' ? 'mars' : 'venus' }}" style="margin-right:4px;"></i>
                                    {{ ucfirst($profile->gender) }}
                                </span>

                                <!-- Remove from favourites -->
                                <button onclick="removeFav({{ $profile->id }}, '{{ $profile->name }}')"
                                    id="fav-star-{{ $profile->id }}"
                                    style="background:none; border:none; cursor:pointer; color:#fbbf24; font-size:18px; padding:4px; transition:all 0.2s; display:flex; align-items:center; gap:6px;"
                                    title="Remove from favourites"
                                    onmouseover="this.style.color='#ef4444'"
                                    onmouseout="this.style.color='#fbbf24'">
                                    <i class="fa-solid fa-star"></i>
                                </button>
                            </div>

                            <!-- Action buttons -->
                            <div class="flex gap-1.5 sm:gap-2">
                                <a href="{{ route('chat.open', $profile->id) }}"
                                    class="flex-1 flex items-center justify-center gap-1 sm:gap-1.5 rounded-lg sm:rounded-[10px] px-1 py-2 sm:px-2.5 sm:py-2.5 text-[11px] sm:text-[13px] font-semibold text-[#d1d7db] no-underline"
                                    style="background:transparent; border:1.5px solid rgba(255,255,255,0.2); transition:all 0.2s;"
                                    onmouseover="this.style.background='rgba(255,255,255,0.08)'; this.style.color='white';"
                                    onmouseout="this.style.background='transparent'; this.style.color='#d1d7db';">
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
                @endforeach
            </div>

            <!-- Empty state after all removed -->
            <div id="emptyState" style="display:none; text-align:center; padding:80px 20px;">
                <div style="width:80px; height:80px; background:rgba(255,255,255,0.05); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                    <i class="fa-regular fa-star" style="font-size:32px; color:#8696a0;"></i>
                </div>
                <h3 style="font-size:20px; font-weight:700; color:white; margin-bottom:8px;">No favourites left</h3>
                <p style="color:#8696a0; font-size:15px; margin-bottom:24px;">Discover more people and save them here.</p>
                <a href="{{ route('discover') }}"
                    style="background:white; color:#111b21; font-weight:700; padding:12px 28px; border-radius:999px; text-decoration:none; font-size:14px;">
                    <i class="fa-solid fa-fire" style="margin-right:8px;"></i> Go to Discover
                </a>
            </div>
        @endif
    </div>

<!-- Toast -->
<div id="toast" style="position:fixed; bottom:28px; left:50%; transform:translateX(-50%) translateY(20px); background:#1f2c34; border:1px solid #2a3942; border-radius:999px; padding:12px 22px; display:flex; align-items:center; gap:10px; box-shadow:0 8px 30px rgba(0,0,0,0.5); z-index:300; opacity:0; transition:all 0.3s ease; pointer-events:none; white-space:nowrap;">
    <i id="toastIcon" class="fa-solid fa-star" style="color:#fbbf24; font-size:15px;"></i>
    <span id="toastMsg" style="color:white; font-size:14px; font-weight:600;"></span>
</div>

@push('scripts')
<script>
    const csrfToken = '{{ csrf_token() }}';
    let toastTimer;

    function showToast(msg, icon = 'fa-star', color = '#fbbf24') {
        clearTimeout(toastTimer);
        const toast = document.getElementById('toast');
        document.getElementById('toastMsg').textContent  = msg;
        document.getElementById('toastIcon').className   = 'fa-solid ' + icon;
        document.getElementById('toastIcon').style.color = color;
        toast.style.opacity       = '1';
        toast.style.transform     = 'translateX(-50%) translateY(0)';
        toast.style.pointerEvents = 'auto';
        toastTimer = setTimeout(() => {
            toast.style.opacity       = '0';
            toast.style.transform     = 'translateX(-50%) translateY(20px)';
            toast.style.pointerEvents = 'none';
        }, 2800);
    }

    function updateFavBadge(delta) {
        document.querySelectorAll('[data-fav-badge]').forEach(el => {
            let count = parseInt(el.textContent) || 0;
            count = Math.max(0, count + delta);
            el.textContent = count;
            el.style.display = count > 0 ? 'inline-flex' : 'none';
        });
    }

    async function removeFav(userId, name) {
        try {
            const res = await fetch('/favourite/' + userId, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                }
            });
            const data = await res.json();

            if (!data.favourited) {
                // Animate card out
                const card = document.getElementById('fav-card-' + userId);
                if (card) {
                    card.style.transition = 'opacity 0.4s, transform 0.4s';
                    card.style.opacity    = '0';
                    card.style.transform  = 'scale(0.85)';
                    setTimeout(() => {
                        card.remove();
                        // Check if grid is empty
                        const grid = document.getElementById('favGrid');
                        if (grid && grid.children.length === 0) {
                            grid.style.display = 'none';
                            document.getElementById('emptyState').style.display = 'block';
                        }
                    }, 400);
                }

                showToast(name + ' removed from Favourites', 'fa-star-half-stroke', '#8696a0');
                updateFavBadge(-1);
            }
        } catch(e) { console.error(e); }
    }
</script>
@endpush
@endsection