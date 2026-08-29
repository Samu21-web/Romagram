@extends('layouts.app')
@section('title', 'Set Your Location')

@section('content')
<div style="min-height:100vh; background:linear-gradient(135deg,#faf5ff,#fdf2f8); display:flex; align-items:center; justify-content:center; padding:24px;">
    <div style="background:white; border-radius:24px; padding:40px; width:100%; max-width:480px; box-shadow:0 20px 60px rgba(114,14,158,0.1);">

        <div style="text-align:center; margin-bottom:32px;">
            <img src="{{ asset('logo.png') }}" alt="Rompace" style="height:48px; margin-bottom:12px;">
            <h2 style="font-size:22px; font-weight:800; color:#111827; margin:0;">Enable your location</h2>
            <p style="color:#6b7280; font-size:14px; margin-top:6px;">We use your location to find matches near you</p>
        </div>

        <!-- Location status -->
        <div id="locationIdle" style="text-align:center; margin-bottom:28px;">
            <div style="width:100px; height:100px; background:linear-gradient(135deg,#720e9e,#9b1bc7); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                <i class="fa-solid fa-location-dot" style="font-size:42px; color:white;"></i>
            </div>
            <p style="color:#374151; font-size:15px; line-height:1.7; margin-bottom:24px;">
                Romagram needs your location to show you people nearby. Your exact location is never shared with other users.
            </p>
            <button onclick="getLocation()"
                style="width:100%; background:#720e9e; color:white; font-weight:700; font-size:16px; padding:14px; border:none; border-radius:999px; cursor:pointer; box-shadow:0 4px 14px rgba(114,14,158,0.3);">
                <i class="fa-solid fa-location-crosshairs" style="margin-right:8px;"></i> Enable Location
            </button>
        </div>

        <!-- Loading state -->
        <div id="locationLoading" style="display:none; text-align:center; margin-bottom:28px;">
            <div style="width:100px; height:100px; background:#f3e8ff; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size:42px; color:#720e9e;"></i>
            </div>
            <p style="color:#6b7280; font-size:15px;">Getting your location...</p>
        </div>

        <!-- Success state -->
        <div id="locationSuccess" style="display:none; text-align:center; margin-bottom:28px;">
            <div style="width:100px; height:100px; background:#dcfce7; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                <i class="fa-solid fa-circle-check" style="font-size:42px; color:#16a34a;"></i>
            </div>
            <h3 style="font-size:18px; font-weight:700; color:#111827; margin-bottom:8px;">Location found!</h3>
            <p id="locationText" style="color:#6b7280; font-size:14px; margin-bottom:24px;"></p>
        </div>

        <!-- Error state -->
        <div id="locationError" style="display:none; text-align:center; margin-bottom:28px;">
            <div style="width:100px; height:100px; background:#fef2f2; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                <i class="fa-solid fa-circle-xmark" style="font-size:42px; color:#ef4444;"></i>
            </div>
            <h3 style="font-size:18px; font-weight:700; color:#111827; margin-bottom:8px;">Location denied</h3>
            <p style="color:#6b7280; font-size:14px; margin-bottom:20px;">Please allow location access in your browser settings, or enter your city manually.</p>

            <!-- Manual fallback -->
            <input type="text" id="manualCity" placeholder="e.g. Nairobi, London, Lagos..."
                style="width:100%; border:1.5px solid #e5e7eb; border-radius:12px; padding:13px 16px; font-size:15px; color:#111827; outline:none; box-sizing:border-box; margin-bottom:16px;">

            <button onclick="saveManualLocation()"
                style="width:100%; background:#720e9e; color:white; font-weight:700; font-size:16px; padding:14px; border:none; border-radius:999px; cursor:pointer;">
                Continue with City
            </button>
        </div>

        <!-- Hidden form -->
        <form id="locationForm" method="POST" action="{{ route('setup.location.save') }}" style="display:none;">
            @csrf
            <input type="hidden" id="inputLat" name="latitude">
            <input type="hidden" id="inputLng" name="longitude">
            <input type="hidden" id="inputCity" name="city">
            <input type="hidden" id="inputCountry" name="country">
        </form>

        <!-- Skip -->
        <div style="text-align:center; margin-top:16px;">
            <button onclick="skipLocation()" style="background:none; border:none; color:#9ca3af; font-size:13px; cursor:pointer;">
                Skip for now
            </button>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function getLocation() {
        if (!navigator.geolocation) {
            showError();
            return;
        }

        document.getElementById('locationIdle').style.display = 'none';
        document.getElementById('locationLoading').style.display = 'block';

        navigator.geolocation.getCurrentPosition(
            async function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                // Reverse geocode using free API
                try {
                    const res = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`);
                    const data = await res.json();

                    const city = data.address.city
                        || data.address.town
                        || data.address.village
                        || data.address.county
                        || 'Unknown';
                    const country = data.address.country || '';

                    document.getElementById('inputLat').value = lat;
                    document.getElementById('inputLng').value = lng;
                    document.getElementById('inputCity').value = city;
                    document.getElementById('inputCountry').value = country;

                    document.getElementById('locationLoading').style.display = 'none';
                    document.getElementById('locationSuccess').style.display = 'block';
                    document.getElementById('locationText').textContent = city + ', ' + country;

                    // Auto submit after 1.5s
                    setTimeout(() => {
                        document.getElementById('locationForm').submit();
                    }, 1500);

                } catch(e) {
                    // If reverse geocode fails, still save coordinates
                    document.getElementById('inputLat').value = lat;
                    document.getElementById('inputLng').value = lng;
                    document.getElementById('inputCity').value = 'Unknown';
                    document.getElementById('inputCountry').value = '';
                    document.getElementById('locationLoading').style.display = 'none';
                    document.getElementById('locationSuccess').style.display = 'block';
                    document.getElementById('locationText').textContent = 'Location saved';
                    setTimeout(() => {
                        document.getElementById('locationForm').submit();
                    }, 1500);
                }
            },
            function(error) {
                document.getElementById('locationLoading').style.display = 'none';
                showError();
            },
            { timeout: 10000, enableHighAccuracy: true }
        );
    }

    function showError() {
        document.getElementById('locationIdle').style.display = 'none';
        document.getElementById('locationLoading').style.display = 'none';
        document.getElementById('locationError').style.display = 'block';
    }

    function saveManualLocation() {
        const city = document.getElementById('manualCity').value.trim();
        if (!city) { alert('Please enter your city.'); return; }
        document.getElementById('inputCity').value = city;
        document.getElementById('inputLat').value = '';
        document.getElementById('inputLng').value = '';
        document.getElementById('inputCountry').value = '';
        document.getElementById('locationForm').submit();
    }

    function skipLocation() {
        document.getElementById('locationForm').submit();
    }
</script>
@endpush
@endsection