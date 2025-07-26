<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MilkProduction;
use App\Models\Cattle;

class MilkProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $milkProductions = MilkProduction::where('user_id', auth()->id())
            ->with('cattle')
            ->latest('production_date')
            ->paginate(15);
            
        return view('milk-production.index', compact('milkProductions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cattle = Cattle::where('user_id', auth()->id())
            ->where('status', 'active')
            ->where('gender', 'female')
            ->get();
            
        return view('milk-production.create', compact('cattle'));
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
            'production_date' => 'required|date',
            'morning_milk' => 'required|numeric|min:0',
            'evening_milk' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500'
        ]);

        // Ensure the cattle belongs to the authenticated user
        $cattle = Cattle::where('id', $request->cattle_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        MilkProduction::create([
            'user_id' => auth()->id(),
            'cattle_id' => $request->cattle_id,
            'production_date' => $request->production_date,
            'morning_milk' => $request->morning_milk,
            'evening_milk' => $request->evening_milk,
            'total_milk' => $request->morning_milk + $request->evening_milk,
            'notes' => $request->notes
        ]);

        return redirect()->route('milk-production.index')
            ->with('success', 'Milk production record added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $milkProduction = MilkProduction::where('user_id', auth()->id())
            ->with('cattle')
            ->findOrFail($id);
            
        return view('milk-production.show', compact('milkProduction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $milkProduction = MilkProduction::where('user_id', auth()->id())
            ->findOrFail($id);
            
        $cattle = Cattle::where('user_id', auth()->id())
            ->where('status', 'active')
            ->where('gender', 'female')
            ->get();
            
        return view('milk-production.edit', compact('milkProduction', 'cattle'));
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
        $milkProduction = MilkProduction::where('user_id', auth()->id())
            ->findOrFail($id);

        $request->validate([
            'cattle_id' => 'required|exists:cattle,id',
            'production_date' => 'required|date',
            'morning_milk' => 'required|numeric|min:0',
            'evening_milk' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500'
        ]);

        // Ensure the cattle belongs to the authenticated user
        $cattle = Cattle::where('id', $request->cattle_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $milkProduction->update([
            'cattle_id' => $request->cattle_id,
            'production_date' => $request->production_date,
            'morning_milk' => $request->morning_milk,
            'evening_milk' => $request->evening_milk,
            'total_milk' => $request->morning_milk + $request->evening_milk,
            'notes' => $request->notes
        ]);

        return redirect()->route('milk-production.index')
            ->with('success', 'Milk production record updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $milkProduction = MilkProduction::where('user_id', auth()->id())
            ->findOrFail($id);
            
        $milkProduction->delete();

        return redirect()->route('milk-production.index')
            ->with('success', 'Milk production record deleted successfully!');
    }
}
