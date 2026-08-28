@extends('layouts.admin')
@section('title', 'Payments')

@section('content')

    <!-- Stats -->
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:28px;">
        <div style="background:linear-gradient(135deg,#064e3b,#022c22); border:1px solid #065f46; border-radius:14px; padding:20px;">
            <p style="color:#6ee7b7; font-size:12px; font-weight:600; text-transform:uppercase; margin:0 0 8px;">Total Revenue</p>
            <p style="color:white; font-size:28px; font-weight:800; margin:0;">KES {{ number_format($totalRevenue, 2) }}</p>
        </div>
        <div style="background:linear-gradient(135deg,#1e3a5f,#1a2f4a); border:1px solid #1e4070; border-radius:14px; padding:20px;">
            <p style="color:#93c5fd; font-size:12px; font-weight:600; text-transform:uppercase; margin:0 0 8px;">Completed</p>
            <p style="color:white; font-size:28px; font-weight:800; margin:0;">{{ $completed }}</p>
        </div>
        <div style="background:linear-gradient(135deg,#3d2f00,#2d2200); border:1px solid #7c5a00; border-radius:14px; padding:20px;">
            <p style="color:#fde68a; font-size:12px; font-weight:600; text-transform:uppercase; margin:0 0 8px;">Pending</p>
            <p style="color:white; font-size:28px; font-weight:800; margin:0;">{{ $pending }}</p>
        </div>
        <div style="background:linear-gradient(135deg,#4c0519,#3b0111); border:1px solid #881337; border-radius:14px; padding:20px;">
            <p style="color:#fca5a5; font-size:12px; font-weight:600; text-transform:uppercase; margin:0 0 8px;">Failed</p>
            <p style="color:white; font-size:28px; font-weight:800; margin:0;">{{ $failed }}</p>
        </div>
    </div>

    <!-- Table -->
    <div style="background:#161b22; border:1px solid #21262d; border-radius:16px; overflow:hidden;">
        <div style="padding:18px 20px; border-bottom:1px solid #21262d; display:flex; align-items:center; justify-content:space-between;">
            <h3 style="color:white; font-size:15px; font-weight:700; margin:0;">All Transactions</h3>
            <span style="color:#8b949e; font-size:13px;">{{ $payments->total() }} records</span>
        </div>
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:1px solid #21262d;">
                    <th style="text-align:left; padding:12px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase;">#</th>
                    <th style="text-align:left; padding:12px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase;">User</th>
                    <th style="text-align:left; padding:12px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase;">Plan</th>
                    <th style="text-align:left; padding:12px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase;">Amount</th>
                    <th style="text-align:left; padding:12px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase;">Reference</th>
                    <th style="text-align:left; padding:12px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase;">Status</th>
                    <th style="text-align:left; padding:12px 20px; color:#8b949e; font-size:12px; font-weight:600; text-transform:uppercase;">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $i => $payment)
                    <tr style="border-bottom:1px solid #21262d;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                        <td style="padding:14px 20px; color:#8b949e; font-size:13px;">{{ $payments->firstItem() + $i }}</td>
                        <td style="padding:14px 20px;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:34px; height:34px; border-radius:50%; background:#720e9e; display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:13px; flex-shrink:0;">
                                    {{ strtoupper(substr($payment->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p style="color:white; font-size:13px; font-weight:600; margin:0;">{{ $payment->user->name }}</p>
                                    <p style="color:#8b949e; font-size:11px; margin:0;">{{ $payment->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td style="padding:14px 20px;">
                            <span style="background:rgba(114,14,158,0.15); color:#a78bfa; font-size:12px; font-weight:600; padding:3px 10px; border-radius:999px;">
                                {{ $payment->package->name }}
                            </span>
                        </td>
                        <td style="padding:14px 20px; color:#22c55e; font-size:14px; font-weight:600;">KES {{ number_format($payment->amount, 2) }}</td>
                        <td style="padding:14px 20px; color:#8b949e; font-size:12px; font-family:monospace;">{{ $payment->reference }}</td>
                        <td style="padding:14px 20px;">
                            @if($payment->status === 'completed')
                                <span style="background:rgba(34,197,94,0.15); color:#22c55e; font-size:12px; font-weight:600; padding:4px 12px; border-radius:999px;">
                                    <i class="fa-solid fa-check" style="margin-right:4px;"></i> Completed
                                </span>
                            @elseif($payment->status === 'pending')
                                <span style="background:rgba(245,158,11,0.15); color:#f59e0b; font-size:12px; font-weight:600; padding:4px 12px; border-radius:999px;">
                                    <i class="fa-solid fa-clock" style="margin-right:4px;"></i> Pending
                                </span>
                            @else
                                <span style="background:rgba(239,68,68,0.15); color:#ef4444; font-size:12px; font-weight:600; padding:4px 12px; border-radius:999px;">
                                    <i class="fa-solid fa-xmark" style="margin-right:4px;"></i> Failed
                                </span>
                            @endif
                        </td>
                        <td style="padding:14px 20px; color:#8b949e; font-size:13px;">{{ $payment->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:40px; color:#8b949e; font-size:14px;">No transactions yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if($payments->hasPages())
            <div style="padding:16px 20px; border-top:1px solid #21262d; display:flex; justify-content:space-between; align-items:center;">
                <p style="color:#8b949e; font-size:13px; margin:0;">Showing {{ $payments->firstItem() }}-{{ $payments->lastItem() }} of {{ $payments->total() }}</p>
                <div style="display:flex; gap:6px;">
                    @if($payments->onFirstPage())
                        <span style="background:#21262d; color:#4b5563; padding:6px 12px; border-radius:6px; font-size:13px;">← Prev</span>
                    @else
                        <a href="{{ $payments->previousPageUrl() }}" style="background:#21262d; color:#d1d7db; padding:6px 12px; border-radius:6px; font-size:13px; text-decoration:none;">← Prev</a>
                    @endif
                    @if($payments->hasMorePages())
                        <a href="{{ $payments->nextPageUrl() }}" style="background:#720e9e; color:white; padding:6px 12px; border-radius:6px; font-size:13px; text-decoration:none;">Next →</a>
                    @else
                        <span style="background:#21262d; color:#4b5563; padding:6px 12px; border-radius:6px; font-size:13px;">Next →</span>
                    @endif
                </div>
            </div>
        @endif
    </div>

@endsection