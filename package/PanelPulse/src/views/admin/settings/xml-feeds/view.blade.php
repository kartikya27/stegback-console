@extends('PanelPulse::admin.layout.header')
@section('title', 'XML Feeds | ' . env('APP_NAME'))
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
                    <button class="btn btn-secondary" onclick="window.location.href='/admin/products/list'"><i
                            class="fas fa-long-arrow-alt-left"></i></button>
                </div>
                <div class="col-md-6 p-0">
                    <table style="width:100%;height:100%">
                        <tr>
                            <td class="align-middle" style="width:100%;height:100%">
                                <h2 class="heading2">Product XML Feeds</h2>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-4 pt-3">
                    <h3 class="info-cont-heading mb-3">XML Feeds</h3>
                    <p class="subtext1">Also known as “product data feed” or simply “data feed,” a product feed is essentially a CSV, TXT, XML, or JSON file that holds the product data that marketplaces, search engines, and social commerce platforms utilize to display product listings.</p>
                    @if($feedReports->count() > 0)
                    <p><strong>The Last Feed report genrated on
                        <b>{{$feedReports->first()->formatted_date}}</b>
                    </strong></p>
                    @endif

                    <button class="btn btn-secondary ml-3" onclick="window.location.href='{{ route('admin.products.genrateNewXml') }}'">
                        Generate New Report
                    </button>

                </div>
                <div class="col-8">
                    <div class="container info-cont">
                            @if($feedReports->count() > 0)
                            @foreach($feedReports as $report)
                            <div class="row">
                                <div class="col-4">
                                    <table style="width:100%;height:100%">
                                        <tr>
                                            <td class="align-middle" style="width:100%;height:100%">
                                                <img class="tax-flag" src="" />
                                                    {{ $report->value }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-8">
                                    <table style="width:100%;height:100%">
                                        <tr>
                                            <td class="align-middle text-end" style="width:100%;height:100%">
                                                
                                                <div class="block2">{{$report->formatted_date}}</div>

                                                <button class="btn btn-secondary ml-3" 
                                                        data-url="{{ $report->value }}" 
                                                        onclick="copyToClipboard(this)">
                                                    Copy URL
                                                </button>

                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            @endforeach
                            @else
                            <p class="text-center">No reports found.</p>
                            @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function copyToClipboard(button) {
        // Get the URL from the data-url attribute
        var url = button.getAttribute('data-url');
        
        // Create a temporary input element
        var tempInput = document.createElement("input");
        document.body.appendChild(tempInput);
        tempInput.value = url;
        
        // Select and copy the text
        tempInput.select();
        document.execCommand("copy");
        
        // Remove the temporary input element
        document.body.removeChild(tempInput);
        
        // Optionally, you can show a notification to indicate the URL has been copied
        // alert("URL copied to clipboard!");
    }
</script>


@endsection