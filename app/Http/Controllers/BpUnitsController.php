<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BpUnit;
use Illuminate\Http\Request;
use Exception;

class BpUnitsController extends Controller
{

    /**
     * Display a listing of the bp units.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $bpUnits = BpUnit::paginate(25);

        return view('bp_units.index', compact('bpUnits'));
    }

    /**
     * Show the form for creating a new bp unit.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('bp_units.create');
    }

    /**
     * Store a new bp unit in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $data = $this->getData($request);
        
        BpUnit::create($data);

        return redirect()->route('bp-units.bp-unit.index')
            ->with('success_message', 'Bp Unit was successfully added.');
    }

    /**
     * Display the specified bp unit.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $bpUnit = BpUnit::findOrFail($id);

        return view('bp_units.show', compact('bpUnit'));
    }

    /**
     * Show the form for editing the specified bp unit.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $bpUnit = BpUnit::findOrFail($id);
        

        return view('bp_units.edit', compact('bpUnit'));
    }

    /**
     * Update the specified bp unit in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        $data = $this->getData($request);
        
        $bpUnit = BpUnit::findOrFail($id);
        $bpUnit->update($data);

        return redirect()->route('bp-units.bp-unit.index')
            ->with('success_message', 'Bp Unit was successfully updated.');  
    }

    /**
     * Remove the specified bp unit from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $bpUnit = BpUnit::findOrFail($id);
            $bpUnit->delete();

            return redirect()->route('bp-units.bp-unit.index')
                ->with('success_message', 'Bp Unit was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    
    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request 
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
                'name' => 'string|min:1|max:255|nullable',
            'is_active' => 'boolean|nullable', 
        ];

        
        $data = $request->validate($rules);


        $data['is_active'] = $request->has('is_active');


        return $data;
    }

}