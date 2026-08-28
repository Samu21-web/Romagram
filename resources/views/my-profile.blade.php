@extends('layouts.app-auth')
@section('title', 'My Profile')

@section('content')
<div style="max-width:1100px; margin:0 auto; padding:32px 16px;">

    <!-- Header -->
    <div style="margin-bottom:28px;">
        <h1 style="color:white; font-size:24px; font-weight:800; margin:0 0 4px;">My Profile</h1>
        <p style="color:#8696a0; font-size:14px; margin:0;">Manage your profile information and password</p>
    </div>

    <!-- Success message -->
    @if(session('success'))
        <div style="background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3); border-radius:12px; padding:14px 18px; margin-bottom:24px; color:#22c55e; font-size:14px; display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); border-radius:12px; padding:14px 18px; margin-bottom:24px; color:#ef4444; font-size:14px;">
            <i class="fa-solid fa-circle-exclamation" style="margin-right:8px;"></i>{{ $errors->first() }}
        </div>
    @endif

    <div class="rp-profile-cols" style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">

        <!-- LEFT: Profile info -->
        <div>
            <div style="background:#1f2c34; border-radius:20px; padding:28px; border:1px solid #2a3942; margin-bottom:24px;">
                <h3 style="color:white; font-size:16px; font-weight:700; margin:0 0 24px;">Profile Information</h3>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Avatar upload -->
                    <div style="text-align:center; margin-bottom:24px;">
                        <div style="position:relative; display:inline-block;">
                            <img id="avatarPreview"
                                 src="{{ $user->avatar ? asset('storage/' . $user->avatar) : '' }}"
                                 style="width:100px; height:100px; border-radius:50%; object-fit:cover; border:3px solid rgba(255,255,255,0.2); {{ $user->avatar ? '' : 'display:none;' }}">
                            <div id="avatarPlaceholder" style="{{ $user->avatar ? 'display:none;' : '' }} width:100px; height:100px; border-radius:50%; background:#2a3942; display:flex; align-items:center; justify-content:center; border:3px solid rgba(255,255,255,0.2);">
                                <i class="fa-solid fa-user" style="font-size:40px; color:#8696a0;"></i>
                            </div>
                            <label for="avatarInput" style="position:absolute; bottom:0; right:0; width:32px; height:32px; background:#720e9e; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; border:2px solid #1f2c34;">
                                <i class="fa-solid fa-camera" style="color:white; font-size:13px;"></i>
                            </label>
                            <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display:none;" onchange="previewAvatar(this)">
                        </div>
                        <p style="color:#8696a0; font-size:12px; margin:8px 0 0;">Click camera to change photo</p>
                    </div>

                    <!-- Name -->
                    <div style="margin-bottom:16px;">
                        <label style="display:block; color:#8696a0; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Nickname</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            style="width:100%; background:#2a3942; border:1px solid rgba(255,255,255,0.1); color:white; font-size:14px; padding:11px 14px; border-radius:10px; outline:none; box-sizing:border-box;"
                            onfocus="this.style.borderColor='rgba(255,255,255,0.3)'"
                            onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                    </div>

<!-- Email -->
                    <div style="margin-bottom:16px;">
                        <label style="display:block; color:#8696a0; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            style="width:100%; background:#2a3942; border:1px solid rgba(255,255,255,0.1); color:white; font-size:14px; padding:11px 14px; border-radius:10px; outline:none; box-sizing:border-box;"
                            onfocus="this.style.borderColor='rgba(255,255,255,0.3)'"
                            onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                    </div>

                    <!-- Phone -->
                    <div style="margin-bottom:16px;">
                        <label style="display:block; color:#8696a0; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                            style="width:100%; background:#2a3942; border:1px solid rgba(255,255,255,0.1); color:white; font-size:14px; padding:11px 14px; border-radius:10px; outline:none; box-sizing:border-box;"
                            onfocus="this.style.borderColor='rgba(255,255,255,0.3)'"
                            onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                    </div>

                    <!-- City -->
                    <div style="margin-bottom:24px;">
                        <label style="display:block; color:#8696a0; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">City</label>
                        <input type="text" name="city" value="{{ old('city', $user->city) }}" placeholder="e.g. Nairobi"
                            style="width:100%; background:#2a3942; border:1px solid rgba(255,255,255,0.1); color:white; font-size:14px; padding:11px 14px; border-radius:10px; outline:none; box-sizing:border-box;"
                            onfocus="this.style.borderColor='rgba(255,255,255,0.3)'"
                            onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                    </div>

                    <button type="submit"
                        style="width:100%; background:white; color:#111b21; font-weight:700; font-size:15px; padding:12px; border:none; border-radius:10px; cursor:pointer; transition:all 0.2s;"
                        onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        <i class="fa-solid fa-floppy-disk" style="margin-right:8px;"></i> Save Changes
                    </button>
                </form>
            </div>

            <!-- Extra Photos -->
            <div style="background:#1f2c34; border-radius:20px; padding:28px; border:1px solid #2a3942;">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
                    <div>
                        <h3 style="color:white; font-size:16px; font-weight:700; margin:0 0 4px;">My Photos</h3>
                        <p style="color:#8696a0; font-size:12px; margin:0;" id="photoCountLabel">
                            {{ $user->photos->count() }}/5 photos added
                        </p>
                    </div>
                    @if($user->photos->count() < 5)
                        <label for="extraPhotosInput"
                            style="display:flex; align-items:center; gap:6px; background:rgba(255,255,255,0.08); border:1.5px solid rgba(255,255,255,0.15); color:#d1d7db; font-size:13px; font-weight:600; padding:8px 16px; border-radius:999px; cursor:pointer;"
                            onmouseover="this.style.background='rgba(255,255,255,0.14)'"
                            onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                            <i class="fa-solid fa-plus"></i> Add Photos
                        </label>
                    @endif
                    <input type="file" id="extraPhotosInput" accept="image/*" multiple style="display:none;" onchange="uploadExtraPhotos(this)">
                </div>
                <div id="photosGrid" style="display:grid; grid-template-columns:repeat(3,1fr); gap:10px;">
                    @if($user->avatar)
                        <div style="position:relative; aspect-ratio:1; border-radius:12px; overflow:hidden; border:2px solid rgba(255,255,255,0.15);">
                            <img src="{{ asset('storage/' . $user->avatar) }}" style="width:100%; height:100%; object-fit:cover;">
                            <div style="position:absolute; top:6px; left:6px; background:rgba(0,0,0,0.6); color:white; font-size:10px; font-weight:600; padding:2px 8px; border-radius:999px;">Main</div>
                        </div>
                    @endif

                    @foreach($user->photos as $photo)
                        <div class="photo-item" data-photo-id="{{ $photo->id }}" style="position:relative; aspect-ratio:1; border-radius:12px; overflow:hidden; border:2px solid rgba(255,255,255,0.15);">
                            <img src="{{ asset('storage/' . $photo->path) }}" style="width:100%; height:100%; object-fit:cover;">
                            <button onclick="deletePhoto({{ $photo->id }}, this)"
                                style="position:absolute; top:6px; right:6px; width:26px; height:26px; background:rgba(239,68,68,0.85); border:none; border-radius:50%; color:white; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:11px;">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    @endforeach

                    @for($i = $user->photos->count(); $i < 5; $i++)
                        <div class="photo-slot" style="aspect-ratio:1; border-radius:12px; background:#182028; border:1.5px dashed rgba(255,255,255,0.1); display:flex; flex-direction:column; align-items:center; justify-content:center; cursor:pointer;"
                             onclick="document.getElementById('extraPhotosInput').click()">
                            <i class="fa-solid fa-image" style="font-size:24px; color:rgba(255,255,255,0.2); margin-bottom:6px;"></i>
                            <span style="color:rgba(255,255,255,0.2); font-size:11px;">Add photo</span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- RIGHT: Stats + Password -->
        <div>
            <!-- Profile stats -->
            <div style="background:#1f2c34; border-radius:20px; padding:24px; border:1px solid #2a3942; margin-bottom:24px;">
                <h3 style="color:white; font-size:16px; font-weight:700; margin:0 0 20px;">Profile Stats</h3>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div style="background:#182028; border-radius:12px; padding:14px; text-align:center;">
                        <p style="color:white; font-size:24px; font-weight:800; margin:0 0 4px;">{{ \App\Models\Swipe::where('swiped_id', $user->id)->where('action','like')->count() }}</p>
                        <p style="color:#8696a0; font-size:12px; margin:0;">Likes Received</p>
                    </div>
                    <div style="background:#182028; border-radius:12px; padding:14px; text-align:center;">
                        <p style="color:white; font-size:24px; font-weight:800; margin:0 0 4px;">{{ \App\Models\Favourite::where('user_id', $user->id)->count() }}</p>
                        <p style="color:#8696a0; font-size:12px; margin:0;">Favourites</p>
                    </div>
                    <div style="background:#182028; border-radius:12px; padding:14px; text-align:center;">
                        <p style="color:white; font-size:24px; font-weight:800; margin:0 0 4px;">{{ \App\Models\Swipe::where('swiper_id', $user->id)->where('action','like')->count() }}</p>
                        <p style="color:#8696a0; font-size:12px; margin:0;">Profiles Liked</p>
                    </div>
                    <div style="background:#182028; border-radius:12px; padding:14px; text-align:center;">
                        <p style="color:white; font-size:24px; font-weight:800; margin:0 0 4px;">{{ (int) $user->created_at->diffInDays() }}</p>
                        <p style="color:#8696a0; font-size:12px; margin:0;">Days on Romagram</p>
                    </div>
                </div>

                <!-- Membership status -->
                <div style="margin-top:16px; padding:14px; background:#182028; border-radius:12px; display:flex; align-items:center; justify-content:space-between;">
                    <div style="display:flex; align-items:center; gap:10px;">
                        <i class="fa-solid fa-crown" style="color:{{ in_array($user->subscription_plan, ['premium','gold']) ? '#f59e0b' : '#8696a0' }}; font-size:18px;"></i>
                        <div>
                            <p style="color:white; font-size:13px; font-weight:600; margin:0;">
                                {{ in_array($user->subscription_plan, ['premium','gold']) ? 'Premium Member' : 'Free Member' }}
                            </p>
                            <p style="color:#8696a0; font-size:11px; margin:0;">
                                {{ in_array($user->subscription_plan, ['premium','gold']) ? 'All features unlocked' : 'Limited access' }}
                            </p>
                        </div>
                    </div>
                    @if(!in_array($user->subscription_plan, ['premium','gold']))
                        <a href="{{ route('pricing') }}"
                            style="background:rgba(245,158,11,0.15); border:1px solid rgba(245,158,11,0.3); color:#f59e0b; font-size:12px; font-weight:600; padding:6px 12px; border-radius:999px; text-decoration:none;">
                            Upgrade
                        </a>
                    @endif
                </div>
            </div>

            <!-- Change password -->
            <div style="background:#1f2c34; border-radius:20px; padding:28px; border:1px solid #2a3942; margin-bottom:24px;">
                <h3 style="color:white; font-size:16px; font-weight:700; margin:0 0 24px;">Change Password</h3>

                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    <div style="margin-bottom:16px;">
                        <label style="display:block; color:#8696a0; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Current Password</label>
                        <div style="position:relative;">
                            <input type="password" name="current_password" id="currentPwd" placeholder="Enter current password" required
                                style="width:100%; background:#2a3942; border:1px solid rgba(255,255,255,0.1); color:white; font-size:14px; padding:11px 40px 11px 14px; border-radius:10px; outline:none; box-sizing:border-box;"
                                onfocus="this.style.borderColor='rgba(255,255,255,0.3)'"
                                onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                            <button type="button" onclick="togglePwd('currentPwd')"
                                style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#8696a0;">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <p style="color:#ef4444; font-size:12px; margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div style="margin-bottom:16px;">
                        <label style="display:block; color:#8696a0; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">New Password</label>
                        <div style="position:relative;">
                            <input type="password" name="password" id="newPwd" placeholder="Min 8 characters" required
                                style="width:100%; background:#2a3942; border:1px solid rgba(255,255,255,0.1); color:white; font-size:14px; padding:11px 40px 11px 14px; border-radius:10px; outline:none; box-sizing:border-box;"
                                onfocus="this.style.borderColor='rgba(255,255,255,0.3)'"
                                onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                            <button type="button" onclick="togglePwd('newPwd')"
                                style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#8696a0;">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div style="margin-bottom:24px;">
                        <label style="display:block; color:#8696a0; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Confirm New Password</label>
                        <div style="position:relative;">
                            <input type="password" name="password_confirmation" id="confirmPwd" placeholder="Repeat new password" required
                                style="width:100%; background:#2a3942; border:1px solid rgba(255,255,255,0.1); color:white; font-size:14px; padding:11px 40px 11px 14px; border-radius:10px; outline:none; box-sizing:border-box;"
                                onfocus="this.style.borderColor='rgba(255,255,255,0.3)'"
                                onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                            <button type="button" onclick="togglePwd('confirmPwd')"
                                style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#8696a0;">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        style="width:100%; background:rgba(255,255,255,0.08); color:white; font-weight:700; font-size:15px; padding:12px; border:1.5px solid rgba(255,255,255,0.15); border-radius:10px; cursor:pointer; transition:all 0.2s;"
                        onmouseover="this.style.background='rgba(255,255,255,0.12)'" onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                        <i class="fa-solid fa-lock" style="margin-right:8px;"></i> Update Password
                    </button>
                </form>
            </div>

            <!-- Danger Zone -->
            <div style="background:#1f2c34; border-radius:20px; padding:24px; border:1px solid rgba(239,68,68,0.25);">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:12px;">
                    <div style="width:36px; height:36px; background:rgba(239,68,68,0.1); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fa-solid fa-triangle-exclamation" style="color:#ef4444; font-size:15px;"></i>
                    </div>
                    <div>
                        <h3 style="color:white; font-size:15px; font-weight:700; margin:0;">Danger Zone</h3>
                        <p style="color:#8696a0; font-size:12px; margin:0;">Irreversible account actions</p>
                    </div>
                </div>

                <div style="background:#182028; border-radius:12px; padding:16px; display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;">
                    <div>
                        <p style="color:white; font-size:14px; font-weight:600; margin:0 0 4px;">Deactivate Account</p>
                        <p style="color:#8696a0; font-size:12px; margin:0;">Your profile will be hidden and you will be logged out.</p>
                    </div>
                    <button onclick="document.getElementById('deactivateModal').style.display='flex'"
                        style="background:rgba(239,68,68,0.1); border:1.5px solid rgba(239,68,68,0.3); color:#ef4444; font-size:13px; font-weight:600; padding:9px 18px; border-radius:10px; cursor:pointer; white-space:nowrap; transition:all 0.2s; flex-shrink:0;"
                        onmouseover="this.style.background='rgba(239,68,68,0.2)'"
                        onmouseout="this.style.background='rgba(239,68,68,0.1)'">
                        <i class="fa-solid fa-power-off" style="margin-right:6px;"></i> Deactivate
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deactivate Confirmation Modal -->
<div id="deactivateModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.85); z-index:200; align-items:center; justify-content:center;">
    <div style="background:#1f2c34; border:1px solid #2a3942; border-radius:24px; padding:36px; max-width:420px; width:90%; text-align:center; box-shadow:0 20px 60px rgba(0,0,0,0.5);">

        <!-- Icon -->
        <div style="width:70px; height:70px; background:rgba(239,68,68,0.1); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px; border:2px solid rgba(239,68,68,0.3);">
            <i class="fa-solid fa-power-off" style="font-size:28px; color:#ef4444;"></i>
        </div>

        <h2 style="font-size:22px; font-weight:800; color:white; margin:0 0 10px;">Deactivate Account?</h2>
        <p style="color:#8696a0; font-size:14px; line-height:1.7; margin:0 0 12px;">
            Are you sure you want to deactivate your account?
        </p>
        <div style="background:rgba(239,68,68,0.06); border:1px solid rgba(239,68,68,0.15); border-radius:12px; padding:14px; margin-bottom:28px; text-align:left;">
            <div style="display:flex; align-items:center; gap:10px; color:#fca5a5; font-size:13px; margin-bottom:8px;">
                <i class="fa-solid fa-circle-dot" style="font-size:8px;"></i> Your profile will be hidden from Discover
            </div>
            <div style="display:flex; align-items:center; gap:10px; color:#fca5a5; font-size:13px; margin-bottom:8px;">
                <i class="fa-solid fa-circle-dot" style="font-size:8px;"></i> You will be logged out immediately
            </div>
            <div style="display:flex; align-items:center; gap:10px; color:#fca5a5; font-size:13px;">
                <i class="fa-solid fa-circle-dot" style="font-size:8px;"></i> Contact support to reactivate anytime
            </div>
        </div>

        <div style="display:flex; gap:12px;">
            <button onclick="document.getElementById('deactivateModal').style.display='none'"
                style="flex:1; background:rgba(255,255,255,0.06); border:1.5px solid rgba(255,255,255,0.15); color:#d1d7db; font-weight:600; font-size:14px; padding:12px; border-radius:12px; cursor:pointer; transition:all 0.2s;"
                onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                onmouseout="this.style.background='rgba(255,255,255,0.06)'">
                Cancel
            </button>
            <form method="POST" action="{{ route('profile.deactivate') }}" style="flex:1;">
                @csrf
                <button type="submit"
                    style="width:100%; background:#ef4444; border:none; color:white; font-weight:700; font-size:14px; padding:12px; border-radius:12px; cursor:pointer; transition:all 0.2s;"
                    onmouseover="this.style.background='#dc2626'"
                    onmouseout="this.style.background='#ef4444'">
                    <i class="fa-solid fa-power-off" style="margin-right:6px;"></i> Yes, Deactivate
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .rp-profile-cols {
            grid-template-columns: 1fr !important;
        }
    }
</style>

@push('scripts')
<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatarPreview');
                const placeholder = document.getElementById('avatarPlaceholder');
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function togglePwd(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    // ── Extra photos upload ──
    const uploadPhotosUrl  = '{{ route("profile.photos.upload") }}';
    const csrfTokenProfile = '{{ csrf_token() }}';

    async function uploadExtraPhotos(input) {
        if (!input.files || input.files.length === 0) return;

        const formData = new FormData();
        for (let i = 0; i < input.files.length; i++) {
            formData.append('photos[]', input.files[i]);
        }

        try {
            const res = await fetch(uploadPhotosUrl, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfTokenProfile },
                body: formData,
            });

            if (res.ok) {
                location.reload();
            } else {
                const data = await res.json().catch(() => null);
                alert(data?.errors?.photos?.[0] || 'Could not upload photos. Please check file size and try again.');
            }
        } catch (e) {
            console.error(e);
            alert('Something went wrong uploading photos.');
        }
    }

    // ── Extra photos delete ──
    async function deletePhoto(photoId, btn) {
        const confirmDelete = window.Swal
            ? await Swal.fire({
                title: 'Delete this photo?',
                text: 'This cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#374151',
                background: '#1f2c34',
                color: '#ffffff',
                width: 300,
                padding: '1.2em',
            }).then(r => r.isConfirmed)
            : confirm('Delete this photo? This cannot be undone.');

        if (!confirmDelete) return;

        try {
            const res = await fetch('/my-profile/photos/' + photoId, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfTokenProfile, 'Accept': 'application/json' }
            });
            const data = await res.json();

            if (data.success) {
                location.reload();
            } else {
                alert(data.error || 'Could not delete photo.');
            }
        } catch (e) {
            console.error(e);
            alert('Something went wrong deleting the photo.');
        }
    }
</script>
@endpush
@endsection