@extends('layouts.guest2')

@section('title', 'Create an Account')
@section('content')

<div class="flex flex-col lg:flex-row min-h-screen">
    <!-- Left Side - Branding & Illustration (Desktop Only) -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary-600 to-primary-800 relative overflow-hidden">
        <!-- Animated Shapes -->
        <div class="absolute inset-0 overflow-hidden opacity-10">
            <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-white rounded-full mix-blend-overlay floating-slow">
            </div>
            <div class="absolute bottom-1/3 right-1/4 w-96 h-96 bg-white rounded-full mix-blend-overlay floating"></div>
            <div class="absolute top-2/3 left-1/3 w-40 h-40 bg-white rounded-full mix-blend-overlay floating-slower">
            </div>

            <!-- Grid pattern -->
            <div class="absolute inset-0"
                style="background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 20px 20px;">
            </div>
        </div>

        <!-- Content -->
        <div class="relative flex flex-col justify-center items-center w-full h-full text-white p-12 z-10">
            <!-- Logo -->
            <a href="/" class="mb-6">
                <img src="{{ asset('storage/app/public/' . ($settings->logo ?? 'default-logo.png')) }}" alt="Logo"
                    class="h-16 filter brightness-0 invert">
            </a>

            <!-- Title -->
            <h1 class="text-4xl font-extrabold mb-6 text-center">Start Banking with Us</h1>

            <!-- Description -->
            <p class="text-xl mb-8 max-w-md text-center text-white/80">
                Create your {{ $settings->site_name ?? 'Banking' }} account in just a few steps and enjoy our full range
                of banking services.
            </p>

            <!-- Benefits -->
            <div class="w-full max-w-md space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-white/20 flex items-center justify-center mt-0.5">
                        <i data-lucide="check" class="h-3 w-3"></i>
                    </div>
                    <p class="text-sm text-white/80">
                        <span class="font-medium text-white">Secure Banking Platform</span> - Industry-leading security
                        protocols to keep your funds safe
                    </p>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-white/20 flex items-center justify-center mt-0.5">
                        <i data-lucide="check" class="h-3 w-3"></i>
                    </div>
                    <p class="text-sm text-white/80">
                        <span class="font-medium text-white">Fast Transfers</span> - Send and receive money quickly to
                        anyone, anywhere
                    </p>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-white/20 flex items-center justify-center mt-0.5">
                        <i data-lucide="check" class="h-3 w-3"></i>
                    </div>
                    <p class="text-sm text-white/80">
                        <span class="font-medium text-white">24/7 Account Access</span> - Manage your finances anytime,
                        anywhere on any device
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Registration Form -->
    <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 lg:p-12">
        <div class="w-full max-w-2xl">
            <!-- Mobile Logo -->
            <div class="lg:hidden text-center mb-8">
                <a href="/">
                    <img src="{{ asset('storage/app/public/' . ($settings->logo ?? 'default-logo.png')) }}" alt="Logo"
                        class="h-12 mx-auto">
                </a>
            </div>

            <!-- Alerts -->
            @if (Session::has('status'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                <p>{{ session('status') }}</p>
            </div>
            @endif

            @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Registration Card -->
            <div x-data="{ 
                step: 1,
                totalSteps: 4,
                formData: {
                    name: '{{ old('name') }}',
                    middlename: '{{ old('middlename') }}',
                    lastname: '{{ old('lastname') }}',
                    username: '{{ old('username') }}',
                    email: '{{ old('email') }}',
                    phone: '{{ old('phone') }}',
                    country: '{{ old('country') }}',
                    currency: '{{ old('currency') }}',
                    accounttype: '{{ old('accounttype') }}',
                    pin: '{{ old('pin') }}',
                    password: '',
                    password_confirmation: '',
                    terms: {{ old('terms') ? 'true' : 'false' }}
                },
                nextStep() {
                    if (this.validateCurrentStep()) {
                        if (this.step < this.totalSteps) {
                            this.step++;
                            window.scrollTo(0, 0);
                        }
                    }
                },
                prevStep() {
                    if (this.step > 1) {
                        this.step--;
                        window.scrollTo(0, 0);
                    }
                },
                validateCurrentStep() {
                    // Basic validation logic based on current step
                    if (this.step === 1) {
                        return this.formData.name && this.formData.lastname && this.formData.username;
                    } else if (this.step === 2) {
                        return this.formData.email && this.formData.phone && this.formData.country && this.formData.currency;
                    } else if (this.step === 3) {
                        return this.formData.accounttype && this.formData.pin;
                    } else if (this.step === 4) {
                        return this.formData.password && this.formData.password_confirmation && this.formData.terms;
                    }
                    return true;
                },
                get progress() {
                    return (this.step / this.totalSteps) * 100;
                }
            }" class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Progress Header -->
                <div class="bg-gray-50 px-8 py-6 border-b border-gray-200">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-2xl font-bold text-gray-900">Create Your Account</h2>
                        <span class="text-sm font-medium text-gray-500">Step <span x-text="step"></span> of <span
                                x-text="totalSteps"></span></span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-primary-600 rounded-full transition-all duration-300 ease-in-out"
                            :style="'width: ' + progress + '%'"></div>
                    </div>

                    <!-- Step Titles -->
                    <div class="flex justify-between mt-2 text-xs text-gray-500">
                        <div class="text-center" :class="{ 'text-primary-600 font-medium': step >= 1 }">Personal Info
                        </div>
                        <div class="text-center" :class="{ 'text-primary-600 font-medium': step >= 2 }">Contact Details
                        </div>
                        <div class="text-center" :class="{ 'text-primary-600 font-medium': step >= 3 }">Account Setup
                        </div>
                        <div class="text-center" :class="{ 'text-primary-600 font-medium': step >= 4 }">Security</div>
                    </div>
                </div>

                <!-- Form Container -->
                <div class="px-8 py-6">
                    <form action="{{ route('register') }}" method="post" id="registration-form">
                        @csrf

                        <!-- Step 1: Personal Information -->
                        <div x-show="step === 1" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                            <div class="text-center mb-6">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-100 mb-4">
                                    <i data-lucide="user" class="h-8 w-8 text-primary-600"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                                <p class="mt-1 text-sm text-gray-500">Please provide your legal name as it appears on
                                    official documents</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- First Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Legal First
                                        Name *</label>
                                    <input type="text" id="name" name="name" x-model="formData.name"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                        placeholder="John" required>
                                    @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Middle Name -->
                                <div>
                                    <label for="middlename" class="block text-sm font-medium text-gray-700 mb-2">Middle
                                        Name</label>
                                    <input type="text" id="middlename" name="middlename" x-model="formData.middlename"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                        placeholder="David">
                                </div>

                                <!-- Last Name -->
                                <div>
                                    <label for="lastname" class="block text-sm font-medium text-gray-700 mb-2">Legal
                                        Last Name *</label>
                                    <input type="text" id="lastname" name="lastname" x-model="formData.lastname"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                        placeholder="Smith" required>
                                    @error('lastname')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Username -->
                                <div>
                                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username
                                        *</label>
                                    <input type="text" id="username" name="username" x-model="formData.username"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                        placeholder="johnsmith123" required>
                                    @error('username')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Contact Information -->
                        <div x-show="step === 2" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                            <div class="text-center mb-6">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-100 mb-4">
                                    <i data-lucide="mail" class="h-8 w-8 text-primary-600"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">Contact Information</h3>
                                <p class="mt-1 text-sm text-gray-500">We'll use these details to communicate with you
                                    about your account</p>
                            </div>

                            <div class="space-y-6 mb-6">
                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email
                                        Address *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i data-lucide="mail" class="h-5 w-5 text-gray-400"></i>
                                        </div>
                                        <input type="email" id="email" name="email" x-model="formData.email"
                                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                            placeholder="john.smith@example.com" required>
                                    </div>
                                    @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number
                                        *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i data-lucide="phone" class="h-5 w-5 text-gray-400"></i>
                                        </div>
                                        <input type="tel" id="phone" name="phone" x-model="formData.phone"
                                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                            placeholder="+1 (234) 567-8901" required>
                                    </div>
                                    @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Country -->
                                <div>
                                    <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country
                                        *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i data-lucide="globe" class="h-5 w-5 text-gray-400"></i>
                                        </div>
                                        <select id="country" name="country" x-model="formData.country"
                                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none"
                                            required>
                                            <option value="" disabled selected>Select your country</option>
                                            @include('auth.countries')
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i data-lucide="chevron-down" class="h-5 w-5 text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('country')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Currency -->
                                <div>
                                    <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">Preferred
                                        Currency *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i data-lucide="dollar-sign" class="h-5 w-5 text-gray-400"></i>
                                        </div>
                                        <select id="currency" name="currency" x-model="formData.currency"
                                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none"
                                            required>
                                            <option value="" disabled selected>Select your currency</option>
                                            <option value="USD" {{ old('currency')=='USD' ? 'selected' : '' }}>USD - US
                                                Dollar</option>
                                            <option value="EUR" {{ old('currency')=='EUR' ? 'selected' : '' }}>EUR -
                                                Euro</option>
                                            <option value="GBP" {{ old('currency')=='GBP' ? 'selected' : '' }}>GBP -
                                                British Pound</option>
                                            <option value="NGN" {{ old('currency')=='NGN' ? 'selected' : '' }}>NGN -
                                                Nigerian Naira</option>
                                            <option value="CAD" {{ old('currency')=='CAD' ? 'selected' : '' }}>CAD -
                                                Canadian Dollar</option>
                                            <option value="AUD" {{ old('currency')=='AUD' ? 'selected' : '' }}>AUD -
                                                Australian Dollar</option>
                                            <option value="JPY" {{ old('currency')=='JPY' ? 'selected' : '' }}>JPY -
                                                Japanese Yen</option>
                                            <option value="CNY" {{ old('currency')=='CNY' ? 'selected' : '' }}>CNY -
                                                Chinese Yuan</option>
                                            <option value="INR" {{ old('currency')=='INR' ? 'selected' : '' }}>INR -
                                                Indian Rupee</option>
                                            <option value="ZAR" {{ old('currency')=='ZAR' ? 'selected' : '' }}>ZAR -
                                                South African Rand</option>
                                            <option value="BRL" {{ old('currency')=='BRL' ? 'selected' : '' }}>BRL -
                                                Brazilian Real</option>
                                            <option value="RUB" {{ old('currency')=='RUB' ? 'selected' : '' }}>RUB -
                                                Russian Ruble</option>
                                            <option value="MXN" {{ old('currency')=='MXN' ? 'selected' : '' }}>MXN -
                                                Mexican Peso</option>
                                            <option value="CHF" {{ old('currency')=='CHF' ? 'selected' : '' }}>CHF -
                                                Swiss Franc</option>
                                            <option value="PHP" {{ old('currency')=='PHP' ? 'selected' : '' }}>NGN -
                                                Philippine Peso</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i data-lucide="chevron-down" class="h-5 w-5 text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('currency')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Account Setup -->
                        <div x-show="step === 3" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                            <div class="text-center mb-6">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-100 mb-4">
                                    <i data-lucide="landmark" class="h-8 w-8 text-primary-600"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">Account Setup</h3>
                                <p class="mt-1 text-sm text-gray-500">Choose your account type and set up your
                                    transaction PIN</p>
                            </div>

                            <div class="space-y-6 mb-6">
                                <!-- Account Type -->
                                <div>
                                    <label for="accounttype"
                                        class="block text-sm font-medium text-gray-700 mb-2">Account Type *</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <label @click="formData.accounttype = 'Checking Account'"
                                            class="relative block cursor-pointer">
                                            <input type="radio" name="accounttype" value="Checking Account"
                                                x-model="formData.accounttype" class="sr-only" {{
                                                old('accounttype')=='Checking Account' ? 'checked' : '' }}>
                                            <div class="border rounded-lg p-4 transition-all"
                                                :class="formData.accounttype === 'Checking Account' ? 'border-primary-500 bg-primary-50 ring-2 ring-primary-500' : 'border-gray-300 hover:border-primary-300'">
                                                <div class="flex items-start">
                                                    <div class="flex-shrink-0">
                                                        <div
                                                            class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                                                            <i data-lucide="credit-card"
                                                                class="h-5 w-5 text-primary-600"></i>
                                                        </div>
                                                    </div>
                                                    <div class="ml-3">
                                                        <h4 class="text-sm font-medium text-gray-900">Checking Account
                                                        </h4>
                                                        <p class="text-xs text-gray-500">Perfect for daily transactions
                                                            and bill payments</p>
                                                    </div>
                                                </div>
                                                <div x-show="formData.accounttype === 'Checking Account'"
                                                    class="absolute top-2 right-2 w-5 h-5 bg-primary-500 rounded-full flex items-center justify-center">
                                                    <i data-lucide="check" class="h-3 w-3 text-white"></i>
                                                </div>
                                            </div>
                                        </label>

                                        <label @click="formData.accounttype = 'Savings Account'"
                                            class="relative block cursor-pointer">
                                            <input type="radio" name="accounttype" value="Savings Account"
                                                x-model="formData.accounttype" class="sr-only" {{
                                                old('accounttype')=='Savings Account' ? 'checked' : '' }}>
                                            <div class="border rounded-lg p-4 transition-all"
                                                :class="formData.accounttype === 'Savings Account' ? 'border-primary-500 bg-primary-50 ring-2 ring-primary-500' : 'border-gray-300 hover:border-primary-300'">
                                                <div class="flex items-start">
                                                    <div class="flex-shrink-0">
                                                        <div
                                                            class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                                                            <i data-lucide="piggy-bank"
                                                                class="h-5 w-5 text-primary-600"></i>
                                                        </div>
                                                    </div>
                                                    <div class="ml-3">
                                                        <h4 class="text-sm font-medium text-gray-900">Savings Account
                                                        </h4>
                                                        <p class="text-xs text-gray-500">Earn interest on your deposits
                                                        </p>
                                                    </div>
                                                </div>
                                                <div x-show="formData.accounttype === 'Savings Account'"
                                                    class="absolute top-2 right-2 w-5 h-5 bg-primary-500 rounded-full flex items-center justify-center">
                                                    <i data-lucide="check" class="h-3 w-3 text-white"></i>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Additional account types dropdown for more options -->
                                    <div class="mt-4" x-data="{ open: false }">
                                        <button type="button" @click="open = !open"
                                            class="w-full text-left flex items-center justify-between text-sm text-primary-600 hover:text-primary-700 focus:outline-none">
                                            <span>Show more account types</span>
                                            <i data-lucide="chevron-down" class="h-4 w-4"
                                                :class="{'transform rotate-180': open}"></i>
                                        </button>

                                        <div x-show="open" x-transition class="mt-2 space-y-2">
                                            <template x-for="(type, index) in [
                                                {value: 'Fixed Deposit Account', label: 'Fixed Deposit Account', desc: 'Highest interest rates for fixed terms', icon: 'calendar'},
                                                {value: 'Current Account', label: 'Current Account', desc: 'For everyday business transactions', icon: 'briefcase'},
                                                {value: 'Crypto Currency Account', label: 'Crypto Currency Account', desc: 'For digital currency management', icon: 'bitcoin'},
                                                {value: 'Business Account', label: 'Business Account', desc: 'For small to medium businesses', icon: 'building'},
                                                {value: 'Non Resident Account', label: 'Non Resident Account', desc: 'For international customers', icon: 'globe'},
                                                {value: 'Cooperate Business Account', label: 'Cooperate Business Account', desc: 'For large corporations', icon: 'landmark'},
                                                {value: 'Investment Account', label: 'Investment Account', desc: 'For stocks and securities', icon: 'trending-up'}
                                            ]" :key="index">
                                                <label @click="formData.accounttype = type.value"
                                                    class="relative block cursor-pointer">
                                                    <input type="radio" name="accounttype" :value="type.value"
                                                        x-model="formData.accounttype" class="sr-only" {{
                                                        old('accounttype')=='type.value' ? 'checked' : '' }}>
                                                    <div class="border rounded-lg p-4 transition-all"
                                                        :class="formData.accounttype === type.value ? 'border-primary-500 bg-primary-50 ring-2 ring-primary-500' : 'border-gray-300 hover:border-primary-300'">
                                                        <div class="flex items-start">
                                                            <div class="flex-shrink-0">
                                                                <div
                                                                    class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                                                                    <i :data-lucide="type.icon"
                                                                        class="h-5 w-5 text-primary-600"></i>
                                                                </div>
                                                            </div>
                                                            <div class="ml-3">
                                                                <h4 class="text-sm font-medium text-gray-900"
                                                                    x-text="type.label"></h4>
                                                                <p class="text-xs text-gray-500" x-text="type.desc"></p>
                                                            </div>
                                                        </div>
                                                        <div x-show="formData.accounttype === type.value"
                                                            class="absolute top-2 right-2 w-5 h-5 bg-primary-500 rounded-full flex items-center justify-center">
                                                            <i data-lucide="check" class="h-3 w-3 text-white"></i>
                                                        </div>
                                                    </div>
                                                </label>
                                            </template>
                                        </div>
                                    </div>
                                    @error('accounttype')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Transaction PIN -->
                                <div>
                                    <label for="pin" class="block text-sm font-medium text-gray-700 mb-2">Transaction
                                        PIN (4 digits) *</label>
                                    <div class="relative" x-data="{ showPin: false }">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i data-lucide="key" class="h-5 w-5 text-gray-400"></i>
                                        </div>
                                        <input :type="showPin ? 'text' : 'password'" id="pin" name="pin"
                                            x-model="formData.pin"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                            placeholder="••••" maxlength="4" pattern="[0-9]{4}" required>
                                        <button type="button" @click="showPin = !showPin"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i data-lucide="eye" class="h-5 w-5 text-gray-400" x-show="!showPin"></i>
                                            <i data-lucide="eye-off" class="h-5 w-5 text-gray-400" x-show="showPin"></i>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Your PIN will be required to authorize
                                        transactions</p>
                                    @error('pin')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Security -->
                        <div x-show="step === 4" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                            <div class="text-center mb-6">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-100 mb-4">
                                    <i data-lucide="shield" class="h-8 w-8 text-primary-600"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">Secure Your Account</h3>
                                <p class="mt-1 text-sm text-gray-500">Create a strong password to protect your account
                                </p>
                            </div>

                            <div class="space-y-6 mb-6">
                                <!-- Password -->
                                <div x-data="{ showPassword: false }">
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password
                                        *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i data-lucide="lock" class="h-5 w-5 text-gray-400"></i>
                                        </div>
                                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password"
                                            x-model="formData.password"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                            placeholder="••••••••" required>
                                        <button type="button" @click="showPassword = !showPassword"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i data-lucide="eye" class="h-5 w-5 text-gray-400"
                                                x-show="!showPassword"></i>
                                            <i data-lucide="eye-off" class="h-5 w-5 text-gray-400"
                                                x-show="showPassword"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                    <!-- Password Strength Meter -->
                                    <div class="mt-2" x-data="{ 
                                        get strength() {
                                            let score = 0;
                                            
                                            // Length check
                                            if (formData.password.length > 7) score += 1;
                                            if (formData.password.length > 10) score += 1;
                                            
                                            // Complexity checks
                                            if (/[A-Z]/.test(formData.password)) score += 1;
                                            if (/[0-9]/.test(formData.password)) score += 1;
                                            if (/[^A-Za-z0-9]/.test(formData.password)) score += 1;
                                            
                                            return score;
                                        },
                                        get strengthLabel() {
                                            const labels = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong', 'Very Strong'];
                                            return labels[this.strength] || 'Very Weak';
                                        },
                                        get strengthColor() {
                                            const colors = [
                                                'bg-red-500', // Very Weak
                                                'bg-red-500', // Weak
                                                'bg-yellow-500', // Fair
                                                'bg-yellow-500', // Good
                                                'bg-green-500', // Strong
                                                'bg-green-500'  // Very Strong
                                            ];
                                            return colors[this.strength] || 'bg-red-500';
                                        }
                                    }" x-show="formData.password.length > 0">
                                        <div class="flex justify-between items-center mb-1">
                                            <p class="text-xs text-gray-500">Password strength: <span
                                                    x-text="strengthLabel" :class="{
                                                'text-red-600': strength < 2,
                                                'text-yellow-600': strength >= 2 && strength < 4,
                                                'text-green-600': strength >= 4
                                            }"></span></p>
                                        </div>
                                        <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full transition-all duration-300 ease-in-out"
                                                :class="strengthColor" :style="`width: ${(strength / 5) * 100}%`"></div>
                                        </div>
                                        <ul class="mt-2 space-y-1 text-xs text-gray-500">
                                            <li class="flex items-center"
                                                :class="{ 'text-green-600': formData.password.length > 7 }">
                                                <i data-lucide="check-circle" class="h-3 w-3 mr-1"
                                                    x-show="formData.password.length > 7"></i>
                                                <i data-lucide="circle" class="h-3 w-3 mr-1"
                                                    x-show="formData.password.length <= 7"></i>
                                                At least 8 characters
                                            </li>
                                            <li class="flex items-center"
                                                :class="{ 'text-green-600': /[A-Z]/.test(formData.password) }">
                                                <i data-lucide="check-circle" class="h-3 w-3 mr-1"
                                                    x-show="/[A-Z]/.test(formData.password)"></i>
                                                <i data-lucide="circle" class="h-3 w-3 mr-1"
                                                    x-show="!/[A-Z]/.test(formData.password)"></i>
                                                At least one uppercase letter
                                            </li>
                                            <li class="flex items-center"
                                                :class="{ 'text-green-600': /[0-9]/.test(formData.password) }">
                                                <i data-lucide="check-circle" class="h-3 w-3 mr-1"
                                                    x-show="/[0-9]/.test(formData.password)"></i>
                                                <i data-lucide="circle" class="h-3 w-3 mr-1"
                                                    x-show="!/[0-9]/.test(formData.password)"></i>
                                                At least one number
                                            </li>
                                            <li class="flex items-center"
                                                :class="{ 'text-green-600': /[^A-Za-z0-9]/.test(formData.password) }">
                                                <i data-lucide="check-circle" class="h-3 w-3 mr-1"
                                                    x-show="/[^A-Za-z0-9]/.test(formData.password)"></i>
                                                <i data-lucide="circle" class="h-3 w-3 mr-1"
                                                    x-show="!/[^A-Za-z0-9]/.test(formData.password)"></i>
                                                At least one special character
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div x-data="{ showPassword: false }">
                                    <label for="password_confirmation"
                                        class="block text-sm font-medium text-gray-700 mb-2">Confirm Password *</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i data-lucide="lock" class="h-5 w-5 text-gray-400"></i>
                                        </div>
                                        <input :type="showPassword ? 'text' : 'password'" id="password_confirmation"
                                            name="password_confirmation" x-model="formData.password_confirmation"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                            placeholder="••••••••" required>
                                        <button type="button" @click="showPassword = !showPassword"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i data-lucide="eye" class="h-5 w-5 text-gray-400"
                                                x-show="!showPassword"></i>
                                            <i data-lucide="eye-off" class="h-5 w-5 text-gray-400"
                                                x-show="showPassword"></i>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-sm" x-show="formData.password && formData.password_confirmation"
                                        :class="formData.password === formData.password_confirmation ? 'text-green-600' : 'text-red-600'">
                                        <span x-show="formData.password === formData.password_confirmation">
                                            <i data-lucide="check" class="inline h-3 w-3"></i> Passwords match
                                        </span>
                                        <span x-show="formData.password !== formData.password_confirmation">
                                            <i data-lucide="x" class="inline h-3 w-3"></i> Passwords do not match
                                        </span>
                                    </p>
                                </div>

                                <!-- Terms and Conditions -->
                                <div>
                                    <label class="flex items-start">
                                        <input type="checkbox" id="terms" name="terms" x-model="formData.terms"
                                            class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 mt-1"
                                            {{ old('terms') ? 'checked' : '' }} required>
                                        <span class="ml-2 text-sm text-gray-600">
                                            I agree to the <a href="/terms" target="_blank"
                                                class="text-primary-600 hover:text-primary-500 underline">Terms of
                                                Service</a> and <a href="/privacy" target="_blank"
                                                class="text-primary-600 hover:text-primary-500 underline">Privacy
                                                Policy</a>
                                        </span>
                                    </label>
                                    @error('terms')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Step Navigation -->
                        <div class="flex justify-between pt-4 border-t border-gray-200">
                            <button type="button" x-show="step > 1" @click="prevStep"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <i data-lucide="chevron-left" class="h-4 w-4 mr-2"></i>
                                Previous
                            </button>
                            <div x-show="step === 1"></div>

                            <button type="button" x-show="step < totalSteps" @click="nextStep"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Next
                                <i data-lucide="chevron-right" class="h-4 w-4 ml-2"></i>
                            </button>

                            <button type="submit" x-show="step === totalSteps"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <i data-lucide="check" class="h-4 w-4 mr-2"></i>
                                Create Account
                            </button>
                        </div>

                        <!-- Hidden form fields to ensure data is submitted even if user doesn't visit every step -->
                        <input type="hidden" name="name" :value="formData.name">
                        <input type="hidden" name="middlename" :value="formData.middlename">
                        <input type="hidden" name="lastname" :value="formData.lastname">
                        <input type="hidden" name="username" :value="formData.username">
                        <input type="hidden" name="email" :value="formData.email">
                        <input type="hidden" name="phone" :value="formData.phone">
                        <input type="hidden" name="country" :value="formData.country">
                        <input type="hidden" name="currency" :value="formData.currency">
                        <input type="hidden" name="accounttype" :value="formData.accounttype">
                        <input type="hidden" name="pin" :value="formData.pin">
                        <input type="hidden" name="password" :value="formData.password">
                        <input type="hidden" name="password_confirmation" :value="formData.password_confirmation">
                    </form>
                </div>

                <!-- Login Link -->
                <div class="text-center mt-4 pb-4">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-500 font-medium">
                            Sign in instead
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function restrictSpaces(event) {
        if (event.keyCode === 32) {
            return false;
        }
    }
    
    // When the DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Prevent spaces in username field
        const usernameInput = document.getElementById('username');
        if (usernameInput) {
            usernameInput.addEventListener('keypress', restrictSpaces);
        }
        
        // Restrict PIN to numbers only
        const pinInput = document.getElementById('pin');
        if (pinInput) {
            pinInput.addEventListener('keypress', function(event) {
                const charCode = (event.which) ? event.which : event.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    event.preventDefault();
                    return false;
                }
                return true;
            });
        }
    });
</script>
@endsection