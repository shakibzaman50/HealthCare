<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PhysicalCondition;
use Illuminate\Http\Request;
use Exception;

class PhysicalConditionsController extends Controller
{

    /**
     * Display a listing of the physical conditions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $physicalConditions = PhysicalCondition::paginate(25);

        return view('physical_conditions.index', compact('physicalConditions'));
    }

    /**
     * Show the form for creating a new physical condition.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('physical_conditions.create');
    }

    /**
     * Store a new physical condition in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $data = $this->getData($request);
        
        PhysicalCondition::create($data);

        return redirect()->route('physical-conditions.physical-condition.index')
            ->with('success_message', 'Physical Condition was successfully added.');
    }

    /**
     * Display the specified physical condition.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $physicalCondition = PhysicalCondition::findOrFail($id);

        return view('physical_conditions.show', compact('physicalCondition'));
    }

    /**
     * Show the form for editing the specified physical condition.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $physicalCondition = PhysicalCondition::findOrFail($id);
        

        return view('physical_conditions.edit', compact('physicalCondition'));
    }

    /**
     * Update the specified physical condition in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        $data = $this->getData($request);
        
        $physicalCondition = PhysicalCondition::findOrFail($id);
        $physicalCondition->update($data);

        return redirect()->route('physical-conditions.physical-condition.index')
            ->with('success_message', 'Physical Condition was successfully updated.');  
    }

    /**
     * Remove the specified physical condition from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $physicalCondition = PhysicalCondition::findOrFail($id);
            $physicalCondition->delete();

            return redirect()->route('physical-conditions.physical-condition.index')
                ->with('success_message', 'Physical Condition was successfully deleted.');
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