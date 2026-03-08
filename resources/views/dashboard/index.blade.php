@extends('layouts.app')

@section('page_title', 'Dashboard - ' . config('app.name'))

@section('content')
<div class="container-fluid">
    <!-- Welcome Header -->
    <div class="d-flex justify-content-between align-items-start mb-4" data-animate>
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: var(--ink-0); margin-bottom: 8px;">
                Welcome, {{ auth()->user()->name }}.
            </h1>
            <p class="text-muted" style="font-size: 15px; margin-bottom: 0;">
                Here's what's happening with your franchise today.
            </p>
        </div>
    </div>

    <!-- Brand Tabs -->
    <div class="mb-4" data-animate>
        <div class="d-flex flex-wrap" style="border-bottom: 2px solid var(--line); padding-bottom: 8px;">
            <a href="#" class="tab {{ !$currentBrand ? 'active' : '' }}" 
               style="padding: 12px 4px; margin-right: 28px; color: var(--ink-1); text-decoration: none; border-bottom: 3px solid transparent; font-weight: 600; transition: all 0.2s;">
                Dashboard
            </a>
            <a href="{{ route('dashboard.stores') }}" class="tab" 
               style="padding: 12px 4px; margin-right: 28px; color: var(--ink-1); text-decoration: none; border-bottom: 3px solid transparent; font-weight: 600; transition: all 0.2s;">
                Stores
            </a>
            <a href="{{ route('dashboard.journals') }}" class="tab" 
               style="padding: 12px 4px; color: var(--ink-1); text-decoration: none; border-bottom: 3px solid transparent; font-weight: 600; transition: all 0.2s;">
                Daily Journals
            </a>
        </div>
    </div>

    <!-- Brand Selection Pills -->
    @if($brands->count() > 0)
    <div class="row mb-4" data-animate>
        <div class="col-md-12">
            <div class="card premium-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-muted mb-0" style="font-size: 12px; font-weight: 700; letter-spacing: 0.5px;">
                            Brand Context
                        </h6>
                        <small class="text-muted">{{ $brands->count() }} brand(s) available</small>
                    </div>
                    <div class="brand-pills">
                        @foreach ($brands as $brand)
                            <form method="POST" action="{{ route('dashboard.switchBrand', $brand->id) }}" class="brand-pill">
                                @csrf
                                <button type="submit"
                                    class="btn {{ $brand->id === $currentBrand?->id ? 'active' : '' }}" 
                                    style="background-color: {{ $brand->color }}; color: white; border-color: {{ $brand->color }};">
                                    <i class="fas fa-{{ $brand->id === $currentBrand?->id ? 'check-circle' : 'circle' }}"></i>
                                    {{ $brand->name }}
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Statistics Cards -->
    @php
        $totalStores = $stores->count();
        $totalRevenue = $stores->sum(function($store) {
            return $store->journals->sum('revenue');
        });
        $totalProfit = $stores->sum(function($store) {
            return $store->journals->sum('profit');
        });
        $avgRevenue = $totalStores > 0 ? $totalRevenue / $totalStores : 0;
    @endphp

    <div class="stats-grid" data-animate>
        <div class="stat-card blue">
            <div class="stat-card-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="stat-card-label">Total Stores</div>
            <div class="stat-card-value">{{ number_format($totalStores) }}</div>
            <div class="stat-card-subtext">{{ $currentBrand ? 'For ' . $currentBrand->name : 'Across all brands' }}</div>
        </div>

        <div class="stat-card purple">
            <div class="stat-card-icon">
                <i class="fas fa-chart-pie"></i>
            </div>
            <div class="stat-card-label">Total Revenue</div>
            <div class="stat-card-value">${{ number_format($totalRevenue / 100, 0) }}</div>
            <div class="stat-card-subtext">Lifetime earnings</div>
        </div>

        <div class="stat-card green">
            <div class="stat-card-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-card-label">Total Profit</div>
            <div class="stat-card-value">${{ number_format($totalProfit / 100, 0) }}</div>
            <div class="stat-card-subtext">Net earnings</div>
        </div>

        <div class="stat-card orange">
            <div class="stat-card-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-card-label">Avg Per Store</div>
            <div class="stat-card-value">${{ number_format($avgRevenue / 100, 0) }}</div>
            <div class="stat-card-subtext">Average revenue</div>
        </div>
    </div>

    <!-- Current Brand Indicator -->
    @if ($currentBrand)
        <div class="row mb-4" data-animate>
            <div class="col-md-12">
                <div class="card premium-card border-0" style="border-left: 5px solid {{ $currentBrand->color }} !important;">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="mr-3" style="width: 48px; height: 48px; background-color: {{ $currentBrand->color }}; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-store" style="color: white; font-size: 24px;"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0" style="font-weight: 700;">{{ $currentBrand->name }}</h5>
                                    <small class="text-muted">{{ $stores->count() }} store(s) in this brand</small>
                                </div>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm" onclick="window.location.href='{{ route('dashboard.export') }}'">
                                <i class="fas fa-download"></i> Export Financial Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Stores Header -->
    @if($stores->count() > 0)
    <div class="d-flex justify-content-between align-items-center mb-3" data-animate>
        <h4 style="font-weight: 700; margin-bottom: 0;">My Stores</h4>
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="search" class="form-control" placeholder="Search stores..." id="storeSearch" name="store_filter_query" autocomplete="off" spellcheck="false" readonly>
        </div>
    </div>
    @endif

    <!-- Stores Grid -->
    <div class="row store-grid">
        @forelse ($stores as $store)
            <div class="col-md-6 col-lg-4 mb-4" data-animate>
                <div class="card premium-card tilt-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="store-brand-icon mr-2" style="background-color: {{ $store->brand->color }}; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <span style="color: white; font-size: 14px; font-weight: 700;">
                                            {{ substr($store->brand->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <h5 class="card-title mb-0" style="font-weight: 700; font-size: 18px;">
                                        {{ $store->number }}
                                    </h5>
                                </div>
                                <p class="text-muted mb-0" style="font-size: 13px;">
                                    {{ $store->address }}<br>
                                    {{ $store->city }}, {{ $store->state }} {{ $store->zip_code }}
                                </p>
                            </div>
                            <span class="badge store-brand-badge" style="background-color: {{ $store->brand->color }};">
                                {{ substr($store->brand->name, 0, 3) }}
                            </span>
                        </div>

                        <div class="border-top pt-3 mt-3">
                            <div class="row">
                                <div class="col-6">
                                    <div class="text-center">
                                        <p class="text-muted mb-1" style="font-size: 11px; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Revenue</p>
                                        <h5 class="mb-0" style="color: var(--success); font-weight: 800; font-size: 20px;">
                                            ${{ number_format($store->journals->sum('revenue') / 100, 0) }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <p class="text-muted mb-1" style="font-size: 11px; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Profit</p>
                                        <h5 class="mb-0" style="color: var(--info); font-weight: 800; font-size: 20px;">
                                            ${{ number_format($store->journals->sum('profit') / 100, 0) }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-top mt-3 pt-3">
                            <a href="{{ route('dashboard.storeDetail', $store->id) }}" class="btn btn-primary btn-sm btn-block mb-2">
                                <i class="fas fa-chart-bar"></i> View Details
                            </a>
                            <form method="POST" action="{{ route('export.store', $store->id) }}" style="display: inline; width: 100%;">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary btn-sm btn-block">
                                    <i class="fas fa-download"></i> Export Data
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="alert alert-info" data-animate>
                    <i class="fas fa-info-circle"></i>
                    <div>
                        <strong>No stores available</strong>  
                        <p class="mb-0">{{ $currentBrand ? 'No stores found for ' . $currentBrand->name . '.' : 'Please select a brand to view your stores.' }}</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
const storeSearch = document.getElementById('storeSearch');

if (storeSearch) {

    storeSearch.value = '';
    storeSearch.addEventListener('focus', function() {
        this.removeAttribute('readonly');
        this.value = '';
    });

    storeSearch.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const storeCards = document.querySelectorAll('.store-grid > div');

        storeCards.forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
}

document.querySelectorAll('.tab').forEach(tab => {
    tab.addEventListener('mouseenter', function() {
        this.style.color = 'var(--ink-0)';
        this.style.borderBottomColor = 'var(--sidebar-bg)';
    });

    tab.addEventListener('mouseleave', function() {
        if (!this.classList.contains('active')) {
            this.style.color = 'var(--ink-1)';
            this.style.borderBottomColor = 'transparent';
        }
    });
});

document.querySelector('.tab.active')?.setAttribute(
    'style',
    'padding: 12px 4px; color: var(--sidebar-bg); text-decoration: none; border-bottom: 3px solid var(--sidebar-bg); font-weight: 700; transition: all 0.2s;'
);
</script>
@endpush
@endsection
