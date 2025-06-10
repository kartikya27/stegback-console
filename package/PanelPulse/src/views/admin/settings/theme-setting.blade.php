@extends('PanelPulse::admin.layout.header')
@section('title', 'Theme Setting | ' . env('APP_NAME'))
@section('style')
    <style>
        .admin-menu.settings {
            background-color: #eaeaea;
            border-left: 5px solid black;
            color: black;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="container mb-4">
            <div class="row">
                <div class="col-md-1">
                    <button class="btn btn-secondary" onclick="window.location.href='/admin/settings/theme'"><i
                            class="fas fa-long-arrow-alt-left"></i></button>
                </div>
                <div class="col-md-1 p-0">
                    <table style="width:100%;height:100%">
                        <tr>
                            <td class="align-middle" style="width:100%;height:100%">
                                <h2 class="heading2">{{ $theme->element_name }}</h2>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-4 pt-3">
                    <h3 class="info-cont-heading mb-3">Base theme</h3>
                    <p class="subtext1">All applicable design for {{ $theme->element_name }}. These setting will be used
                        unless overrides.</p>
                </div>
                <div class="col-8">
                    <div class="container info-cont">
                        <h3 class="info-cont-heading">{{ ucfirst($theme->type) }} Value</h3>
                        <form class="needs-validation" action="/admin/settings/theme/{{ $theme->id }}" method="POST"
                            novalidate>
                            @csrf
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <input type="text" class="form-control" id="validationCustom01" name="value"
                                        value="{{ $theme->value }}" required />

                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" name="charge"
                                            @if ($theme->apply == '1') checked @endif>
                                        <label class="custom-control-label" for="customCheck1">Apply over the theme</label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-secondary" type="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptContent')
    <script>
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
