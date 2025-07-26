<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cattle;
use App\Models\User;
use Illuminate\Http\Request;

class CattleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cattle = Cattle::with('assignedUser')->latest()->paginate(15);
        return view('admin.cattle.index', compact('cattle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $farmers = User::where('role', 'farmer')->get();
        return view('admin.cattle.create', compact('farmers'));
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
            'tag_number' => 'required|unique:cattle',
            'breed' => 'required',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date',
            'weight' => 'nullable|numeric',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|in:active,inactive,sold,deceased'
        ]);

        Cattle::create($request->all());

        return redirect()->route('admin.cattle.index')
                        ->with('success', 'Cattle registered successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cattle = Cattle::with(['assignedUser', 'milkProductions', 'healthRecords', 'breedingRecords'])->findOrFail($id);
        return view('admin.cattle.show', compact('cattle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cattle = Cattle::findOrFail($id);
        $farmers = User::where('role', 'farmer')->get();
        return view('admin.cattle.edit', compact('cattle', 'farmers'));
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
        $cattle = Cattle::findOrFail($id);
        
        $request->validate([
            'tag_number' => 'required|unique:cattle,tag_number,' . $id,
            'breed' => 'required',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date',
            'weight' => 'nullable|numeric',
            'assigned_to' => 'nullable|exists:users,id',
            'status' => 'required|in:active,inactive,sold,deceased'
        ]);

        $cattle->update($request->all());

        return redirect()->route('admin.cattle.index')
                        ->with('success', 'Cattle updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cattle = Cattle::findOrFail($id);
        $cattle->delete();

        return redirect()->route('admin.cattle.index')
                        ->with('success', 'Cattle deleted successfully.');
    }
}
