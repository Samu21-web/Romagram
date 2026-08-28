@extends('layouts.app-auth')
@section('title', 'Matches')

@section('content')

    <!-- Header -->
    <div style="background:#1f2c34; border-bottom:1px solid #2a3942; padding:16px 24px;">
        <div style="max-width:1200px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div>
                <h1 style="font-size:20px; font-weight:800; color:white; margin:0;">Matches</h1>
                <p style="color:#8696a0; font-size:13px; margin:2px 0 0;">People who liked you back</p>
            </div>
            <div style="display:flex; gap:10px;">
                @if($totalCount > 0)
                    <span style="background:rgba(236,72,153,0.12); border:1px solid rgba(236,72,153,0.3); color:#f472b6; font-size:13px; font-weight:600; padding:6px 14px; border-radius:999px;">
                        <i class="fa-solid fa-heart" style="margin-right:5px;"></i>
                        {{ $totalCount }} {{ $totalCount === 1 ? 'match' : 'matches' }}
                    </span>
                @endif
                @if($newCount > 0)
                    <span style="background:rgba(34,197,94,0.12); border:1px solid rgba(34,197,94,0.3); color:#22c55e; font-size:13px; font-weight:600; padding:6px 14px; border-radius:999px;">
                        <i class="fa-solid fa-star" style="margin-right:5px;"></i>
                        {{ $newCount }} new
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div style="max-width:1200px; margin:0 auto; padding:24px 16px;">

        @if(empty($matches))
            <div style="text-align:center; padding:80px 20px;">
                <div style="width:100px; height:100px; background:rgba(236,72,153,0.08); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 24px; border:2px solid rgba(236,72,153,0.15);">
                    <i class="fa-solid fa-heart-crack" style="font-size:40px; color:rgba(236,72,153,0.4);"></i>
                </div>
                <h3 style="font-size:22px; font-weight:700; color:white; margin:0 0 10px;">No matches yet</h3>
                <p style="color:#8696a0; font-size:15px; margin:0 0 28px; line-height:1.6; max-width:380px; margin-left:auto; margin-right:auto;">
                    Keep liking profiles on Discover — when someone likes you back, they'll appear here!
                </p>
                <a href="{{ route('discover') }}"
                    style="display:inline-flex; align-items:center; gap:8px; background:white; color:#111b21; font-weight:700; padding:13px 28px; border-radius:999px; text-decoration:none; font-size:15px;">
                    <i class="fa-solid fa-fire"></i> Discover People
                </a>
            </div>
        @else

            @php
                $newMatches = array_filter($matches, fn($m) => $m['isNew']);
                $oldMatches = array_filter($matches, fn($m) => !$m['isNew']);
            @endphp

            <!-- New Matches -->
            @if(count($newMatches) > 0)
                <div style="margin-bottom:36px;">
                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:16px;">
                        <div style="width:8px; height:8px; background:#22c55e; border-radius:50%;"></div>
                        <h2 style="color:white; font-size:15px; font-weight:700; margin:0;">New Matches</h2>
                        <span style="background:rgba(34,197,94,0.15); color:#22c55e; font-size:11px; font-weight:700; padding:2px 8px; border-radius:999px;">{{ count($newMatches) }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2.5 sm:[grid-template-columns:repeat(auto-fill,minmax(200px,1fr))] sm:gap-4">
                        @foreach($newMatches as $match)
                            @include('partials.match-card', ['match' => $match])
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Older Matches -->
            @if(count($oldMatches) > 0)
                <div>
                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:16px;">
                        <i class="fa-solid fa-heart" style="color:#f472b6; font-size:14px;"></i>
                        <h2 style="color:white; font-size:15px; font-weight:700; margin:0;">Previous Matches</h2>
                        <span style="background:rgba(236,72,153,0.12); color:#f472b6; font-size:11px; font-weight:700; padding:2px 8px; border-radius:999px;">{{ count($oldMatches) }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2.5 sm:[grid-template-columns:repeat(auto-fill,minmax(200px,1fr))] sm:gap-4">
                        @foreach($oldMatches as $match)
                            @include('partials.match-card', ['match' => $match])
                        @endforeach
                    </div>
                </div>
            @endif

        @endif
    </div>
@endsection