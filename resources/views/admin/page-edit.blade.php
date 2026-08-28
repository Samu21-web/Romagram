@extends('layouts.admin')
@section('title', 'Edit: ' . $page->title)

@section('content')

    <!-- Header -->
    <div style="display:flex; align-items:center; gap:16px; margin-bottom:28px;">
        <a href="{{ route('admin.pages') }}"
            style="background:#21262d; border:1px solid #30363d; color:#8b949e; width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; text-decoration:none;"
            onmouseover="this.style.color='white'" onmouseout="this.style.color='#8b949e'">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h2 style="color:white; font-size:20px; font-weight:700; margin:0 0 2px;">Edit: {{ $page->title }}</h2>
            <p style="color:#8b949e; font-size:13px; margin:0;">
                Public URL:
                <a href="{{ route('page.show', $page->slug) }}" target="_blank" style="color:#a78bfa; text-decoration:none;">
                    /{{ $page->slug }} <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:10px;"></i>
                </a>
            </p>
        </div>
    </div>

    @if(session('success'))
        <div style="background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3); border-radius:12px; padding:12px 16px; margin-bottom:20px; color:#22c55e; font-size:14px; display:flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.pages.update', $page->slug) }}">
        @csrf
        <div style="display:grid; grid-template-columns:1fr 340px; gap:20px; align-items:start;">

            <!-- Main editor -->
            <div style="background:#161b22; border:1px solid #21262d; border-radius:16px; overflow:hidden;">

                <!-- Toolbar -->
                <div style="padding:12px 16px; border-bottom:1px solid #21262d; display:flex; gap:6px; flex-wrap:wrap;">
                    <button type="button" onclick="insertTag('h2')"
                        style="background:#21262d; border:1px solid #30363d; color:#d1d7db; font-size:12px; font-weight:600; padding:5px 10px; border-radius:6px; cursor:pointer;">H2</button>
                    <button type="button" onclick="insertTag('h3')"
                        style="background:#21262d; border:1px solid #30363d; color:#d1d7db; font-size:12px; font-weight:600; padding:5px 10px; border-radius:6px; cursor:pointer;">H3</button>
                    <button type="button" onclick="insertTag('p')"
                        style="background:#21262d; border:1px solid #30363d; color:#d1d7db; font-size:12px; font-weight:600; padding:5px 10px; border-radius:6px; cursor:pointer;">P</button>
                    <button type="button" onclick="insertTag('strong')"
                        style="background:#21262d; border:1px solid #30363d; color:#d1d7db; font-size:12px; font-weight:700; padding:5px 10px; border-radius:6px; cursor:pointer;">B</button>
                    <button type="button" onclick="insertTag('em')"
                        style="background:#21262d; border:1px solid #30363d; color:#d1d7db; font-size:12px; font-style:italic; padding:5px 10px; border-radius:6px; cursor:pointer;">I</button>
                    <div style="width:1px; background:#30363d; margin:0 4px;"></div>
                    <button type="button" onclick="insertList()"
                        style="background:#21262d; border:1px solid #30363d; color:#d1d7db; font-size:12px; font-weight:600; padding:5px 10px; border-radius:6px; cursor:pointer;">
                        <i class="fa-solid fa-list"></i> List
                    </button>
                    <button type="button" onclick="togglePreview()"
                        style="background:rgba(114,14,158,0.2); border:1px solid rgba(114,14,158,0.4); color:#a78bfa; font-size:12px; font-weight:600; padding:5px 12px; border-radius:6px; cursor:pointer; margin-left:auto;">
                        <i class="fa-solid fa-eye" style="margin-right:4px;"></i> Preview
                    </button>
                </div>

                <!-- Title -->
                <div style="padding:16px 16px 0;">
                    <label style="display:block; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Page Title</label>
                    <input type="text" name="title" value="{{ old('title', $page->title) }}" required
                        style="width:100%; background:#0d1117; border:1px solid #30363d; color:white; font-size:16px; font-weight:600; padding:10px 14px; border-radius:8px; outline:none; box-sizing:border-box;"
                        onfocus="this.style.borderColor='#720e9e'" onblur="this.style.borderColor='#30363d'">
                </div>

                <!-- Content textarea -->
                <div style="padding:16px;" id="editorWrapper">
                    <label style="display:block; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Content (HTML)</label>
                    <textarea name="content" id="contentEditor" rows="22" required
                        style="width:100%; background:#0d1117; border:1px solid #30363d; color:#e6edf3; font-size:13px; font-family:monospace; line-height:1.7; padding:14px; border-radius:8px; outline:none; resize:vertical; box-sizing:border-box;"
                        onfocus="this.style.borderColor='#720e9e'" onblur="this.style.borderColor='#30363d'">{{ old('content', $page->content) }}</textarea>
                </div>

                <!-- Preview -->
                <div id="previewWrapper" style="display:none; padding:24px; border-top:1px solid #21262d;">
                    <p style="color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 16px;">Preview</p>
                    <div id="previewContent" style="color:#d1d7db; font-size:15px; line-height:1.8; background:#0d1117; padding:20px; border-radius:8px; border:1px solid #30363d;"></div>
                </div>
            </div>

            <!-- Sidebar -->
            <div style="display:flex; flex-direction:column; gap:16px;">

                <!-- Publish -->
                <div style="background:#161b22; border:1px solid #21262d; border-radius:16px; padding:20px;">
                    <h3 style="color:white; font-size:14px; font-weight:700; margin:0 0 16px;">Publish</h3>
                    <div style="margin-bottom:16px;">
                        <p style="color:#8b949e; font-size:12px; margin:0 0 4px;">Status</p>
                        <span style="background:rgba(34,197,94,0.15); color:#22c55e; font-size:12px; font-weight:600; padding:3px 10px; border-radius:999px; border:1px solid rgba(34,197,94,0.3);">
                            <i class="fa-solid fa-circle" style="font-size:7px; margin-right:4px;"></i> Published
                        </span>
                    </div>
                    @if($page->last_updated_at)
                        <div style="margin-bottom:16px;">
                            <p style="color:#8b949e; font-size:12px; margin:0 0 4px;">Last Updated</p>
                            <p style="color:#d1d7db; font-size:13px; margin:0;">{{ $page->last_updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    @endif
                    <button type="submit"
                        style="width:100%; background:#720e9e; color:white; font-weight:700; font-size:14px; padding:11px; border:none; border-radius:10px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; transition:background 0.2s;"
                        onmouseover="this.style.background='#9b1bc7'" onmouseout="this.style.background='#720e9e'">
                        <i class="fa-solid fa-floppy-disk"></i> Save Changes
                    </button>
                </div>

                <!-- Page info -->
                <div style="background:#161b22; border:1px solid #21262d; border-radius:16px; padding:20px;">
                    <h3 style="color:white; font-size:14px; font-weight:700; margin:0 0 16px;">Page Info</h3>
                    <div style="margin-bottom:12px;">
                        <p style="color:#8b949e; font-size:12px; margin:0 0 4px;">Slug</p>
                        <p style="color:#d1d7db; font-size:13px; font-family:monospace; margin:0; background:#0d1117; padding:6px 10px; border-radius:6px; border:1px solid #30363d;">{{ $page->slug }}</p>
                    </div>
                    <div>
                        <p style="color:#8b949e; font-size:12px; margin:0 0 4px;">Public URL</p>
                        <a href="{{ route('page.show', $page->slug) }}" target="_blank"
                            style="color:#a78bfa; font-size:12px; text-decoration:none; display:flex; align-items:center; gap:4px;"
                            onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                            /{{ $page->slug }} <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:10px;"></i>
                        </a>
                    </div>
                </div>

                <!-- HTML tips -->
                <div style="background:#161b22; border:1px solid #21262d; border-radius:16px; padding:20px;">
                    <h3 style="color:white; font-size:14px; font-weight:700; margin:0 0 12px;">HTML Tips</h3>
                    <div style="display:flex; flex-direction:column; gap:8px;">
                        <div style="background:#0d1117; border-radius:6px; padding:8px 10px; font-family:monospace; font-size:11px; color:#8b949e;">&lt;h2&gt;Section Title&lt;/h2&gt;</div>
                        <div style="background:#0d1117; border-radius:6px; padding:8px 10px; font-family:monospace; font-size:11px; color:#8b949e;">&lt;p&gt;Paragraph text&lt;/p&gt;</div>
                        <div style="background:#0d1117; border-radius:6px; padding:8px 10px; font-family:monospace; font-size:11px; color:#8b949e;">&lt;ul&gt;&lt;li&gt;Item&lt;/li&gt;&lt;/ul&gt;</div>
                        <div style="background:#0d1117; border-radius:6px; padding:8px 10px; font-family:monospace; font-size:11px; color:#8b949e;">&lt;strong&gt;Bold&lt;/strong&gt;</div>
                        <div style="background:#0d1117; border-radius:6px; padding:8px 10px; font-family:monospace; font-size:11px; color:#8b949e;">&lt;a href="#"&gt;Link&lt;/a&gt;</div>
                    </div>
                </div>
            </div>
        </div>
    </form>

<script>
    function insertTag(tag) {
        const ta = document.getElementById('contentEditor');
        const start = ta.selectionStart;
        const end   = ta.selectionEnd;
        const sel   = ta.value.substring(start, end) || 'Content here';
        const replacement = `<${tag}>${sel}</${tag}>`;
        ta.value = ta.value.substring(0, start) + replacement + ta.value.substring(end);
        ta.focus();
    }

    function insertList() {
        const ta = document.getElementById('contentEditor');
        const pos = ta.selectionStart;
        const list = '\n<ul>\n<li>Item one</li>\n<li>Item two</li>\n<li>Item three</li>\n</ul>\n';
        ta.value = ta.value.substring(0, pos) + list + ta.value.substring(pos);
        ta.focus();
    }

    function togglePreview() {
        const editor  = document.getElementById('editorWrapper');
        const preview = document.getElementById('previewWrapper');
        const content = document.getElementById('contentEditor').value;

        if (preview.style.display === 'none') {
            document.getElementById('previewContent').innerHTML = content;
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    }
</script>
@endsection