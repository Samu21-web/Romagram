@extends('layouts.admin')
@section('title', 'Packages & Plans')

@section('content')

    @if(session('success'))
        <div style="background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3); border-radius:12px; padding:12px 16px; margin-bottom:20px; color:#22c55e; font-size:14px; display:flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px;">
        <div>
            <h2 style="color:white; font-size:20px; font-weight:700; margin:0 0 4px;">Packages & Plans</h2>
            <p style="color:#8b949e; font-size:14px; margin:0;">{{ $packages->count() }} plans · {{ $packages->where('is_active',true)->count() }} active</p>
        </div>
        <button onclick="document.getElementById('addPackageModal').style.display='flex'"
            style="background:#720e9e; color:white; font-weight:600; font-size:14px; padding:10px 20px; border:none; border-radius:10px; cursor:pointer; display:flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-plus"></i> Add Plan
        </button>
    </div>

    <!-- Package cards -->
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:28px;">
        @foreach($packages as $package)
            <div style="background:#161b22; border:1px solid #21262d; border-radius:16px; padding:24px; position:relative;">
                <div style="position:absolute; top:16px; right:16px;">
                    @if($package->is_active)
                        <span style="background:rgba(34,197,94,0.15); color:#22c55e; font-size:11px; font-weight:600; padding:4px 10px; border-radius:999px; border:1px solid rgba(34,197,94,0.3);">
                            <i class="fa-solid fa-circle" style="font-size:6px; margin-right:4px;"></i> Active
                        </span>
                    @else
                        <span style="background:rgba(239,68,68,0.15); color:#ef4444; font-size:11px; font-weight:600; padding:4px 10px; border-radius:999px; border:1px solid rgba(239,68,68,0.3);">
                            Inactive
                        </span>
                    @endif
                </div>
                <div style="width:48px; height:48px; background:rgba(114,14,158,0.2); border-radius:12px; display:flex; align-items:center; justify-content:center; margin-bottom:16px;">
                    <i class="fa-solid fa-box" style="color:#a78bfa; font-size:20px;"></i>
                </div>
                <h3 style="color:white; font-size:20px; font-weight:700; margin:0 0 4px;">{{ $package->name }}</h3>
                <p style="color:#22c55e; font-size:28px; font-weight:800; margin:8px 0;">KES {{ number_format($package->price, 2) }}</p>
                <p style="color:#8b949e; font-size:13px; margin:0 0 20px;">{{ $package->duration_days }} {{ $package->duration_days === 1 ? 'day' : 'days' }} · {{ $package->description }}</p>

                <div style="display:flex; gap:8px;">
                    <!-- Edit button -->
                    <button onclick="openEditModal({{ $package->id }}, '{{ $package->name }}', {{ $package->price }}, {{ $package->duration_days }}, '{{ $package->description }}')"
                        style="flex:1; background:rgba(114,14,158,0.15); border:1px solid rgba(114,14,158,0.3); color:#a78bfa; font-size:13px; font-weight:600; padding:9px; border-radius:8px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px; transition:all 0.2s;"
                        onmouseover="this.style.background='rgba(114,14,158,0.3)'"
                        onmouseout="this.style.background='rgba(114,14,158,0.15)'">
                        <i class="fa-solid fa-pen"></i> Edit
                    </button>
                    <!-- Toggle button -->
                    <form method="POST" action="{{ route('admin.packages.toggle', $package->id) }}" style="flex:1;">
                        @csrf
                        <button type="submit"
                            style="width:100%; background:{{ $package->is_active ? 'rgba(239,68,68,0.1)' : 'rgba(34,197,94,0.1)' }}; border:1px solid {{ $package->is_active ? 'rgba(239,68,68,0.3)' : 'rgba(34,197,94,0.3)' }}; color:{{ $package->is_active ? '#ef4444' : '#22c55e' }}; font-size:13px; font-weight:600; padding:9px; border-radius:8px; cursor:pointer;">
                            {{ $package->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Table -->
    <div style="background:#161b22; border:1px solid #21262d; border-radius:16px; overflow:hidden;">
        <div style="padding:18px 20px; border-bottom:1px solid #21262d;">
            <h3 style="color:white; font-size:15px; font-weight:700; margin:0;">All Plans</h3>
        </div>
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:1px solid #21262d;">
                    <th style="text-align:left; padding:12px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase;">#</th>
                    <th style="text-align:left; padding:12px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase;">Plan Name</th>
                    <th style="text-align:left; padding:12px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase;">Price (KES)</th>
                    <th style="text-align:left; padding:12px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase;">Duration</th>
                    <th style="text-align:left; padding:12px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase;">Status</th>
                    <th style="text-align:left; padding:12px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($packages as $i => $package)
                    <tr style="border-bottom:1px solid #21262d;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                        <td style="padding:14px 20px; color:#8b949e; font-size:14px;">{{ $i + 1 }}</td>
                        <td style="padding:14px 20px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <i class="fa-solid fa-tag" style="color:#720e9e;"></i>
                                <span style="color:white; font-size:14px; font-weight:600;">{{ $package->name }}</span>
                            </div>
                        </td>
                        <td style="padding:14px 20px; color:#22c55e; font-size:14px; font-weight:600;">KES {{ number_format($package->price, 2) }}</td>
                        <td style="padding:14px 20px; color:#d1d7db; font-size:14px;">{{ $package->duration_days }} {{ $package->duration_days === 1 ? 'day' : 'days' }}</td>
                        <td style="padding:14px 20px;">
                            @if($package->is_active)
                                <span style="background:rgba(34,197,94,0.15); color:#22c55e; font-size:12px; font-weight:600; padding:4px 12px; border-radius:999px;">Active</span>
                            @else
                                <span style="background:rgba(239,68,68,0.15); color:#ef4444; font-size:12px; font-weight:600; padding:4px 12px; border-radius:999px;">Inactive</span>
                            @endif
                        </td>
                        <td style="padding:14px 20px;">
                            <div style="display:flex; gap:6px;">
                                <button onclick="openEditModal({{ $package->id }}, '{{ $package->name }}', {{ $package->price }}, {{ $package->duration_days }}, '{{ $package->description }}')"
                                    style="background:rgba(114,14,158,0.15); border:1px solid rgba(114,14,158,0.3); color:#a78bfa; font-size:12px; font-weight:500; padding:5px 12px; border-radius:6px; cursor:pointer; display:flex; align-items:center; gap:4px;"
                                    onmouseover="this.style.background='rgba(114,14,158,0.3)'"
                                    onmouseout="this.style.background='rgba(114,14,158,0.15)'">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </button>
                                <form method="POST" action="{{ route('admin.packages.toggle', $package->id) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit"
                                        style="background:{{ $package->is_active ? 'rgba(239,68,68,0.1)' : 'rgba(34,197,94,0.1)' }}; border:1px solid {{ $package->is_active ? 'rgba(239,68,68,0.3)' : 'rgba(34,197,94,0.3)' }}; color:{{ $package->is_active ? '#ef4444' : '#22c55e' }}; font-size:12px; font-weight:500; padding:5px 14px; border-radius:6px; cursor:pointer;">
                                        {{ $package->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

<!-- Add Package Modal -->
<div id="addPackageModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.8); z-index:200; align-items:center; justify-content:center;">
    <div style="background:#161b22; border:1px solid #21262d; border-radius:20px; padding:32px; max-width:440px; width:90%;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
            <h3 style="color:white; font-size:18px; font-weight:700; margin:0;">Add New Plan</h3>
            <button onclick="document.getElementById('addPackageModal').style.display='none'"
                style="background:none; border:none; color:#8b949e; cursor:pointer; font-size:18px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.packages.create') }}">
            @csrf
            <div style="margin-bottom:16px;">
                <label style="display:block; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Plan Name</label>
                <input type="text" name="name" placeholder="e.g. Monthly" required
                    style="width:100%; background:#0d1117; border:1px solid #30363d; color:white; font-size:14px; padding:10px 14px; border-radius:8px; outline:none; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#720e9e'" onblur="this.style.borderColor='#30363d'">
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Price (KES)</label>
                <input type="number" name="price" placeholder="e.g. 250" min="1" required
                    style="width:100%; background:#0d1117; border:1px solid #30363d; color:white; font-size:14px; padding:10px 14px; border-radius:8px; outline:none; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#720e9e'" onblur="this.style.borderColor='#30363d'">
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Duration (Days)</label>
                <input type="number" name="duration_days" placeholder="e.g. 30" min="1" required
                    style="width:100%; background:#0d1117; border:1px solid #30363d; color:white; font-size:14px; padding:10px 14px; border-radius:8px; outline:none; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#720e9e'" onblur="this.style.borderColor='#30363d'">
            </div>
            <div style="margin-bottom:24px;">
                <label style="display:block; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Description</label>
                <input type="text" name="description" placeholder="e.g. Full access for 30 days"
                    style="width:100%; background:#0d1117; border:1px solid #30363d; color:white; font-size:14px; padding:10px 14px; border-radius:8px; outline:none; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#720e9e'" onblur="this.style.borderColor='#30363d'">
            </div>
            <button type="submit"
                style="width:100%; background:#720e9e; color:white; font-weight:700; font-size:15px; padding:12px; border:none; border-radius:10px; cursor:pointer;">
                Create Plan
            </button>
        </form>
    </div>
</div>

<!-- Edit Package Modal -->
<div id="editPackageModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.8); z-index:200; align-items:center; justify-content:center;">
    <div style="background:#161b22; border:1px solid #21262d; border-radius:20px; padding:32px; max-width:440px; width:90%;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
            <h3 style="color:white; font-size:18px; font-weight:700; margin:0;">Edit Plan</h3>
            <button onclick="document.getElementById('editPackageModal').style.display='none'"
                style="background:none; border:none; color:#8b949e; cursor:pointer; font-size:18px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form method="POST" id="editPackageForm">
            @csrf
            <div style="margin-bottom:16px;">
                <label style="display:block; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Plan Name</label>
                <input type="text" name="name" id="editName" required
                    style="width:100%; background:#0d1117; border:1px solid #30363d; color:white; font-size:14px; padding:10px 14px; border-radius:8px; outline:none; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#720e9e'" onblur="this.style.borderColor='#30363d'">
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Price (KES)</label>
                <input type="number" name="price" id="editPrice" min="1" required
                    style="width:100%; background:#0d1117; border:1px solid #30363d; color:white; font-size:14px; padding:10px 14px; border-radius:8px; outline:none; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#720e9e'" onblur="this.style.borderColor='#30363d'">
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Duration (Days)</label>
                <input type="number" name="duration_days" id="editDuration" min="1" required
                    style="width:100%; background:#0d1117; border:1px solid #30363d; color:white; font-size:14px; padding:10px 14px; border-radius:8px; outline:none; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#720e9e'" onblur="this.style.borderColor='#30363d'">
            </div>
            <div style="margin-bottom:24px;">
                <label style="display:block; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Description</label>
                <input type="text" name="description" id="editDescription"
                    style="width:100%; background:#0d1117; border:1px solid #30363d; color:white; font-size:14px; padding:10px 14px; border-radius:8px; outline:none; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#720e9e'" onblur="this.style.borderColor='#30363d'">
            </div>
            <button type="submit"
                style="width:100%; background:#720e9e; color:white; font-weight:700; font-size:15px; padding:12px; border:none; border-radius:10px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px;">
                <i class="fa-solid fa-floppy-disk"></i> Save Changes
            </button>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, name, price, duration, description) {
        document.getElementById('editName').value        = name;
        document.getElementById('editPrice').value       = price;
        document.getElementById('editDuration').value    = duration;
        document.getElementById('editDescription').value = description || '';
        document.getElementById('editPackageForm').action = '/admin/packages/' + id + '/update';
        document.getElementById('editPackageModal').style.display = 'flex';
    }
</script>

@endsection