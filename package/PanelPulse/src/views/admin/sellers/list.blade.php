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
@push('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-1">
        <h1 class="heading1">Sellers</h1>
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
                            <th scope="col">Name</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Products</th>
                            <th scope="col" class="text-center">Orders</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sellers as $seller)
                        <tr class="">
                            <th scope="row">{{ $seller->id }}/{{ $seller->company->company_id }}</th>

                            <td>
                                {{ $seller->seller_name }}
                                <br>
                                <span class="text-muted">{{ $seller->company->email }}</span>
                            </td>
                            <td class="text-center">
                                @if ($seller->company->status == '1')
                                    <div class="block3"><i class="far fa-circle"></i>Active</div>
                                    <a href="{{ env('STORE_URL').'/store/'.$seller->seller_name.'/pages/'.base64_encode($seller->id) }}" target="_blank">
                                        <div class="block3">
                                            <i class="far fa-eye"></i>Visit Store
                                        </div>
                                    </a>
                                @else
                                    <div class="block2"><i class="far fa-circle"></i>Inactive</div>
                                @endif
                            </td>
                            <td class="text-center">{{ $seller->products->count() }}</td>
                            <td class="text-center">{{ $seller->orders->count() }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.sellers.show.sales-report', $seller->id) }}" class="btn btn-sm">
                                <i class="bi-file-bar-graph bi"></i>Sales Report 
                                </a>
                                <form action="{{ route('admin.sellers.destroy', $seller->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
           
        </div>
    </div>
</div>
@endsection 