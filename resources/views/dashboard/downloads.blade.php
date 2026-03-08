@extends('layouts.app')

@section('page_title', 'My Export Downloads - ' . config('app.name'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4" data-animate>
        <div>
            <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 6px;">My Downloads</h1>
            <p class="text-muted mb-0">Recently generated exports for your account.</p>
        </div>
        <a href="{{ route('dashboard.export') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Export
        </a>
    </div>

    <div class="table-container" data-animate>
        <div class="table-header">
            <h3>Export Files</h3>
            <small class="text-muted">{{ $files->count() }} files</small>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th>Size</th>
                        <th>Generated</th>
                        <th>Download</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($files as $file)
                        <tr>
                            <td>{{ $file['name'] }}</td>
                            <td>{{ number_format($file['size'] / 1024, 1) }} KB</td>
                            <td>{{ \Carbon\Carbon::createFromTimestamp($file['last_modified'])->format('Y-m-d H:i') }}</td>
                            <td>
                                <a href="{{ $file['url'] }}" class="btn btn-sm btn-primary" target="_blank" rel="noopener">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No exports found yet. Queue an export first.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
