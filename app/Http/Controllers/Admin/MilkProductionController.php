<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MilkProduction;
use App\Models\Cattle;
use App\Models\User;
use Illuminate\Http\Request;

class MilkProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productions = MilkProduction::with(['cattle', 'user'])
                                   ->latest('production_date')
                                   ->paginate(15);
        
        $todayTotal = MilkProduction::whereDate('production_date', today())->sum('total_milk');
        $weekTotal = MilkProduction::whereBetween('production_date', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_milk');
        $monthTotal = MilkProduction::whereMonth('production_date', now()->month)->sum('total_milk');
        
        return view('admin.milk-production.index', compact('productions', 'todayTotal', 'weekTotal', 'monthTotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cattle = Cattle::where('status', 'active')->where('gender', 'female')->get();
        $farmers = User::where('role', 'farmer')->get();
        return view('admin.milk-production.create', compact('cattle', 'farmers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'cattle_id' => 'required|exists:cattle,id',
            'user_id' => 'required|exists:users,id',
            'production_date' => 'required|date',
            'morning_milk' => 'required|numeric|min:0',
            'evening_milk' => 'required|numeric|min:0',
            'quality_grade' => 'required|in:A,B,C',
            'notes' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['total_milk'] = $data['morning_milk'] + $data['evening_milk'];

        MilkProduction::create($data);

        return redirect()->route('admin.milk-production.index')
                        ->with('success', 'Milk production recorded successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $production = MilkProduction::with(['cattle', 'user'])->findOrFail($id);
        return view('admin.milk-production.show', compact('production'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $production = MilkProduction::findOrFail($id);
        $cattle = Cattle::where('status', 'active')->where('gender', 'female')->get();
        $farmers = User::where('role', 'farmer')->get();
        return view('admin.milk-production.edit', compact('production', 'cattle', 'farmers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $production = MilkProduction::findOrFail($id);
        
        $request->validate([
            'cattle_id' => 'required|exists:cattle,id',
            'user_id' => 'required|exists:users,id',
            'production_date' => 'required|date',
            'morning_milk' => 'required|numeric|min:0',
            'evening_milk' => 'required|numeric|min:0',
            'quality_grade' => 'required|in:A,B,C',
            'notes' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['total_milk'] = $data['morning_milk'] + $data['evening_milk'];

        $production->update($data);

        return redirect()->route('admin.milk-production.index')
                        ->with('success', 'Milk production updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $production = MilkProduction::findOrFail($id);
        $production->delete();

        return redirect()->route('admin.milk-production.index')
                        ->with('success', 'Milk production record deleted successfully.');
    }
}
