@extends('layouts.app')

@section('page_title', 'Store #' . $store->number . ' - ' . config('app.name'))

@section('content')
<div class="container-fluid">
  
    <div class="row mt-3">
        <div class="col-md-12">
            <a href="{{ route('dashboard.index') }}" class="btn btn-link text-muted">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card shadow border-0" style="border-left: 5px solid {{ $store->brand->color }} !important;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="mb-0">Store #{{ $store->number }}</h3>
                            <p class="text-muted mb-0">
                                {{ $store->address }}<br>
                                {{ $store->city }}, {{ $store->state }} {{ $store->zip_code }}
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <span class="badge" style="background-color: {{ $store->brand->color }}; color: #ffffff; padding: 10px 15px; font-size: 14px;">
                                {{ $store->brand->name }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-left-primary">
                <div class="card-body">
                    <p class="text-uppercase text-muted mb-1" style="font-size: 12px;">Total Revenue (90 Days)</p>
                    <h4 class="mb-0" style="color: #28a745;">
                        ${{ number_format($stats['totalRevenue'] / 100, 2) }}
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-left-success">
                <div class="card-body">
                    <p class="text-uppercase text-muted mb-1" style="font-size: 12px;">Total Profit (90 Days)</p>
                    <h4 class="mb-0" style="color: #007bff;">
                        ${{ number_format($stats['totalProfit'] / 100, 2) }}
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-left-danger">
                <div class="card-body">
                    <p class="text-uppercase text-muted mb-1" style="font-size: 12px;">Food Cost (90 Days)</p>
                    <h4 class="mb-0" style="color: #e74c3c;">
                        ${{ number_format($stats['totalFoodCost'] / 100, 2) }}
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-left-warning">
                <div class="card-body">
                    <p class="text-uppercase text-muted mb-1" style="font-size: 12px;">Labor Cost (90 Days)</p>
                    <h4 class="mb-0" style="color: #f39c12;">
                        ${{ number_format($stats['totalLaborCost'] / 100, 2) }}
                    </h4>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="text-uppercase text-muted mb-1" style="font-size: 12px;">Average Daily Revenue</p>
                    <h4 class="mb-0">
                        ${{ number_format($stats['averageDailyRevenue'] / 100, 2) }}
                    </h4>
                    <small class="text-muted">Based on {{ $stats['daysCount'] }} days</small>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="text-uppercase text-muted mb-1" style="font-size: 12px;">Profit Margin</p>
                    <h4 class="mb-0">
                        {{ $stats['totalRevenue'] > 0 ? number_format(($stats['totalProfit'] / $stats['totalRevenue']) * 100, 1) : '0' }}%
                    </h4>
                    <small class="text-muted">Average profit percentage</small>
                </div>
            </div>
        </div>
    </div>

  
    <div class="row mt-4">
        <div class="col-md-12">
            <form method="POST" action="{{ route('export.store', $store->id) }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-download"></i> Export All Data as CSV
                </button>
            </form>
            <p class="text-muted mt-2">
                <small>
                    <i class="fas fa-info-circle"></i> 
                    The export will be processed as a background job and you will receive an email when it's ready.
                </small>
            </p>
        </div>
    </div>


    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="mb-0">Recent Financial Data (Last 90 Days)</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Date</th>
                                <th class="text-right">Revenue</th>
                                <th class="text-right">Food Cost</th>
                                <th class="text-right">Labor Cost</th>
                                <th class="text-right">Profit</th>
                                <th class="text-right">Profit %</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($journals as $journal)
                                <tr>
                                    <td>{{ $journal->date->format('M d, Y') }}</td>
                                    <td class="text-right" style="color: #28a745;">
                                        ${{ number_format($journal->revenue / 100, 2) }}
                                    </td>
                                    <td class="text-right" style="color: #e74c3c;">
                                        ${{ number_format($journal->food_cost / 100, 2) }}
                                    </td>
                                    <td class="text-right" style="color: #f39c12;">
                                        ${{ number_format($journal->labor_cost / 100, 2) }}
                                    </td>
                                    <td class="text-right" style="color: #007bff;">
                                        <strong>${{ number_format($journal->profit / 100, 2) }}</strong>
                                    </td>
                                    <td class="text-right">
                                        {{ $journal->revenue > 0 ? number_format(($journal->profit / $journal->revenue) * 100, 1) : '0' }}%
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No financial data available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($journals instanceof \Illuminate\Pagination\LengthAwarePaginator && $journals->hasPages())
                    <div class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <div class="text-muted small mb-2 mb-md-0">
                            Showing {{ $journals->firstItem() ?? 0 }} to {{ $journals->lastItem() ?? 0 }} of {{ $journals->total() }} entries
                        </div>
                        <div>
                            {{ $journals->onEachSide(1)->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .border-left-primary {
        border-left: 4px solid #007bff !important;
    }
    .border-left-success {
        border-left: 4px solid #28a745 !important;
    }
    .border-left-danger {
        border-left: 4px solid #e74c3c !important;
    }
    .border-left-warning {
        border-left: 4px solid #f39c12 !important;
    }
</style>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
