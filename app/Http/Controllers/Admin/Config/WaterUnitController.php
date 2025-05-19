<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\Config\WaterUnitRequest;
use App\Models\WaterUnit;
use App\Services\Config\WaterUnitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WaterUnitController extends Controller
{
    protected $waterUnitService;

    public function __construct(WaterUnitService $waterUnitService)
    {
        $this->waterUnitService = $waterUnitService;
    }

    protected function findWaterUnit(int $id)
    {
        return WaterUnit::findOrFail($id);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $waterUnits = WaterUnit::latest()->paginate(25);
        return view('admin.config.water_units.index', compact('waterUnits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.config.water_units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WaterUnitRequest $request)
    {
        try {
            $this->waterUnitService->create($request->validated());
            return redirect()->route('water-units.index')
                ->with('success_message', 'Water Unit was successfully added.');
        } catch (\Exception $e) {
            Log::error('Water Unit Create failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $waterUnit = $this->findWaterUnit($id);
        return view('admin.config.water_units.show', compact('waterUnit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $waterUnit = $this->findWaterUnit($id);
        return view('admin.config.water_units.edit', compact('waterUnit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WaterUnitRequest $request, string $id)
    {
        try {
            $waterUnit = $this->findWaterUnit($id);
            $this->waterUnitService->update($waterUnit, $request->validated());
            return redirect()->route('water-units.index')
                ->with('success_message', 'Water Unit was successfully updated.');
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
            $waterUnit = $this->findWaterUnit($id);
            if (in_array($waterUnit->name, config('basic.waterUnits'))
                // || BloodSugar::where('feeling_id', $id)->exists()
            ) {
                return back()->with('error_message', 'This Water Unit cannot be deleted');
            }
            $this->waterUnitService->delete($waterUnit);

            return redirect()->route('water-units.index')
                ->with('success_message', 'Water Unit was successfully deleted.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
