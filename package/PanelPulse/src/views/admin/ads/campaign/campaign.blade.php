@extends('PanelPulse::admin.layout.header')
@section('title', 'Sellers | ' . env('APP_NAME'))
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
</style>
@endsection
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-1">
        <h1 class="info-cont-subheading">Campaign</h1>
        <button class="btn btn-sm rounded-3 btn-dark px-3" onclick="window.location.href=''">
            <i class="fas fa-plus me-2"></i>Add Campaign
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
                            <th scope="col">ID</th>
                            <th scope="col">Campaign Name</th>
                            <th scope="col">Total Budget</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Start Date</th>
                            <th scope="col" class="text-center">End Date</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($campaigns as $campaign)
                        <tr>
                            <th scope="row">{{ $campaign->campaign_id }}</th>
                            <td>{{ $campaign->campaign_name }}</td>
                            <td class="text-center">
                                <div class="block3">
                                    @if($campaign->status == '1')
                                        <i class="far fa-circle"></i>Active
                                    @else
                                        <i class="far fa-circle"></i>Inactive
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">{{ (new CommonHelper)->price($campaign->total_budget) }}</td>
                            <td class="text-center">{{ $campaign->start_date }}</td>
                            <td class="text-center">{{ $campaign->end_date }}</td>
                            <td class="text-center">
                            <a href="{{ route('ads.campaigns.seller.auth.ads.show', [$campaign->campaign_id, 'ad-set' => base64_encode($campaign->campaign_name ?? 'default')]) }}" class="btn btn-sm">

                                <i class="bi-file-bar-graph bi"></i>View 
                                </a>
                                <button type="button" class="btn btn-sm" onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-trash"></i>Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        <!-- Add more static rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection