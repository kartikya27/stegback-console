@extends('PanelPulse::admin.layout.header')
@section('title', 'Taxes | ' . env('APP_NAME'))
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
                    <button class="btn btn-secondary" onclick="window.location.href='/admin/settings'"><i
                            class="fas fa-long-arrow-alt-left"></i></button>
                </div>
                <div class="col-md-1 p-0">
                    <table style="width:100%;height:100%">
                        <tr>
                            <td class="align-middle" style="width:100%;height:100%">
                                <h2 class="heading2">Taxes</h2>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-4 pt-3">
                    <h3 class="info-cont-heading mb-3">Tax regions</h3>
                    <p class="subtext1">Manage how your store charges sales tax in your shipping profiles. Check with a tax
                        expert to understand your tax obligations.</p>
                </div>
                <div class="col-8">
                    <div class="container info-cont">
                        @foreach ($taxes as $tax)
                            <div class="row">
                                <div class="col-4">
                                    <table style="width:100%;height:100%">
                                        <tr>
                                            <td class="align-middle" style="width:100%;height:100%">
                                                <img class="tax-flag" src="{{ $tax['flag'] }}" />
                                                {{ $tax['country'] }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-8">
                                    <table style="width:100%;height:100%">
                                        <tr>
                                            <td>{{ $tax['tax'] }}%
                                            </td>
                                            <td class="align-middle text-right" style="width:100%;height:100%">
                                                @if ($tax['charge'] == 'Yes')
                                                    <div class="block2">Collecting</div>
                                                @else
                                                    <div class="block1">Not collecting</div>
                                                @endif
                                                <button class="btn btn-secondary ml-3"
                                                    onclick="window.location.href='/admin/settings/taxes/{{ $tax['country'] }}'">Set
                                                    up</button>

                                                {{-- <button class="btn btn-danger ml-3"
                                                    onclick="window.location.href='/admin/settings/taxes/delete/{{ $tax['id'] }}'">
                                                    <i class="fas fa-trash-alt"></i> --}}
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptContent')
@endsection
