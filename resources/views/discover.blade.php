@extends('layouts.app-auth')
@section('title', 'Discover')

@section('content')

    <!-- Discover Header -->
    <div style="background:#1f2c34; border-bottom:1px solid #2a3942; padding:16px 24px;">
        <div style="max-width:1400px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap;">
            <div>
                <h1 style="font-size:20px; font-weight:800; color:white; margin:0;">Discover</h1>
                <p style="color:#8696a0; font-size:13px; margin:2px 0 0;">Find people near you</p>
            </div>

            <form method="GET" action="{{ route('discover') }}" style="flex:1; max-width:420px; min-width:220px; display:flex; gap:10px;">
                @if(request('gender'))<input type="hidden" name="gender" value="{{ request('gender') }}">@endif
                @if(request('min_age'))<input type="hidden" name="min_age" value="{{ request('min_age') }}">@endif
                @if(request('max_age'))<input type="hidden" name="max_age" value="{{ request('max_age') }}">@endif
                @if(request('city'))<input type="hidden" name="city" value="{{ request('city') }}">@endif

                <div style="position:relative; flex:1;">
                    <i class="fa-solid fa-magnifying-glass" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#8696a0; font-size:13px;"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or location..."
                        style="width:100%; background:#2a3942; border:1px solid rgba(255,255,255,0.1); color:white; font-size:13px; padding:9px 14px 9px 36px; border-radius:999px; outline:none; box-sizing:border-box;"
                        onfocus="this.style.borderColor='rgba(255,255,255,0.3)'"
                        onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                </div>
                @if(request('search'))
                    <a href="{{ route('discover', request()->except('search')) }}"
                        style="display:flex; align-items:center; color:#ef4444; font-size:13px; text-decoration:none; padding:0 4px;">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </form>

            <button onclick="toggleFilter()"
                style="display:flex; align-items:center; gap:8px; background:transparent; border:1.5px solid rgba(255,255,255,0.2); color:#d1d7db; font-weight:600; font-size:14px; padding:9px 20px; border-radius:999px; cursor:pointer; transition:all 0.2s; flex-shrink:0;"
                onmouseover="this.style.borderColor='white'; this.style.color='white';"
                onmouseout="this.style.borderColor='rgba(255,255,255,0.2)'; this.style.color='#d1d7db';">
                <i class="fa-solid fa-sliders"></i> Filter
                @if(request()->hasAny(['gender','min_age','max_age','city']))
                    <span style="background:white; color:#111b21; font-size:10px; font-weight:700; width:18px; height:18px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center;">
                        {{ count(array_filter([request('gender'), request('min_age'), request('max_age'), request('city')])) }}
                    </span>
                @endif
            </button>
        </div>
    </div>

    <!-- Filter Panel -->
    <div id="filterPanel" style="display:none; background:#1f2c34; border-bottom:1px solid #2a3942; padding:20px 24px;">
        <form method="GET" action="{{ route('discover') }}">
            @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
            <div style="max-width:1400px; margin:0 auto; display:grid; grid-template-columns:repeat(4,1fr); gap:16px; align-items:end;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:600; color:#8696a0; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.5px;">Gender</label>
                    <select name="gender" style="width:100%; border:1.5px solid #2a3942; border-radius:10px; padding:10px 12px; font-size:14px; color:white; outline:none; background:#2a3942;">
                        <option value="">Any</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:600; color:#8696a0; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.5px;">Min Age</label>
                    <input type="number" name="min_age" min="18" max="80" value="{{ request('min_age', 18) }}"
                        style="width:100%; border:1.5px solid #2a3942; border-radius:10px; padding:10px 12px; font-size:14px; color:white; outline:none; background:#2a3942; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:600; color:#8696a0; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.5px;">Max Age</label>
                    <input type="number" name="max_age" min="18" max="80" value="{{ request('max_age', 80) }}"
                        style="width:100%; border:1.5px solid #2a3942; border-radius:10px; padding:10px 12px; font-size:14px; color:white; outline:none; background:#2a3942; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:600; color:#8696a0; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.5px;">City</label>
                    <input type="text" name="city" value="{{ request('city') }}" placeholder="e.g. Nairobi"
                        style="width:100%; border:1.5px solid #2a3942; border-radius:10px; padding:10px 12px; font-size:14px; color:white; outline:none; background:#2a3942; box-sizing:border-box;">
                </div>
            </div>
            <div style="max-width:1400px; margin:16px auto 0; display:flex; gap:12px; justify-content:flex-end;">
                <a href="{{ route('discover') }}"
                    style="border:1.5px solid rgba(255,255,255,0.2); color:#8696a0; font-weight:600; font-size:14px; padding:9px 20px; border-radius:999px; text-decoration:none;">
                    Reset
                </a>
                <button type="submit"
                    style="background:white; color:#111b21; font-weight:700; font-size:14px; padding:9px 24px; border:none; border-radius:999px; cursor:pointer;">
                    <i class="fa-solid fa-magnifying-glass" style="margin-right:6px;"></i> Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Main content -->
    <div style="max-width:1400px; margin:0 auto; padding:20px 16px;">

        @if(request()->hasAny(['gender','min_age','max_age','city','search']))
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:20px; flex-wrap:wrap;">
                <span style="font-size:12px; color:#8696a0; font-weight:600;">Active filters:</span>
                @if(request('search'))
                    <span style="background:rgba(255,255,255,0.08); color:#d1d7db; font-size:12px; font-weight:600; padding:3px 10px; border-radius:999px; border:1px solid rgba(255,255,255,0.15);">
                        <i class="fa-solid fa-magnifying-glass" style="margin-right:4px;"></i>{{ request('search') }}
                    </span>
                @endif
                @if(request('gender'))
                    <span style="background:rgba(255,255,255,0.08); color:#d1d7db; font-size:12px; font-weight:600; padding:3px 10px; border-radius:999px; border:1px solid rgba(255,255,255,0.15);">{{ ucfirst(request('gender')) }}</span>
                @endif
                @if(request('min_age') || request('max_age'))
                    <span style="background:rgba(255,255,255,0.08); color:#d1d7db; font-size:12px; font-weight:600; padding:3px 10px; border-radius:999px; border:1px solid rgba(255,255,255,0.15);">Age: {{ request('min_age',18) }}-{{ request('max_age',80) }}</span>
                @endif
                @if(request('city'))
                    <span style="background:rgba(255,255,255,0.08); color:#d1d7db; font-size:12px; font-weight:600; padding:3px 10px; border-radius:999px; border:1px solid rgba(255,255,255,0.15);">{{ request('city') }}</span>
                @endif
                <a href="{{ route('discover') }}" style="color:#ef4444; font-size:12px; font-weight:600; text-decoration:none; margin-left:4px;">
                    <i class="fa-solid fa-xmark"></i> Clear all
                </a>
            </div>
        @endif

        @if($profiles->isEmpty())
            <div style="text-align:center; padding:80px 20px;">
                <div style="width:80px; height:80px; background:rgba(255,255,255,0.05); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                    <i class="fa-solid fa-heart-crack" style="font-size:32px; color:#8696a0;"></i>
                </div>
                <h3 style="font-size:20px; font-weight:700; color:white; margin-bottom:8px;">No profiles found</h3>
                <p style="color:#8696a0; font-size:15px; margin-bottom:20px;">Try adjusting your filters or check back later.</p>
                <a href="{{ route('discover') }}"
                    style="background:white; color:#111b21; font-weight:700; padding:12px 28px; border-radius:999px; text-decoration:none; font-size:14px;">
                    Clear Filters
                </a>
            </div>
        @else
            <p style="color:#8696a0; font-size:14px; margin-bottom:20px;">
                <i class="fa-solid fa-users" style="margin-right:6px;"></i>
                Showing <strong id="loadedCount" style="color:white;">{{ $profiles->count() }}</strong> people near you
            </p>

            <div class="rp-discover-grid" id="discoverGrid">
                @foreach($profiles as $index => $profile)
                    @php $isLocked = !$isPremium && $index > 0; @endphp
                    @include('partials.discover-card', ['profile' => $profile, 'isLocked' => $isLocked, 'favouriteIds' => $favouriteIds])
                @endforeach
            </div>

            <div id="loadMoreWrap" style="text-align:center; margin-top:32px; {{ $hasMore ? '' : 'display:none;' }}">
                <button id="loadMoreBtn" onclick="loadMoreProfiles()"
                    style="background:#22c55e; color:white; font-weight:700; font-size:14px; padding:12px 32px; border:none; border-radius:999px; cursor:pointer; display:inline-flex; align-items:center; gap:8px;">
                    <span id="loadMoreLabel">Show more</span>
                    <i class="fa-solid fa-chevron-down" id="loadMoreIcon"></i>
                </button>
            </div>

            @if(!$isPremium)
                <div style="text-align:center; margin-top:40px; padding:40px 24px; background:#1f2c34; border-radius:24px; border:1px solid #2a3942;">
                    <div style="width:60px; height:60px; background:rgba(245,158,11,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                        <i class="fa-solid fa-crown" style="font-size:24px; color:#f59e0b;"></i>
                    </div>
                    <h3 style="color:white; font-size:20px; font-weight:800; margin-bottom:8px;">Want to see more people?</h3>
                    <p style="color:#8696a0; font-size:14px; margin-bottom:24px; line-height:1.6;">Upgrade to Premium to unlock all profiles, chat, WhatsApp contacts and more.</p>
                    <button onclick="showPremiumModal()"
                        style="background:white; color:#111b21; font-weight:700; font-size:16px; padding:14px 36px; border:none; border-radius:999px; cursor:pointer;">
                        <i class="fa-solid fa-crown" style="color:#f59e0b; margin-right:8px;"></i> Upgrade to Premium
                    </button>
                </div>
            @endif
        @endif
    </div>

<!-- Premium Modal -->
<div id="premiumModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.85); z-index:200;">
    <div style="background:#1f2c34; border:1px solid #2a3942; border-radius:28px; padding:40px; max-width:400px; width:90%; text-align:center; box-shadow:0 20px 60px rgba(0,0,0,0.5); position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);">
        <div style="width:70px; height:70px; background:rgba(245,158,11,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px; border:2px solid rgba(245,158,11,0.3);">
            <i class="fa-solid fa-crown" style="font-size:30px; color:#f59e0b;"></i>
        </div>
        <h2 style="font-size:24px; font-weight:800; color:white; margin-bottom:8px;">Upgrade to Premium</h2>
        <p style="color:#8696a0; font-size:15px; margin-bottom:28px; line-height:1.6;">Unlock all profiles, WhatsApp contacts, live chat and more.</p>
        <div style="display:flex; flex-direction:column; gap:12px; margin-bottom:28px; text-align:left;">
            <div style="display:flex; align-items:center; gap:12px; color:#d1d7db; font-size:14px;"><i class="fa-solid fa-check" style="color:#22c55e; width:16px;"></i> View unlimited profiles</div>
            <div style="display:flex; align-items:center; gap:12px; color:#d1d7db; font-size:14px;"><i class="fa-solid fa-check" style="color:#22c55e; width:16px;"></i> WhatsApp direct messaging</div>
            <div style="display:flex; align-items:center; gap:12px; color:#d1d7db; font-size:14px;"><i class="fa-solid fa-check" style="color:#22c55e; width:16px;"></i> Live chat with matches</div>
            <div style="display:flex; align-items:center; gap:12px; color:#d1d7db; font-size:14px;"><i class="fa-solid fa-check" style="color:#22c55e; width:16px;"></i> See who liked you</div>
        </div>
        <a href="{{ route('pricing') }}"
            style="display:block; background:white; color:#111b21; font-weight:700; font-size:16px; padding:14px; border-radius:999px; text-decoration:none; margin-bottom:12px;">
            <i class="fa-solid fa-crown" style="color:#f59e0b; margin-right:8px;"></i> Upgrade Now
        </a>
        <button onclick="closePremiumModal()"
            style="background:none; border:none; color:#8696a0; font-size:14px; cursor:pointer; padding:8px;">
            Maybe later
        </button>
    </div>
</div>

<!-- Match Modal -->
<div id="matchModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.8); z-index:200;">
    <div style="background:#1f2c34; border:1px solid #2a3942; border-radius:28px; padding:40px; max-width:380px; width:90%; text-align:center; box-shadow:0 20px 60px rgba(0,0,0,0.5); position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);">
        <div style="font-size:60px; margin-bottom:8px;">💕</div>
        <h2 style="font-size:28px; font-weight:800; color:white; margin-bottom:8px;">It's a Match!</h2>
        <p style="color:#8696a0; margin-bottom:24px;">You and <strong style="color:white;" id="matchName"></strong> liked each other!</p>
        <div style="display:flex; gap:12px;">
            <button onclick="closeMatch()"
                style="flex:1; border:1.5px solid rgba(255,255,255,0.2); background:transparent; color:#d1d7db; font-weight:600; padding:12px; border-radius:999px; cursor:pointer;">
                Keep Browsing
            </button>
            <button onclick="closeMatch()"
                style="flex:1; background:white; color:#111b21; font-weight:700; padding:12px; border:none; border-radius:999px; cursor:pointer;">
                <i class="fa-solid fa-message" style="margin-right:6px;"></i> Message
            </button>
        </div>
    </div>
</div>

<!-- Toast -->
<div id="toast" style="position:fixed; bottom:28px; left:50%; transform:translateX(-50%) translateY(20px); background:#1f2c34; border:1px solid #2a3942; border-radius:999px; padding:12px 22px; display:flex; align-items:center; gap:10px; box-shadow:0 8px 30px rgba(0,0,0,0.5); z-index:300; opacity:0; transition:all 0.3s ease; pointer-events:none; white-space:nowrap;">
    <i id="toastIcon" class="fa-solid fa-star" style="color:#fbbf24; font-size:15px;"></i>
    <span id="toastMsg" style="color:white; font-size:14px; font-weight:600;"></span>
</div>

<style>
    @media (max-width: 640px) {
        .rp-card-photo {
            height: 160px !important;
        }
    }
</style>

@push('scripts')
<script>
    const swipeUrl    = '{{ route('swipe') }}';
    const loadMoreUrl = '{{ route('discover.loadMore') }}';
    const csrfToken   = '{{ csrf_token() }}';

    let currentPage = {{ $currentPage }};
    let isLoadingMore = false;

    function toggleFilter() {
        const panel = document.getElementById('filterPanel');
        panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
    }

    @if(request()->hasAny(['gender','min_age','max_age','city']))
        document.getElementById('filterPanel').style.display = 'block';
    @endif

    // ── Toast ──
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

    // ── Update navbar fav badges ──
    function updateFavBadge(delta) {
        document.querySelectorAll('[data-fav-badge]').forEach(el => {
            let count = parseInt(el.textContent) || 0;
            count = Math.max(0, count + delta);
            el.textContent = count;
            el.style.display = count > 0 ? 'inline-flex' : 'none';
        });
    }

    // ── Favourite toggle ──
    async function toggleFav(userId, btn) {
        try {
            const res  = await fetch('/favourite/' + userId, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            });
            const data = await res.json();
            const icon = document.getElementById('fav-icon-' + userId);

            if (data.favourited) {
                icon.className  = 'fa-solid fa-star';
                btn.style.color = '#fbbf24';
                showToast('Added to Favourites', 'fa-star', '#fbbf24');
                updateFavBadge(1);
            } else {
                icon.className  = 'fa-regular fa-star';
                btn.style.color = '#8696a0';
                showToast('Removed from Favourites', 'fa-star-half-stroke', '#8696a0');
                updateFavBadge(-1);
            }
        } catch(e) { console.error(e); }
    }

    // ── Like ──
    async function sendSwipe(userId, action) {
        try {
            const res = await fetch(swipeUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ swiped_id: userId, action }),
            });
            return await res.json();
        } catch(e) { return null; }
    }

    async function quickLike(userId, userName) {
        const btn = document.getElementById('like-' + userId);
        btn.innerHTML     = '<i class="fa-solid fa-heart"></i> Liked!';
        btn.style.background  = 'rgba(34,197,94,0.2)';
        btn.style.borderColor = '#22c55e';
        btn.style.color       = '#22c55e';
        btn.disabled          = true;
        btn.onmouseover = null;
        btn.onmouseout  = null;
        showToast('Liked ' + userName + '!', 'fa-heart', '#22c55e');
        const data = await sendSwipe(userId, 'like');
        if (data && data.match) {
            setTimeout(() => showMatch(data.match.name), 600);
        }
    }

    function showMatch(name) {
        document.getElementById('matchName').textContent = name;
        document.getElementById('matchModal').style.display = 'block';
    }

    function closeMatch() {
        document.getElementById('matchModal').style.display = 'none';
    }

    function showPremiumModal() {
        document.getElementById('premiumModal').style.display = 'block';
    }

    function closePremiumModal() {
        document.getElementById('premiumModal').style.display = 'none';
    }

    // ── Load More ──
    async function loadMoreProfiles() {
        if (isLoadingMore) return;
        isLoadingMore = true;

        const btn   = document.getElementById('loadMoreBtn');
        const label = document.getElementById('loadMoreLabel');
        const icon  = document.getElementById('loadMoreIcon');

        label.textContent = 'Loading...';
        icon.className = 'fa-solid fa-spinner fa-spin';
        btn.disabled = true;

        currentPage++;

        const params = new URLSearchParams(window.location.search);
        params.set('page', currentPage);

        try {
            const res  = await fetch(loadMoreUrl + '?' + params.toString(), {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();

            document.getElementById('discoverGrid').insertAdjacentHTML('beforeend', data.html);

            const countEl = document.getElementById('loadedCount');
            const grid = document.getElementById('discoverGrid');
            countEl.textContent = grid.children.length;

            if (data.hasMore) {
                label.textContent = 'Show more';
                icon.className = 'fa-solid fa-chevron-down';
                btn.disabled = false;
            } else {
                document.getElementById('loadMoreWrap').style.display = 'none';
            }
        } catch (e) {
            console.error(e);
            label.textContent = 'Try again';
            icon.className = 'fa-solid fa-rotate-right';
            btn.disabled = false;
            currentPage--; // roll back so retry hits the same page
        }

        isLoadingMore = false;
    }
</script>
@endpush
@endsection