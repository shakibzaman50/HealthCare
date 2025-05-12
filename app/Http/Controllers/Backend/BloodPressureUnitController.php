<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BloodPressureUnit;
use App\Rules\UniqueBloodPressureUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BloodPressureUnitController extends Controller
{
    protected function validated($request, $id=null)
    {
        $request->validate([
            'name' => ['required', 'max:10', new UniqueBloodPressureUnit($id)],
        ]);
    }

    protected function findBloodPressureUnit($id)
    {
        return BloodPressureUnit::findOrFail($id);
    }

    protected function checkTrashed($name)
    {
        return
            BloodPressureUnit::withTrashed()
                ->where('name', Str::squish($name))
                ->first() ?? null;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bloodPressureUnits = BloodPressureUnit::select('id','name','status','created_at')->paginate(100);
        return view('backend.module.blood_pressure_unit', compact('bloodPressureUnits'));
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
            BloodPressureUnit::create([
                'name' => Str::squish($request->name)
            ]);
        }
        return back()->with('success', 'Blood Pressure Unit Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bloodPressureUnit = $this->findBloodPressureUnit(decrypt($id));
        $bloodPressureUnit->update(['status' => !$bloodPressureUnit->status]);
        return back()->with('success', 'Blood Pressure Unit status changed successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validated($request, $id);
        BloodPressureUnit::where('id', $id)->update([
            'name' => Str::squish($request->name)
        ]);
        return back()->with('success', 'Blood Pressure Unit Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bloodPressureUnit = $this->findSugarUnit($id);

        if (in_array($bloodPressureUnit->name, config('basic.bloodPressureUnits'))
//         || BloodSugar::where('unit_id', $id)->exists()
        ) {
            return back()->with('error', 'This Blood Pressure Unit cannot be deleted');
        }

        $bloodPressureUnit->delete();
        return back()->with('success', 'Blood Pressure Unit Deleted Successfully');
    }
}
