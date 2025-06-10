@extends('PanelPulse::admin.layout.header')
@section('title', 'Ads Group | ' . env('APP_NAME'))
@section('style')
<style>
    .admin-menu.sellers i {
        color: black;
    }

    .admin-menu1.sellers {
        background-color: #eaeaea;
        border-left: 5px solid black;
        color: black;
    }

    /* Styling for ad group headers */
    .ad-group-header {
        background-color: #eaeaea;
        font-weight: bold;
    }

    /* Indent ads under ad groups */
    .ad-row td {
        padding-left: 20px;
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-1">
        <h5 class="info-cont-subheading">{{ $campaign->campaign_name }} > Ads Group</h5>
        <button class="btn btn-sm rounded-3 btn-dark px-3" onclick="window.location.href=''">
            <i class="fas fa-plus me-2"></i>Create New Ads Group
        </button>
    </div>
    <div class="container info-cont">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pills-all-tab" data-toggle="pill" href="#all" role="tab" 
                   aria-controls="pills-all" aria-selected="true">All</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="pills-all-tab">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Ad Group</th>
                            <th scope="col">Ad Name</th>
                            <th scope="col">Ad Type</th>
                            <th scope="col">Ad URL</th>
                            <th scope="col">Ad Text</th>
                            <th scope="col">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($adgroups as $adgroup)
                            <!-- Ad Group Header -->
                            <tr class="ad-group-header">
                                <td colspan="6">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>
                                            {{ $adgroup->ad_group_name }}
                                            <a href="{{ route('ads.campaigns.seller.auth.ads.create', [$adgroup->ad_group_id]) }}" class="badge bg-light text-dark">+ Create New Ad</a>
                                        </span>
                                        
                                    </div>
                                </td>
                            </tr>

                            <!-- Ads under this Ad Group -->
                            @foreach ($adgroup->ads as $ad)
                                <tr class="ad-row">
                                    <td></td>
                                    <td>{{ $ad->ad_name }}</td>
                                    <td>{{ $ad->ad_type }}</td>
                                    <td>
                                        <a href="{{ $ad->ad_url }}" target="_blank">View Ad</a>
                                    </td>
                                    <td>{{ $ad->ad_text }}</td>
                                    <td>{{ $ad->start_date }}</td>
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
