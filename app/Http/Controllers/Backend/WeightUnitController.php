<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\WeightUnit;
use App\Rules\UniqueWeightUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WeightUnitController extends Controller
{
    protected function validated($request, $id=null){
        $request->validate([
            'name' => ['required', 'max:10', new UniqueWeightUnit($id)],
        ]);
    }

    protected function findSugarUnit($id){
        return WeightUnit::findOrFail($id);
    }

    protected function checkTrashed($name){
        return
            WeightUnit::withTrashed()
                ->where('name', Str::squish($name))
                ->first() ?? null;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $weightUnits = WeightUnit::select('id','name','status','created_at')->paginate(100);
        return view('backend.module.weight_unit', compact('weightUnits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validated($request);
        $trashedUnit = $this->checkTrashed($request->name);
        if ($trashedUnit){
            $trashedUnit->restore();
        }
        else{
            WeightUnit::create([
                'name' => Str::squish($request->name)
            ]);
        }
        return back()->with('success', 'Sugar Unit Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $weightUnit = $this->findSugarUnit(decrypt($id));
        $weightUnit->update(['status' => !$weightUnit->status]);
        return back()->with('success', 'Sugar Unit status changed successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validated($request, $id);
        WeightUnit::where('id', $id)->update([
            'name' => Str::squish($request->name)
        ]);
        return back()->with('success', 'Sugar Unit Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $weightUnit = $this->findSugarUnit($id);

        if (in_array($weightUnit->name, config('basic.weightUnits'))
//         || Profile::where('weight_id', $id)->exists()
        ) {
            return back()->with('error', 'This Weight Unit cannot be deleted');
        }

        $weightUnit->delete();
        return back()->with('success', 'Sugar Unit Deleted Successfully');
    }
}
