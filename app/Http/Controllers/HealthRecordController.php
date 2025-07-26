<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HealthRecord;
use App\Models\Cattle;

class HealthRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $healthRecords = HealthRecord::whereHas('cattle', function($query) {
            $query->where('user_id', auth()->id());
        })->with('cattle')->paginate(12);

        return view('health-records.index', compact('healthRecords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cattle = Cattle::where('user_id', auth()->id())->where('status', 'active')->get();
        return view('health-records.create', compact('cattle'));
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
            'checkup_date' => 'required|date',
            'checkup_type' => 'required|string|max:255',
            'veterinarian' => 'nullable|string|max:255',
            'symptoms' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'medication' => 'nullable|string',
            'next_checkup_date' => 'nullable|date|after:checkup_date',
            'notes' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
        ]);

        // Verify cattle belongs to the authenticated user
        $cattle = Cattle::where('id', $request->cattle_id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        $data = $request->all();
        $data['user_id'] = auth()->id(); // Add the authenticated user's ID

        HealthRecord::create($data);

        return redirect()->route('health-records.index')
                        ->with('success', 'Health record created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $healthRecord = HealthRecord::whereHas('cattle', function($query) {
            $query->where('user_id', auth()->id());
        })->with('cattle')->findOrFail($id);

        return view('health-records.show', compact('healthRecord'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $healthRecord = HealthRecord::whereHas('cattle', function($query) {
            $query->where('user_id', auth()->id());
        })->with('cattle')->findOrFail($id);

        $cattle = Cattle::where('user_id', auth()->id())->where('status', 'active')->get();

        return view('health-records.edit', compact('healthRecord', 'cattle'));
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
            'checkup_date' => 'required|date',
            'checkup_type' => 'required|string|max:255',
            'veterinarian' => 'nullable|string|max:255',
            'symptoms' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
            'medication' => 'nullable|string',
            'next_checkup_date' => 'nullable|date|after:checkup_date',
            'notes' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
        ]);

        $healthRecord = HealthRecord::whereHas('cattle', function($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        // Verify cattle belongs to the authenticated user
        $cattle = Cattle::where('id', $request->cattle_id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        $data = $request->all();
        $data['user_id'] = auth()->id(); // Ensure user_id is set

        $healthRecord->update($data);

        return redirect()->route('health-records.index')
                        ->with('success', 'Health record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $healthRecord = HealthRecord::whereHas('cattle', function($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        $healthRecord->delete();

        return redirect()->route('health-records.index')
                        ->with('success', 'Health record deleted successfully.');
    }
}
