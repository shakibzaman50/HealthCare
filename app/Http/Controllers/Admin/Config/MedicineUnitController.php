<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\Config\MedicineUnitRequest;
use App\Models\MedicineUnit;
use App\Services\Config\MedicineUnitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MedicineUnitController extends Controller
{
    protected $medicineUnitService;

    public function __construct(MedicineUnitService $medicineUnitService)
    {
        $this->medicineUnitService = $medicineUnitService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicineUnits = MedicineUnit::paginate(25);
        return view('medicine_units.index', compact('medicineUnits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medicine_units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicineUnitRequest $request)
    {
      try {
          $this->medicineUnitService->create($request->validated());
          return redirect()->route('medicine-units.index')
            ->with('success_message', 'Medicine Unit was successfully added.');
      } catch (\Exception $e) {
          Log::error('Medicine Unit Create failed: ' . $e->getMessage());
          return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
      }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $medicineUnit = MedicineUnit::findOrFail($id);
        return view('medicine_units.show', compact('medicineUnit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $medicineUnit = MedicineUnit::findOrFail($id);
        return view('medicine_units.edit', compact('medicineUnit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicineUnitRequest $request, string $id)
    {
        try {
            $medicineUnit = MedicineUnit::findOrFail($id);
            $this->medicineUnitService->update($medicineUnit, $request->validated());
            return redirect()->route('medicine-units.index')
              ->with('success_message', 'Medicine Unit was successfully updated.');
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
            $medicineUnit = MedicineUnit::findOrFail($id);
            $this->medicineUnitService->delete($medicineUnit);

            return redirect()->route('medicine-units.index')
              ->with('success_message', 'Medicine Unit was successfully deleted.');
        } catch (\Exception $e) {
            return back()->withInput()
               ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
