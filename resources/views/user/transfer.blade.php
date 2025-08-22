@extends('layouts.user')

@section('title', 'Bank Transfer - ' . $settings->site_name)

@section('content')
<div class="container pt-4">
    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        Please fix the following errors:
        <ul class="mb-0 mt-1">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="mb-0 fw-semibold">Bank Transfer</h5>
        </div>
        <div class="text-end">
            <span class="text-muted small d-block">
                <span id="accountNumber">{{ $user->usernumber }}</span>
                <i class="bi bi-copy ms-1 clickable" id="copyIcon" onclick="copyAccountNumber()"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Copy to clipboard"></i>
            </span>
        </div>
    </div>

    <!-- Balance Display -->
    <div class="transfer-header">
        <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted">Available Balance</span>
            <span class="balance-display">{{ $user->currency ?? '$' }}{{ number_format($user->account_bal, 2)
                }}</span>
        </div>
    </div>

    <!-- Transfer Form -->
    <div class="transaction-box">
        <div class="alert alert-notice mb-3">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            You're about to transfer from your account's available balance. Please enter your correct information.
        </div>

        <form action="{{ route('bank.transfer.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Account Name</label>
                <input type="text" name="account_name" class="form-control @error('account_name') is-invalid @enderror"
                    placeholder="Recipient's name" value="{{ old('account_name') }}" required>
                @error('account_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Account Number</label>
                <input type="text" name="account_number"
                    class="form-control @error('account_number') is-invalid @enderror"
                    placeholder="Recipient's account number" value="{{ old('account_number') }}" required>
                @error('account_number')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Bank Name</label>
                <select name="bank_name" class="form-control @error('bank_name') is-invalid @enderror" required>
                    <option value="">Select Bank</option>
                    @foreach($banks as $bank)
                    <option value="{{ $bank }}" {{ old('bank_name')==$bank ? 'selected' : '' }}>{{ $bank }}</option>
                    @endforeach
                </select>
                @error('bank_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Routing Number</label>
                <input type="text" name="routing_number"
                    class="form-control @error('routing_number') is-invalid @enderror" placeholder="Bank routing number"
                    value="{{ old('routing_number') }}" required>
                @error('routing_number')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Amount</label>
                <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                    placeholder="Transfer amount" value="{{ old('amount') }}" step="0.01" min="0.01"
                    max="{{ $user->balance }}" required>
                @error('amount')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Transaction PIN</label>
                <input type="password" name="transaction_pin"
                    class="form-control @error('transaction_pin') is-invalid @enderror"
                    placeholder="Enter your 4-digit PIN" maxlength="4" required pattern="\d{4}">
                @error('transaction_pin')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Description (Optional)</label>
                <input type="text" name="description" class="form-control" placeholder="Transaction description"
                    value="{{ old('description') }}">
            </div>

            <button type="submit" class="btn btn-main w-100">Next</button>
        </form>
    </div>

    <!-- OTP Modal -->
    @if($settings->otp && $settings->enable_2fa)
    <div class="modal fade" id="otpModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">OTP Verification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="bi bi-shield-lock me-2"></i>
                        Enter the OTP sent to your registered email
                    </div>
                    <form action="{{ route('bank.transfer.verify') }}" method="POST">
                        @csrf
                        <input type="number" name="otp" class="form-control mb-3" placeholder="Enter OTP" required>
                        <button type="submit" class="btn btn-main w-100">Confirm Transfer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    // Copy account number with better UX
    function copyAccountNumber() {
        const accNum = document.getElementById("accountNumber").innerText;
        const icon = document.getElementById("copyIcon");

        navigator.clipboard.writeText(accNum).then(() => {
            const tooltip = bootstrap.Tooltip.getInstance(icon);
            tooltip.setContent({ '.tooltip-inner': 'Copied!' });
            icon.classList.replace("bi-copy", "bi-check2");

            setTimeout(() => {
                tooltip.setContent({ '.tooltip-inner': 'Copy to clipboard' });
                icon.classList.replace("bi-check2", "bi-copy");
            }, 2000);
        });
    }

    // Enable Bootstrap tooltip
    document.addEventListener("DOMContentLoaded", function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Show OTP modal if needed
        @if(session('show_otp'))
            const otpModal = new bootstrap.Modal(document.getElementById('otpModal'));
            otpModal.show();
        @endif
    });

    // Amount validation
    const amountInput = document.querySelector('input[name="amount"]');
    if (amountInput) {
        amountInput.addEventListener('input', function() {
            const maxAmount = parseFloat(this.max);
            const currentAmount = parseFloat(this.value);
            
            if (currentAmount > maxAmount) {
                this.setCustomValidity(`Amount cannot exceed your available balance of ${this.max}`);
            } else {
                this.setCustomValidity('');
            }
        });
    }
</script>
@endsection