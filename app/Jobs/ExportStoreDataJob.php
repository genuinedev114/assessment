<?php

namespace App\Jobs;

use App\Mail\ExportReadyMail;
use App\Models\Store;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ExportStoreDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $store;
    protected $user;


    public function __construct(Store $store, User $user)
    {
        $this->store = $store;
        $this->user = $user;
    }

    public function handle()
    {
        try {
        
            $journals = $this->store->journals()->orderBy('date', 'asc')->get();

       
            $filename = 'export_store_' . $this->store->id . '_u' . $this->user->id . '_' . time() . '.csv';
            $path = 'exports/' . $filename;

    
            $csv = $this->generateCsv($journals);

      
            Storage::disk('public')->put($path, $csv);

  
            try {
                Mail::to($this->user->email)->send(new ExportReadyMail($this->user, $this->store, $filename, $path));
            } catch (Throwable $mailException) {
                Log::warning(
                    'Export generated but notification email failed for store ' . $this->store->id . ': ' . $mailException->getMessage()
                );
            }

        } catch (\Exception $e) {
            \Log::error('Export failed for store ' . $this->store->id . ': ' . $e->getMessage());
            throw $e;
        }
    }


    private function generateCsv($journals)
    {
        $csv = "Date,Revenue,Food Cost,Labor Cost,Profit,Profit Percentage\n";

        foreach ($journals as $journal) {
            $profitPercentage = $journal->revenue > 0 ? ($journal->profit / $journal->revenue) * 100 : 0;
            $csv .= sprintf(
                "%s,\$%.2f,\$%.2f,\$%.2f,\$%.2f,%.1f%%\n",
                $journal->date->format('Y-m-d'),
                $journal->revenue / 100,
                $journal->food_cost / 100,
                $journal->labor_cost / 100,
                $journal->profit / 100,
                $profitPercentage
            );
        }


        $totalRevenue = $journals->sum('revenue');
        $totalFoodCost = $journals->sum('food_cost');
        $totalLaborCost = $journals->sum('labor_cost');
        $totalProfit = $journals->sum('profit');
        $avgProfitPercentage = $totalRevenue > 0 ? ($totalProfit / $totalRevenue) * 100 : 0;

        $csv .= "\n";
        $csv .= sprintf(
            "TOTAL,\$%.2f,\$%.2f,\$%.2f,\$%.2f,%.1f%%\n",
            $totalRevenue / 100,
            $totalFoodCost / 100,
            $totalLaborCost / 100,
            $totalProfit / 100,
            $avgProfitPercentage
        );

        return $csv;
    }
}
