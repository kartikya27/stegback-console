@extends('PanelPulse::admin.layout.header')
@section('title', 'Create Ad Campaign | ' . env('APP_NAME'))
@section('style')
<style>
    .admin-menu.sellers i {
        color: black;
    }

    .admin-menu1.sellers {
        background-color: #eaeaea;
        border-left: 5px solid black;
        color: black;
    }

    /* Premium UI Styles */
    .ad-creation-container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 30px;
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 24px;
        font-weight: 500;
        color: #333;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eaeaea;
    }

    .form-section {
        margin-bottom: 30px;
    }

    .form-section-title {
        font-size: 18px;
        font-weight: 500;
        margin-bottom: 15px;
        color: #444;
    }

    .form-control {
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 10px 15px;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #000;
        box-shadow: 0 0 0 2px rgba(66, 133, 244, 0.25);
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 8px;
        color: #555;
    }

    .btn-primary {
        background-color: #000;
        border-color: #000;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        background-color: #3367d6;
        border-color: #3367d6;
    }

    .btn-outline-secondary {
        color: #5f6368;
        border-color: #dadce0;
        padding: 10px 20px;
        font-weight: 500;
    }

    .btn-outline-secondary:hover {
        background-color: #f1f3f4;
        color: #202124;
    }

    /* Ad Preview Styles */
    .ad-preview-container {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 25px;
        position: sticky;
        top: 20px;
    }

    .ad-preview-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .ad-preview-title {
        font-size: 18px;
        font-weight: 500;
        color: #444;
    }

    .ad-preview-controls {
        display: flex;
        gap: 10px;
    }

    .ad-preview-box {
        background-color: #fff;
        border: 1px solid #dadce0;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .ad-preview-url {
        color: #202124;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .ad-preview-headline {
        color: #1a0dab;
        font-size: 18px;
        font-weight: 500;
        margin-bottom: 5px;
        text-decoration: none;
    }

    .ad-preview-headline:hover {
        text-decoration: underline;
    }

    .ad-preview-description {
        color: #4d5156;
        font-size: 14px;
        line-height: 1.4;
    }

    .ad-preview-final-url {
        color: #1e8e3e;
        font-size: 14px;
        margin-top: 5px;
    }

    .preview-info {
        color: #5f6368;
        font-size: 13px;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #dadce0;
    }

    /* Campaign Progress */
    .campaign-progress {
        display: flex;
        margin-bottom: 30px;
    }

    .progress-step {
        flex: 1;
        text-align: center;
        position: relative;
    }

    .progress-step:not(:last-child):after {
        content: '';
        position: absolute;
        top: 15px;
        right: -50%;
        width: 100%;
        height: 2px;
        background-color: #dadce0;
        z-index: 1;
    }

    .progress-step.active:not(:last-child):after {
        background-color: #000;
    }

    .step-number {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #dadce0;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        position: relative;
        z-index: 2;
    }

    .progress-step.active .step-number {
        background-color: #000;
    }

    .progress-step.completed .step-number {
        background-color: #34a853;
    }

    .step-label {
        font-size: 14px;
        color: #5f6368;
    }

    .progress-step.active .step-label {
        color: #000;
        font-weight: 500;
    }

    .progress-step.completed .step-label {
        color: #34a853;
        font-weight: 500;
    }

    /* Form validation */
    .is-invalid {
        border-color: #ea4335;
    }

    .invalid-feedback {
        color: #ea4335;
        font-size: 12px;
        margin-top: 5px;
    }

    /* Character counter */
    .char-counter {
        font-size: 12px;
        color: #5f6368;
        text-align: right;
        margin-top: 5px;
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .ad-preview-container {
            position: static;
            margin-top: 30px;
        }
    }

.preview-section {
    display: none;
}
.preview-section.active {
    display: block;
}
.preview-type-btn.active {
    background-color: #000;
    color: white;
}
.new-arrival-card,
.sponsored-card,
.horizontal-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    background: white;
}
.product-image-container {
    width: 100%;
    height: 200px;
    overflow: hidden;
    margin-bottom: 10px;
}
.product-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.new-arrival-label {
    font-size: 16px;
    font-weight: 500;
    margin-bottom: 10px;
}
.product-title {
    font-size: 14px;
    margin-bottom: 8px;
}
.product-price {
    display: flex;
    align-items: baseline;
    gap: 8px;
}
.price-amount {
    font-size: 18px;
    font-weight: 500;
}
.price-tax {
    font-size: 12px;
    color: #666;
}
.sponsored-label {
    font-size: 12px;
    color: #666;
    margin-top: 8px;
}
.horizontal-card {
    display: flex;
    gap: 15px;
}
.horizontal-card .product-image-container {
    width: 120px;
    height: 120px;
    flex-shrink: 0;
}
.product-rating {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 8px;
}
.rating-stars {
    color: #ffd700;
}
.rating-count {
    color: #666;
    font-size: 12px;
}
.discount {
    color: #d32f2f;
    font-weight: 500;
}
.original-price {
    text-decoration: line-through;
    color: #666;
    font-size: 14px;
}
</style>
@endsection
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="info-cont-subheading"><i class="fas fa-ad me-2"></i> Create New Ad > {{ $adgroup->ad_group_name }}</h5>
        <button class=" btn-secondary btn-sm btn  rounded px-2 small text-dark border-1 border-secondary border-opacity-50" onclick="window.history.back()">
            <i class="fas fa-arrow-left me-2"></i>Back to Campaigns
        </button>
    </div>


    <div class="row">
        <!-- Ad Creation Form -->
        <div class="col-lg-7">
            <div class="ad-creation-container">
                <h2 class="subtext1">Review your Ad to be sure it's right</h2>
                
                <form id="adForm" class="needs-validation" novalidate>
                    <!-- Campaign Details Section -->
                    <div class="form-section">
                   
                        <div class="mb-3 d-none">
                            <label for="campaignGoal" class="form-label">Campaign goal</label>
                            <select class="form-select" id="campaignGoal" required>
                                <option value="website_traffic" selected>Website traffic</option>
                                <option value="leads">Leads</option>
                                <option value="sales">Sales</option>
                                <option value="brand_awareness">Brand awareness</option>
                            </select>
                            <div class="invalid-feedback">Please select a campaign goal.</div>
                        </div>
                    </div>
                    
                    <!-- Ad Content Section -->
                    <div class="form-section">
                        <div class="form-section-title">Ad Content</div>
                        
                        <div class="mb-3">
                            <label for="headlines" class="form-label">Headlines</label>
                            <input type="text" class="form-control" id="headlines" 
                                   placeholder="Enter your main headline" 
                                   value="Sample Product Name under 90 laters" 
                                   maxlength="90" required>
                            <div class="char-counter"><span id="headlineCounter">0</span>/90</div>
                            <div class="invalid-feedback">Please provide a headline for your ad.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="descriptions" class="form-label">Descriptions</label>
                            <textarea class="form-control" id="descriptions" rows="3" 
                                      placeholder="Describe your products or services" 
                                      maxlength="180" required>Describe your products or services.</textarea>
                            <div class="char-counter"><span id="descriptionCounter">0</span>/180</div>
                            <div class="invalid-feedback">Please provide a description for your ad.</div>
                        </div>
                    
                        
                        <div class="mb-3">
                            <label for="keywordThemes" class="form-label">Keyword themes</label>
                            <input type="text" class="form-control" id="keywordThemes" 
                                   placeholder="Enter keywords related to your business" 
                                   value="marktforschungsinstitut, solaranlagenservice">
                            <small class="text-muted">Separate keywords with commas</small>
                        </div>
                    </div>
                    
                    <!-- Images Section -->
                    <div class="form-section">

                        <div class="mb-3">
                            <x-PanelPulse::file-upload label="Product Image" name="file" multiple=false />
                        </div>
                    </div>
                    
                   
                </form>
            </div>
        </div>
        
        <!-- Ad Preview -->
        <div class="col-lg-5">
            <div class="ad-preview-container">
                <div class="ad-preview-header">
                    <div class="ad-preview-title">Ad Previews</div>
                    <div class="ad-preview-controls">
                        <button class="btn btn-sm rounded-3 px-3 mt-3 preview-type-btn active" data-preview="newArrival">
                            New Arrival
                        </button>
                        <button class="btn btn-sm rounded-3 px-3 mt-3 preview-type-btn" data-preview="sponsored">
                            Sponsored
                        </button>
                        <button class="btn btn-sm rounded-3 px-3 mt-3 preview-type-btn" data-preview="horizontal">
                            Horizontal
                        </button>
                    </div>
                </div>
                
                <!-- New Arrival Preview -->
                <div class="ad-preview-box preview-section active" id="newArrivalPreview">
                    <div class="new-arrival-card">
                        <div class="new-arrival-label">Product Grid</div>
                        <div class="product-image-container">
                            <img id="previewImage1" src="" alt="Product" class="product-image">
                        </div>
                        <div class="product-title" id="newArrivalTitle"></div>
                        <div class="product-price">
                            <span class="price-amount">€<span id="newArrivalPrice">17.24</span></span>
                            <span class="price-tax">19% MwSt. Inklusive</span>
                        </div>
                    </div>
                </div>

                <!-- Sponsored Preview -->
                <div class="ad-preview-box preview-section" id="sponsoredPreview">
                    <div class="sponsored-card">
                        <div class="product-image-container">
                            <img id="previewImage2" src="" alt="Product" class="product-image">
                        </div>
                        <div class="product-title" id="sponsoredTitle"></div>
                        <div class="product-price">
                            <span class="price-amount">€<span id="sponsoredPrice">48.34</span></span>
                        </div>
                        <div class="sponsored-label">Gesponsert</div>
                    </div>
                </div>

                <!-- Horizontal Preview -->
                <div class="ad-preview-box preview-section" id="horizontalPreview">
                    <div class="horizontal-card">
                        <div class="product-image-container">
                            <img id="previewImage3" src="" alt="Product" class="product-image">
                        </div>
                        <div class="product-info">
                            <div class="product-title" id="horizontalTitle"></div>
                            <div class="product-rating">
                                <span class="rating-score">4.4</span>
                                <span class="rating-stars">★★★★½</span>
                                <span class="rating-count">(1,314)</span>
                            </div>
                            <div class="product-price">
                                <span class="discount">-93%</span>
                                <span class="current-price">€<span id="horizontalPrice">343.00</span></span>
                                <span class="original-price">€4,999.00</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                

                <button type="button" class="btn btn-sm rounded-3 btn-dark px-3 mt-3" id="previewButton">
                    Continue<i class="fas fa-arrow-right ms-2"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize character counters
        updateCharCounter('headlines', 'headlineCounter');
        updateCharCounter('descriptions', 'descriptionCounter');
        
        // Add event listeners for real-time character counting and preview updates
        document.getElementById('headlines').addEventListener('input', function() {
            updateCharCounter('headlines', 'headlineCounter');
            updatePreviews();
        });
        
        document.getElementById('descriptions').addEventListener('input', function() {
            updateCharCounter('descriptions', 'descriptionCounter');
            updatePreviews();
        });
        
        // Preview type switching
        document.querySelectorAll('.preview-type-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons and previews
                document.querySelectorAll('.preview-type-btn').forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.preview-section').forEach(preview => preview.classList.remove('active'));
                
                // Add active class to clicked button and corresponding preview
                this.classList.add('active');
                const previewType = this.getAttribute('data-preview');
                document.getElementById(previewType + 'Preview').classList.add('active');
            });
        });

        // Initial preview update
        updatePreviews();
    });
    
    function updateCharCounter(inputId, counterId) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(counterId);
        const maxLength = input.getAttribute('maxlength');
        const currentLength = input.value.length;
        
        counter.textContent = currentLength;
        
        if (currentLength > maxLength * 0.9) {
            counter.style.color = '#ea4335';
        } else {
            counter.style.color = '#5f6368';
        }
    }
    
    function updatePreviews() {
        const headlines = document.getElementById('headlines').value;
        const descriptions = document.getElementById('descriptions').value;
        
        // Update titles in all previews
        document.getElementById('newArrivalTitle').textContent = headlines;
        document.getElementById('sponsoredTitle').textContent = headlines;
        document.getElementById('horizontalTitle').textContent = headlines;
        
        // Update descriptions where applicable
        // Note: In this case, descriptions might not be used in all preview types
        // based on the provided designs
    }
    
    // Form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
@endsection