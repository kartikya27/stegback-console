@extends('PanelPulse::admin.layout.header')
@section('title', 'Taxes Edit | ' . env('APP_NAME'))
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
                    <button class="btn btn-secondary" onclick="window.location.href='/admin/settings/taxes'"><i
                            class="fas fa-long-arrow-alt-left"></i></button>
                </div>
                <div class="col-md-1 p-0">
                    <table style="width:100%;height:100%">
                        <tr>
                            <td class="align-middle" style="width:100%;height:100%">
                                <h2 class="heading2">{{ $taxes->country }}</h2>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-4 pt-3">
                    <h3 class="info-cont-heading mb-3">Base taxes</h3>
                    <p class="subtext1">All applicable taxes for {{ $taxes->country }}. These taxes will be used unless
                        overrides.</p>
                </div>
                <div class="col-8">
                    <div class="container info-cont">
                        <h3 class="info-cont-heading">Country Tax</h3>
                        <form class="needs-validation" action="/admin/settings/taxes/{{ $taxes->country }}" method="POST"
                            novalidate>
                            @csrf
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <input type="number" class="form-control priceInput" id="validationCustom01"
                                        name="tax" value="{{ $taxes->tax }}" required />
                                    <i class="fas fa-receipt rupeeIcon"></i>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" name="charge"
                                            @if ($taxes->charge == 'Yes') checked @endif>
                                        <label class="custom-control-label" for="customCheck1">Charge tax on product</label>
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
