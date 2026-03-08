<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Store;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $user = auth()->user();
        
   
        $brands = $user->brands()->get();

        if (!$user->current_brand_id && $brands->count() > 0) {
            $user->update(['current_brand_id' => $brands->first()->id]);
        }

        $currentBrand = $user->currentBrand;

        $stores = [];
        if ($currentBrand) {
            $stores = $user->stores()
                ->where('brand_id', $currentBrand->id)
                ->with('brand')
                ->get();
        }

        return view('dashboard.index', [
            'brands' => $brands,
            'currentBrand' => $currentBrand,
            'stores' => $stores,
        ]);
    }


    public function switchBrand(Brand $brand)
    {
        $user = auth()->user();


        if (!$user->brands()->where('brands.id', $brand->id)->exists()) {
            return redirect()->back()->with('error', 'You do not have access to this brand.');
        }

        $user->update(['current_brand_id' => $brand->id]);

        return redirect()->route('dashboard.index')->with('success', "Switched to {$brand->name}");
    }

    public function storeDetail(Store $store)
    {
        $user = auth()->user();


        if (!$user->stores()->where('store_id', $store->id)->exists()) {
            return redirect()->route('dashboard.index')->with('error', 'You do not have access to this store.');
        }

        $journalsQuery = $store->journals()->orderBy('date', 'desc');

   
        $statsJournals = (clone $journalsQuery)
            ->limit(90)
            ->get();

        $journals = $journalsQuery->paginate(30);


        $totalRevenue = $statsJournals->sum('revenue');
        $totalProfit = $statsJournals->sum('profit');
        $totalFoodCost = $statsJournals->sum('food_cost');
        $totalLaborCost = $statsJournals->sum('labor_cost');
        $averageDailyRevenue = $statsJournals->count() > 0 ? $totalRevenue / $statsJournals->count() : 0;

        return view('dashboard.store-detail', [
            'store' => $store,
            'journals' => $journals,
            'stats' => [
                'totalRevenue' => $totalRevenue,
                'totalProfit' => $totalProfit,
                'totalFoodCost' => $totalFoodCost,
                'totalLaborCost' => $totalLaborCost,
                'averageDailyRevenue' => $averageDailyRevenue,
                'daysCount' => $statsJournals->count(),
            ],
        ]);
    }


    public function stores(Request $request)
    {
        $user = auth()->user();
        $brands = $user->brands()->get();
        $currentBrand = $user->currentBrand;

        $query = $user->stores()->with(['brand', 'journals']);

        if ($currentBrand) {
            $query->where('brand_id', $currentBrand->id);
        }


        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('number', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $stores = $query->paginate(12);

        return view('dashboard.stores', [
            'stores' => $stores,
            'brands' => $brands,
            'currentBrand' => $currentBrand,
        ]);
    }


    public function journals(Request $request)
    {
        $user = auth()->user();
        $brands = $user->brands()->get();
        $currentBrand = $user->currentBrand;

        $query = \App\Models\Journal::whereIn('store_id', $user->stores()->pluck('stores.id'))
            ->with('store.brand')
            ->orderBy('date', 'desc');

        if ($currentBrand) {
            $query->whereHas('store', function($q) use ($currentBrand) {
                $q->where('brand_id', $currentBrand->id);
            });
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->where('date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->where('date', '<=', $request->date_to);
        }

        $journals = $query->paginate(30);

        return view('dashboard.journals', [
            'journals' => $journals,
            'brands' => $brands,
            'currentBrand' => $currentBrand,
        ]);
    }

    /**
     * Show export page.
     */
    public function export()
    {
        $user = auth()->user();
        $brands = $user->brands()->get();
        $currentBrand = $user->currentBrand;
        $stores = $user->stores()->with('brand')->get();

        return view('dashboard.export', [
            'brands' => $brands,
            'currentBrand' => $currentBrand,
            'stores' => $stores,
        ]);
    }

    /**
     * Show analytics dashboard.
     */
    public function analytics()
    {
        $user = auth()->user();
        $brands = $user->brands()->get();
        $currentBrand = $user->currentBrand;

        $stores = $user->stores();
        if ($currentBrand) {
            $stores = $stores->where('brand_id', $currentBrand->id);
        }
        $stores = $stores->with(['brand', 'journals'])->get();

        // Calculate aggregate statistics
        $totalRevenue = 0;
        $totalProfit = 0;
        $totalStores = $stores->count();

        foreach ($stores as $store) {
            $totalRevenue += $store->journals->sum('revenue');
            $totalProfit += $store->journals->sum('profit');
        }

        return view('dashboard.analytics', [
            'brands' => $brands,
            'currentBrand' => $currentBrand,
            'stores' => $stores,
            'totalRevenue' => $totalRevenue,
            'totalProfit' => $totalProfit,
            'totalStores' => $totalStores,
        ]);
    }
}
