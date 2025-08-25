@extends('layouts.user')

@section('title', 'Update Profile Picture - ' . $settings->site_name)

@section('content')
<div class="container pt-4">
    <!-- Back Button -->
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm me-2">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h5 class="mb-0">Update Profile Picture</h5>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <!-- Current Profile Display -->
                    <div class="text-center mb-4">
                        <div class="mx-auto mb-3 position-relative">
                            @if ($user->profile_photo_path)
                            <img src="{{ $user->profile_photo_url }}" alt="Profile" class="rounded-circle"
                                style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto"
                                style="width: 120px; height: 120px;">
                                <span class="text-white" style="font-size: 3rem;">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            @endif
                        </div>
                        <h5 class="fw-semibold">{{ $user->name }}</h5>
                    </div>

                    <!-- Upload Form -->
                    <form action="{{ route('personal-dp.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="profileImageInput" class="form-label fw-semibold">Choose new profile
                                picture</label>
                            <input class="form-control" type="file" id="profileImageInput" name="image" accept="image/*"
                                required>
                            <div class="form-text">Select a JPG, PNG or GIF image (max 2MB)</div>
                        </div>

                        <!-- Image Preview -->
                        <div class="text-center mb-4 d-none" id="previewContainer">
                            <p class="small text-muted">Preview</p>
                            <img id="imagePreview" class="rounded-circle border"
                                style="width: 150px; height: 150px; object-fit: cover;">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-main flex-fill">
                                <i class="bi bi-cloud-upload me-2"></i> Upload Picture
                            </button>

                            @if ($user->profile_photo_path)
                            <form action="{{ route('personal-dp.delete') }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger"
                                    onclick="return confirm('Are you sure you want to remove your profile picture?')">
                                    <i class="bi bi-trash me-2"></i> Remove
                                </button>
                            </form>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips -->
            <div class="mt-4">
                <div class="alert alert-light border">
                    <h6 class="fw-semibold mb-3"><i class="bi bi-lightbulb me-2"></i>Tips for a great profile picture
                    </h6>
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Use a clear, well-lit photo
                        </li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Make sure your face is
                            visible</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Avoid blurry or dark images
                        </li>
                        <li><i class="bi bi-check-circle text-success me-2"></i>Square images work best</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Preview image before upload
    document.getElementById('profileImageInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        const previewContainer = document.getElementById('previewContainer');
        const preview = document.getElementById('imagePreview');
        
        // Check if file is an image
        if (!file.type.match('image.*')) {
            alert('Please select an image file (JPEG, PNG, GIF)');
            e.target.value = '';
            return;
        }
        
        // Check file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Image must be less than 2MB');
            e.target.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    });
</script>
@endsection