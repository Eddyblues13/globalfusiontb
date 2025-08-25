<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $settings->site_name }} - Card Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        /* Custom CSS */
        .card-preview {
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            border-radius: 16px;
            padding: 20px;
            color: white;
            position: relative;
            height: 200px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .visa-card {
            background: linear-gradient(135deg, #1a3a8f, #0066b2);
        }

        .card-status {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-active {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .status-inactive {
            background: rgba(108, 117, 125, 0.3);
            color: white;
        }

        .card-logo {
            position: absolute;
            top: 15px;
            left: 20px;
            height: 40px;
        }

        .card-number {
            font-size: 22px;
            letter-spacing: 2px;
            margin-top: 70px;
            font-family: monospace;
        }

        .card-details {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .card-name {
            font-size: 16px;
            font-weight: 500;
        }

        .card-expiry,
        .card-cvv {
            font-size: 14px;
        }

        .btn-main {
            background-color: #3a7bd5;
            color: white;
        }

        .btn-main:hover {
            background-color: #2d62a8;
            color: white;
        }

        .btn-outline-main {
            border-color: #3a7bd5;
            color: #3a7bd5;
        }

        .btn-outline-main:hover {
            background-color: #3a7bd5;
            color: white;
        }

        .card-feature {
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .card-feature:last-child {
            border-bottom: none;
        }

        .card-feature-icon {
            font-size: 24px;
            color: #3a7bd5;
            margin-right: 15px;
        }

        .transaction-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
        }

        .small-text {
            font-size: 14px;
        }

        .bottom-nav {
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
        }

        .nav-link {
            color: #6c757d;
        }

        .nav-link.active {
            color: #3a7bd5;
        }

        .clickable {
            cursor: pointer;
        }

        .card-option {
            border: 2px solid #dee2e6;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 15px;
        }

        .card-option:hover,
        .card-option.selected {
            border-color: #3a7bd5;
            background-color: #f8f9fa;
        }

        .card-option img {
            height: 50px;
            margin-bottom: 10px;
        }

        .create-card-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="container pt-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="mb-0 fw-semibold">My Cards</h6>
            </div>
            <div class="text-end">
                <span class="text-muted small d-block">
                    <span id="accountNumber">{{ $user->usernumber }}</span>
                    <i class="bi bi-copy ms-1 clickable" id="copyIcon" onclick="copyAccountNumber()"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Copy to clipboard"></i>
                </span>
            </div>
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

        <!-- Create Card Section (Always Visible) -->
        <div class="create-card-section mt-3">
            <h6>Create New Card</h6>
            <form action="{{ route('card.store') }}" method="POST" id="cardForm">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card-option {{ old('type') == 'mastercard' ? 'selected' : '' }}"
                            data-type="mastercard" onclick="selectCardType('mastercard')">
                            <img src="{{ asset('images/mastercard.png') }}" alt="Mastercard"
                                onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2MCIgaGVpZ2h0PSI0MCIgdmlld0JveD0iMCAwIDYwIDQwIj48cmVjdCB3aWR0aD0iNjAiIGhlaWdodD0iNDAiIGZpbGw9IiNmYzYiIHJ4PSI1Ii8+PHRleHQgeD0iMzAiIHk9IjIwIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTIiIGZpbGw9IiNmZmYiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGRvbWluYW50LWJhc2VsaW5lPSJtaWRkbGUiPk1DQzwvdGV4dD48L3N2Zz4='">
                            <h6 class="mb-1">Mastercard</h6>
                            <p class="small-text mb-0">Global acceptance</p>
                        </div>
                        <input type="radio" name="type" value="mastercard" id="mastercard" class="d-none" {{
                            old('type')=='mastercard' ? 'checked' : '' }} required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card-option {{ old('type') == 'visa' ? 'selected' : '' }}" data-type="visa"
                            onclick="selectCardType('visa')">
                            <img src="{{ asset('images/visa.png') }}" alt="Visa"
                                onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2MCIgaGVpZ2h0PSI0MCIgdmlld0JveD0iMCAwIDYwIDQwIj48cmVjdCB3aWR0aD0iNjAiIGhlaWdodD0iNDAiIGZpbGw9IiMxYTM5OGYiIHJ4PSI1Ii8+PHRleHQgeD0iMzAiIHk9IjIwIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTQiIGZpbGw9IiNmZmYiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGRvbWluYW50LWJhc2VsaW5lPSJtaWRkbGUiPlZJU0E8L3RleHQ+PC9zdmc+'">
                            <h6 class="mb-1">Visa</h6>
                            <p class="small-text mb-0">Widely accepted</p>
                        </div>
                        <input type="radio" name="type" value="visa" id="visa" class="d-none" {{ old('type')=='visa'
                            ? 'checked' : '' }} required>
                    </div>
                </div>

                <div class="alert alert-info py-2">
                    <i class="bi bi-info-circle"></i> Your card will be generated instantly with a unique number.
                </div>

                <div class="text-center mt-2">
                    <button type="submit" class="btn btn-main" id="createBtn" disabled>
                        <i class="bi bi-plus-circle"></i> Create Card
                    </button>
                </div>
            </form>
        </div>

        <!-- Display Existing Cards -->
        @if($cards->count() > 0)
        @foreach($cards as $card)
        <!-- Card preview -->
        <div class="card-preview {{ $card->type === 'visa' ? 'visa-card' : '' }}">
            <div class="card-status status-{{ $card->status }}">{{ strtoupper($card->status) }}</div>
            <img src="{{ asset('images/' . $card->type . '.png') }}" alt="Card Logo" class="card-logo"
                onerror="this.src='data:image/svg+xml;base64,{{ $card->type === 'visa' ? 'PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2MCIgaGVpZ2h0PSI0MCIgdmlld0JveD0iMCAwIDYwIDQwIj48cmVjdCB3aWR0aD0iNjAiIGhlaWdodD0iNDAiIGZpbGw9IiMxYTM5OGYiIHJ4PSI1Ii8+PHRleHQgeD0iMzAiIHk9IjIwIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTQiIGZpbGw9IiNmZmYiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGRvbWluYW50LWJhc2VsaW5lPSJtaWRkbGUiPlZJU0E8L3RleHQ+PC9zdmc+' : 'PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2MCIgaGVpZ2h0PSI0MCIgdmlld0JveD0iMCAwIDYwIDQwIj48cmVjdCB3aWR0aD0iNjAiIGhlaWdodD0iNDAiIGZpbGw9IiNmYzYiIHJ4PSI1Ii8+PHRleHQgeD0iMzAiIHk9IjIwIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTIiIGZpbGw9IiNmZmYiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGRvbWluYW50LWJhc2VsaW5lPSJtaWRkbGUiPk1DQzwvdGV4dD48L3N2Zz4=' }}'">
            <div class="card-number">
                {{ chunk_split($card->card_number, 4, ' ') }}
            </div>
            <div class="card-details">
                <div class="card-name">
                    {{ $card->card_holder_name }}
                </div>

                <div class="card-cvv" id="cvvField-{{ $card->id }}" style="font-weight: 500;">
                    CVV <span id="cvvValue-{{ $card->id }}">•••</span>
                </div>

                <div class="card-expiry">
                    Exp: {{ $card->expiry_date }}
                </div>
            </div>
        </div>

        <!-- Card actions -->
        <div class="d-flex gap-2 mb-4">
            <button class="btn btn-main flex-fill" onclick="toggleCVV({{ $card->id }})">
                <i class="bi bi-eye" id="cvvIcon-{{ $card->id }}"></i> <span id="cvvBtnText-{{ $card->id }}">Show
                    CVV</span>
            </button>

            <form action="{{ route('card.toggle-status', $card) }}" method="POST" class="flex-fill">
                @csrf
                <button type="submit" class="btn btn-{{ $card->status === 'active' ? 'warning' : 'success' }} w-100">
                    <i class="bi bi-{{ $card->status === 'active' ? 'pause' : 'play' }}"></i> {{ $card->status ===
                    'active' ? 'Deactivate' : 'Activate' }}
                </button>
            </form>

            <form action="{{ route('card.destroy', $card) }}" method="POST" class="flex-fill">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger w-100"
                    onclick="return confirm('Are you sure you want to delete this card?')">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
        @endforeach
        @else
        <!-- No card message -->
        <div class="alert alert-info mt-3">
            <p class="mb-0">You haven't created any cards yet. Select a card type above to create your first card.</p>
        </div>
        @endif

        <!-- Card delivery request -->
        <div class="text-center mt-3">
            <button type="button" class="btn btn-outline-main" data-bs-toggle="modal" data-bs-target="#deliveryModal">
                <i class="bi bi-truck"></i> Request Physical Card Delivery
            </button>
        </div>

        <!-- Delivery requests history -->
        @if($deliveryRequests->count() > 0)
        <h6 class="mt-4">Delivery Requests</h6>
        <div class="transaction-box">
            @foreach($deliveryRequests as $request)
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted small-text">Request #{{ $request->id }} ({{ $request->created_at->format('M d,
                    Y') }})</span>
                <span
                    class="badge bg-{{ $request->status == 'delivered' ? 'success' : ($request->status == 'shipped' ? 'primary' : 'warning') }}">
                    {{ ucfirst($request->status) }}
                </span>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Card features -->
        <h6 class="mt-4">Card Features</h6>
        <div class="card-feature d-flex align-items-center">
            <i class="bi bi-lightning card-feature-icon"></i>
            <div>
                <h6 class="mb-1">Instant Access</h6>
                <p class="small-text mb-0">Create and use your card immediately</p>
            </div>
        </div>

        <div class="card-feature d-flex align-items-center">
            <i class="bi bi-shield-check card-feature-icon"></i>
            <div>
                <h6 class="mb-1">Safety</h6>
                <p class="small-text mb-0">Secure transactions and fraud protection</p>
            </div>
        </div>

        <!-- Personal information -->
        <h6 class="mt-4">Personal Information</h6>
        <div class="transaction-box">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted small-text">First Name</span>
                <span>{{ Auth::user()->name ?? 'Mary' }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted small-text">Last Name</span>
                <span>{{ Auth::user()->lastname ?? 'Zannelle' }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted small-text">Date of Birth</span>
                <span>{{ Auth::user()->dob ?? '' }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-muted small-text">Gender</span>
                <span>{{ Auth::user()->gender ?? '' }}</span>
            </div>
        </div>
    </div>

    <!-- Delivery Request Modal -->
    <div class="modal fade" id="deliveryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Card Delivery Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="requestForm" action="{{ route('card.request-delivery') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullName" name="full_name"
                                value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="houseAddress" class="form-label">House Address</label>
                            <textarea class="form-control" id="houseAddress" name="address" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phoneNumber" name="phone_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="emailAddress" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="emailAddress" name="email" required>
                        </div>
                        <!-- New Nearest Airport Field -->
                        <div class="mb-3">
                            <label for="nearestAirport" class="form-label">Nearest Airport</label>
                            <input type="text" class="form-control" id="nearestAirport" name="nearest_airport"
                                placeholder="Enter your nearest airport" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-main" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-main">Submit Request</button>
                    </div>
                </form>
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
    
    // Check if a card type was previously selected (after form validation error)
    @if(old('type'))
      selectCardType('{{ old('type') }}');
    @endif
  });

  // Card type selection
  function selectCardType(type) {
    // Remove selected class from all options
    document.querySelectorAll('.card-option').forEach(option => {
      option.classList.remove('selected');
    });
    
    // Add selected class to clicked option
    document.querySelector(`.card-option[data-type="${type}"]`).classList.add('selected');
    
    // Check the corresponding radio button
    document.getElementById(type).checked = true;
    
    // Enable the create button
    document.getElementById('createBtn').disabled = false;
  }
    </script>

    @foreach($cards as $card)
    <script>
        const actualCVV{{ $card->id }} = "{{ $card->cvv }}";
  let isCVVVisible{{ $card->id }} = false;

  function toggleCVV(cardId) {
    const cvvValue = document.getElementById("cvvValue-" + cardId);
    const cvvIcon = document.getElementById("cvvIcon-" + cardId);
    const cvvBtnText = document.getElementById("cvvBtnText-" + cardId);

    isCVVVisible{{ $card->id }} = !isCVVVisible{{ $card->id }};

    if (isCVVVisible{{ $card->id }}) {
      cvvValue.textContent = actualCVV{{ $card->id }};
      cvvIcon.classList.remove("bi-eye");
      cvvIcon.classList.add("bi-eye-slash");
      cvvBtnText.textContent = "Hide CVV";
    } else {
      cvvValue.textContent = "•••";
      cvvIcon.classList.remove("bi-eye-slash");
      cvvIcon.classList.add("bi-eye");
      cvvBtnText.textContent = "Show CVV";
    }
  }
    </script>
    @endforeach
</body>

</html>