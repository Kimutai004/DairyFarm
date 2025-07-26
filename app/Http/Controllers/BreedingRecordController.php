<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BreedingRecord;
use App\Models\Cattle;

class BreedingRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breedingRecords = BreedingRecord::whereHas('cattle', function($query) {
            $query->where('user_id', auth()->id());
        })->with('cattle')->latest('breeding_date')->paginate(12);

        return view('breeding-records.index', compact('breedingRecords'));
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
        return view('breeding-records.create', compact('cattle'));
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
            'breeding_date' => 'required|date',
            'breeding_method' => 'required|string|max:255',
            'bull_id' => 'nullable|string|max:255',
            'sire_breed' => 'nullable|string|max:255',
            'expected_calving_date' => 'nullable|date|after:breeding_date',
            'actual_calving_date' => 'nullable|date',
            'pregnancy_confirmed' => 'nullable|boolean',
            'pregnancy_check_date' => 'nullable|date|after:breeding_date',
            'notes' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
        ]);

        // Verify cattle belongs to the authenticated user and is female
        $cattle = Cattle::where('id', $request->cattle_id)
                        ->where('user_id', auth()->id())
                        ->where('gender', 'female')
                        ->firstOrFail();

        BreedingRecord::create($request->all());

        return redirect()->route('breeding-records.index')
                        ->with('success', 'Breeding record created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $breedingRecord = BreedingRecord::whereHas('cattle', function($query) {
            $query->where('user_id', auth()->id());
        })->with('cattle')->findOrFail($id);

        return view('breeding-records.show', compact('breedingRecord'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $breedingRecord = BreedingRecord::whereHas('cattle', function($query) {
            $query->where('user_id', auth()->id());
        })->with('cattle')->findOrFail($id);

        $cattle = Cattle::where('user_id', auth()->id())
                       ->where('status', 'active')
                       ->where('gender', 'female')
                       ->get();

        return view('breeding-records.edit', compact('breedingRecord', 'cattle'));
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
        $request->validate([
            'cattle_id' => 'required|exists:cattle,id',
            'breeding_date' => 'required|date',
            'breeding_method' => 'required|string|max:255',
            'bull_id' => 'nullable|string|max:255',
            'sire_breed' => 'nullable|string|max:255',
            'expected_calving_date' => 'nullable|date|after:breeding_date',
            'actual_calving_date' => 'nullable|date',
            'pregnancy_confirmed' => 'nullable|boolean',
            'pregnancy_check_date' => 'nullable|date|after:breeding_date',
            'notes' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
        ]);

        $breedingRecord = BreedingRecord::whereHas('cattle', function($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        // Verify cattle belongs to the authenticated user and is female
        $cattle = Cattle::where('id', $request->cattle_id)
                        ->where('user_id', auth()->id())
                        ->where('gender', 'female')
                        ->firstOrFail();

        $breedingRecord->update($request->all());

        return redirect()->route('breeding-records.index')
                        ->with('success', 'Breeding record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $breedingRecord = BreedingRecord::whereHas('cattle', function($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        $breedingRecord->delete();

        return redirect()->route('breeding-records.index')
                        ->with('success', 'Breeding record deleted successfully.');
    }
}
