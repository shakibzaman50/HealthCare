<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\Config\WeightUnitRequest;
use App\Models\WeightUnit;
use App\Services\Config\WeightUnitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WeightUnitController extends Controller
{
    protected $weightUnitService;

    public function __construct(WeightUnitService $weightUnitService)
    {
      $this->weightUnitService = $weightUnitService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $weightUnits = WeightUnit::paginate(25);
      return view('weight_units.index', compact('weightUnits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('weight_units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WeightUnitRequest $request)
    {
      try {
        $this->weightUnitService->create($request->validated());
        return redirect()->route('weight-units.index')
          ->with('success_message', 'Weight Unit was successfully added.');
      } catch (\Exception $e) {
        Log::error('Weight Unit Create failed: ' . $e->getMessage());
        return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
      }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $weightUnit = WeightUnit::findOrFail($id);
      return view('weight_units.show', compact('weightUnit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
      $weightUnit = WeightUnit::findOrFail($id);
      return view('weight_units.edit', compact('weightUnit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WeightUnitRequest $request, string $id)
    {
      try {
        $weightUnit = WeightUnit::findOrFail($id);
        $this->weightUnitService->update($weightUnit, $request->validated());
        return redirect()->route('weight-units.index')
          ->with('success_message', 'Weight Unit was successfully updated.');
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
        $weightUnit = WeightUnit::findOrFail($id);
        $this->weightUnitService->delete($weightUnit);

        return redirect()->route('weight-units.index')
          ->with('success_message', 'Weight Unit was successfully deleted.');
      } catch (\Exception $e) {
        return back()->withInput()
          ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
      }
    }
}
