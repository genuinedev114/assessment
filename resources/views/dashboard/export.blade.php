@extends('layouts.app')

@section('page_title', 'Export Data - ' . config('app.name'))

@section('content')
<div class="container-fluid">
	<div class="d-flex justify-content-between align-items-center mb-4">
		<div>
			<h2 class="mb-1">Export Data</h2>
			<p class="text-muted mb-0">Run exports for a single store or all accessible stores.</p>
		</div>
		<a href="{{ route('dashboard.index') }}" class="btn btn-outline-secondary btn-sm">
			<i class="fas fa-arrow-left"></i> Dashboard
		</a>
	</div>

	<div class="card premium-card mb-4">
		<div class="card-body d-flex justify-content-between align-items-center flex-wrap">
			<div>
				<h6 class="mb-1">Export All Stores</h6>
				<p class="text-muted mb-0">Queue a background export for all stores visible to your user.</p>
			</div>
			<form method="POST" action="{{ route('export.all') }}" class="mt-2 mt-md-0">
				@csrf
				<button type="submit" class="btn btn-primary">
					<i class="fas fa-download"></i> Export All
				</button>
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
						<th class="text-right">Action</th>
					</tr>
				</thead>
				<tbody>
					@forelse($stores as $store)
						<tr>
							<td><strong>#{{ $store->number }}</strong></td>
							<td>
								<span class="badge" style="background: {{ $store->brand->color }}; color: #fff;">
									{{ $store->brand->name }}
								</span>
							</td>
							<td>{{ $store->city }}, {{ $store->state }}</td>
							<td class="text-right">
								<form method="POST" action="{{ route('export.store', $store->id) }}" class="d-inline">
									@csrf
									<button type="submit" class="btn btn-sm btn-outline-primary">
										Export Store
									</button>
								</form>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="4" class="text-center text-muted py-4">No stores available for export.</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
