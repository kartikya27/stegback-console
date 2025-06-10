@extends('PanelPulse::admin.layout.header')
@section('title', 'Category | ' . env('APP_NAME'))
@section('style')
    <style>
        .admin-menu.settings {
            background-color: #eaeaea;
            border-left: 5px solid black;
            color: black;
        }
        .select2-container .select2-selection--single {
            height: 38px;
            line-height: 38px;
            border-radius: 5px;
        }
    </style>

    <!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

@endsection
@section('content')

<div class="container">
    <div class="container mb-4">
        <div class="row">
            <div class="col-md-1">
                <button class="btn btn-secondary" onclick="window.location.href='{{route('category.list')}}'"><i
                        class="fas fa-long-arrow-alt-left"></i></button>
            </div>
            <div class="col-md-6 p-0">
                <table style="width:100%;height:100%">
                    <tr>
                        <td class="align-middle" style="width:100%;height:100%">
                            <h2 class="heading2">{{$category['name']}}</h2>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-4 pt-3">
                <h3 class="info-cont-heading mb-3">Total ** Product under this category</h3>
                <p class="subtext1">Total ** child category under this category</p>
                <h3 class="info-cont-heading mb-3">Most Saleable product</h3>
                <p class="subtext1">(Product name)</p>
            </div>
            <div class="col-8">
                <div class="container info-cont">
                    <h3 class="info-cont-heading">Edit - {{$category['name']}}</h3>
                    <form class="needs-validation" action="{{route('category.save',[$category['slug']])}}" method="POST" novalidate enctype="multipart/form-data" >
                        @csrf
                        <div class="row">
                            <x-PanelPulse::text-input type="hidden" name="id" value="{{$category->id}}" />

                            @if($parentCategories)
                                <div class="col-md-6 mb-3">
                                    <x-PanelPulse::text-input  label="Parent Category" name="parent_id" value="{!! $parentCategories->name !!}" :extraAttributes="['readonly' => 'readonly']"/>
                                </div>
                            @endif

                            <div class="col-md-6 mb-3">
                                <x-PanelPulse::text-input label="Name" name="name" value="{!! $category['name'] !!}" required/>
                            </div>

                            <div class="col-md-12 mb-3 justify-content-between d-flex">
                                <x-PanelPulse::checkbox-input label="Header Menu" name="header"  :checked="$category['header'] == 1"/>
                                <x-PanelPulse::checkbox-input label="Slider Menu" name="slider"  :checked="$category['slider'] == 1"/>
                                <x-PanelPulse::checkbox-input label="Side Offcanvas Menu" name="drawer"  :checked="$category['drawer'] == 1"/>
                                <x-PanelPulse::checkbox-input label="Best in Category Menu" name="best_category"  :checked="$category['best_category'] == 1"/>
                                <x-PanelPulse::checkbox-input label="Shop by Department Menu" name="department"  :checked="$category['department'] == 1"/>
                            </div>

                            <div class="col-12 mb-3">
                                <x-PanelPulse::file-upload label="Media (Icons 500 x 500 px)" name="file" multiple=true />
                            </div>

                            <div class="col-12 mb-3">
                                <x-PanelPulse::file-upload label="Banners  ( 1280 x 250 px)" name="banners" multiple=true />
                            </div>


                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="slugCheck" >
                                    <label class="custom-control-label" for="customCheck1"> Want update slug? It may impect seo result.</label>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-secondary" type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="col-8 ">
                <div class="container info-cont">
                    <h3 class="info-cont-heading">Media <span class="fw-normal small">(Thumb Images)</span></h3>
                    <div class="media-container">
                        @if(!empty($category['media']['thumb_images']))
                            @foreach($category['media']['thumb_images'] as $id => $image)
                            <div class="media-item">
                                <img src="{{$image}}" alt="Preview">
                                <a href="{{route('category.delete',[$category['id'] , 'thumb_images', $id ])}}"><button class="remove-preview">&times;</button></a>
                            </div>
                            @endforeach

                        @else
                        No images are found.
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-8 ">
                <div class="container info-cont">
                    <h3 class="info-cont-heading">Media <span class="fw-normal small">(Banner Images)</span></h3>
                    <div class="media-container">
                        @if(!empty($category['media']['banner_images']))
                            @foreach($category['media']['banner_images'] as $id => $image)
                            <div class="media-item">
                                <img src="{{$image}}" alt="Preview">
                                <a href="{{route('category.delete',[$category['id'] , 'banner_images', $id])}}"><button class="remove-preview">&times;</button></a>
                            </div>
                            @endforeach

                        @else
                        No images are found.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scriptContent')
<script>
    let fileInput = document.querySelector(".default-file-input");
    let previewContainer = document.querySelector(".preview-container");
    let form = document.querySelector('form');
    let filesList = [];

    // Handle the file selection via drag-and-drop
    fileInput.addEventListener("change", handleFileInput);

    function handleFileInput(event) {
        const files = Array.from(event.target.files);
        files.forEach((file) => {
            filesList.push(file);
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewItem = document.createElement("div");
                previewItem.classList.add("mt-2", "preview-item");
                previewItem.innerHTML = `
                    <img src="${e.target.result}" alt="Preview">
                    <button class="remove-preview">&times;</button>
                `;

                previewItem.querySelector(".remove-preview").addEventListener("click", () => {
                    filesList = filesList.filter(f => f.name !== file.name);
                    previewItem.remove();
                });

                previewContainer.appendChild(previewItem);
            };
            reader.readAsDataURL(file);
        });
    }

    // Add selected files to the form before submit
    form.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission for handling it in JavaScript

        // Check if files are added
        if (filesList.length > 0) {
            // Add files to hidden input
            let hiddenInput = document.createElement('input');
            hiddenInput.type = 'file';
            hiddenInput.name = 'file[]'; // Ensures array of files
            hiddenInput.multiple = true;

            filesList.forEach(file => {
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                hiddenInput.files = dataTransfer.files;
            });

            // Append the hidden file input to the form
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        } else {
            alert('Please select at least one file!');
        }
    });
</script>

@endsection

