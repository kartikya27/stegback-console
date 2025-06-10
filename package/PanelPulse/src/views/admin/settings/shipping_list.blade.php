@extends('PanelPulse::admin.layout.header')
@section('title', 'Manage Shipping Rates | ' . env('APP_NAME'))
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
                    <button class="btn btn-secondary" onclick="window.location.href='/admin/settings/shipping'">
                        <i class="fas fa-long-arrow-alt-left"></i></button>
                </div>
                <div class="col-md-5 p-0">
                    <table style="width:100%;height:100%">
                        <tr>
                            <td class="align-middle" style="width:100%;height:100%">
                                <h2 class="heading2">General profile</h2>
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
                        <h3 class="info-cont-heading">Shipping to</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Country</th>
                                    <th scope="col" class="text-center">State</th>
                                    <th scope="col" class="text-center">Shipping Class Name</th>
                                    <th scope="col" class="text-center">Cost</th>

                                    <th scope="col" class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shippings as $shipping)
                                    <tr class="table-row1">
                                        <th scope="row" class="align-middle">{{ $shipping['country_name'] }}</th>
                                        <th class="align-middle text-center">{{ $shipping['state'] }}</th>
                                        <th class="align-middle text-center">{{ $shipping['shipping_class']['name'] }}</th>
                                        <th class="align-middle text-center">
                                            @if ($shipping['cost'] > 0)
                                                USD {{ $shipping['cost'] }}
                                            @else
                                                Free
                                            @endif
                                        </th>

                                        <th>
                                            {{-- <button class="btn btn-secondary mr-3"
                                                onclick="updateshipping({{ $shipping['id'] }}, '{{ $shipping['state'] }}', '{{ $shipping['name'] }}', {{ $shipping['cost'] }}, {{ $shipping['min_order_value'] }}, {{ $shipping['max_order_value'] }});">Edit</button> --}}
                                            <button class="btn btn-secondary"
                                                onclick="deleteshipping({{ $shipping['id'] }})">Delete</button>
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
                    <h5 class="modal-title" id="staticBackdropLabel">Add new shipping information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" action="/admin/settings/shipping/add-country" method="POST" novalidate>

                        @csrf
                        <input type="hidden" name="shipping_id" value="{{ $shipping_class }}" />
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
                                <label for="validationCustom02">Shipping Cost</label>
                                <input type="number" class="form-control" id="validationCustom02" name="cost"
                                    required />
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

        function deleteshipping(id) {
            $.ajax({
                url: '/admin/settings/shipping/country/delete',
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

        function updateshipping(id, state, name, cost, orderMinValue, orderMaxValue) {
            document.getElementById("validationCustom101").value = id;
            document.getElementById("validationCustom102").value = state;
            document.getElementById("validationCustom103").value = name;
            document.getElementById("validationCustom104").value = cost;
            document.getElementById("validationCustom105").value = orderMinValue;
            document.getElementById("validationCustom106").value = orderMaxValue;

            $('#shippingUpdateModal').modal('show');
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
