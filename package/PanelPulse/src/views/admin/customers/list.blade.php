@extends('PanelPulse::admin.layout.header')
@section('title', 'Customers | ' . env('APP_NAME'))

@section('style')
<style>
    .table-header {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }

    .search-box {
        max-width: 300px;
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: 500;
        color: #637381;
    }

    .table td {
        vertical-align: middle;
        color: #212B36;
    }

    .customer-name {
        font-weight: 500;
        color: #2E3A47;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .status-active {
        background-color: #E8F5E9;
        color: #2E7D32;
    }

    .status-inactive {
        background-color: #FFEBEE;
        color: #C62828;
    }

    .action-btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Customers</h1>
        <button class="btn btn-sm btn-primary" onclick="window.location.href=''">
            <i class="fas fa-plus me-2"></i>Add Customer
        </button>
    </div>

    <!-- Filters & Search -->
    <div class="card table-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex gap-3">
                <select class="form-select" style="width: 150px;">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <select class="form-select" style="width: 150px;">
                    <option value="">All Countries</option>
                    @foreach($countries ?? [] as $country)
                        <option value="{{ $country }}">{{ $country }}</option>
                    @endforeach
                </select>
            </div>
            <div class="search-box">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Search customers...">
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Customer</th>
                            <th>Contact</th>
                            <th>Location</th>
                            <th>Orders</th>
                            <th>Joined Date</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-3">
                                        @if($customer->avatar)
                                            <img src="{{ $customer->avatar }}" class="rounded-circle" width="40">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-secondary"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="customer-name">{{ $customer->name }}</div>
                                        <div class="text-muted small">{{ $customer->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>{{ $customer->phone ?? 'N/A' }}</div>
                            </td>
                            <td>{{ $customer->country ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $customer->orders_count ?? 0 }}</span>
                            </td>
                            <td>{{ $customer->created_at ? (new CommonHelper())->formatDate($customer->created_at, 'd M Y') : 'N/A' }}</td>
                            <td>
                                <span class="status-badge {{ $customer->status == 'active' ? 'status-active' : 'status-inactive' }}">
                                    {{ ucfirst($customer->status ?? 'inactive') }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.customers', [$customer->id]) }}" class="btn btn-light action-btn">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.customers.delete', [$customer->id]) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light action-btn text-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted">
            Showing {{ $customers->firstItem() ?? 0 }} to {{ $customers->lastItem() ?? 0 }} of {{ $customers->total() ?? 0 }} customers
        </div>
        <div>
            {{ $customers->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Alert auto-hide
    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(function () {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(function (alert) {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500);
            });
        }, 3000);
    });
</script>
@endpush
