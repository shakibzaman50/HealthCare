<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\FellingList;
use App\Rules\UniqueFeelingList;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FellingListController extends Controller
{
    protected function validated($request, $id=null){
        $request->validate([
            'name' => ['required', 'max:20', new UniqueFeelingList($id)],
        ]);
    }

    protected function findSugarUnit($id){
        return FellingList::findOrFail($id);
    }

    protected function checkTrashed($name){
        return
            FellingList::withTrashed()
                ->where('name', Str::squish($name))
                ->first() ?? null;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feelingList = FellingList::select('id','name','status','created_at')->paginate(100);
        return view('backend.module.feeling_list', compact('feelingList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validated($request);
        $trashedFeeling = $this->checkTrashed($request->name);
        if ($trashedFeeling){
            $trashedFeeling->restore();
        }
        else{
            FellingList::create([
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
        $feelingList = $this->findSugarUnit(decrypt($id));
        $feelingList->update(['status' => !$feelingList->status]);
        return back()->with('success', 'Sugar Unit status changed successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validated($request, $id);
        FellingList::where('id', $id)->update([
            'name' => Str::squish($request->name)
        ]);
        return back()->with('success', 'Sugar Unit Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $feelingList = $this->findSugarUnit($id);

        if (in_array($feelingList->name, config('basic.feelingLists'))
//         || BloodSugar::where('feeling_id', $id)->exists()
        ) {
            return back()->with('error', 'This Feeling List cannot be deleted');
        }

        $feelingList->delete();
        return back()->with('success', 'Sugar Unit Deleted Successfully');
    }
}
