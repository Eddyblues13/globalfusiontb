<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title') - {{$settings->site_name}}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">
    <meta name="apple-mobile-web-app-title" content="{{$settings->site_name}}">
    <meta name="application-name" content="{{$settings->site_name}}">
    <meta name="description" content="Swift and Secure Money Transfer to any UK bank account will become a breeze with {{$settings->site_name}}.">
    <link rel="shortcut icon" href="{{ asset('storage/app/public/' . $settings->favicon) }}">
    
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_light : "#f0f9ff" }}',
                            100: '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_light : "#e0f2fe" }}',
                            200: '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_light : "#bae6fd" }}',
                            300: '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_light : "#7dd3fc" }}',
                            400: '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_light : "#38bdf8" }}',
                            500: '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color : "#0ea5e9" }}',
                            600: '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color : "#0284c7" }}',
                            700: '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_dark : "#0369a1" }}',
                            800: '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_dark : "#075985" }}',
                            900: '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_dark : "#0c4a6e" }}',
                        },
                        secondary: {
                            50: '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color_light : "#f0fdfa" }}',
                            100: '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color_light : "#ccfbf1" }}',
                            200: '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color_light : "#99f6e4" }}',
                            300: '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color_light : "#5eead4" }}',
                            400: '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color_light : "#2dd4bf" }}',
                            500: '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color : "#14b8a6" }}',
                            600: '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color : "#0d9488" }}',
                            700: '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color_dark : "#0f766e" }}',
                            800: '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color_dark : "#115e59" }}',
                            900: '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color_dark : "#134e4a" }}',
                        }
                    },
                    fontFamily: {
                        'sans': ['Lato', 'sans-serif'],
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    
    <!-- CSS Variables -->
    <script>
        // Set CSS theme variables
        document.documentElement.style.setProperty('--primary-color', '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color : "#0ea5e9" }}');
        document.documentElement.style.setProperty('--primary-color-dark', '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_dark : "#0369a1" }}');
        document.documentElement.style.setProperty('--primary-color-light', '{{ isset($appearanceSettings) ? $appearanceSettings->primary_color_light : "#38bdf8" }}');
        document.documentElement.style.setProperty('--secondary-color', '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color : "#14b8a6" }}');
        document.documentElement.style.setProperty('--secondary-color-dark', '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color_dark : "#0f766e" }}');
        document.documentElement.style.setProperty('--secondary-color-light', '{{ isset($appearanceSettings) ? $appearanceSettings->secondary_color_light : "#5eead4" }}');
        document.documentElement.style.setProperty('--text-color', '{{ isset($appearanceSettings) ? $appearanceSettings->text_color : "#111827" }}');
        document.documentElement.style.setProperty('--bg-color', '{{ isset($appearanceSettings) ? $appearanceSettings->bg_color : "#f9fafb" }}');
        document.documentElement.style.setProperty('--card-bg-color', '{{ isset($appearanceSettings) ? $appearanceSettings->card_bg_color : "#ffffff" }}');
    </script>
    
    @if(isset($appearanceSettings) && $appearanceSettings->custom_css)
    <style>
        {!! $appearanceSettings->custom_css !!}
    </style>
    @endif
    
    <!-- Modern Loading Animation -->
    <style>
        .page-loading {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transition: all .4s .2s ease-in-out;
            background-color: #ffffff;
            visibility: hidden;
            z-index: 9999;
        }
        .page-loading.active {
            opacity: 1;
            visibility: visible;
        }
        .page-loading-inner {
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            text-align: center;
            transform: translateY(-50%);
            transition: opacity .2s ease-in-out;
            opacity: 0;
        }
        .page-loading.active>.page-loading-inner {
            opacity: 1;
        }
        
        .loading-container {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        
        .loading-animation {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
            position: relative;
        }
        
        .loading-animation .circle {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 4px solid transparent;
            mix-blend-mode: overlay;
            animation: rotateCircle 1.5s linear infinite;
        }
        
        .loading-animation .circle:nth-child(1) {
            border-top-color: var(--primary-color);
            animation-delay: 0s;
        }
        
        .loading-animation .circle:nth-child(2) {
            border-right-color: var(--primary-color-light);
            animation-delay: 0.2s;
        }
        
        .loading-animation .circle:nth-child(3) {
            border-bottom-color: var(--secondary-color);
            animation-delay: 0.4s;
        }
        
        .loading-animation .circle:nth-child(4) {
            border-left-color: var(--primary-color-light);
            animation-delay: 0.6s;
        }
        
        .loading-animation .core {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary-color-light), var(--primary-color-dark));
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
            animation: pulse 1s ease-in-out infinite alternate;
        }
        
        .page-loading .text {
            color: var(--primary-color);
            font-weight: 500;
            letter-spacing: 0.05em;
            margin-top: 0.5rem;
            font-size: 0.875rem;
            background: linear-gradient(90deg, var(--primary-color-dark), var(--primary-color-light), var(--primary-color-dark));
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradient 2s linear infinite;
        }
        
        @keyframes rotateCircle {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @keyframes pulse {
            from { transform: scale(0.8); opacity: 0.8; }
            to { transform: scale(1.2); opacity: 1; }
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Floating elements animation */
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        .floating-slow {
            animation: floating 6s ease-in-out infinite;
        }
        .floating-slower {
            animation: floating 8s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        /* Interactive elements */
        .input-wrapper {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .input-wrapper:focus-within {
            transform: translateY(-2px);
        }
        
        .input-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 1rem;
            color: #94a3b8;
            transition: color 0.3s ease;
        }
        
        .input-wrapper:focus-within .input-icon {
            color: var(--primary-color);
        }
        
        input:focus + .input-toggle {
            color: var(--primary-color);
        }
    </style>
    @laravelPWA
</head>

<body class="font-sans bg-gray-50 text-gray-900 flex min-h-screen">
    <!-- Page Loader -->
    <div class="page-loading active">
        <div class="page-loading-inner">
            <div class="loading-container">
                <div class="loading-animation">
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="core"></div>
                </div>
                <div class="text">{{ $settings->site_name }}</div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="w-full">
        @yield('content')
    </div>
    
    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
    
    <!-- Enhanced Page Loading Animation -->
    <script>
        window.onload = function() {
            const preloader = document.querySelector('.page-loading');
            
            // Add a slight delay to make loading animation more noticeable
            setTimeout(function() {
                preloader.classList.remove('active');
                setTimeout(function() {
                    preloader.remove();
                }, 500);
            }, 800);
        };
    </script>
    <script>
        
    </script>
    
    <!-- Tidio Chat -->
    @if($settings->tido)
    <script src="//code.tidio.co/{{$settings->tido}}" async></script>
    @endif
    
    <!-- Additional Scripts -->
    @yield('scripts')
</body>
</html>