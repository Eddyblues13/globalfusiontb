@extends('layouts.dash2')
@section('title', 'Cheque Deposit')
@section('content')

<div class="container mx-auto px-4 py-6 max-w-4xl">
    <!-- Alerts -->
    <x-danger-alert />
    <x-success-alert />
    <x-error-alert />

    <!-- Page Header with Breadcrumbs -->
    <div class="flex flex-col mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 mb-1">Make Cheque Deposit</h1>
            <div class="flex items-center text-sm text-gray-500">
                <a href="{{ route('dashboard') }}" class="hover:text-primary-600">Dashboard</a>
                <i data-lucide="chevron-right" class="h-4 w-4 mx-2"></i>
                <a href="{{ route('deposits') }}" class="hover:text-primary-600">Deposits</a>
                <i data-lucide="chevron-right" class="h-4 w-4 mx-2"></i>
                <span class="font-medium text-gray-700">Cheque Deposit</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <!-- Content Header -->
        <div class="border-b border-gray-200 px-6 py-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center">
                    <i data-lucide="file-text" class="h-5 w-5 mr-2 text-primary-600"></i>
                    <h2 class="text-xl font-semibold text-gray-900">Cheque Deposit</h2>
                </div>
                <div class="mt-2 md:mt-0 md:ml-4">
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-gray-800">
                        Minimum: {{ config('currencies.'.Auth::user()->currency, '$') }}{{
                        number_format($settings->min_cheque) }} {{
                        Auth::user()->currency }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <div class="p-6">
            <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i data-lucide="info" class="h-5 w-5 text-blue-500"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Cheque Deposit Instructions</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>Please fill in your cheque details and upload clear images of both the front and back of
                                your cheque. Cheque deposits typically take 3-5 business days to clear.</p>
                            <ul class="list-disc pl-5 mt-2">
                                <li>Ensure the cheque is signed and dated correctly</li>
                                <li>Write your account number on the back of the cheque</li>
                                <li>Ensure all details are clearly visible in the images</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <form method="post" action="{{ route('savechequedeposit') }}" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="cheque_number" class="block text-sm font-medium text-gray-700 mb-1">Cheque Number
                            *</label>
                        <input type="text" id="cheque_number" name="cheque_number" required
                            class="block w-full py-2 px-3 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                            placeholder="Enter cheque number">
                    </div>

                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount *</label>
                        <input type="number" id="amount" name="amount" min="{{ $settings->min_cheque }}" step="0.01"
                            required
                            class="block w-full py-2 px-3 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                            placeholder="0.00">
                    </div>

                    <div>
                        <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-1">Bank Name *</label>
                        <input type="text" id="bank_name" name="bank_name" required
                            class="block w-full py-2 px-3 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                            placeholder="Issuing bank name">
                    </div>

                    <div>
                        <label for="account_holder" class="block text-sm font-medium text-gray-700 mb-1">Account Holder
                            Name *</label>
                        <input type="text" id="account_holder" name="account_holder" required
                            class="block w-full py-2 px-3 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                            placeholder="Name on the cheque">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Front of Cheque *</label>
                    <div id="front-upload-area"
                        class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-500 transition-all relative cursor-pointer">
                        <div id="front-upload-placeholder" class="flex flex-col items-center justify-center">
                            <i data-lucide="upload-cloud" class="h-10 w-10 text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-500 mb-2">
                                <span class="font-medium text-primary-600">Click to upload</span> or drag and drop
                            </p>
                            <p class="text-xs text-gray-500">PNG, JPG (max. 5MB)</p>
                        </div>
                        <div id="front-preview-container" class="hidden flex flex-col items-center justify-center">
                            <img id="front-image-preview" src="#" alt="Front preview"
                                class="max-h-48 max-w-full mb-3 rounded-lg shadow-sm">
                            <p class="text-sm font-medium text-gray-700 flex items-center">
                                <span id="front-file-name">filename.jpg</span>
                                <button type="button" id="front-remove-file"
                                    class="ml-2 text-red-500 hover:text-red-700">
                                    <i data-lucide="x-circle" class="h-5 w-5"></i>
                                </button>
                            </p>
                        </div>
                        <input id="front-upload" class="hidden" name="front_image" type="file" required
                            accept="image/*">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Back of Cheque *</label>
                    <div id="back-upload-area"
                        class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-500 transition-all relative cursor-pointer">
                        <div id="back-upload-placeholder" class="flex flex-col items-center justify-center">
                            <i data-lucide="upload-cloud" class="h-10 w-10 text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-500 mb-2">
                                <span class="font-medium text-primary-600">Click to upload</span> or drag and drop
                            </p>
                            <p class="text-xs text-gray-500">PNG, JPG (max. 5MB)</p>
                        </div>
                        <div id="back-preview-container" class="hidden flex flex-col items-center justify-center">
                            <img id="back-image-preview" src="#" alt="Back preview"
                                class="max-h-48 max-w-full mb-3 rounded-lg shadow-sm">
                            <p class="text-sm font-medium text-gray-700 flex items-center">
                                <span id="back-file-name">filename.jpg</span>
                                <button type="button" id="back-remove-file"
                                    class="ml-2 text-red-500 hover:text-red-700">
                                    <i data-lucide="x-circle" class="h-5 w-5"></i>
                                </button>
                            </p>
                        </div>
                        <input id="back-upload" class="hidden" name="back_image" type="file" required accept="image/*">
                    </div>
                </div>

                <div class="flex justify-center mt-8">
                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                        <i data-lucide="check-circle" class="h-5 w-5 mr-2"></i>
                        Submit Cheque Deposit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Setup file upload with preview and drag-drop for both upload areas
        const setupFileUpload = (dropAreaId, fileInputId, placeholderId, previewContainerId, imagePreviewId, fileNameId, removeButtonId) => {
            const dropArea = document.getElementById(dropAreaId);
            const fileInput = document.getElementById(fileInputId);
            const placeholder = document.getElementById(placeholderId);
            const previewContainer = document.getElementById(previewContainerId);
            const imagePreview = document.getElementById(imagePreviewId);
            const fileName = document.getElementById(fileNameId);
            const removeButton = document.getElementById(removeButtonId);
            
            if (!dropArea || !fileInput || !placeholder || !previewContainer || !imagePreview || !fileName || !removeButton) return;
            
            // Prevent default behavior for all drag events
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            // Highlight drop area when dragging over it
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                dropArea.classList.add('border-primary-500');
                dropArea.classList.add('bg-primary-50');
            }
            
            function unhighlight() {
                dropArea.classList.remove('border-primary-500');
                dropArea.classList.remove('bg-primary-50');
            }
            
            // Handle file selection via drag & drop
            dropArea.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files.length) {
                    fileInput.files = files;
                    updateFilePreview(files[0]);
                }
            }
            
            // Handle file selection via click
            dropArea.addEventListener('click', () => {
                fileInput.click();
            });
            
            // Handle file selection changes
            fileInput.addEventListener('change', function() {
                if (this.files.length) {
                    updateFilePreview(this.files[0]);
                }
            });
            
            // Handle removing the selected file
            removeButton.addEventListener('click', function(e) {
                e.stopPropagation(); // Prevent triggering dropArea click
                resetFileInput();
            });
            
            // Update the preview with the selected file
            function updateFilePreview(file) {
                // Display file name
                fileName.textContent = file.name;
                
                // Handle image preview
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        showPreview();
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Show a generic file icon for other files
                    imagePreview.src = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9ImN1cnJlbnRDb2xvciIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiIGNsYXNzPSJsdWNpZGUgbHVjaWRlLWZpbGUiPjxwYXRoIGQ9Ik0xNCAySDZhMiAyIDAgMCAwLTIgMnYxNmEyIDIgMCAwIDAgMiAyaDEyYTIgMiAwIDAgMCAyLTJWOHoiLz48cGF0aCBkPSJNMTQgMnY2aDYiLz48L3N2Zz4=';
                    imagePreview.classList.add('h-24', 'w-24', 'object-contain');
                    showPreview();
                }
            }
            
            // Show the preview and hide the placeholder
            function showPreview() {
                placeholder.classList.add('hidden');
                previewContainer.classList.remove('hidden');
            }
            
            // Reset the file input and show the placeholder again
            function resetFileInput() {
                fileInput.value = '';
                placeholder.classList.remove('hidden');
                previewContainer.classList.add('hidden');
                // Remove any added classes to the image preview
                imagePreview.classList.remove('h-24', 'w-24', 'object-contain');
            }
        };
        
        // Setup file upload for both front and back images
        setupFileUpload(
            'front-upload-area', 
            'front-upload', 
            'front-upload-placeholder', 
            'front-preview-container', 
            'front-image-preview', 
            'front-file-name', 
            'front-remove-file'
        );
        
        setupFileUpload(
            'back-upload-area', 
            'back-upload', 
            'back-upload-placeholder', 
            'back-preview-container', 
            'back-image-preview', 
            'back-file-name', 
            'back-remove-file'
        );
    });
</script>
@endsection