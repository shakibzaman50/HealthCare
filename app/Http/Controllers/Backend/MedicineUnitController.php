<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MedicineUnit;
use App\Rules\UniqueMedicineUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MedicineUnitController extends Controller
{
    protected function validated($request, $id=null){
        $request->validate([
            'name' => ['required', 'max:10', new UniqueMedicineUnit($id)],
        ]);
    }

    protected function findSugarUnit($id){
        return MedicineUnit::findOrFail($id);
    }

    protected function checkTrashed($name){
        return
            MedicineUnit::withTrashed()
                ->where('name', Str::squish($name))
                ->first() ?? null;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicineUnits = MedicineUnit::select('id','name','status','created_at')->paginate(100);
        return view('backend.module.sugar_unit', compact('medicineUnits'));
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
            MedicineUnit::create([
                'name' => Str::squish($request->name)
            ]);
        }
        return back()->with('success', 'Medicine Unit Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $medicineUnit = $this->findSugarUnit(decrypt($id));
        $medicineUnit->update(['status' => !$medicineUnit->status]);
        return back()->with('success', 'Medicine Unit status changed successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validated($request, $id);
        MedicineUnit::where('id', $id)->update([
            'name' => Str::squish($request->name)
        ]);
        return back()->with('success', 'Medicine Unit Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $medicineUnit = $this->findSugarUnit($id);

        if (in_array($medicineUnit->name, config('basic.medicineUnits'))
//         || BloodSugar::where('unit_id', $id)->exists()
        ) {
            return back()->with('error', 'This Medicine Unit cannot be deleted');
        }

        $medicineUnit->delete();
        return back()->with('success', 'Medicine Unit Deleted Successfully');
    }
}
