<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bank App UI - Crypto Withdrawal</title>
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

        /* Crypto specific styles */
        .crypto-card {
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

        .crypto-option {
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 12px;
            margin-bottom: 10px;
            background-color: white;
        }

        .crypto-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 20px;
        }

        .btc-icon {
            background-color: #f7931a;
            color: white;
        }

        .eth-icon {
            background-color: #627eea;
            color: white;
        }

        .ltc-icon {
            background-color: #345d9d;
            color: white;
        }

        .usdt-icon {
            background-color: #26a17b;
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

        .warning-note {
            background-color: #FFF3E0;
            border-left: 4px solid #FFA000;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>
</head>

<body>

    <div class="container pt-4">
        <!-- Alerts -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> Please check the form for errors.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="mb-0 fw-semibold">Crypto Withdrawal</h5>
            </div>
            <div class="text-end">
                <span class="text-muted small d-block">
                    <span id="accountNumber">{{ $accountNumber }}</span>
                    <i class="bi bi-copy ms-1 clickable" id="copyIcon" onclick="copyAccountNumber()"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Copy to clipboard"></i>
                </span>
            </div>
        </div>

        <!-- Balance Display -->
        <div class="crypto-card">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted">Available Balance</span>
                <span class="balance-display">${{ number_format($balance, 2) }}</span>
            </div>
        </div>

        <!-- Withdrawal Form -->
        <div class="transaction-box">
            <div class="warning-note">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                You're about to transfer from your account. This action cannot be reversed.
            </div>

            <form action="{{ route('user.crypto.withdraw.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="mb-3">
                    <label class="form-label">Amount (USD)</label>
                    <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                        placeholder="Enter amount" required min="0.01" step="0.01" value="{{ old('amount') }}">
                    @error('amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Wallet Type</label>
                    <select class="form-select @error('wallet_type') is-invalid @enderror" name="wallet_type" required>
                        @foreach($cryptoOptions as $key => $option)
                        <option value="{{ $key }}" {{ old('wallet_type')==$key ? 'selected' : '' }}>
                            {{ $key }}
                        </option>
                        @endforeach
                    </select>
                    @error('wallet_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Wallet Address</label>
                    <input type="text" name="wallet_address"
                        class="form-control @error('wallet_address') is-invalid @enderror"
                        placeholder="Enter wallet address" required value="{{ old('wallet_address') }}">
                    @error('wallet_address')
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

                <button type="submit" class="btn btn-main w-100">
                    <i class="bi bi-arrow-up-circle"></i> Withdraw Crypto
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
                        <input type="number" name="otp" class="form-control mb-3" placeholder="Enter OTP">
                        <button type="button" class="btn btn-main w-100">Confirm Withdrawal</button>
                    </div>
                </div>
            </div>
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


    <div class="gtranslate_wrapper"></div>
    <script>
        window.gtranslateSettings = {"default_language":"en","detect_browser_language":true,"wrapper_selector":".gtranslate_wrapper","switcher_horizontal_position":"right","switcher_vertical_position":"top","alt_flags":{"en":"usa","pt":"brazil","es":"colombia","fr":"quebec"}}
    </script>
    <script src="https://cdn.gtranslate.net/widgets/latest/float.js" defer></script>
    </div>
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
            
            // Auto-dismiss alerts after 5 seconds
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
</body>

</html>