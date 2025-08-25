@extends('layouts.user')

@section('title', 'Dashboard - ' . $settings->site_name)

@section('content')
<div class="container pt-4">
    <div class="d-flex justify-content-between align-items-center">
        <!-- Profile Section - Now links to update page -->
        <a href="{{ route('profile.picture') }}" class="text-decoration-none text-dark">
            <div class="d-flex align-items-center">
                <!-- Profile Picture Circle -->
                <div class="rounded-circle overflow-hidden me-3" style="width: 40px; height: 40px; position: relative;">
                    @if ($user->profile_photo_path)
                    <img src="{{ $user->profile_photo_url }}" alt="Profile" class="w-100 h-100"
                        style="object-fit: cover;">
                    @else
                    <div class="bg-secondary w-100 h-100 d-flex align-items-center justify-content-center">
                        <span class="text-white">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                    @endif
                </div>

                <!-- Greeting Text -->
                <div>
                    <h6 class="mb-0 fw-semibold">Hello, {{ $user->name }}!</h6>
                </div>
            </div>
        </a>

        <!-- Account Number + Copy -->
        <div class="text-end">
            <span class="text-muted small d-block">
                <span id="accountNumber">{{ $user->usernumber }}</span>
                <i class="bi bi-copy ms-1 clickable" id="copyIcon" onclick="copyAccountNumber()"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Copy to clipboard"></i>
            </span>
        </div>
    </div>

    <div class="mt-2">
        <span class="badge bg-light text-dark small-text">Savings</span>
    </div>

    <div class="mt-2 d-flex align-items-center gap-2">
        <span class="text-muted small-text">Book Balance:</span>
        <span id="balance" class="fw-bold clickable">
            {{ $user->currency ?? 'Kz' }}{{ number_format($user->account_bal, 2) }}
        </span>
    </div>

    <!-- Buttons -->
    <div class="d-flex gap-2 mt-3">
        <a href="{{ route('deposit.index') }}" class="btn btn-main flex-fill">
            <i class="bi bi-plus-circle"></i> Fund account
        </a>
        <a href="{{ route('bank.transfer') }}" class="btn btn-outline-main flex-fill">
            <i class="bi bi-arrow-right"></i> Transfer
        </a>
        @if($settings->modules && in_array('fx', json_decode($settings->modules, true)))
        <a href="{{ route('fx') }}" class="btn btn-outline-main flex-fill">
            <i class="bi bi-currency-exchange"></i> FX
        </a>
        @endif
    </div>

    <!-- Shortcuts -->
    <h6 class="mt-4">Shortcuts</h6>
    <div class="d-flex justify-content-around text-center">
        @if($settings->modules && in_array('crypto', json_decode($settings->modules, true)))
        <a href="{{ route('crypto') }}" class="text-decoration-none text-dark">
            <div>
                <div class="shortcut-icon bg-shortcut-1"><i class="bi bi-currency-bitcoin"></i></div>
                <small>Crypto</small>
            </div>
        </a>
        @endif

        <a href="{{ route('deposit.index') }}" class="text-decoration-none text-dark">
            <div>
                <div class="shortcut-icon bg-shortcut-3"><i class="bi bi-bank2"></i></div>
                <small>Deposit</small>
            </div>
        </a>

        @if($settings->modules && in_array('loan', json_decode($settings->modules, true)))
        <a href="{{ route('loan') }}" class="text-decoration-none text-dark">
            <div>
                <div class="shortcut-icon bg-shortcut-3"><i class="bi bi-credit-card"></i></div>
                <small>Loan</small>
            </div>
        </a>
        @endif

        @if($settings->modules && in_array('bills', json_decode($settings->modules, true)))
        <a href="{{ route('bills.pay') }}" class="text-decoration-none text-dark">
            <div>
                <div class="shortcut-icon bg-shortcut-3"><i class="bi bi-cash-stack"></i></div>
                <small>Pay Bill</small>
            </div>
        </a>
        @endif

        @if($settings->modules && in_array('paypal', json_decode($settings->modules, true)))
        <a href="{{ route('paypal') }}" class="text-decoration-none text-dark">
            <div>
                <div class="shortcut-icon bg-shortcut-4"><i class="bi bi-paypal"></i></div>
                <small>PayPal</small>
            </div>
        </a>
        @endif
    </div>

    <!-- Transaction -->
    <h6 class="mt-4 d-flex justify-content-between align-items-center">
        Transaction history
        <a href="{{ route('transactions') }}" class="small text-decoration-none">See more</a>
    </h6>

    @if($transactions->count() > 0)
    <div class="list-group">
        @foreach($transactions as $transaction)
        <div class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1">{{ $transaction->description }}</h6>
                <small class="text-{{ $transaction->type === 'credit' ? 'success' : 'danger' }}">
                    {{ $transaction->type === 'credit' ? '+' : '-' }}{{ $user->currency ?? 'Kz' }}{{
                    number_format($transaction->amount, 2) }}
                </small>
            </div>
            <p class="mb-1 small">{{ $transaction->created_at->format('M d, Y H:i') }}</p>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center text-muted py-4">
        No transactions yet.
    </div>
    @endif

    <!-- Investments -->
    @if($settings->modules && in_array('investments', json_decode($settings->modules, true)))
    <div class="card border-0 bg-light mb-4">
        <div class="card-body text-center py-5">
            <i class="bi bi-safe2-fill text-muted opacity-50" style="font-size: 3rem;"></i>
            <h5 class="mt-3 mb-1 fw-semibold">No investments yet</h5>
            <p class="text-muted small mb-0">Your investment portfolio will appear here</p>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    /* ✅ Copy account number */
    function copyAccountNumber() {
        const accountNumber = document.getElementById('accountNumber').textContent;
        navigator.clipboard.writeText(accountNumber).then(() => {
            const tooltip = new bootstrap.Tooltip(document.getElementById('copyIcon'), {
                title: 'Copied!',
                trigger: 'manual'
            });
            tooltip.show();
            setTimeout(() => tooltip.hide(), 2000);
        });
    }

    /* ✅ Init Bootstrap tooltips */
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(el) {
            return new bootstrap.Tooltip(el);
        });
    });
</script>
@endsection