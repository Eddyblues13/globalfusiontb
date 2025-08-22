<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fund Account | Bank App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        :root {
            --primary-color: #b93b2d;
            --primary-bg: #fddbd3;
            --secondary-text: #888;
            --card-bg: #f6f6f6;
            --active-nav: #f26a63;
            --success-color: #2BC155;
            --error-color: #FF2E2E;
            --warning-color: #FFA500;
            --info-color: #1EAAE7;
        }

        body {
            background-color: #fff;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;
            padding-bottom: 70px;
        }

        .btn-main {
            background-color: var(--primary-bg);
            color: var(--primary-color);
            border-radius: 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-main:hover {
            background-color: #fcc9bc;
            color: var(--primary-color);
        }

        .btn-outline-primary {
            border-color: var(--info-color);
            color: var(--info-color);
            border-radius: 20px;
            font-weight: 500;
        }

        .btn-outline-primary:hover {
            background-color: var(--info-color);
            color: white;
        }

        .btn-primary {
            background-color: var(--info-color);
            border-color: var(--info-color);
            border-radius: 20px;
            font-weight: 500;
        }

        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
            border-radius: 20px;
            font-weight: 500;
        }

        .bg-primary {
            background-color: var(--info-color) !important;
        }

        .bg-success {
            background-color: var(--success-color) !important;
        }

        .shortcut-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 4px;
        }

        .transaction-box {
            background-color: var(--card-bg);
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
            font-size: 0.8125rem;
        }

        .clickable {
            cursor: pointer;
        }

        /* Card styling */
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .card-header {
            border-radius: 15px 15px 0 0 !important;
            background-color: var(--card-bg);
        }

        /* Account card styling */
        .account-card {
            background-color: white;
            border-radius: 15px;
            padding: 1.5rem;
        }

        .account-icon {
            width: 68px;
            height: 68px;
            margin-right: 1rem;
        }

        .account-details {
            flex: 1;
        }

        .account-number {
            font-size: 1.25rem;
            font-weight: 500;
        }

        .account-balance {
            font-size: 1.75rem;
            font-weight: 600;
            margin: 0.5rem 0;
        }

        /* Quick action cards */
        .quick-action-card {
            border-radius: 15px;
            padding: 1rem;
            color: white;
            transition: transform 0.3s ease;
        }

        .quick-action-card:hover {
            transform: translateY(-5px);
        }

        .quick-action-icon {
            background-color: white;
            border-radius: 50%;
            padding: 1rem;
            margin-right: 1rem;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Form styling */
        .form-control,
        .form-select {
            padding: 0.75rem 1rem;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--info-color);
            box-shadow: 0 0 0 0.25rem rgba(30, 170, 231, 0.2);
        }

        .custom-file-label::after {
            content: "Browse";
            background-color: var(--card-bg);
            border-left: 1px solid #ddd;
        }

        /* Alert styling */
        .alert {
            border-radius: 10px;
            padding: 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .account-icon {
                width: 50px;
                height: 50px;
            }

            .account-balance {
                font-size: 1.5rem;
            }

            .account-number {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 768px) {
            .account-card {
                flex-direction: column;
                text-align: center;
            }

            .account-icon {
                margin: 0 auto 1rem;
            }

            .account-meta {
                justify-content: center;
                margin-top: 1rem;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            .account-balance {
                font-size: 1.25rem;
            }

            .btn-lg {
                padding: 0.5rem 1rem;
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>

    <div class="content-body">

        <div class="container pt-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-black fw-semibold mb-0">Fund Account</h2>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center account-card">
                                <div class="account-icon">
                                    <svg width="68" height="68" viewBox="0 0 68 68" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M59.4999 31.688V19.8333C59.4999 19.0818 59.2014 18.3612 58.6701 17.8298C58.1387 17.2985 57.418 17 56.6666 17H11.3333C10.5818 17 9.86114 16.7014 9.32978 16.1701C8.79843 15.6387 8.49992 14.9181 8.49992 14.1666C8.49992 13.4152 8.79843 12.6945 9.32978 12.1632C9.86114 11.6318 10.5818 11.3333 11.3333 11.3333H56.6666C57.418 11.3333 58.1387 11.0348 58.6701 10.5034C59.2014 9.97208 59.4999 9.25141 59.4999 8.49996C59.4999 7.74851 59.2014 7.02784 58.6701 6.49649C58.1387 5.96514 57.418 5.66663 56.6666 5.66663H11.3333C9.07891 5.66663 6.9169 6.56216 5.32284 8.15622C3.72878 9.75028 2.83325 11.9123 2.83325 14.1666V53.8333C2.83325 56.0876 3.72878 58.2496 5.32284 59.8437C6.9169 61.4378 9.07891 62.3333 11.3333 62.3333H56.6666C57.418 62.3333 58.1387 62.0348 58.6701 61.5034C59.2014 60.9721 59.4999 60.2514 59.4999 59.5V47.6453C61.1561 47.0683 62.5917 45.9902 63.6076 44.5605C64.6235 43.1308 65.1693 41.4205 65.1693 39.6666C65.1693 37.9128 64.6235 36.2024 63.6076 34.7727C62.5917 33.3431 61.1561 32.265 59.4999 31.688ZM53.8333 56.6666H11.3333C10.5818 56.6666 9.86114 56.3681 9.32978 55.8368C8.79843 55.3054 8.49992 54.5847 8.49992 53.8333V22.1453C9.40731 22.4809 10.3658 22.6572 11.3333 22.6666H53.8333V31.1666H45.3333C43.0789 31.1666 40.9169 32.0622 39.3228 33.6562C37.7288 35.2503 36.8333 37.4123 36.8333 39.6666C36.8333 41.921 37.7288 44.083 39.3228 45.677C40.9169 47.2711 43.0789 48.1666 45.3333 48.1666H53.8333V56.6666ZM56.6666 42.5H45.3333C44.5818 42.5 43.8611 42.2015 43.3298 41.6701C42.7984 41.1387 42.4999 40.4181 42.4999 39.6666C42.4999 38.9152 42.7984 38.1945 43.3298 37.6632C43.8611 37.1318 44.5818 36.8333 45.3333 36.8333H56.6666C57.418 36.8333 58.1387 37.1318 58.6701 37.6632C59.2014 38.1945 59.4999 38.9152 59.4999 39.6666C59.4999 40.4181 59.2014 41.1387 58.6701 41.6701C58.1387 42.2015 57.418 42.5 56.6666 42.5Z"
                                            fill="#1EAAE7"></path>
                                    </svg>
                                </div>

                                <div class="account-details">
                                    <h5 class="text-black fw-semibold mb-1">Main Balance</h5>
                                    <div class="account-balance text-black"> {{ $user->currency ?? 'Kz' }}{{
                                        number_format($user->account_bal, 2) }}
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap account-meta">
                                    <div class="me-3 mb-2">
                                        <p class="small-text mb-1">ACC TYPE</p>
                                        <span class="text-black">{{ $user->accounttype }}</span>
                                    </div>
                                    <div class="me-3 mb-2">
                                        <p class="small-text mb-1">ACCOUNT OWNER</p>
                                        <span class="text-black">{{ $user->name }}</span>
                                    </div>
                                    <div class="me-3 mb-2">
                                        <p class="small-text mb-1">ACCOUNT NUMBER</p>
                                        <span class="account-number text-black">{{ $user->usernumber }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 mb-3">
                                    <button class="btn btn-outline-primary rounded btn-lg w-100 py-2"
                                        data-bs-toggle="modal" data-bs-target="#fiat">
                                        <i class="bi bi-cash-coin me-2"></i> Mobile Check Deposit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="quick-action-card bg-primary mb-3">
                        <a href="{{ route('bank.transfer') }}" class="text-decoration-none text-white">
                            <div class="d-flex align-items-center">
                                <div class="quick-action-icon">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g opacity="0.98" clip-path="">
                                            <path
                                                d="M9.77812 2.0125C10.1062 2.69062 9.81641 3.51094 9.13828 3.83906C7.25156 4.74688 5.65469 6.15781 4.51719 7.92422C3.35234 9.73437 2.73438 11.8344 2.73438 14C2.73438 20.2125 7.7875 25.2656 14 25.2656C20.2125 25.2656 25.2656 20.2125 25.2656 14C25.2656 11.8344 24.6477 9.73437 23.4883 7.91875C22.3563 6.15234 20.7539 4.74141 18.8672 3.83359C18.1891 3.50547 17.8992 2.69063 18.2273 2.00703C18.5555 1.32891 19.3703 1.03906 20.0539 1.36719C22.4 2.49375 24.3852 4.24375 25.7906 6.44219C27.2344 8.69531 28 11.3094 28 14C28 17.7406 26.5453 21.257 23.8984 23.8984C21.257 26.5453 17.7406 28 14 28C10.2594 28 6.74297 26.5453 4.10156 23.8984C1.45469 21.2516 1.22342e-07 17.7406 1.66948e-07 14C1.99034e-07 11.3094 0.765625 8.69531 2.21484 6.44219C3.62578 4.24922 5.61094 2.49375 7.95156 1.36719C8.63516 1.04453 9.45 1.3289 9.77812 2.0125Z"
                                                fill="#1EAAE7"></path>
                                            <path
                                                d="M8.67896 13.2726C8.41099 13.0047 8.27974 12.6547 8.27974 12.3047C8.27974 11.9547 8.41099 11.6047 8.67896 11.3367L12.1188 7.89685C12.6219 7.39373 13.2891 7.12029 13.9946 7.12029C14.7 7.12029 15.3727 7.3992 15.8704 7.89685L19.3102 11.3367C19.8461 11.8726 19.8461 12.7367 19.3102 13.2726C18.7743 13.8086 17.9102 13.8086 17.3743 13.2726L15.3563 11.2547L15.3563 19.0258C15.3563 19.7804 14.7438 20.3929 13.9891 20.3929C13.2344 20.3929 12.6219 19.7804 12.6219 19.0258L12.6219 11.2492L10.604 13.2672C10.079 13.8031 9.21489 13.8031 8.67896 13.2726Z"
                                                fill="#1EAAE7"></path>
                                        </g>
                                        <defs>
                                            <clipPath id="clip11">
                                                <rect width="28" height="28" fill="white"
                                                    transform="matrix(1.19249e-08 -1 -1 -1.19249e-08 28 28)"></rect>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                <span class="fs-5 fw-semibold">Transfer</span>
                            </div>
                        </a>
                    </div>

                    <div class="quick-action-card bg-success">
                        <a href="{{ route('transactions') }}" class="text-decoration-none text-white">
                            <div class="d-flex align-items-center">
                                <div class="quick-action-icon">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M22.1667 1.16669H5.83342C4.59574 1.16669 3.40875 1.65835 2.53358 2.53352C1.65841 3.40869 1.16675 4.59568 1.16675 5.83335V14C1.16675 14.3094 1.28966 14.6062 1.50846 14.825C1.72725 15.0438 2.024 15.1667 2.33341 15.1667H8.16675V25.6667C8.1662 25.8898 8.22965 26.1085 8.34959 26.2966C8.46952 26.4848 8.6409 26.6346 8.84342 26.7284C9.0464 26.8218 9.27195 26.855 9.49325 26.824C9.71455 26.7929 9.92228 26.699 10.0917 26.5534L13.4167 23.7067L16.7417 26.5534C16.9531 26.7341 17.222 26.8334 17.5001 26.8334C17.7782 26.8334 18.0471 26.7341 18.2584 26.5534L21.5834 23.7067L24.9084 26.5534C25.1197 26.7341 25.3887 26.8334 25.6667 26.8334C25.8355 26.8322 26.0023 26.7964 26.1567 26.7284C26.3593 26.6346 26.5306 26.4848 26.6506 26.2966C26.7705 26.1085 26.834 25.8898 26.8334 25.6667V5.83335C26.8334 4.59568 26.3418 3.40869 25.4666 2.53352C24.5914 1.65835 23.4044 1.16669 22.1667 1.16669ZM3.50008 12.8334V5.83335C3.50008 5.21452 3.74591 4.62102 4.18350 4.18344C4.62108 3.74585 5.21458 3.50002 5.83342 3.50002C6.45225 3.50002 7.04575 3.74585 7.48333 4.18344C7.92092 4.62102 8.16675 5.21452 8.16675 5.83335V12.8334H3.50008ZM24.5001 23.135L22.3417 21.28C22.1304 21.0993 21.8615 20.9999 21.5834 20.9999C21.3053 20.9999 21.0364 21.0993 20.8251 21.28L17.5001 24.1267L14.1751 21.28C13.9638 21.0993 13.6948 20.9999 13.4167 20.9999C13.1387 20.9999 12.8697 21.0993 12.6584 21.28L10.5001 23.135V5.83335C10.4986 5.01375 10.2813 4.20898 9.87008 3.50002H22.1667C22.7856 3.50002 23.3791 3.74585 23.8167 4.18344C24.2542 4.62102 24.5001 5.21452 24.5001 5.83335V23.135ZM22.1667 7.00002C22.1667 7.30944 22.0438 7.60619 21.825 7.82498C21.6062 8.04377 21.3095 8.16669 21.0001 8.16669H14.0001C13.6907 8.16669 13.3939 8.04377 13.1751 7.82498C12.9563 7.60619 12.8334 7.30944 12.8334 7.00002C12.8334 6.6906 12.9563 6.39386 13.1751 6.17506C13.3939 5.95627 13.6907 5.83335 14.0001 5.83335H21.0001C21.3095 5.83335 21.6062 5.95627 21.825 6.17506C22.0438 6.39386 22.1667 6.6906 22.1667 7.00002ZM22.1667 11.6667C22.1667 11.9761 22.0438 12.2729 21.825 12.4916C21.6062 12.7104 21.3095 12.8334 21.0001 12.8334H14.0001C13.6907 12.8334 13.3939 12.7104 13.1751 12.4916C12.9563 12.2729 12.8334 11.9761 12.8334 11.6667C12.8334 11.3573 12.9563 11.0605 13.1751 10.8417C13.3939 10.6229 13.6907 10.5 14.0001 10.5H21.0001C21.3095 10.5 21.6062 10.6229 21.825 10.8417C22.0438 11.0605 22.1667 11.3573 22.1667 11.6667ZM22.1667 16.3334C22.1667 16.6428 22.0438 16.9395 21.825 17.1583C21.6062 17.3771 21.3095 17.5 21.0001 17.5H14.0001C13.6907 17.5 13.3939 17.3771 13.1751 17.1583C12.9563 16.9395 12.8334 16.6428 12.8334 16.3334C12.8334 16.0239 12.9563 15.7272 13.1751 15.5084C13.3939 15.2896 13.6907 15.1667 14.0001 15.1667H21.0001C21.3095 15.1667 21.6062 15.2896 21.825 15.5084C22.0438 15.7272 22.1667 16.0239 22.1667 16.3334Z"
                                            fill="#2BC155"></path>
                                    </svg>
                                </div>
                                <span class="fs-5 fw-semibold">View Transactions</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Check Deposit Modal -->
    <div class="modal fade" id="fiat" tabindex="-1" aria-labelledby="fiatLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fiatLabel">Check Deposit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/check.jpg') }}" alt="Check Deposit" class="img-fluid"
                            style="max-height: 150px;">
                    </div>

                    <form action="{{ route('deposit.store') }}" method="POST" enctype="multipart/form-data"
                        id="depositForm">
                        @csrf
                        <input type="hidden" name="email" value="{{ $user->email }}">

                        <div class="mb-3">
                            <label for="pin_amount" class="form-label">Amount</label>
                            <input id="pin_amount" type="number" name="amount" step="0.01"
                                class="form-control @error('amount') is-invalid @enderror" placeholder="Enter Amount"
                                value="{{ old('amount') }}" required min="1">
                            @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @else
                            <div class="invalid-feedback">Please enter a valid amount</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="checkImage" class="form-label">Upload Check Slip</label>
                            <div class="custom-file">
                                <input type="file" class="form-control @error('front_cheque') is-invalid @enderror"
                                    id="checkImage" name="front_cheque" accept="image/*" required>
                                @error('front_cheque')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">Please upload a check image</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="transaction_pin" class="form-label">Transaction Pin</label>
                            <input id="transaction_pin" type="password" name="transaction_pin" maxlength="4"
                                class="form-control @error('transaction_pin') is-invalid @enderror"
                                placeholder="Enter 4-digit PIN" required pattern="\d{4}">
                            @error('transaction_pin')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @else
                            <div class="invalid-feedback">Please enter a valid 4-digit PIN</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <span id="submitText">Proceed</span>
                            <span id="loadingSpinner" class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                        </button>
                    </form>

                    <script>
                        // Add JavaScript to show loading spinner during form submission
    document.getElementById('depositForm').addEventListener('submit', function() {
        document.getElementById('submitText').classList.add('d-none');
        document.getElementById('loadingSpinner').classList.remove('d-none');
    });
                    </script>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // File input label update
  document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('checkImage');
    if (fileInput) {
      fileInput.addEventListener('change', function() {
        const fileName = this.files[0] ? this.files[0].name : 'Choose file';
        this.nextElementSibling.textContent = fileName;
      });
    }
    
    // Form validation
    const depositForm = document.getElementById('depositForm');
    if (depositForm) {
      depositForm.addEventListener('submit', function(e) {
        if (!this.checkValidity()) {
          e.preventDefault();
          e.stopPropagation();
        } else {
          // Show loading state
          document.getElementById('submitText').textContent = 'Processing...';
          document.getElementById('loadingSpinner').classList.remove('d-none');
        }
        
        this.classList.add('was-validated');
      }, false);
    }
  });
    </script>
</body>

</html>