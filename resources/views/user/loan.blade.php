<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bank App UI - Loan Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            background-color: #fff;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;
            padding-bottom: 70px;
        }

        .btn-main {
            background-color: #fddbd3;
            color: #b93b2d;
            border-radius: 20px;
            font-weight: 500;
        }

        .btn-outline-main {
            border: 1px solid #fddbd3;
            color: #b93b2d;
            border-radius: 20px;
            font-weight: 500;
        }

        .transaction-box {
            background-color: #f6f6f6;
            padding: 15px;
            border-radius: 12px;
        }

        .bottom-nav {
            border-top: 1px solid #ddd;
        }

        .bottom-nav .nav-link {
            color: #888;
            font-size: 13px;
        }

        .bottom-nav .nav-link.active {
            color: #f26a63;
        }

        .small-text {
            font-size: 13px;
        }

        .clickable {
            cursor: pointer;
        }

        /* Loan specific styles */
        .loan-card {
            background-color: #f8f9fa;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .balance-display {
            font-size: 24px;
            font-weight: 600;
            color: #2c3e50;
        }

        .loan-option {
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 12px;
            margin-bottom: 10px;
            background-color: white;
        }

        .loan-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 20px;
            background-color: #b93b2d;
            color: white;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
        }

        .form-select {
            border-radius: 12px;
            padding: 12px 15px;
        }

        .info-note {
            background-color: #E3F2FD;
            border-left: 4px solid #1976D2;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .terms-box {
            background-color: #f6f6f6;
            border-radius: 12px;
            padding: 15px;
            margin-top: 20px;
        }

        .loan-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .stat-item {
            text-align: center;
            padding: 10px;
            background-color: white;
            border-radius: 12px;
            flex: 1;
            margin: 0 5px;
        }

        .stat-value {
            font-weight: 600;
            font-size: 18px;
            color: #2c3e50;
        }

        .stat-label {
            font-size: 12px;
            color: #888;
        }
    </style>
</head>

<body>

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

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="mb-0 fw-semibold">Loan Request</h5>
            </div>
            <div class="text-end">
                <span class="text-muted small d-block">
                    <span id="accountNumber">{{ auth()->user()->account_number }}</span>
                    <i class="bi bi-copy ms-1 clickable" id="copyIcon" onclick="copyAccountNumber()"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Copy to clipboard"></i>
                </span>
            </div>
        </div>

        <!-- Loan Stats -->
        <div class="loan-stats">
            <div class="stat-item">
                <div class="stat-value">${{ number_format($eligibleAmount, 2) }}</div>
                <div class="stat-label">Eligible Amount</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">${{ number_format($outstandingLoans, 2) }}</div>
                <div class="stat-label">Outstanding</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">${{ number_format($pendingLoans, 2) }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>

        <!-- Loan Form -->
        <div class="transaction-box">
            <div class="info-note">
                <i class="bi bi-info-circle-fill me-2"></i>
                You're eligible for a loan up to ${{ number_format($eligibleAmount, 2) }} based on your account
                activity.
            </div>

            <form action="{{ route('loan.request') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Loan Amount</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                            placeholder="Enter amount" required min="100" max="{{ $eligibleAmount }}" step="100"
                            value="{{ old('amount') }}">
                    </div>
                    <small class="text-muted">Minimum: $100</small>
                    @error('amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Loan Type</label>
                    <select class="form-select @error('loan_type') is-invalid @enderror" name="loan_type" required>
                        <option value="">Select Loan Type</option>
                        <option value="Personal Loan" {{ old('loan_type')=='Personal Loan' ? 'selected' : '' }}>Personal
                            Loan</option>
                        <option value="Business Loan" {{ old('loan_type')=='Business Loan' ? 'selected' : '' }}>Business
                            Loan</option>
                        <option value="Emergency Loan" {{ old('loan_type')=='Emergency Loan' ? 'selected' : '' }}>
                            Emergency
                            Loan</option>
                        <option value="Education Loan" {{ old('loan_type')=='Education Loan' ? 'selected' : '' }}>
                            Education
                            Loan</option>
                    </select>
                    @error('loan_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Repayment Period</label>
                    <select class="form-select @error('repayment_period') is-invalid @enderror" name="repayment_period"
                        required>
                        <option value="30" {{ old('repayment_period')=='30' ? 'selected' : '' }}>1 Month</option>
                        <option value="90" {{ old('repayment_period')=='90' ? 'selected' : '' }}>3 Months</option>
                        <option value="180" {{ old('repayment_period')=='180' ? 'selected' : (old('repayment_period')
                            ? '' : 'selected' ) }}>6 Months</option>
                        <option value="365" {{ old('repayment_period')=='365' ? 'selected' : '' }}>12 Months</option>
                    </select>
                    @error('repayment_period')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Purpose</label>
                    <textarea name="reason" class="form-control @error('reason') is-invalid @enderror" rows="3"
                        placeholder="Briefly describe the purpose of this loan" required>{{ old('reason') }}</textarea>
                    @error('reason')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Transaction PIN</label>
                    <input type="password" name="transaction_pin"
                        class="form-control @error('transaction_pin') is-invalid @enderror"
                        placeholder="Enter 4-digit PIN" maxlength="4" required>
                    @error('transaction_pin')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="terms-box">
                    <div class="form-check">
                        <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox"
                            id="termsCheck" name="terms" required {{ old('terms') ? 'checked' : '' }}>
                        <label class="form-check-label small" for="termsCheck">
                            I agree to the loan terms and conditions. I understand that late repayments may incur
                            additional
                            fees.
                        </label>
                        @error('terms')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-main w-100 mt-3">
                    <i class="bi bi-cash-stack"></i> Request Loan
                </button>
            </form>
        </div>

        <!-- Loan History -->
        <div class="mt-4">
            <h6 class="fw-semibold mb-3">Recent Loan Transactions</h6>

            @if($loans->count() > 0)
            @foreach($loans as $loan)
            <div class="transaction-box mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">{{ $loan->loan_type }}</h6>
                        <small class="text-muted">{{ $loan->created_at->format('M d, Y') }}</small>
                    </div>
                    <div class="text-end">
                        <h6 class="mb-0">${{ number_format($loan->amount, 2) }}</h6>
                        <span class="badge bg-{{ 
                            $loan->status == Transaction::STATUS_COMPLETED ? 'success' : 
                            ($loan->status == Transaction::STATUS_PENDING ? 'warning' : 
                            ($loan->status == Transaction::STATUS_FAILED ? 'danger' : 'secondary')) 
                        }}">
                            {{ ucfirst($loan->status) }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="text-center py-4">
                <i class="bi bi-cash-stack fs-1 text-muted"></i>
                <p class="text-muted">No loan transactions yet</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Bottom Navigation -->
    <nav class="navbar fixed-bottom bg-white bottom-nav">
        <div class="container d-flex justify-content-around text-center">
            <a class="nav-link active" href="{{ route('dashboard') }}">
                <i class="bi bi-house-door-fill"></i><br><small>Home</small>
            </a>

            @if($settings->modules && in_array('card', json_decode($settings->modules, true)))
            <a class="nav-link" href="{{ route('card') }}">
                <i class="bi bi-credit-card-2-front"></i><br><small>Card</small>
            </a>
            @endif

            <a class="nav-link" href="{{ route('bank.transfer') }}">
                <i class="bi bi-arrow-left-right"></i><br><small>Transfers</small>
            </a>

            <a class="nav-link" href="{{ route('transactions') }}">
                <i class="bi bi-clock-history"></i><br><small>History</small>
            </a>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="nav-link btn btn-link p-0 m-0"
                    style="color: inherit; text-decoration: none;">
                    <i class="bi bi-box-arrow-right"></i><br><small>Logout</small>
                </button>
            </form>
        </div>
    </nav>

    <!-- Scripts -->
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

  // Enable Bootstrap tooltip
  document.addEventListener("DOMContentLoaded", function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Set max amount to eligible loan amount
    const amountInput = document.querySelector('input[name="amount"]');
    if(amountInput) {
      amountInput.max = {{ $eligibleAmount }};
    }
  });
    </script>
</body>

</html>