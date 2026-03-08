@extends('layouts.app')

@section('page_title', 'Stores - ' . config('app.name'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Stores</h2>
            <p class="text-muted mb-0">Browse stores assigned to your account.</p>
        </div>
        <a href="{{ route('dashboard.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Dashboard
        </a>
    </div>

    <div class="card premium-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard.stores') }}" class="form-inline">
                <div class="input-group w-100">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Search by store number, address, or city"
                        style="height:auto;"
                    >
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('dashboard.stores') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card premium-card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Store</th>
                        <th>Brand</th>
                        <th>Location</th>
                        <th class="text-right">Revenue</th>
                        <th class="text-right">Profit</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stores as $store)
                        @php
                            $revenue = $store->journals->sum('revenue');
                            $profit = $store->journals->sum('profit');
                        @endphp
                        <tr>
                            <td><strong>#{{ $store->number }}</strong></td>
                            <td>
                                <span class="badge" style="background: {{ $store->brand->color }}; color: #fff;">
                                    {{ $store->brand->name }}
                                </span>
                            </td>
                            <td>{{ $store->city }}, {{ $store->state }}</td>
                            <td class="text-right" style="color: #28a745;">${{ number_format($revenue / 100, 2) }}</td>
                            <td class="text-right" style="color: #007bff;"><strong>${{ number_format($profit / 100, 2) }}</strong></td>
                            <td class="text-right">
                                <a href="{{ route('dashboard.storeDetail', $store->id) }}" class="btn btn-sm btn-outline-primary">
                                    Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No stores found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($stores instanceof \Illuminate\Pagination\LengthAwarePaginator && $stores->hasPages())
            <div class="card-footer bg-white">
                {{ $stores->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
