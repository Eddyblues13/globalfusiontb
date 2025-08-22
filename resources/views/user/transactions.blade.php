<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Upward Saver - Transactions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        .transaction-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6c757d;
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #dee2e6;
        }

        .transaction-item {
            border-left: 4px solid;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.25rem;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .transaction-type-bank_transfer {
            border-left-color: #0d6efd;
        }

        .transaction-type-paypal_withdrawal {
            border-left-color: #6f42c1;
        }

        .transaction-type-crypto_deposit {
            border-left-color: #198754;
        }

        .transaction-type-crypto_withdrawal {
            border-left-color: #fd7e14;
        }

        .transaction-type-check_deposit {
            border-left-color: #d63384;
        }

        .transaction-type-loan_request {
            border-left-color: #ffc107;
        }

        .transaction-status-pending {
            color: #fd7e14;
        }

        .transaction-status-processing {
            color: #0dcaf0;
        }

        .transaction-status-completed {
            color: #198754;
        }

        .transaction-status-failed {
            color: #dc3545;
        }

        .transaction-status-cancelled {
            color: #6c757d;
        }

        .bottom-nav {
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
        }

        .nav-link {
            color: #6c757d;
        }

        .nav-link.active {
            color: #0d6efd;
        }

        .clickable {
            cursor: pointer;
        }

        .transaction-amount {
            font-weight: 600;
        }

        .transaction-date {
            font-size: 0.875rem;
            color: #6c757d;
        }
    </style>
</head>

<body>

    <div class="container pt-4 pb-5">
        <div class="transaction-header">
            <div>
                <h5 class="mb-0 fw-semibold">Transaction History</h5>
            </div>
            <div class="text-end">
                <span class="text-muted small d-block">
                    <span id="accountNumber">-1735572391</span>
                    <i class="bi bi-copy ms-1 clickable" id="copyIcon" onclick="copyAccountNumber()"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Copy to clipboard"></i>
                </span>
            </div>
        </div>

        <?php
  // In a real Laravel application, this would be in a controller
  use App\Models\Transaction;
  
  // Simulate fetching transactions for the authenticated user
  $userId = auth()->id(); // This would come from Laravel's auth system
  $transactions = Transaction::where('user_id', $userId)
      ->orderBy('created_at', 'desc')
      ->get();
  ?>

        <?php if($transactions->count() > 0): ?>
        <div class="transaction-list">
            <?php foreach($transactions as $transaction): ?>
            <div class="transaction-item transaction-type-<?php echo e($transaction->type); ?>">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="mb-1">
                            <?php echo e($transaction->getTypeLabelAttribute()); ?>
                        </h6>
                        <p class="mb-1 small">Ref:
                            <?php echo e($transaction->reference_id); ?>
                        </p>
                        <?php if($transaction->description): ?>
                        <p class="mb-1 small">
                            <?php echo e($transaction->description); ?>
                        </p>
                        <?php endif; ?>
                        <span class="transaction-date">
                            <?php echo e($transaction->created_at->format('M d, Y h:i A')); ?>

                        </span>
                    </div>
                    <div class="text-end">
                        <div class="transaction-amount">
                            $
                            <?php echo e(number_format($transaction->amount, 2)); ?>
                        </div>
                        <div class="transaction-status-<?php echo e($transaction->status); ?> small">
                            <?php echo e(ucfirst($transaction->status)); ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="bi bi-clock-history"></i>
            </div>
            <h5>No transactions yet</h5>
            <p class="text-muted">Your transaction history will appear here</p>
        </div>
        <?php endif; ?>
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
        window.gtranslateSettings = {
  "default_language":"en",
  "detect_browser_language":true,
  "wrapper_selector":".gtranslate_wrapper",
  "switcher_horizontal_position":"right",
  "switcher_vertical_position":"top",
  "alt_flags":{"en":"usa","pt":"brazil","es":"colombia","fr":"quebec"}
};
    </script>
    <script src="https://cdn.gtranslate.net/widgets/latest/float.js" defer></script>

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
  });
    </script>
</body>

</html>