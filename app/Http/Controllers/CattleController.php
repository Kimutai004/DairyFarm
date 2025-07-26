<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cattle;

class CattleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cattle = Cattle::where('user_id', auth()->id())
            ->latest()
            ->paginate(12);
            
        return view('cattle.index', compact('cattle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cattle.create');
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
            'tag_number' => 'required|string|unique:cattle,tag_number',
            'name' => 'required|string|max:255',
            'breed' => 'required|in:Holstein,Jersey,Guernsey,Ayrshire,Brown Swiss,Shorthorn,Other',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date|before:today',
            'weight' => 'nullable|numeric|min:0',
            'color' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ]);

        Cattle::create([
            'user_id' => auth()->id(),
            'tag_number' => $request->tag_number,
            'name' => $request->name,
            'breed' => $request->breed,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'weight' => $request->weight,
            'color' => $request->color,
            'notes' => $request->notes,
            'status' => 'active'
        ]);

        return redirect()->route('cattle.index')
            ->with('success', 'Cattle added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cattle = Cattle::where('user_id', auth()->id())
            ->findOrFail($id);
            
        return view('cattle.show', compact('cattle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cattle = Cattle::where('user_id', auth()->id())
            ->findOrFail($id);
            
        return view('cattle.edit', compact('cattle'));
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
        $cattle = Cattle::where('user_id', auth()->id())
            ->findOrFail($id);

        $request->validate([
            'tag_number' => 'required|string|unique:cattle,tag_number,' . $cattle->id,
            'name' => 'required|string|max:255',
            'breed' => 'required|in:Holstein,Jersey,Guernsey,Ayrshire,Brown Swiss,Shorthorn,Other',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date|before:today',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,sold,deceased,dry',
            'color' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ]);

        $cattle->update([
            'tag_number' => $request->tag_number,
            'name' => $request->name,
            'breed' => $request->breed,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'weight' => $request->weight,
            'status' => $request->status,
            'color' => $request->color,
            'notes' => $request->notes
        ]);

        return redirect()->route('cattle.index')
            ->with('success', 'Cattle updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cattle = Cattle::where('user_id', auth()->id())
            ->findOrFail($id);
            
        $cattle->delete();

        return redirect()->route('cattle.index')
            ->with('success', 'Cattle removed successfully!');
    }
}
