@extends('layouts.app')

@section('page_title', 'Daily Journals - ' . config('app.name'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Daily Journals</h2>
            <p class="text-muted mb-0">Financial journal entries across your stores.</p>
        </div>
        <a href="{{ route('dashboard.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Dashboard
        </a>
    </div>

    <div class="card premium-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard.journals') }}" class="form-row">
                <div class="col-md-4 mb-2">
                    <label class="small text-muted">From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
                </div>
                <div class="col-md-4 mb-2">
                    <label class="small text-muted">To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
                </div>
                <div class="col-md-4 mb-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary mr-2">Apply</button>
                    <a href="{{ route('dashboard.journals') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card premium-card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Store</th>
                        <th>Brand</th>
                        <th class="text-right">Revenue</th>
                        <th class="text-right">Food</th>
                        <th class="text-right">Labor</th>
                        <th class="text-right">Profit</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($journals as $journal)
                        @php
                            $displayDate = $journal->date;
                            if ($journal->date instanceof \Illuminate\Support\Carbon) {
                                $displayDate = $journal->date->format('Y-m-d');
                            } elseif (!empty($journal->date)) {
                                try {
                                    $displayDate = \Illuminate\Support\Carbon::parse($journal->date)->format('Y-m-d');
                                } catch (\Throwable $e) {
                                    $displayDate = (string) $journal->date;
                                }
                            }
                        @endphp
                        <tr>
                            <td>{{ $displayDate }}</td>
                            <td>#{{ $journal->store->number }}</td>
                            <td>{{ $journal->store->brand->name }}</td>
                            <td class="text-right" style="color: #28a745;">${{ number_format($journal->revenue / 100, 2) }}</td>
                            <td class="text-right" style="color: #e74c3c;">${{ number_format($journal->food_cost / 100, 2) }}</td>
                            <td class="text-right" style="color: #f39c12;">${{ number_format($journal->labor_cost / 100, 2) }}</td>
                            <td class="text-right" style="color: #007bff;"><strong>${{ number_format($journal->profit / 100, 2) }}</strong></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No journal entries found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($journals instanceof \Illuminate\Pagination\LengthAwarePaginator && $journals->hasPages())
            <div class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="text-muted small mb-2 mb-md-0">
                    Showing {{ $journals->firstItem() ?? 0 }} to {{ $journals->lastItem() ?? 0 }} of {{ $journals->total() }} results
                </div>
                <div class="journal-pagination">
                    {{ $journals->withQueryString()->onEachSide(1)->links('pagination::bootstrap-4') }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .journal-pagination .pagination {
        margin-bottom: 0;
    }

    .journal-pagination .page-link {
        border-radius: 6px;
        margin: 0 2px;
    }
</style>
@endpush
