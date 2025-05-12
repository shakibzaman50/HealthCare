<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HeightUnit;
use App\Rules\UniqueHeightUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HeightUnitController extends Controller
{
    protected function validated($request, $id=null)
    {
        $request->validate([
            'name' => ['required', 'max:10', new UniqueHeightUnit($id)],
        ]);
    }

    protected function findSugarUnit($id)
    {
        return HeightUnit::findOrFail($id);
    }

    protected function checkTrashed($name)
    {
        return
            HeightUnit::withTrashed()
                ->where('name', Str::squish($name))
                ->first() ?? null;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heightUnits = HeightUnit::select('id', 'name', 'status', 'created_at')->paginate(100);
        return view('backend.module.height_unit', compact('heightUnits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validated($request);
        $trashedUnit = $this->checkTrashed($request->name);
        if ($trashedUnit) {
            $trashedUnit->restore();
        } else {
            HeightUnit::create([
                'name' => Str::squish($request->name)
            ]);
        }
        return back()->with('success', 'Height Unit Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $heightUnit = $this->findSugarUnit(decrypt($id));
        $heightUnit->update(['status' => !$heightUnit->status]);
        return back()->with('success', 'Height Unit status changed successfully');
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
        return back()->with('success', 'Height Unit Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $heightUnit = $this->findSugarUnit($id);

        if (in_array($heightUnit->name, config('basic.sugarUnits'))
//         || BloodSugar::where('unit_id', $id)->exists()
        ) {
            return back()->with('error', 'This Height Unit cannot be deleted');
        }

        $heightUnit->delete();
        return back()->with('success', 'Height Unit Deleted Successfully');
    }
}
