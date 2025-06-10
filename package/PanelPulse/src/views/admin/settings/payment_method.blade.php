@extends('PanelPulse::admin.layout.header')
@section('title', 'Payment Method | ' . env('APP_NAME'))
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
                    <button class="btn btn-secondary" onclick="window.location.href='/admin/settings/payments'"><i
                            class="fas fa-long-arrow-alt-left"></i></button>
                </div>
                <div class="col-md-5 p-0">
                    <table style="width:100%;height:100%">
                        <tr>
                            <td class="align-middle" style="width:100%;height:100%">
                                <h2 class="heading2">Bank Transfer</h2>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#shippingModal">Add new</button>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="container info-cont">
                        <h3 class="info-cont-heading">Available in</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Country</th>
                                    <th scope="col">State</th>
                                    <th scope="col" class="text-center">Payment mode</th>
                                    <th scope="col" class="text-center">Condition</th>
                                    <th scope="col" class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($payments as $payment)
                                    <tr class="table-row1">
                                        <th scope="row" class="align-middle">{{ $payment['country'] }}</th>
                                        <th class="align-middle">{{ $payment['state'] }}</th>
                                        <th class="align-middle text-center">{{ $payment['payment_mode'] }}</th>
                                        <th class="align-middle text-center">
                                            @if ($payment['min_order_value'] == 0)
                                                Below USD {{ $payment['max_order_value'] }}
                                            @elseif($payment['max_order_value'] == 0)
                                                Above USD {{ $payment['min_order_value'] }}
                                            @else
                                                USD {{ $payment['min_order_value'] }} - USD
                                                {{ $payment['max_order_value'] }}
                                            @endif
                                        </th>
                                        <th class="align-middle text-right">
                                            <button class="btn btn-secondary mr-3"
                                                onclick="updatepayment({{ $payment['id'] }}, '{{ $payment['country'] }}', '{{ $payment['state'] }}', {{ $payment['min_order_value'] }}, {{ $payment['max_order_value'] }});">Edit</button>
                                            <button class="btn btn-secondary"
                                                onclick="deletepayment({{ $payment['id'] }})">Delete</button>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="shippingModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add new location for Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" action="{{ route('admin.settings.payments.methods.add') }}"
                        method="POST" novalidate>
                        @csrf
                        <input type="hidden" name="mode" value="Bank" />
                        <div class="form-row mb-3">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">Country</label>
                                <select class="custom-select" id="validationCustom01" name="country" required
                                    onchange="getState(this.options[this.selectedIndex].text)">
                                    <option selected disabled value="">Choose country...</option>
                                    @foreach ((new CommonHelper())->getCountryList() as $key => $country)
                                        <option value="{{ $key . '-' . $country['country_name'] }}">
                                            {{ $country['country_name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="col-md-12 mb-3">
                                <label for="validationState">State</label>
                                <select class="custom-select validationState" id="validationState" name="state" required>
                                    <option selected disabled value="">Choose state</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom02">Min. order value</label>
                                <input type="number" class="form-control" id="validationCustom02" name="min_order_value"
                                    required />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom03">Max. order value</label>
                                <input type="number" class="form-control" id="validationCustom03" name="max_order_value"
                                    required />
                            </div>
                        </div>
                        <p class="text-right"><button type="submit" class="btn btn-primary">Save</button></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="shippingUpdateModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" action="/admin/settings/payments/methods/update" method="POST"
                        novalidate>
                        @csrf
                        <input type="hidden" name="id" id="validationCustom101" />
                        <input type="hidden" name="mode" value="Bank" />


                        <div class="form-row mb-3">
                            <div class="col-md-12 mb-3">
                                <label for="validationState">State</label>
                                <select class="custom-select validationState" id="validationStateUpdate"
                                    name="stateUpdate" required>
                                    <option selected disabled value="">Choose state</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom103">Min. order value</label>
                                <input type="number" class="form-control" id="validationCustom103"
                                    name="min_order_value" required />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom104">Max. order value</label>
                                <input type="number" class="form-control" id="validationCustom104"
                                    name="max_order_value" required />
                            </div>
                        </div>
                        <p class="text-right"><button type="submit" class="btn btn-primary">Save</button></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptContent')
    <script>
        function getState(country) {
            // alert(country);
            $.ajax({
                url: "{{ route('getStateByCountry') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    country: country,
                },
                success: function(response) {

                    $('#validationState option:not(:first)').remove();
                    $.each(response, function(key, value) {
                        $.each(value, function(key2, state) {
                            // console.log(state);
                            $('#validationState').append('<option value="' + state.state_name +
                                '">' +
                                state.state_name +
                                '</option>');
                        });
                    });
                }
            });
        }

        function getStateUpdate(country) {

            $.ajax({
                url: "{{ route('getStateByCountry') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    country: country,
                },
                success: function(response) {

                    $('#validationStateUpdate option:not(:first)').remove();
                    $.each(response, function(key, value) {
                        $.each(value, function(key2, state) {
                            // console.log(state);
                            $('#validationStateUpdate').append('<option value="' + state
                                .state_name +
                                '">' +
                                state.state_name +
                                '</option>');
                        });
                    });
                }
            });
        }


        function updatepayment(id, country, stateUpdate, orderMinValue, orderMaxValue) {
            document.getElementById("validationCustom101").value = id;
            document.getElementById("validationStateUpdate").value = stateUpdate;
            document.getElementById("validationCustom103").value = orderMinValue;
            document.getElementById("validationCustom104").value = orderMaxValue;
            getStateUpdate(country);
            $('#shippingUpdateModal').modal('show');
        }

        function deletepayment(id) {
            $.ajax({
                url: "{{ route('admin.settings.payments.methods.delete') }}",
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        }

        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
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
