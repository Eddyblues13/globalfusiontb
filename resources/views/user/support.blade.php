@extends('layouts.dash2')
@section('title', $title)
@section('content')

<div class="container mx-auto px-4 py-6 max-w-4xl">
    <!-- Alerts -->
    <x-danger-alert />
    <x-success-alert />
    <x-error-alert />

    <!-- Page Header with Breadcrumbs -->
    <div class="flex flex-col mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 mb-1">Support Center</h1>
            <div class="flex items-center text-sm text-gray-500">
                <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
                <i data-lucide="chevron-right" class="h-4 w-4 mx-2"></i>
                <span class="font-medium text-gray-700">Support</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <!-- Content Header -->
        <div class="border-b border-gray-200 px-6 py-4">
            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                <i data-lucide="life-buoy" class="h-5 w-5 mr-2 text-primary-600"></i>
                Submit a Support Ticket
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                We're here to help. Tell us about your issue and we'll find a solution.
            </p>
        </div>
        
        <!-- Support Icon -->
        <div class="flex justify-center py-8">
            <div class="h-24 w-24 rounded-full bg-primary-50 flex items-center justify-center">
                <i data-lucide="message-circle-question" class="h-12 w-12 text-gray-600"></i>
            </div>
        </div>
        
        <!-- Form Content -->
        <div class="p-6">
            <form action="{{ route('enquiry') }}" method="post" class="space-y-6">
                @csrf
                
                <!-- Hidden Fields -->
                <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                <input type="hidden" name="name" value="{{ Auth::user()->name }}" />
                
                <!-- Ticket Title -->
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">
                        Ticket Title
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="bookmark" class="h-5 w-5 text-gray-400"></i>
                        </div>
                        <input 
                            type="text" 
                            id="subject" 
                            name="subject"
                            class="block w-full pl-10 py-3 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                            placeholder="Briefly describe your issue"
                            required
                        />
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Be specific to help us understand your issue</p>
                </div>
                
                <!-- Priority Selection -->
                <div>
                    <label for="selectPriority" class="block text-sm font-medium text-gray-700 mb-1">
                        Priority Level
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="flag" class="h-5 w-5 text-gray-400"></i>
                        </div>
                        <select 
                            id="selectPriority" 
                            name="selectPriority"
                            class="block w-full pl-10 py-3 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all appearance-none"
                            required
                        >
                            <option value="low">Low Priority</option>
                            <option value="medium">Medium Priority</option>
                            <option value="high">High Priority</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i data-lucide="chevron-down" class="h-5 w-5 text-gray-400"></i>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Select based on urgency of your request</p>
                </div>
                
                <!-- Message Content -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                        Describe Your Issue
                    </label>
                    <div class="relative">
                        <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                            <i data-lucide="message-square-text" class="h-5 w-5 text-gray-400"></i>
                        </div>
                        <textarea 
                            id="message" 
                            name="message"
                            rows="6"
                            class="block w-full pl-10 py-3 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all preserveLines"
                            placeholder="Please provide all relevant details about your issue so we can help you better"
                            required
                        ></textarea>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Include any relevant details that might help us resolve your issue</p>
                </div>
                
                <!-- Support Info Card -->
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i data-lucide="info" class="h-5 w-5 text-blue-500"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Support Information</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>
                                    Our support team typically responds within 24 hours. For urgent matters, 
                                    please select "High Priority" and we'll do our best to assist you sooner.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="pt-3">
                    <button 
                        type="submit"
                        class="w-full md:w-auto px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors flex items-center justify-center"
                    >
                        <i data-lucide="send" class="h-5 w-5 mr-2"></i>
                        Submit Ticket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons
        lucide.createIcons();
    });
</script>
@endpush

@endsection