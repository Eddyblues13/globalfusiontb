<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pay Bills - Upward Saver</title>
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

        .bill-tile {
            background-color: #f9f9f9;
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }

        .bill-tile:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transform: translateY(-3px);
        }

        .bill-icon {
            font-size: 30px;
            margin-bottom: 10px;
            color: #b93b2d;
        }

        .section-title {
            font-size: 22px;
            font-weight: 600;
            margin-top: 20px;
            margin-bottom: 10px;
            color: #333;
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

        /* Notification Modal Styles */
        .notification-modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            z-index: 1050;
            max-width: 90%;
            width: 350px;
            text-align: center;
            display: none;
        }

        .notification-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none;
        }

        .notification-icon {
            font-size: 40px;
            color: #b93b2d;
            margin-bottom: 15px;
        }

        .notification-close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
            color: #888;
        }
    </style>
</head>

<body>

    <div class="container mt-4">
        <h2 class="section-title">Pay Bills</h2>
        <p>Select a biller below to proceed</p>

        <div class="row g-3 mt-3">
            <!-- Electricity -->
            <div class="col-4">
                <div class="bill-tile" onclick="showNotification('Electricity')">
                    <div class="bill-icon"><i class="bi bi-lightning-charge"></i></div>
                    <div>Electricity</div>
                </div>
            </div>

            <!-- Water -->
            <div class="col-4">
                <div class="bill-tile" onclick="showNotification('Water')">
                    <div class="bill-icon"><i class="bi bi-droplet-half"></i></div>
                    <div>Water</div>
                </div>
            </div>

            <!-- Internet -->
            <div class="col-4">
                <div class="bill-tile" onclick="showNotification('Internet')">
                    <div class="bill-icon"><i class="bi bi-wifi"></i></div>
                    <div>Internet</div>
                </div>
            </div>

            <!-- Mobile Top-Up -->
            <div class="col-4">
                <div class="bill-tile" onclick="showNotification('Mobile Top-Up')">
                    <div class="bill-icon"><i class="bi bi-phone"></i></div>
                    <div>Mobile Top-Up</div>
                </div>
            </div>

            <!-- Cable TV -->
            <div class="col-4">
                <div class="bill-tile" onclick="showNotification('Cable TV')">
                    <div class="bill-icon"><i class="bi bi-tv"></i></div>
                    <div>Cable TV</div>
                </div>
            </div>

            <!-- Gas -->
            <div class="col-4">
                <div class="bill-tile" onclick="showNotification('Gas')">
                    <div class="bill-icon"><i class="bi bi-fire"></i></div>
                    <div>Gas</div>
                </div>
            </div>
        </div>

        <!-- Add a quick action button -->

    </div>

    <!-- Notification Modal -->
    <div class="notification-overlay" id="notificationOverlay"></div>
    <div class="notification-modal" id="notificationModal">
        <span class="notification-close" onclick="hideNotification()">&times;</span>
        <div class="notification-icon">
            <i class="bi bi-envelope-check"></i>
        </div>
        <h5>Payment Instruction</h5>
        <p id="notificationMessage">You will receive a notification soon with detailed instructions on how to proceed
            with making your payment. Please keep an eye on your email or phone for further information.</p>
        <button class="btn btn-main mt-3" onclick="hideNotification()">Got it</button>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showNotification(billType) {
      const message = `You will receive ${billType} payment instructions soon. Please check your email or phone for details. Thank you for your patience.`;
      document.getElementById('notificationMessage').textContent = message;
      document.getElementById('notificationModal').style.display = 'block';
      document.getElementById('notificationOverlay').style.display = 'block';
    }

    function hideNotification() {
      document.getElementById('notificationModal').style.display = 'none';
      document.getElementById('notificationOverlay').style.display = 'none';
    }

    // Close modal when clicking outside
    document.getElementById('notificationOverlay').addEventListener('click', hideNotification);
    </script>
</body>

</html>

</body>

</html>
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
            <button type="submit" class="nav-link btn btn-link p-0 m-0" style="color: inherit; text-decoration: none;">
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