<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title') - {{ $settings->site_name ?? config('app.name') }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">
    <meta name="apple-mobile-web-app-title" content="{{ $settings->site_name ?? config('app.name') }}">
    <meta name="application-name" content="{{ $settings->site_name ?? config('app.name') }}">
    <meta name="description"
        content="Swift and Secure Money Transfer to any UK bank account will become a breeze with {{ $settings->site_name ?? config('app.name') }}.">

    {{-- ✅ Corrected favicon path (storage symlink safe, with fallback) --}}
    <link rel="shortcut icon"
        href="{{ !empty($settings->favicon) ? asset('storage/' . $settings->favicon) : asset('default-favicon.png') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '{{ $appearanceSettings->primary_color_light ?? "#f0f9ff" }}',
                            100: '{{ $appearanceSettings->primary_color_light ?? "#e0f2fe" }}',
                            200: '{{ $appearanceSettings->primary_color_light ?? "#bae6fd" }}',
                            300: '{{ $appearanceSettings->primary_color_light ?? "#7dd3fc" }}',
                            400: '{{ $appearanceSettings->primary_color_light ?? "#38bdf8" }}',
                            500: '{{ $appearanceSettings->primary_color ?? "#0ea5e9" }}',
                            600: '{{ $appearanceSettings->primary_color ?? "#0284c7" }}',
                            700: '{{ $appearanceSettings->primary_color_dark ?? "#0369a1" }}',
                            800: '{{ $appearanceSettings->primary_color_dark ?? "#075985" }}',
                            900: '{{ $appearanceSettings->primary_color_dark ?? "#0c4a6e" }}',
                        },
                        secondary: {
                            50: '{{ $appearanceSettings->secondary_color_light ?? "#f0fdfa" }}',
                            100: '{{ $appearanceSettings->secondary_color_light ?? "#ccfbf1" }}',
                            200: '{{ $appearanceSettings->secondary_color_light ?? "#99f6e4" }}',
                            300: '{{ $appearanceSettings->secondary_color_light ?? "#5eead4" }}',
                            400: '{{ $appearanceSettings->secondary_color_light ?? "#2dd4bf" }}',
                            500: '{{ $appearanceSettings->secondary_color ?? "#14b8a6" }}',
                            600: '{{ $appearanceSettings->secondary_color ?? "#0d9488" }}',
                            700: '{{ $appearanceSettings->secondary_color_dark ?? "#0f766e" }}',
                            800: '{{ $appearanceSettings->secondary_color_dark ?? "#115e59" }}',
                            900: '{{ $appearanceSettings->secondary_color_dark ?? "#134e4a" }}',
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
        document.documentElement.style.setProperty('--primary-color', '{{ $appearanceSettings->primary_color ?? "#0ea5e9" }}');
        document.documentElement.style.setProperty('--primary-color-dark', '{{ $appearanceSettings->primary_color_dark ?? "#0369a1" }}');
        document.documentElement.style.setProperty('--primary-color-light', '{{ $appearanceSettings->primary_color_light ?? "#38bdf8" }}');
        document.documentElement.style.setProperty('--secondary-color', '{{ $appearanceSettings->secondary_color ?? "#14b8a6" }}');
        document.documentElement.style.setProperty('--secondary-color-dark', '{{ $appearanceSettings->secondary_color_dark ?? "#0f766e" }}');
        document.documentElement.style.setProperty('--secondary-color-light', '{{ $appearanceSettings->secondary_color_light ?? "#5eead4" }}');
        document.documentElement.style.setProperty('--text-color', '{{ $appearanceSettings->text_color ?? "#111827" }}');
        document.documentElement.style.setProperty('--bg-color', '{{ $appearanceSettings->bg_color ?? "#f9fafb" }}');
        document.documentElement.style.setProperty('--card-bg-color', '{{ $appearanceSettings->card_bg_color ?? "#ffffff" }}');
    </script>

    {{-- Custom CSS if set --}}
    @if(!empty($appearanceSettings->custom_css))
    <style>
        {
             ! ! $appearanceSettings->custom_css  ! !
        }
    </style>
    @endif


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
                <div class="text">{{ $settings->site_name ?? config('app.name') }}</div>
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

    <!-- Hide preloader after load -->
    <script>
        window.onload = function() {
            const preloader = document.querySelector('.page-loading');
            setTimeout(() => {
                preloader.classList.remove('active');
                setTimeout(() => preloader.remove(), 500);
            }, 800);
        };
    </script>

    <!-- Tidio Chat -->
    @if(!empty($settings->tido))
    <script src="//code.tidio.co/{{ $settings->tido }}" async></script>
    @endif

    <!-- Additional Scripts -->
    @yield('scripts')
</body>

</html>