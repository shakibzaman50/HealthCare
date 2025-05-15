<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HeartRateUnit;
use Illuminate\Http\Request;
use Exception;

class HeartRateUnitsController extends Controller
{

    /**
     * Display a listing of the heart rate units.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $heartRateUnits = HeartRateUnit::paginate(25);

        return view('heart_rate_units.index', compact('heartRateUnits'));
    }

    /**
     * Show the form for creating a new heart rate unit.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('heart_rate_units.create');
    }

    /**
     * Store a new heart rate unit in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $data = $this->getData($request);
        
        HeartRateUnit::create($data);

        return redirect()->route('heart-rate-units.heart-rate-unit.index')
            ->with('success_message', 'Heart Rate Unit was successfully added.');
    }

    /**
     * Display the specified heart rate unit.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $heartRateUnit = HeartRateUnit::findOrFail($id);

        return view('heart_rate_units.show', compact('heartRateUnit'));
    }

    /**
     * Show the form for editing the specified heart rate unit.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $heartRateUnit = HeartRateUnit::findOrFail($id);
        

        return view('heart_rate_units.edit', compact('heartRateUnit'));
    }

    /**
     * Update the specified heart rate unit in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        $data = $this->getData($request);
        
        $heartRateUnit = HeartRateUnit::findOrFail($id);
        $heartRateUnit->update($data);

        return redirect()->route('heart-rate-units.heart-rate-unit.index')
            ->with('success_message', 'Heart Rate Unit was successfully updated.');  
    }

    /**
     * Remove the specified heart rate unit from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $heartRateUnit = HeartRateUnit::findOrFail($id);
            $heartRateUnit->delete();

            return redirect()->route('heart-rate-units.heart-rate-unit.index')
                ->with('success_message', 'Heart Rate Unit was successfully deleted.');
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