@extends('layouts.user')

@section('title', 'Confirm Transfer - ' . $settings->site_name)

@section('content')
<div class="container pt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0 fw-semibold">Confirm Transfer</h5>
    </div>

    <div class="transaction-box">
        <div class="alert alert-warning mb-3">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            Please review your transfer details before confirming.
        </div>

        <div class="transfer-details mb-4">
            <h6 class="mb-3">Transfer Details</h6>
            <div class="row">
                <div class="col-6 mb-2">
                    <small class="text-muted">Recipient Name</small>
                    <p class="mb-0">{{ $transfer['account_name'] }}</p>
                </div>
                <div class="col-6 mb-2">
                    <small class="text-muted">Account Number</small>
                    <p class="mb-0">{{ $transfer['account_number'] }}</p>
                </div>
                <div class="col-6 mb-2">
                    <small class="text-muted">Bank Name</small>
                    <p class="mb-0">{{ $transfer['bank_name'] }}</p>
                </div>
                <div class="col-6 mb-2">
                    <small class="text-muted">Routing Number</small>
                    <p class="mb-0">{{ $transfer['routing_number'] }}</p>
                </div>
                <div class="col-6 mb-2">
                    <small class="text-muted">Amount</small>
                    <p class="mb-0 fw-bold">{{ $settings->s_currency ?? '$' }}{{ number_format($transfer['amount'], 2)
                        }}</p>
                </div>
                <div class="col-6 mb-2">
                    <small class="text-muted">Fee (1%)</small>
                    <p class="mb-0 text-danger">-{{ $settings->s_currency ?? '$' }}{{ number_format($transfer['amount']
                        * 0.01, 2) }}</p>
                </div>
                <div class="col-12 mb-2">
                    <small class="text-muted">Net Amount</small>
                    <p class="mb-0 fw-bold text-success">{{ $settings->s_currency ?? '$' }}{{
                        number_format($transfer['amount'] * 0.99, 2) }}</p>
                </div>
                @if(!empty($transfer['description']))
                <div class="col-12 mb-2">
                    <small class="text-muted">Description</small>
                    <p class="mb-0">{{ $transfer['description'] }}</p>
                </div>
                @endif
            </div>
        </div>

        @if($settings->enable_2fa && $settings->otp)
        <div class="alert alert-info">
            <i class="bi bi-shield-check me-2"></i>
            An OTP has been sent to your registered email. Please enter it below to confirm the transfer.
        </div>

        <form action="{{ route('bank.transfer.verify') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">OTP Code</label>
                <input type="text" name="otp" class="form-control" placeholder="Enter OTP code" required>
            </div>
            <button type="submit" class="btn btn-main w-100">Confirm Transfer</button>
        </form>
        @else
        <form action="{{ route('bank.transfer.process') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-main w-100">Confirm Transfer</button>
        </form>
        @endif

        <a href="{{ route('bank.transfer') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
    </div>
</div>
@endsection