<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\FeelingList;
use App\Rules\UniqueFeelingList;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FeelingListController extends Controller
{
    protected function validated($request, $id=null)
    {
        $request->validate([
            'name' => ['required', 'max:20', new UniqueFeelingList($id)],
        ]);
    }

    protected function findFeelingItem($id)
    {
        return FeelingList::findOrFail($id);
    }

    protected function checkTrashed($name)
    {
        return
            FeelingList::withTrashed()
                ->where('name', Str::squish($name))
                ->first() ?? null;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feelingList = FeelingList::select('id','name','status','created_at')->paginate(100);
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
            FeelingList::create([
                'name' => Str::squish($request->name)
            ]);
        }
        return back()->with('success', 'Feeling List Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $feelingItem = $this->findSugarUnit(decrypt($id));
        $feelingItem->update(['status' => !$feelingItem->status]);
        return back()->with('success', 'Feeling Item status changed successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validated($request, $id);
        FeelingList::where('id', $id)->update([
            'name' => Str::squish($request->name)
        ]);
        return back()->with('success', 'Feeling Item Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $feelingItem = $this->findFeelingItem($id);

        if (in_array($feelingItem->name, config('basic.feelingLists'))
//         || BloodSugar::where('feeling_id', $id)->exists()
        ) {
            return back()->with('error', 'This Feeling Item cannot be deleted');
        }

        $feelingItem->delete();
        return back()->with('success', 'This Feeling Item Deleted Successfully');
    }
}
