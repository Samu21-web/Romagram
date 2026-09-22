<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Romagram Admin - @yield('title')</title>
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
            <a href="javascript:void(0)" onclick="openCompressModal()"
               style="display:flex; align-items:center; gap:10px; padding:10px 14px; border-radius:10px; text-decoration:none; font-size:14px; font-weight:500; margin-bottom:4px; color:#8b949e; cursor:pointer;"
               onmouseover="this.style.background='rgba(255,255,255,0.06)'; this.style.color='white';"
               onmouseout="this.style.background='transparent'; this.style.color='#8b949e';">
                <i class="fa-solid fa-compress" style="width:16px;"></i> Compress Images
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

    <!-- Compress Images Modal -->
    <div id="compressModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.85); z-index:300; align-items:center; justify-content:center;">
        <div style="background:#161b22; border:1px solid #21262d; border-radius:20px; padding:32px; max-width:440px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,0.5);">

            <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px;">
                <div style="width:44px; height:44px; background:rgba(114,14,158,0.15); border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fa-solid fa-compress" style="color:#a855f7; font-size:18px;"></i>
                </div>
                <div>
                    <h3 style="color:white; font-size:16px; font-weight:700; margin:0;">Compress Images</h3>
                    <p style="color:#8b949e; font-size:12px; margin:2px 0 0;">Converts avatars &amp; extra photos to WebP</p>
                </div>
            </div>

            <!-- Idle / pre-check state -->
            <div id="compressIdleState">
                <p id="compressPendingText" style="color:#d1d7db; font-size:14px; margin:0 0 20px;">Checking for images to compress...</p>
                <div style="display:flex; gap:10px;">
                    <button onclick="closeCompressModal()"
                        style="flex:1; background:rgba(255,255,255,0.06); border:1.5px solid rgba(255,255,255,0.15); color:#d1d7db; font-weight:600; font-size:14px; padding:11px; border-radius:10px; cursor:pointer;">
                        Cancel
                    </button>
                    <button id="startCompressBtn" onclick="startCompression()" disabled
                        style="flex:1; background:#720e9e; border:none; color:white; font-weight:700; font-size:14px; padding:11px; border-radius:10px; cursor:pointer; opacity:0.6;">
                        Start
                    </button>
                </div>
            </div>

            <!-- In-progress state -->
            <div id="compressProgressState" style="display:none;">
                <div style="background:#21262d; border-radius:999px; height:12px; overflow:hidden; margin-bottom:12px;">
                    <div id="compressProgressBar" style="background:linear-gradient(to right,#720e9e,#9b1bc7); height:12px; width:0%; transition:width 0.3s;"></div>
                </div>
                <p id="compressProgressText" style="color:#d1d7db; font-size:13px; margin:0 0 20px; text-align:center;">0 of 0 compressed</p>
                <button disabled
                    style="width:100%; background:rgba(255,255,255,0.06); border:1.5px solid rgba(255,255,255,0.15); color:#d1d7db; font-weight:600; font-size:14px; padding:11px; border-radius:10px; cursor:not-allowed; opacity:0.5;">
                    Compressing...
                </button>
            </div>

            <!-- Done state -->
            <div id="compressDoneState" style="display:none; text-align:center;">
                <div style="width:60px; height:60px; background:rgba(34,197,94,0.1); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                    <i class="fa-solid fa-circle-check" style="color:#22c55e; font-size:26px;"></i>
                </div>
                <p id="compressDoneText" style="color:white; font-size:15px; font-weight:600; margin:0 0 4px;"></p>
                <p id="compressFailedText" style="color:#8b949e; font-size:12px; margin:0 0 20px;"></p>
                <button onclick="closeCompressModal()"
                    style="width:100%; background:#720e9e; border:none; color:white; font-weight:700; font-size:14px; padding:11px; border-radius:10px; cursor:pointer;">
                    Done
                </button>
            </div>

        </div>
    </div>

    <script>
        const compressPendingUrl = '{{ route("admin.images.pending") }}';
        const compressBatchUrl   = '{{ route("admin.images.batch") }}';
        const compressCsrfToken  = '{{ csrf_token() }}';

        let compressTotal    = 0;
        let compressDone     = 0;
        let compressFailed   = 0;
        let excludedAvatarIds = [];
        let excludedPhotoIds  = [];
        let isCompressing     = false;
        let compressFailReasons = [];

        function openCompressModal() {
            document.getElementById('compressModal').style.display = 'flex';
            resetCompressUI();
            checkPendingImages();
        }

        function closeCompressModal() {
            if (isCompressing) return; // don't allow closing mid-run
            document.getElementById('compressModal').style.display = 'none';
        }

        function resetCompressUI() {
            compressTotal = 0;
            compressDone = 0;
            compressFailed = 0;
            excludedAvatarIds = [];
            excludedPhotoIds = [];
            compressFailReasons = [];

            document.getElementById('compressIdleState').style.display = 'block';
            document.getElementById('compressProgressState').style.display = 'none';
            document.getElementById('compressDoneState').style.display = 'none';

            const startBtn = document.getElementById('startCompressBtn');
            startBtn.disabled = true;
            startBtn.style.opacity = '0.6';

            document.getElementById('compressPendingText').textContent = 'Checking for images to compress...';
            document.getElementById('compressProgressBar').style.width = '0%';
        }

        async function checkPendingImages() {
            try {
                const res = await fetch(compressPendingUrl, { headers: { 'Accept': 'application/json' } });
                const data = await res.json();
                compressTotal = data.total;

                const startBtn = document.getElementById('startCompressBtn');

                if (compressTotal === 0) {
                    document.getElementById('compressPendingText').textContent = 'All images are already compressed.';
                } else {
                    document.getElementById('compressPendingText').textContent =
                        compressTotal + (compressTotal === 1 ? ' image needs' : ' images need') + ' compressing.';
                    startBtn.disabled = false;
                    startBtn.style.opacity = '1';
                }
            } catch (e) {
                document.getElementById('compressPendingText').textContent = 'Could not check pending images.';
            }
        }

        async function startCompression() {
            if (compressTotal === 0) return;

            isCompressing = true;
            document.getElementById('compressIdleState').style.display = 'none';
            document.getElementById('compressProgressState').style.display = 'block';

            await runCompressBatch();
        }

        async function runCompressBatch() {
            try {
                const res = await fetch(compressBatchUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': compressCsrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        limit: 10,
                        excluded_avatar_ids: excludedAvatarIds,
                        excluded_photo_ids: excludedPhotoIds,
                    }),
                });
                const data = await res.json();

                compressDone += data.compressed;
                compressFailed += (data.failed_avatar_ids.length + data.failed_photo_ids.length);
                excludedAvatarIds = excludedAvatarIds.concat(data.failed_avatar_ids);
                excludedPhotoIds = excludedPhotoIds.concat(data.failed_photo_ids);

                if (data.failed_details && data.failed_details.length) {
                    compressFailReasons = compressFailReasons.concat(data.failed_details);
                    console.warn('Image compression failures:', data.failed_details);
                }

                const processed = Math.min(compressDone + compressFailed, compressTotal);
                const percent = compressTotal > 0 ? Math.round((processed / compressTotal) * 100) : 100;

                document.getElementById('compressProgressBar').style.width = percent + '%';
                document.getElementById('compressProgressText').textContent =
                    compressDone + ' of ' + compressTotal + ' compressed';

                if (data.remaining > 0) {
                    await runCompressBatch();
                } else {
                    finishCompression();
                }
            } catch (e) {
                finishCompression(true);
            }
        }

        function finishCompression(errored = false) {
            isCompressing = false;
            document.getElementById('compressProgressState').style.display = 'none';
            document.getElementById('compressDoneState').style.display = 'block';

            document.getElementById('compressDoneText').textContent = errored
                ? 'Compression stopped due to an error.'
                : 'Compressed ' + compressDone + (compressDone === 1 ? ' image.' : ' images.');

            document.getElementById('compressFailedText').textContent = compressFailed > 0
                ? compressFailed + (compressFailed === 1 ? ' image could not be compressed: ' : ' images could not be compressed. First reason: ')
                    + (compressFailReasons[0] ? compressFailReasons[0].reason : 'unknown')
                : '';
        }
    </script>

</body>
</html>