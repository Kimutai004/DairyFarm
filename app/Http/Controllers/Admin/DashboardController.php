<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cattle;
use App\Models\MilkProduction;
use App\Models\User;
use App\Models\Sale;
use App\Models\HealthRecord;
use App\Models\BreedingRecord;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get dashboard statistics
        $totalCattle = Cattle::count();
        $activeCattle = Cattle::where('status', 'active')->count();
        $totalFarmers = User::where('role', 'farmer')->count();
        
        // Today's milk production
        $todayMilk = MilkProduction::whereDate('production_date', today())->sum('total_milk');
        
        // This month's statistics
        $monthlyMilk = MilkProduction::whereYear('production_date', now()->year)
                                   ->whereMonth('production_date', now()->month)
                                   ->sum('total_milk');
        
        $monthlySales = Sale::whereYear('sale_date', now()->year)
                           ->whereMonth('sale_date', now()->month)
                           ->sum('total_amount');
        
        // Recent activities
        $recentMilkProductions = MilkProduction::with(['cattle', 'user'])
                                              ->latest('production_date')
                                              ->take(5)
                                              ->get();
        
        $recentSales = Sale::with('user')->latest('sale_date')->take(5)->get();
        
        // Upcoming health checkups
        $upcomingCheckups = HealthRecord::where('next_checkup_date', '>=', today())
                                      ->where('next_checkup_date', '<=', today()->addDays(7))
                                      ->with(['cattle', 'user'])
                                      ->get();
        
        // Breeding records due
        $upcomingCalving = BreedingRecord::where('expected_calving_date', '>=', today())
                                       ->where('expected_calving_date', '<=', today()->addDays(30))
                                       ->where('pregnancy_status', 'confirmed')
                                       ->with(['cattle', 'user'])
                                       ->get();
        
        // Monthly milk production chart data
        $monthlyMilkData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyMilkData[] = [
                'month' => $month->format('M Y'),
                'milk' => MilkProduction::whereYear('production_date', $month->year)
                                      ->whereMonth('production_date', $month->month)
                                      ->sum('total_milk')
            ];
        }
        
        return view('admin.dashboard', compact(
            'totalCattle',
            'activeCattle', 
            'totalFarmers',
            'todayMilk',
            'monthlyMilk',
            'monthlySales',
            'recentMilkProductions',
            'recentSales',
            'upcomingCheckups',
            'upcomingCalving',
            'monthlyMilkData'
        ));
    }
}
