@extends('layouts.guest2')

@section('title', 'Verify Email')
@section('content')

<div class="container py-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-5">
            <div class="flex items-center justify-center">
                <div class="bg-white/20 backdrop-blur-sm p-3 rounded-full">
                    <i data-lucide="mail" class="h-10 w-10 text-white"></i>
                </div>
            </div>
            <h1 class="text-white text-center font-bold text-2xl mt-4">Verify Your Email Address</h1>
            <p class="text-white/80 text-center mt-2">Enter the 4-digit code sent to your email</p>
        </div>

        <!-- Card Content -->
        <div class="p-6 sm:p-8">
            <!-- Toastr Notifications (rendered via JS below) -->

            <!-- Main Content -->
            <div class="text-center pt-4">
                <div class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-primary-50 mb-6">
                    <i data-lucide="shield-check" class="h-12 w-12 text-primary-600"></i>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-4">Enter Verification Code</h2>
                <p class="text-gray-600 mb-6">We've sent a 4-digit code to your email address</p>

                <!-- Code Input Form -->
                <form action="{{ route('verification.verify.code') }}" method="POST" class="mb-8">
                    @csrf
                    <div class="flex justify-center gap-3 mb-6">
                        <input type="text" name="digit1" id="digit1" maxlength="1"
                            class="w-16 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none transition-colors"
                            inputmode="numeric" pattern="[0-9]" autocomplete="off" required autofocus>
                        <input type="text" name="digit2" id="digit2" maxlength="1"
                            class="w-16 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none transition-colors"
                            inputmode="numeric" pattern="[0-9]" autocomplete="off" required>
                        <input type="text" name="digit3" id="digit3" maxlength="1"
                            class="w-16 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none transition-colors"
                            inputmode="numeric" pattern="[0-9]" autocomplete="off" required>
                        <input type="text" name="digit4" id="digit4" maxlength="1"
                            class="w-16 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none transition-colors"
                            inputmode="numeric" pattern="[0-9]" autocomplete="off" required>
                    </div>

                    <button type="submit"
                        class="inline-flex items-center justify-center w-full px-4 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                        <i data-lucide="check" class="h-5 w-5 mr-2"></i>
                        Verify Email
                    </button>
                </form>

                <div class="bg-gray-50 rounded-lg p-5 text-left mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Didn't get the code?</h3>
                    <ul class="list-decimal pl-5 text-gray-600 space-y-2">
                        <li>The email may be in your spam folder</li>
                        <li>The email address you entered might have a typo</li>
                        <li>The code expires after 10 minutes</li>
                    </ul>
                </div>

                <!-- Actions -->
                <div class="space-y-4">
                    <a href="{{ route('verification.send') }}"
                        onclick="event.preventDefault(); document.getElementById('resend-form').submit();"
                        class="inline-flex items-center justify-center w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                        <i data-lucide="refresh-cw" class="h-5 w-5 mr-2"></i>
                        Resend Code
                    </a>
                    <form id="resend-form" action="{{ route('verification.send') }}" method="POST" class="hidden">
                        {{ csrf_field() }}
                    </form>

                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="inline-flex items-center justify-center w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                        <i data-lucide="log-out" class="h-5 w-5 mr-2 text-gray-400"></i>
                        Sign Out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();

        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 5000
        };

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ addslashes($error) }}");
            @endforeach
        @endif

        @if (session('error'))
            toastr.error("{{ addslashes(session('error')) }}");
        @endif

        @if (session('success'))
            toastr.success("{{ addslashes(session('success')) }}");
        @endif

        @if (session('message'))
            toastr.info("{{ addslashes(session('message')) }}");
        @endif

        @if (session('status'))
            toastr.info("{{ addslashes(session('status')) }}");
        @endif

        const inputs = document.querySelectorAll('#digit1, #digit2, #digit3, #digit4');
        const codeForm = document.querySelector('form[action*="verify-code"]');

        inputs.forEach((input, index) => {
            input.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
                // Auto-submit when all 4 digits are filled
                const allFilled = Array.from(inputs).every(i => i.value.length === 1);
                if (allFilled) {
                    setTimeout(function() { codeForm.submit(); }, 100);
                }
            });

            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value === '' && index > 0) {
                    inputs[index - 1].focus();
                }
            });

            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '').slice(0, 4);
                for (let i = 0; i < pasted.length && i < inputs.length; i++) {
                    inputs[i].value = pasted[i];
                }
                if (pasted.length > 0) {
                    inputs[Math.min(pasted.length, inputs.length) - 1].focus();
                }
                // Auto-submit on paste if all 4 digits filled
                const allFilled = Array.from(inputs).every(i => i.value.length === 1);
                if (allFilled) {
                    setTimeout(function() { codeForm.submit(); }, 100);
                }
                }
            });
        });
    });
</script>
@endsection