@extends('layouts.app')
@section('title', $page->title)

@section('content')
<div style="max-width:800px; margin:0 auto; padding:60px 24px;">

    <!-- Back -->
    <a href="{{ route('home') }}" style="display:inline-flex; align-items:center; gap:8px; color:#720e9e; text-decoration:none; font-size:14px; margin-bottom:32px;"
       onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">
        <i class="fa-solid fa-arrow-left"></i> Back to Home
    </a>

    <!-- Header -->
    <div style="margin-bottom:40px; padding-bottom:32px; border-bottom:1px solid #e5e7eb;">
        <h1 style="font-size:36px; font-weight:800; color:#111827; margin:0 0 12px;">{{ $page->title }}</h1>
        @if($page->last_updated_at)
            <p style="color:#6b7280; font-size:14px; margin:0;">
                <i class="fa-solid fa-clock" style="margin-right:6px;"></i>
                Last updated: {{ $page->last_updated_at->format('F d, Y') }}
            </p>
        @endif
    </div>

    <!-- Content -->
    <div style="color:#374151; font-size:16px; line-height:1.8;">
        {!! $page->content !!}
    </div>

    <!-- Footer links -->
    <div style="margin-top:60px; padding-top:32px; border-top:1px solid #e5e7eb; display:flex; gap:24px; flex-wrap:wrap;">
        <a href="{{ route('page.privacy') }}" style="color:#720e9e; text-decoration:none; font-size:14px; font-weight:500;"
           onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
            Privacy Policy
        </a>
        <a href="{{ route('page.terms') }}" style="color:#720e9e; text-decoration:none; font-size:14px; font-weight:500;"
           onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
            Terms of Service
        </a>
    </div>
</div>

<style>
    .page-content h2 { font-size:22px; font-weight:700; color:#111827; margin:32px 0 12px; }
    .page-content h3 { font-size:18px; font-weight:600; color:#374151; margin:24px 0 10px; }
    .page-content p  { margin:0 0 16px; }
    .page-content ul { padding-left:24px; margin:0 0 16px; }
    .page-content li { margin-bottom:8px; }
</style>
@endsection