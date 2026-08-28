@extends('layouts.app')
@section('title', 'Upload Your Photo')

@section('content')
<div style="min-height:100vh; background:linear-gradient(135deg,#faf5ff,#fdf2f8); display:flex; align-items:center; justify-content:center; padding:24px;">
    <div style="background:white; border-radius:24px; padding:40px; width:100%; max-width:480px; box-shadow:0 20px 60px rgba(114,14,158,0.1);">

        <!-- Logo -->
        <div style="text-align:center; margin-bottom:28px;">
            <img src="{{ asset('logo.png') }}" alt="Rompace" style="height:48px; margin-bottom:12px;">
            <h2 style="font-size:22px; font-weight:800; color:#111827; margin:0;">Add your photo</h2>
            <p style="color:#6b7280; font-size:14px; margin-top:6px;">Profiles with photos get 10x more matches</p>
        </div>

        @if($errors->any())
            <div style="background:#fef2f2; border:1px solid #fecaca; border-radius:12px; padding:12px 16px; margin-bottom:20px; color:#dc2626; font-size:14px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('setup.photos.save') }}" enctype="multipart/form-data">
            @csrf

            <!-- Photo upload area -->
            <div id="uploadArea" onclick="document.getElementById('avatarInput').click()"
                style="border:2px dashed #d1d5db; border-radius:20px; padding:40px 20px; text-align:center; cursor:pointer; margin-bottom:24px; transition:border 0.2s; position:relative;">

                <!-- Preview -->
                <div id="previewContainer" style="display:none; margin-bottom:16px;">
                    <img id="photoPreview" style="width:120px; height:120px; border-radius:50%; object-fit:cover; border:4px solid #720e9e; margin:0 auto; display:block;">
                </div>

                <!-- Placeholder -->
                <div id="uploadPlaceholder">
                    <div style="width:80px; height:80px; background:#f3e8ff; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                        <i class="fa-solid fa-camera" style="font-size:32px; color:#720e9e;"></i>
                    </div>
                    <p style="font-weight:600; color:#374151; margin:0 0 4px;">Click to upload your photo</p>
                    <p style="color:#9ca3af; font-size:13px; margin:0;">JPG, PNG or WEBP · Max 5MB</p>
                </div>

                <input type="file" id="avatarInput" name="avatar" accept="image/*" required
                    style="display:none;" onchange="previewPhoto(this)">
            </div>

            <button type="submit" id="submitBtn"
                style="width:100%; background:#720e9e; color:white; font-weight:700; font-size:16px; padding:14px; border:none; border-radius:999px; cursor:pointer; box-shadow:0 4px 14px rgba(114,14,158,0.3);">
                <i class="fa-solid fa-heart" style="margin-right:8px;"></i> Complete Profile
            </button>

            <button type="button" onclick="skipPhotos()"
                style="width:100%; background:none; border:none; color:#9ca3af; font-size:14px; padding:12px; cursor:pointer; margin-top:8px;">
                Skip for now
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewPhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('photoPreview').src = e.target.result;
                document.getElementById('previewContainer').style.display = 'block';
                document.getElementById('uploadPlaceholder').style.display = 'none';
                document.getElementById('uploadArea').style.borderColor = '#720e9e';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function skipPhotos() {
        const form = document.querySelector('form');
        const input = document.getElementById('avatarInput');
        input.removeAttribute('required');
        form.submit();
    }
</script>
@endpush
@endsection