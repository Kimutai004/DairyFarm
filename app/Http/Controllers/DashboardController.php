<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cattle;
use App\Models\MilkProduction;
use App\Models\HealthRecord;
use App\Models\FeedRecord;
use App\Models\BreedingRecord;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with farm statistics
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->id();
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        
        // Cattle Statistics
        $totalCattle = Cattle::where('user_id', $userId)->count();
        $activeCattle = Cattle::where('user_id', $userId)->where('status', 'active')->count();
        $femaleCattle = Cattle::where('user_id', $userId)->where('gender', 'female')->where('status', 'active')->count();
        $maleCattle = Cattle::where('user_id', $userId)->where('gender', 'male')->where('status', 'active')->count();
        
        // Milk Production Statistics
        $todayMilk = MilkProduction::where('user_id', $userId)
            ->whereDate('production_date', $today)
            ->sum('total_milk');
            
        $thisMonthMilk = MilkProduction::where('user_id', $userId)
            ->where('production_date', '>=', $thisMonth)
            ->sum('total_milk');
            
        $averageDailyMilk = MilkProduction::where('user_id', $userId)
            ->where('production_date', '>=', Carbon::now()->subDays(30))
            ->avg('total_milk');
        
        // Health Records Statistics
        $healthRecordsThisMonth = HealthRecord::whereHas('cattle', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('checkup_date', '>=', $thisMonth)->count();
        
        $upcomingCheckups = HealthRecord::whereHas('cattle', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('next_checkup_date', '>=', $today)
          ->where('next_checkup_date', '<=', Carbon::now()->addDays(7))
          ->count();
        
        // Feed Records Statistics
        $feedRecordsToday = FeedRecord::where('user_id', $userId)
            ->whereDate('feeding_date', $today)
            ->count();
            
        $feedCostThisMonth = FeedRecord::where('user_id', $userId)
            ->where('feeding_date', '>=', $thisMonth)
            ->sum('total_cost');
        
        // Breeding Records Statistics
        $pregnantCattle = BreedingRecord::whereHas('cattle', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('pregnancy_confirmed', true)
          ->whereNull('actual_calving_date')
          ->count();
          
        $expectedCalvingsSoon = BreedingRecord::whereHas('cattle', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('expected_calving_date', '>=', $today)
          ->where('expected_calving_date', '<=', Carbon::now()->addDays(30))
          ->whereNull('actual_calving_date')
          ->count();
        
        // Recent Activity
        $recentMilkRecords = MilkProduction::where('user_id', $userId)
            ->with('cattle')
            ->latest('production_date')
            ->take(5)
            ->get();
            
        $recentHealthRecords = HealthRecord::whereHas('cattle', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with('cattle')
          ->latest('checkup_date')
          ->take(5)
          ->get();
        
        return view('home', compact(
            'totalCattle',
            'activeCattle', 
            'femaleCattle',
            'maleCattle',
            'todayMilk',
            'thisMonthMilk',
            'averageDailyMilk',
            'healthRecordsThisMonth',
            'upcomingCheckups',
            'feedRecordsToday',
            'feedCostThisMonth',
            'pregnantCattle',
            'expectedCalvingsSoon',
            'recentMilkRecords',
            'recentHealthRecords'
        ));
    }
}
