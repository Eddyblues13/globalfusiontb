<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bank App UI - FX Trading</title>
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

        /* FX Specific Styles */

        .fx-header {
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

        .asset-card {
            background-color: #f6f6f6;
            border-radius: 16px;
            padding: 15px;
            margin-bottom: 15px;
            transition: transform 0.2s;
        }

        .asset-card:hover {
            transform: translateY(-3px);
        }

        .asset-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 18px;
        }

        .stock-icon {
            background-color: #e3f2fd;
            color: #1565c0;
        }

        .crypto-icon {
            background-color: #fbe9e7;
            color: #b93b2d;
        }

        .asset-name {
            font-weight: 600;
            margin-bottom: 2px;
        }

        .asset-symbol {
            color: #666;
            font-size: 13px;
        }

        .asset-price {
            font-weight: 600;
        }

        .price-change-up {
            color: #2E7D32;
        }

        .price-change-down {
            color: #C62828;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #666;
            font-weight: 500;
            padding: 10px 15px;
        }

        .nav-tabs .nav-link.active {
            color: #b93b2d;
            border-bottom: 2px solid #b93b2d;
        }

        .search-box {
            position: relative;
            margin-bottom: 20px;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 12px;
            color: #888;
        }

        .search-box input {
            padding-left: 40px;
            border-radius: 20px;
        }

        .order-form {
            background-color: #f6f6f6;
            border-radius: 16px;
            padding: 20px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
        }
    </style>
</head>

<body>

    <div class="container pt-4">
        <!-- Header -->
        <div class="fx-header">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 fw-semibold">FX Trading</h5>
                <span class="text-muted small">
                    <span id="accountNumber">668060724</span>
                    <i class="bi bi-copy ms-1 clickable" id="copyIcon" onclick="copyAccountNumber()"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Copy to clipboard"></i>
                </span>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small-text">Available Balance</div>
                    <div class="balance-display"> {{ $settings->s_currency ?? 'Kz' }}{{ number_format($user->balance, 2)
                        }}</div>
                </div>
                <a href="{{ route('deposit.index') }}" class="btn btn-outline-main">Add Funds</a>

            </div>
        </div>

        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs mb-4" id="fxTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="stocks-tab" data-bs-toggle="tab" data-bs-target="#stocks"
                    type="button" role="tab">Stocks</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="crypto-tab" data-bs-toggle="tab" data-bs-target="#crypto" type="button"
                    role="tab">Crypto</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="forex-tab" data-bs-toggle="tab" data-bs-target="#forex" type="button"
                    role="tab">Forex</button>
            </li>
        </ul>

        <!-- Search Box -->
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" class="form-control" placeholder="Search assets...">
        </div>



        <!-- Tab Content -->
        <div class="tab-content" id="fxTabContent">
            <!-- Stocks Tab -->
            <div class="tab-pane fade show active" id="stocks" role="tabpanel">
                <h6 class="fw-semibold mb-3">Popular Stocks</h6>

                <div class="asset-card clickable" data-bs-toggle="modal" data-bs-target="#tradeModal" data-asset="AAPL">
                    <div class="d-flex align-items-center">
                        <div class="asset-icon stock-icon">
                            <i class="bi bi-bar-chart-line"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="asset-name">Apple Inc.</div>
                            <div class="asset-symbol">AAPL</div>
                        </div>
                        <div class="text-end">
                            <div class="asset-price">$189.98</div>
                            <div class="price-change-up">+2.34%</div>
                        </div>
                    </div>
                </div>

                <div class="asset-card clickable" data-bs-toggle="modal" data-bs-target="#tradeModal" data-asset="TSLA">
                    <div class="d-flex align-items-center">
                        <div class="asset-icon stock-icon">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="asset-name">Tesla Inc.</div>
                            <div class="asset-symbol">TSLA</div>
                        </div>
                        <div class="text-end">
                            <div class="asset-price">$248.42</div>
                            <div class="price-change-down">-1.25%</div>
                        </div>
                    </div>
                </div>

                <div class="asset-card clickable" data-bs-toggle="modal" data-bs-target="#tradeModal" data-asset="AMZN">
                    <div class="d-flex align-items-center">
                        <div class="asset-icon stock-icon">
                            <i class="bi bi-cart"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="asset-name">Amazon.com</div>
                            <div class="asset-symbol">AMZN</div>
                        </div>
                        <div class="text-end">
                            <div class="asset-price">$178.75</div>
                            <div class="price-change-up">+0.87%</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Crypto Tab -->
            <div class="tab-pane fade" id="crypto" role="tabpanel">
                <h6 class="fw-semibold mb-3">Popular Cryptos</h6>

                <div class="asset-card clickable" data-bs-toggle="modal" data-bs-target="#tradeModal" data-asset="BTC">
                    <div class="d-flex align-items-center">
                        <div class="asset-icon crypto-icon">
                            <i class="bi bi-currency-bitcoin"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="asset-name">Bitcoin</div>
                            <div class="asset-symbol">BTC</div>
                        </div>
                        <div class="text-end">
                            <div class="asset-price">$67,245.32</div>
                            <div class="price-change-up">+3.42%</div>
                        </div>
                    </div>
                </div>

                <div class="asset-card clickable" data-bs-toggle="modal" data-bs-target="#tradeModal" data-asset="ETH">
                    <div class="d-flex align-items-center">
                        <div class="asset-icon crypto-icon">
                            <i class="bi bi-currency-ethereum"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="asset-name">Ethereum</div>
                            <div class="asset-symbol">ETH</div>
                        </div>
                        <div class="text-end">
                            <div class="asset-price">$3,512.76</div>
                            <div class="price-change-up">+1.87%</div>
                        </div>
                    </div>
                </div>

                <div class="asset-card clickable" data-bs-toggle="modal" data-bs-target="#tradeModal" data-asset="SOL">
                    <div class="d-flex align-items-center">
                        <div class="asset-icon crypto-icon">
                            <i class="bi bi-currency-exchange"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="asset-name">Solana</div>
                            <div class="asset-symbol">SOL</div>
                        </div>
                        <div class="text-end">
                            <div class="asset-price">$187.34</div>
                            <div class="price-change-down">-0.65%</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Forex Tab -->
            <div class="tab-pane fade" id="forex" role="tabpanel">
                <h6 class="fw-semibold mb-3">Major Currency Pairs</h6>

                <div class="asset-card clickable" data-bs-toggle="modal" data-bs-target="#tradeModal"
                    data-asset="EUR/USD">
                    <div class="d-flex align-items-center">
                        <div class="asset-icon stock-icon">
                            <i class="bi bi-globe"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="asset-name">Euro / US Dollar</div>
                            <div class="asset-symbol">EUR/USD</div>
                        </div>
                        <div class="text-end">
                            <div class="asset-price">1.0854</div>
                            <div class="price-change-up">+0.12%</div>
                        </div>
                    </div>
                </div>

                <div class="asset-card clickable" data-bs-toggle="modal" data-bs-target="#tradeModal"
                    data-asset="GBP/USD">
                    <div class="d-flex align-items-center">
                        <div class="asset-icon stock-icon">
                            <i class="bi bi-globe"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="asset-name">British Pound / US Dollar</div>
                            <div class="asset-symbol">GBP/USD</div>
                        </div>
                        <div class="text-end">
                            <div class="asset-price">1.2678</div>
                            <div class="price-change-down">-0.08%</div>
                        </div>
                    </div>
                </div>

                <div class="asset-card clickable" data-bs-toggle="modal" data-bs-target="#tradeModal"
                    data-asset="USD/JPY">
                    <div class="d-flex align-items-center">
                        <div class="asset-icon stock-icon">
                            <i class="bi bi-globe"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="asset-name">US Dollar / Japanese Yen</div>
                            <div class="asset-symbol">USD/JPY</div>
                        </div>
                        <div class="text-end">
                            <div class="asset-price">156.32</div>
                            <div class="price-change-up">+0.24%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trade Modal -->
    <!-- Trade Modal -->
    <div class="modal fade" id="tradeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="POST" action="{{ route('trades.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tradeModalTitle">Trade Asset</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="order-form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="asset_symbol" id="assetSymbolInput">
                            <input type="hidden" name="asset_name" id="assetNameInput">
                            <input type="hidden" name="asset_type" id="assetTypeInput">
                            <input type="hidden" name="type" id="tradeTypeInput" value="buy">

                            <div class="d-flex justify-content-between mb-3">
                                <button type="button" class="btn btn-outline-primary active" id="buyBtn">Buy</button>
                                <button type="button" class="btn btn-outline-primary" id="sellBtn">Sell</button>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Amount (USD)</label>
                                <input type="number" name="amount" class="form-control" id="tradeAmount"
                                    placeholder="0.00" step="0.01" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="quantity" class="form-control" id="tradeQuantity"
                                    placeholder="0" step="0.0001" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Order Type</label>
                                <select class="form-select" name="order_type" id="orderType" required>
                                    <option value="market">Market Order</option>
                                    <option value="limit">Limit Order</option>
                                    <option value="stop">Stop Order</option>
                                </select>
                            </div>

                            <div class="mb-3" id="limitPriceContainer" style="display: none;">
                                <label class="form-label">Limit Price</label>
                                <input type="number" name="limit_price" class="form-control" id="limitPrice"
                                    placeholder="0.00" step="0.01">
                            </div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-primary" type="submit">Place Order</button>
                    </div>
                </form>
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
        window.gtranslateSettings = {
            "default_language": "en",
            "detect_browser_language": true,
            "wrapper_selector": ".gtranslate_wrapper",
            "switcher_horizontal_position": "right",
            "switcher_vertical_position": "top",
            "alt_flags": {
                "en": "usa",
                "pt": "brazil",
                "es": "colombia",
                "fr": "quebec"
            }
        }
    </script>
    <script src="https://cdn.gtranslate.net/widgets/latest/float.js" defer></script>
    </div>
    <!-- Scripts -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set Buy/Sell type
            const buyBtn = document.getElementById('buyBtn');
            const sellBtn = document.getElementById('sellBtn');
            const typeInput = document.getElementById('tradeTypeInput');

            buyBtn.addEventListener('click', () => {
                buyBtn.classList.add('active');
                sellBtn.classList.remove('active');
                typeInput.value = 'buy';
            });

            sellBtn.addEventListener('click', () => {
                sellBtn.classList.add('active');
                buyBtn.classList.remove('active');
                typeInput.value = 'sell';
            });

            // Show/hide limit price field
            const orderType = document.getElementById('orderType');
            const limitContainer = document.getElementById('limitPriceContainer');

            orderType.addEventListener('change', function() {
                if (this.value === 'limit') {
                    limitContainer.style.display = 'block';
                } else {
                    limitContainer.style.display = 'none';
                }
            });

            // Set asset symbol/name from card click
            const assetCards = document.querySelectorAll('.asset-card');
            assetCards.forEach(card => {
                card.addEventListener('click', function() {
                    document.getElementById('assetSymbolInput').value = card.getAttribute('data-asset');
                    document.getElementById('assetNameInput').value = card.querySelector('.asset-name').innerText;
                });
            });
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let selectedAsset = null;

            // Detect which asset was clicked
            document.querySelectorAll('.asset-card').forEach(card => {
                card.addEventListener('click', () => {
                    selectedAsset = {
                        symbol: card.getAttribute('data-asset'),
                        name: card.querySelector('.asset-name').innerText,
                    };
                });
            });

            // Toggle order type
            const orderTypeEl = document.getElementById('orderType');
            const limitContainer = document.getElementById('limitPriceContainer');

            orderTypeEl.addEventListener('change', () => {
                if (orderTypeEl.value === 'limit') {
                    limitContainer.style.display = 'block';
                } else {
                    limitContainer.style.display = 'none';
                }
            });

            // Buy/Sell toggle
            let tradeType = 'buy';
            document.getElementById('buyBtn').addEventListener('click', () => {
                tradeType = 'buy';
                document.getElementById('buyBtn').classList.add('active');
                document.getElementById('sellBtn').classList.remove('active');
            });

            document.getElementById('sellBtn').addEventListener('click', () => {
                tradeType = 'sell';
                document.getElementById('sellBtn').classList.add('active');
                document.getElementById('buyBtn').classList.remove('active');
            });

            // Submit trade
            document.getElementById('placeOrderBtn').addEventListener('click', () => {
                const amount = document.getElementById('tradeAmount').value;
                const quantity = document.getElementById('tradeQuantity').value;
                const orderType = document.getElementById('orderType').value;
                const limitPrice = document.getElementById('limitPrice').value;

                fetch('/api/trade', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            asset_symbol: selectedAsset ? .symbol,
                            asset_name: selectedAsset ? .name,
                            type: tradeType,
                            order_type: orderType,
                            amount_usd: amount,
                            quantity: quantity,
                            limit_price: orderType === 'limit' ? limitPrice : null,
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert('Trade placed!');
                            document.getElementById('tradeModal').classList.remove('show');
                        } else {
                            alert('Error placing trade.');
                        }
                    });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Copy account number with better UX
        function copyAccountNumber() {
            const accNum = document.getElementById("accountNumber").innerText;
            const icon = document.getElementById("copyIcon");

            navigator.clipboard.writeText(accNum).then(() => {
                const tooltip = bootstrap.Tooltip.getInstance(icon);
                tooltip.setContent({
                    '.tooltip-inner': 'Copied!'
                });
                icon.classList.replace("bi-copy", "bi-check2");

                setTimeout(() => {
                    tooltip.setContent({
                        '.tooltip-inner': 'Copy to clipboard'
                    });
                    icon.classList.replace("bi-check2", "bi-copy");
                }, 2000);
            });
        }

        // Trade modal functionality
        document.addEventListener("DOMContentLoaded", function() {
            const tradeModal = document.getElementById('tradeModal');
            if (tradeModal) {
                tradeModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const asset = button.getAttribute('data-asset');
                    const modalTitle = tradeModal.querySelector('.modal-title');
                    modalTitle.textContent = `Trade ${asset}`;
                });
            }

            // Toggle buy/sell buttons
            const buyBtn = document.getElementById('buyBtn');
            const sellBtn = document.getElementById('sellBtn');

            buyBtn.addEventListener('click', function() {
                buyBtn.classList.add('active');
                sellBtn.classList.remove('active');
            });

            sellBtn.addEventListener('click', function() {
                sellBtn.classList.add('active');
                buyBtn.classList.remove('active');
            });

            // Show/hide limit price based on order type
            const orderType = document.getElementById('orderType');
            const limitPriceContainer = document.getElementById('limitPriceContainer');

            orderType.addEventListener('change', function() {
                if (this.value === 'limit') {
                    limitPriceContainer.style.display = 'block';
                } else {
                    limitPriceContainer.style.display = 'none';
                }
            });

            // Enable Bootstrap tooltip
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    <!-- Your Existing HTML Above -->
    <!-- Add this just before </body> -->

    <script>
        // === STOCKS: Using Financial Modeling Prep (public demo key) ===
        const stockSymbols = ['AAPL', 'TSLA', 'AMZN'];
        fetch(`https://financialmodelingprep.com/api/v3/quote/${stockSymbols.join(',')}?apikey=demo`)
            .then(res => res.json())
            .then(data => {
                data.forEach(stock => {
                    const card = document.querySelector(`[data-asset="${stock.symbol}"]`);
                    if (card) {
                        const priceEl = card.querySelector('.asset-price');
                        const changeEl = card.querySelector('.price-change-up, .price-change-down');

                        const price = parseFloat(stock.price).toFixed(2);
                        const change = parseFloat(stock.changesPercentage).toFixed(2);

                        priceEl.textContent = `$${price}`;
                        changeEl.textContent = `${change}%`;

                        changeEl.className = change >= 0 ? 'price-change-up' : 'price-change-down';
                    }
                });
            });

        // === CRYPTO: Using CoinGecko API ===
        const cryptoMap = {
            'BTC': 'bitcoin',
            'ETH': 'ethereum',
            'SOL': 'solana'
        };

        fetch(`https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,solana&vs_currencies=usd&include_24hr_change=true`)
            .then(res => res.json())
            .then(data => {
                for (const [symbol, id] of Object.entries(cryptoMap)) {
                    const card = document.querySelector(`[data-asset="${symbol}"]`);
                    if (card && data[id]) {
                        const price = data[id].usd.toFixed(2);
                        const change = data[id].usd_24h_change.toFixed(2);
                        const priceEl = card.querySelector('.asset-price');
                        const changeEl = card.querySelector('.price-change-up, .price-change-down');

                        priceEl.textContent = `$${price}`;
                        changeEl.textContent = `${change}%`;

                        changeEl.className = change >= 0 ? 'price-change-up' : 'price-change-down';
                    }
                }
            });

        // === FOREX: Using Frankfurter API (no key needed) ===
        const forexPairs = {
            'EUR/USD': ['EUR', 'USD'],
            'GBP/USD': ['GBP', 'USD'],
            'USD/JPY': ['USD', 'JPY']
        };

        Object.entries(forexPairs).forEach(([symbol, [from, to]]) => {
            fetch(`https://api.frankfurter.app/latest?from=${from}&to=${to}`)
                .then(res => res.json())
                .then(data => {
                    const rate = data.rates[to];
                    const card = document.querySelector(`[data-asset="${symbol}"]`);
                    if (card) {
                        const priceEl = card.querySelector('.asset-price');
                        const changeEl = card.querySelector('.price-change-up, .price-change-down');
                        priceEl.textContent = `${rate.toFixed(4)}`;

                        // Frankfurter doesn't provide % change, so clear or hide it
                        if (changeEl) changeEl.textContent = '';
                    }
                });
        });
    </script>
    <script>
        function updatePrices() {
            // Paste all fetch code here (the full script above)
        }
        updatePrices();
        setInterval(updatePrices, 60000); // every 60s
    </script>

</body>

</html>