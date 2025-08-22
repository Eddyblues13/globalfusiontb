@extends('layouts.user')

@section('title', 'Loan History - ' . $settings->site_name)

@section('content')
<div class="container pt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="mb-0 fw-semibold">Loan History</h5>
        </div>
        <a href="{{ route('loan') }}" class="btn btn-outline-main">
            <i class="bi bi-arrow-left"></i> Back to Loan
        </a>
    </div>

    @if($loans->count() > 0)
    <div class="list-group">
        @foreach($loans as $loan)
        <div class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1">{{ $loan->loan_type }}</h6>
                <span
                    class="badge bg-{{ $loan->status === 'approved' ? 'success' : ($loan->status === 'pending' ? 'warning' : ($loan->status === 'rejected' ? 'danger' : 'info')) }}">
                    {{ ucfirst($loan->status) }}
                </span>
            </div>
            <p class="mb-1">
                <strong>Amount:</strong> {{ $settings->s_currency }}{{ number_format($loan->amount, 2) }}<br>
                <strong>Total Payable:</strong> {{ $settings->s_currency }}{{ number_format($loan->total_amount, 2)
                }}<br>
                <strong>Monthly Payment:</strong> {{ $settings->s_currency }}{{ number_format($loan->monthly_payment, 2)
                }}
            </p>
            <small class="text-muted">
                Applied: {{ $loan->application_date->format('M d, Y') }} |
                Period: {{ floor($loan->repayment_period / 30) }} months
            </small>
        </div>
        @endforeach
    </div>

    <div class="mt-3">
        {{ $loans->links() }}
    </div>
    @else
    <div class="text-center py-4">
        <i class="bi bi-cash-stack fs-1 text-muted"></i>
        <p class="text-muted">No loan history found</p>
    </div>
    @endif
</div>

<!-- Bottom Navigation -->
<nav class="navbar fixed-bottom bg-white bottom-nav">
    <div class="container d-flex justify-content-around text-center">
        <a class="nav-link" href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i><br><small>Home</small></a>

        @if($settings->modules && in_array('card', json_decode($settings->modules, true)))
        <a class="nav-link" href="{{ route('card') }}"><i
                class="bi bi-credit-card-2-front"></i><br><small>Card</small></a>
        @endif

        <a class="nav-link" href="{{ route('bank.transfer') }}"><i
                class="bi bi-arrow-left-right"></i><br><small>Transfers</small></a>

        <a class="nav-link active" href="{{ route('loan') }}"><i
                class="bi bi-cash-stack"></i><br><small>Loan</small></a>

        <a class="nav-link" href="{{ route('transactions') }}"><i
                class="bi bi-clock-history"></i><br><small>History</small></a>
    </div>
</nav>
@endsection