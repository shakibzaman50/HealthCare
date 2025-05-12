<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SugarUnit;
use App\Rules\UniqueSugarUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SugarUnitController extends Controller
{
    protected function validated($request, $id=null){
        $request->validate([
            'name' => ['required', 'max:10', new UniqueSugarUnit($id)],
        ]);
    }

    protected function findSugarUnit($id){
        return SugarUnit::findOrFail($id);
    }

    protected function checkTrashed($name){
        return
            SugarUnit::withTrashed()
                ->where('name', Str::squish($name))
                ->first() ?? null;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sugarUnits = SugarUnit::select('id','name','status','created_at')->paginate(100);
        return view('backend.module.sugar_unit', compact('sugarUnits'));
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
            SugarUnit::create([
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
        $sugarUnit = $this->findSugarUnit(decrypt($id));
        $sugarUnit->update(['status' => !$sugarUnit->status]);
        return back()->with('success', 'Sugar Unit status changed successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validated($request, $id);
        SugarUnit::where('id', $id)->update([
            'name' => Str::squish($request->name)
        ]);
        return back()->with('success', 'Sugar Unit Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sugarUnit = $this->findSugarUnit($id);

        if (in_array($sugarUnit->name, config('basic.sugarUnits'))
//         || BloodSugar::where('unit_id', $id)->exists()
        ) {
            return back()->with('error', 'This Sugar Unit cannot be deleted');
        }

        $sugarUnit->delete();
        return back()->with('success', 'Sugar Unit Deleted Successfully');
    }
}
