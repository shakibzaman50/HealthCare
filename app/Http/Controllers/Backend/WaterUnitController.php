<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\WaterUnit;
use App\Rules\UniqueWaterUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WaterUnitController extends Controller
{
    protected function validated($request, $id=null){
        $request->validate([
            'name' => ['required', 'max:10', new UniqueWaterUnit($id)],
        ]);
    }

    protected function findSugarUnit($id){
        return WaterUnit::findOrFail($id);
    }

    protected function checkTrashed($name){
        return
            WaterUnit::withTrashed()
                ->where('name', Str::squish($name))
                ->first() ?? null;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $waterUnits = WaterUnit::select('id','name','status','created_at')->paginate(100);
        return view('backend.module.water_unit', compact('waterUnits'));
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
            WaterUnit::create([
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
        $waterUnit = $this->findSugarUnit(decrypt($id));
        $waterUnit->update(['status' => !$waterUnit->status]);
        return back()->with('success', 'Sugar Unit status changed successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validated($request, $id);
        WaterUnit::where('id', $id)->update([
            'name' => Str::squish($request->name)
        ]);
        return back()->with('success', 'Sugar Unit Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $waterUnit = $this->findSugarUnit($id);

        if (in_array($waterUnit->name, config('basic.waterUnits'))
//         || BloodSugar::where('unit_id', $id)->exists()
        ) {
            return back()->with('error', 'This Water Unit cannot be deleted');
        }

        $waterUnit->delete();
        return back()->with('success', 'Sugar Unit Deleted Successfully');
    }
}
