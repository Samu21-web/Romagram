@extends('layouts.admin')
@section('title', 'Pages')

@section('content')
    <div style="margin-bottom:28px;">
        <h2 style="color:white; font-size:20px; font-weight:700; margin:0 0 4px;">Site Pages</h2>
        <p style="color:#8b949e; font-size:14px; margin:0;">Manage your public pages content</p>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
        @foreach($pages as $page)
            <div style="background:#161b22; border:1px solid #21262d; border-radius:16px; padding:24px;">
                <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:16px;">
                    <div>
                        <div style="width:44px; height:44px; background:rgba(114,14,158,0.2); border-radius:12px; display:flex; align-items:center; justify-content:center; margin-bottom:12px;">
                            <i class="fa-solid fa-file-lines" style="color:#a78bfa; font-size:18px;"></i>
                        </div>
                        <h3 style="color:white; font-size:17px; font-weight:700; margin:0 0 4px;">{{ $page->title }}</h3>
                        <p style="color:#8b949e; font-size:12px; margin:0;">
                            <i class="fa-solid fa-link" style="margin-right:4px;"></i>
                            /{{ $page->slug }}
                        </p>
                    </div>
                    <span style="background:rgba(34,197,94,0.15); color:#22c55e; font-size:11px; font-weight:600; padding:4px 10px; border-radius:999px; border:1px solid rgba(34,197,94,0.3);">
                        Published
                    </span>
                </div>

                @if($page->last_updated_at)
                    <p style="color:#8b949e; font-size:12px; margin:0 0 16px;">
                        <i class="fa-solid fa-clock" style="margin-right:4px;"></i>
                        Updated {{ $page->last_updated_at->diffForHumans() }}
                    </p>
                @endif

                <div style="display:flex; gap:8px;">
                    <a href="{{ route('admin.pages.edit', $page->slug) }}"
                        style="flex:1; background:#720e9e; color:white; font-weight:600; font-size:13px; padding:9px; border-radius:8px; text-decoration:none; display:flex; align-items:center; justify-content:center; gap:6px; transition:all 0.2s;"
                        onmouseover="this.style.background='#9b1bc7'" onmouseout="this.style.background='#720e9e'">
                        <i class="fa-solid fa-pen"></i> Edit Content
                    </a>
                    <a href="{{ route('page.show', $page->slug) }}" target="_blank"
                        style="background:#21262d; border:1px solid #30363d; color:#8b949e; font-weight:500; font-size:13px; padding:9px 14px; border-radius:8px; text-decoration:none; display:flex; align-items:center; gap:6px;"
                        onmouseover="this.style.color='white'" onmouseout="this.style.color='#8b949e'">
                        <i class="fa-solid fa-eye"></i> View
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection