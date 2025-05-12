<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HeartRateUnit;
use App\Models\HeightUnit;
use App\Rules\UniqueHeartRateUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HeartRateUnitController extends Controller
{
    protected function validated($request, $id=null){
        $request->validate([
            'name' => ['required', 'max:10', new UniqueHeartRateUnit($id)],
        ]);
    }

    protected function findSugarUnit($id)
    {
        return HeartRateUnit::findOrFail($id);
    }

    protected function checkTrashed($name)
    {
        return
            HeartRateUnit::withTrashed()
                ->where('name', Str::squish($name))
                ->first() ?? null;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heartRateUnits = HeartRateUnit::select('id','name','status','created_at')->paginate(100);
        return view('backend.module.heart_rate_unit', compact('heartRateUnits'));
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
            HeartRateUnit::create([
                'name' => Str::squish($request->name)
            ]);
        }
        return back()->with('success', 'Heart Rate Unit Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $heartRateUnit = $this->findSugarUnit(decrypt($id));
        $heartRateUnit->update(['status' => !$heartRateUnit->status]);
        return back()->with('success', 'Sugar Unit status changed successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validated($request, $id);
        HeightUnit::where('id', $id)->update([
            'name' => Str::squish($request->name)
        ]);
        return back()->with('success', 'Heart Rate Unit Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $heartRateUnit = $this->findSugarUnit($id);

        if (in_array($heartRateUnit->name, config('basic.sugarUnits'))
//         || BloodSugar::where('unit_id', $id)->exists()
        ) {
            return back()->with('error', 'This Heart Rate Unit cannot be deleted');
        }

        $heartRateUnit->delete();
        return back()->with('success', 'Heart Rate Unit Deleted Successfully');
    }
}
