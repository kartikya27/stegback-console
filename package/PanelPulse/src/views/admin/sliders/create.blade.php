@extends('PanelPulse::admin.layout.header')
@section('title', 'Slider create | ' . env('APP_NAME'))
@section('style')

@endsection

@section('content')
<form action="{{route('slider.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
<div class="container">
    <div class="">
        <div class="d-flex align-items-center">
            <h1 class="heading1"><a class="btn btn-secondary btn-sm px-2 me-2" href="{{route('slider.list')}}" ><i class="fas fs-6 fa-arrow-left"></i></a>Add sliders</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-7">

            <div class="info-cont">

                <div class="col-12 mb-3">
                    <x-PanelPulse::text-input label="Redirection Url" name="link" />
                </div>

                <div class="col-12 mb-3">
                    <x-PanelPulse::file-upload label="Banner Slider" name="banner" />
                </div>
                <div class="col-12 mb-3">
                    <x-PanelPulse::file-upload label="Banner Mobile" name="mobile"/>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="info-cont p-3">
                Visibility
                <div class="custom-control custom-checkbox">
                    <div class="mt-2">
                        <x-PanelPulse::radio-input class="me-2" type="radio" name="visiblity" label="Hidden" value="0" :extraAttributes="['checked' => 'checked']" />
                    </div>
                    <div class="mt-2">
                        <x-PanelPulse::radio-input type="radio" class="me-2" name="visiblity" label="Visible" value="1" />
                    </div>
                </div>
            </div>
            <div class="info-cont p-3">
                Banner Slider
                <div class="custom-control custom-checkbox">
                    <div class="mt-2">
                        <x-PanelPulse::radio-input class="me-2" type="radio" name="type" label="Hero Slider" value="hero-banner" :extraAttributes="['checked' => 'checked']" />
                    </div>
                    <div class="mt-2">
                        <x-PanelPulse::radio-input type="radio" class="me-2" name="type" label="Banner" value="banner" />
                    </div>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-end">
                <a class="btn btn-sm rounded-3 btn-danger bg-danger text-white px-3 me-2" href="{{route('slider.list')}}">Cancel</a>
                <button class="btn btn-sm rounded-3 btn-dark px-3" type="submit">Save</button>
            </div>

        </div>
    </div>


</div>
</form>

@endsection
