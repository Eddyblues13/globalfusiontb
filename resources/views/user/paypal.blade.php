@extends('layouts.user')

@section('title', 'PayPal Withdrawal - {{ $settings->site_name }}')

@section('styles')
<style>
    .btn-main {
        background-color: #fddbd3;
        color: #b93b2d;
        border-radius: 20px;
        font-weight: 500;
    }

    .btn-paypal {
        background-color: #003087;
        color: white;
        border-radius: 20px;
        font-weight: 500;
    }

    .btn-paypal:hover {
        background-color: #002b76;
        color: white;
    }

    .transaction-box {
        background-color: #f6f6f6;
        padding: 15px;
        border-radius: 12px;
    }

    .small-text {
        font-size: 13px;
    }

    .clickable {
        cursor: pointer;
    }

    /* PayPal specific styles */
    .paypal-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .paypal-icon {
        color: #003087;
        font-size: 24px;
        margin-right: 10px;
    }

    .balance-display {
        font-size: 24px;
        font-weight: 600;
        color: #2c3e50;
    }

    .warning-note {
        background-color: #FFF3E0;
        border-left: 4px solid #FFA000;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .form-control {
        border-radius: 12px;
        padding: 12px 15px;
    }

    .input-group-text {
        border-radius: 12px 0 0 12px;
    }

    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
    }
</style>
@endsection

@section('content')
<div class="container pt-4">
    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="paypal-header">
        <i class="bi bi-paypal paypal-icon"></i>
        <div>
            <h5 class="mb-0 fw-semibold">PayPal Withdrawal</h5>
        </div>
        <div class="ms-auto text-end">
            <span class="text-muted small d-block">
                <span id="accountNumber">{{ auth()->user()->account_number }}</span>
                <i class="bi bi-copy ms-1 clickable" id="copyIcon" onclick="copyAccountNumber()"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Copy to clipboard"></i>
            </span>
        </div>
    </div>

    <!-- Balance Display -->
    <div class="transaction-box mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted">Available Balance</span>
            <span class="balance-display">${{ number_format(auth()->user()->balance, 2) }}</span>
        </div>
    </div>

    <!-- Withdrawal Form -->
    <div class="transaction-box">
        <div class="warning-note">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            You're about to transfer from your account. This action cannot be reversed.
        </div>

        <form action="{{ route('user.paypal.withdraw') }}" method="POST" id="withdrawalForm">
            @csrf

            <div class="mb-3">
                <label class="form-label">Amount</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                        placeholder="Enter amount" required min="1" max="{{ auth()->user()->balance }}" step="0.01"
                        value="{{ old('amount') }}">
                </div>
                @error('amount')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">PayPal Email</label>
                <input type="email" name="paypal_email" class="form-control @error('paypal_email') is-invalid @enderror"
                    placeholder="Enter PayPal email" required value="{{ old('paypal_email', auth()->user()->email) }}">
                @error('paypal_email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Transaction PIN</label>
                <input type="password" name="transaction_pin"
                    class="form-control @error('transaction_pin') is-invalid @enderror" placeholder="Enter 4-digit PIN"
                    maxlength="4" required>
                @error('transaction_pin')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-paypal w-100" id="submitBtn">
                <i class="bi bi-arrow-up-circle"></i> Withdraw to PayPal
            </button>
        </form>
    </div>

    <!-- OTP Modal -->
    <div class="modal fade" id="otpModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">OTP Verification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="bi bi-shield-lock"></i>
                        Enter the OTP sent to your registered email
                    </div>
                    <input type="number" name="otp" class="form-control mb-3" placeholder="Enter OTP" required>
                    <button type="button" class="btn btn-paypal w-100" id="confirmWithdrawalBtn">
                        Confirm Withdrawal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

    // Form submission handling
    document.getElementById('withdrawalForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
        
        // Submit form via AJAX
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show OTP modal for verification
                var otpModal = new bootstrap.Modal(document.getElementById('otpModal'));
                otpModal.show();
                
                // Set up OTP confirmation
                document.getElementById('confirmWithdrawalBtn').onclick = function() {
                    const otp = document.querySelector('input[name="otp"]').value;
                    if (!otp) {
                        alert('Please enter OTP');
                        return;
                    }
                    
                    // Verify OTP and complete withdrawal
                    verifyOTP(otp, data.transaction_id);
                };
            } else {
                alert(data.message || 'An error occurred');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        })
        .finally(() => {
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-arrow-up-circle"></i> Withdraw to PayPal';
        });
    });

    function verifyOTP(otp, transactionId) {
        const confirmBtn = document.getElementById('confirmWithdrawalBtn');
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Verifying...';
        
        fetch('{{ route("user.paypal.verify-otp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                otp: otp,
                transaction_id: transactionId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Withdrawal successful!');
                window.location.reload();
            } else {
                alert(data.message || 'Invalid OTP');
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = 'Confirm Withdrawal';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = 'Confirm Withdrawal';
        });
    }

    // Enable Bootstrap tooltip
    document.addEventListener("DOMContentLoaded", function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection