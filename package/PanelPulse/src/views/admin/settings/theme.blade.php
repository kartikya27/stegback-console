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
                    <button class="btn btn-secondary" onclick="window.location.href='/admin/settings'"><i
                            class="fas fa-long-arrow-alt-left"></i></button>
                </div>
                <div class="col-md-1 p-0">
                    <table style="width:100%;height:100%">
                        <tr>
                            <td class="align-middle" style="width:100%;height:100%">
                                <h2 class="heading2">Theme Manage</h2>
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
                    <p class="subtext1">Manage how your store looks on frontend. </p>
                </div>
                <div class="col-8">
                    <div class="container info-cont">
                        @foreach ($theme as $theme)
                            <div class="row">
                                <div class="col-4">
                                    <table style="width:100%;height:100%">
                                        <tr>
                                            <td class="align-middle" style="width:100%;height:100%">
                                                <input type="text" value="{{ $theme->value }}" disabled
                                                    class="border-0" />
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-8">
                                    <table style="width:100%;height:100%">
                                        <tr>
                                            <td>{{ $theme['element_name'] }}
                                            </td>
                                            <td class="align-middle text-right" style="width:100%;height:100%">

                                                <button class="btn btn-secondary ml-3"
                                                    onclick="window.location.href='/admin/settings/theme/{{ $theme['id'] }}'">Set
                                                    up</button>
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
