<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeedRecord;
use App\Models\Cattle;

class FeedRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feedRecords = FeedRecord::whereHas('cattle', function($query) {
            $query->where('user_id', auth()->id());
        })->with('cattle')->latest('feeding_date')->paginate(12);

        return view('feed-records.index', compact('feedRecords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cattle = Cattle::where('user_id', auth()->id())->where('status', 'active')->get();
        return view('feed-records.create', compact('cattle'));
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
            'feeding_date' => 'required|date',
            'feed_type' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'cost_per_unit' => 'nullable|numeric|min:0',
            'total_cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Verify cattle belongs to the authenticated user
        $cattle = Cattle::where('id', $request->cattle_id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        // Calculate total cost if not provided
        $totalCost = $request->total_cost;
        if (!$totalCost && $request->cost_per_unit && $request->quantity) {
            $totalCost = $request->cost_per_unit * $request->quantity;
        }

        $data = $request->all();
        $data['total_cost'] = $totalCost;

        FeedRecord::create($data);

        return redirect()->route('feed-records.index')
                        ->with('success', 'Feed record created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $feedRecord = FeedRecord::whereHas('cattle', function($query) {
            $query->where('user_id', auth()->id());
        })->with('cattle')->findOrFail($id);

        return view('feed-records.show', compact('feedRecord'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $feedRecord = FeedRecord::whereHas('cattle', function($query) {
            $query->where('user_id', auth()->id());
        })->with('cattle')->findOrFail($id);

        $cattle = Cattle::where('user_id', auth()->id())->where('status', 'active')->get();

        return view('feed-records.edit', compact('feedRecord', 'cattle'));
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
            'feeding_date' => 'required|date',
            'feed_type' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'cost_per_unit' => 'nullable|numeric|min:0',
            'total_cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $feedRecord = FeedRecord::whereHas('cattle', function($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        // Verify cattle belongs to the authenticated user
        $cattle = Cattle::where('id', $request->cattle_id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        // Calculate total cost if not provided
        $totalCost = $request->total_cost;
        if (!$totalCost && $request->cost_per_unit && $request->quantity) {
            $totalCost = $request->cost_per_unit * $request->quantity;
        }

        $data = $request->all();
        $data['total_cost'] = $totalCost;

        $feedRecord->update($data);

        return redirect()->route('feed-records.index')
                        ->with('success', 'Feed record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feedRecord = FeedRecord::whereHas('cattle', function($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        $feedRecord->delete();

        return redirect()->route('feed-records.index')
                        ->with('success', 'Feed record deleted successfully.');
    }
}
