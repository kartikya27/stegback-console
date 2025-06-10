@extends('PanelPulse::admin.layout.header')
@section('title', 'Sliders | ' . env('APP_NAME'))
@section('style')
<style>

</style>
@endsection

@section('content')

<div class="container">
    <div class="header header d-flex align-items-center justify-content-between mb-3">
        <h1 class="heading1 mb-0">Sliders</h1>
        <a class="btn btn-sm rounded-3 btn-dark px-3" href="{{route('slider.create')}}">Create new</a>
    </div>
    <div class="container info-cont">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="pills-all-tab">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">File name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date added</th>
                            <th scope="col">Size</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sliders as $slider)

                            @foreach ($slider->desktop_images as $image)
                                <tr class="table-row" >
                                    <td scope="row" class="d-flex align-items-center justify-content-between">
                                        <div class="d-inline-block">
                                            <img src="{{ $image['path'] }}" class="img-fluid rounded-3 me-2" style="object-fit: cover;height: 50px; width: 50px;">
                                            {{ $image['path'] }}
                                        </div>

                                    </td>
                                    <td class="align-middle">
                                        <div class="{{$slider['status'] ? 'block3' : 'block2'}} mr-0" style="font-size: smaller;">
                                            <span class="status-pill {{$slider['status'] ? 'active' : 'draft'}}">
                                                <i class="far fa-circle text-secondary"></i>
                                                {{$slider['status'] ? 'Active' : 'Draft'}}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        {{ $slider->formatted_date }}
                                    </td>
                                    <td class="align-middle">{{ $image['size'] }}</td>
                                    <td class="align-middle"><a href="{{route('slider.delete',[$slider->id])}}" class="btn-secondary btn-sm btn  rounded px-2 small text-danger border-1 border-secondary border-opacity-25" style="font-size: 0.75rem; box-shadow:0.5px 0.5px 0rem 0px rgb(0 0 0 / 43%) !important;">Delete</a></td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
