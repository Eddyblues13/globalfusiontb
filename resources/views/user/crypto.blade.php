<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Upward Saver - Crypto</title>
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
        .balance-card {
            background-color: #f8f9fa;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .balance-amount {
            font-size: 28px;
            font-weight: 600;
            color: #2c3e50;
        }

        .account-detail {
            font-size: 14px;
            color: #666;
        }

        .account-value {
            font-weight: 500;
            color: #333;
        }

        .crypto-action-card {
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 15px;
            text-align: center;
            transition: transform 0.2s;
        }

        .crypto-action-card:hover {
            transform: translateY(-3px);
        }

        .crypto-action-icon {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .crypto-deposit {
            background-color: #E8F5E9;
            color: #2E7D32;
        }

        .crypto-withdraw {
            background-color: #FFEBEE;
            color: #C62828;
        }

        .quick-action-card {
            background-color: #f6f6f6;
            border-radius: 16px;
            padding: 15px;
            margin-bottom: 15px;
            text-align: center;
        }

        .quick-action-icon {
            width: 50px;
            height: 50px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-size: 20px;
        }

        .transfer-icon {
            color: #1EAAE7;
        }

        .history-icon {
            color: #2BC155;
        }
    </style>
</head>

<body>

    <div class="container pt-4">
        <!-- Alerts -->

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="mb-0 fw-semibold">Crypto Transactions</h5>
            </div>
            <div class="text-end">
                <span class="text-muted small d-block">
                    <span id="accountNumber">-1735572391</span>
                    <i class="bi bi-copy ms-1 clickable" id="copyIcon" onclick="copyAccountNumber()"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Copy to clipboard"></i>
                </span>
            </div>
        </div>

        <!-- Balance Card -->
        <div class="balance-card">
            <div class="d-flex align-items-center mb-3">
                <i class="bi bi-currency-bitcoin me-3" style="font-size: 24px; color: #f7931a;"></i>
                <div>
                    <div class="small-text">Main Balance</div>
                    <div class="balance-amount">$0.00</div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="account-detail">ACC TYPE</div>
                    <div class="account-value">Savings</div>
                </div>
                <div class="col-6">
                    <div class="account-detail">ACCOUNT OWNER</div>
                    <div class="account-value">Mary Zannelle</div>
                </div>
            </div>
        </div>

        <!-- Crypto Actions -->
        <div class="row">
            <div class="col-md-6">
                <a href="{{route('user.crypto.deposit.page')}}" class="text-decoration-none">
                    <div class="crypto-action-card crypto-deposit">
                        <div class="crypto-action-icon">
                            <i class="bi bi-arrow-down-circle"></i>
                        </div>
                        <h5>Crypto Deposit</h5>
                        <p class="small-text">Add crypto to your account</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{route('user.crypto.withdrawal.page')}}" class="text-decoration-none">
                    <div class="crypto-action-card crypto-withdraw">
                        <div class="crypto-action-icon">
                            <i class="bi bi-arrow-up-circle"></i>
                        </div>
                        <h5>Crypto Withdrawal</h5>
                        <p class="small-text">Send crypto to external wallets</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <h6 class="mt-4">Quick Actions</h6>
        <div class="row">
            <div class="col-md-6">
                <a href="{{route('bank.transfer')}}" class="text-decoration-none">
                    <div class="quick-action-card">
                        <div class="quick-action-card transfer-icon">
                            <i class="bi bi-arrow-left-right"></i>
                        </div>
                        <h6>Transfer</h6>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{route('transactions')}}" class="text-decoration-none">
                    <div class="quick-action-card">
                        <div class="quick-action-card history-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <h6>View Transactions</h6>
                    </div>
                </a>
            </div>
        </div>

        <!-- Crypto Deposit Modal -->
        <div class="modal fade" id="cryptoModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Crypto Deposit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Copy the address below to deposit crypto
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="walletAddress"
                                value="1FpSrZ5NNLzGeX7384xWmrdqixt1UGPJxd" readonly>
                            <button class="btn btn-outline-secondary" type="button" id="copyAddress">
                                <i class="bi bi-copy"></i>
                            </button>
                        </div>
                        <a href="https://moonpay.com" class="btn btn-main w-100">
                            Buy Crypto
                        </a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-main" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

  // Copy wallet address
  document.getElementById('copyAddress').addEventListener('click', function() {
    const walletAddress = document.getElementById('walletAddress');
    walletAddress.select();
    document.execCommand('copy');
    
    const tooltip = new bootstrap.Tooltip(this, {
      title: 'Copied!',
      trigger: 'manual'
    });
    tooltip.show();
    
    setTimeout(() => {
      tooltip.hide();
    }, 2000);
  });

  // Enable Bootstrap tooltip
  document.addEventListener("DOMContentLoaded", function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      new bootstrap.Tooltip(tooltipTriggerEl);
    });
  });
    </script>
</body>

</html>