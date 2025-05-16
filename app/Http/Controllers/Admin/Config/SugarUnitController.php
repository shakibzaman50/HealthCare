<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\Config\SugarUnitRequest;
use App\Models\SugarUnit;
use App\Rules\UniqueSugarUnit;
use App\Services\Config\SugarUnitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SugarUnitController extends Controller
{
    protected $sugarUnitService;
    public function __construct(SugarUnitService $sugarUnitService)
    {
        $this->sugarUnitService = $sugarUnitService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sugarUnits = SugarUnit::paginate(25);
        return view('sugar_units.index', compact('sugarUnits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('sugar_units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SugarUnitRequest $request)
    {
        try {
            $this->sugarUnitService->create($request->validated());
            return redirect()->route('sugar-units.index')
                ->with('success_message', 'Sugar Unit was successfully added.');
        } catch (\Exception $e) {
            Log::error('Sugar Unit Create failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sugarUnit = SugarUnit::findOrFail($id);
        return view('sugar_units.show', compact('sugarUnit'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sugarUnit = SugarUnit::findOrFail($id);
        return view('sugar_units.edit', compact('sugarUnit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SugarUnitRequest $request, string $id)
    {
        try {
            $sugarUnit = SugarUnit::findOrFail($id);
            $this->sugarUnitService->update($sugarUnit, $request->validated());
            return redirect()->route('sugar-units.index')
              ->with('success_message', 'Sugar Unit was successfully updated.');
        } catch (\Exception $e) {
            Log::error('Updated failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $sugarUnit = SugarUnit::findOrFail($id);
            $this->sugarUnitService->delete($sugarUnit);

            return redirect()->route('sugar-units.index')
                ->with('success_message', 'Sugar Unit was successfully deleted.');
        } catch (\Exception $e) {
            return back()->withInput()
              ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
