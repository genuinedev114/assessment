<?php

namespace App\Http\Controllers;

use App\Jobs\ExportStoreDataJob;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store(Store $store)
    {
        $user = auth()->user();

  
        if (!$user->stores()->where('store_id', $store->id)->exists()) {
            return redirect()->route('dashboard.index')->with('error', 'You do not have access to this store.');
        }

    
        ExportStoreDataJob::dispatch($store, $user);

        return redirect()->back()->with('success', 'Your export has been queued. Check Downloads for the file. Email notification is sent when mail is configured.');
    }


    public function all(Request $request)
    {
        $user = auth()->user();
        $stores = $user->stores()->get();

        if ($stores->isEmpty()) {
            return redirect()->route('dashboard.export')->with('error', 'No stores available for export.');
        }

        foreach ($stores as $store) {
            ExportStoreDataJob::dispatch($store, $user);
        }

        return redirect()->route('dashboard.export')->with('success', 'Exports queued for ' . $stores->count() . ' store(s). Check Downloads for generated files.');
    }

    public function downloads()
    {
        $user = auth()->user();
        $allFiles = Storage::disk('public')->files('exports');

        $files = collect($allFiles)
            ->filter(function ($path) use ($user) {
                return str_contains($path, '_u' . $user->id . '_');
            })
            ->map(function ($path) {
                $name = basename($path);

                return [
                    'name' => $name,
                    'size' => Storage::disk('public')->size($path),
                    'last_modified' => Storage::disk('public')->lastModified($path),
                    'url' => route('export.download.file', ['filename' => $name]),
                ];
            })
            ->sortByDesc('last_modified')
            ->values();

        return view('dashboard.downloads', compact('files'));
    }

  
    public function download(string $filename)
    {
        $user = auth()->user();

        if (!str_contains($filename, '_u' . $user->id . '_')) {
            abort(403);
        }

        $path = 'exports/' . basename($filename);

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return Storage::disk('public')->download($path, basename($filename));
    }
}
