<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\Config\MedicineTypeRequest;
use App\Models\MedicineType;
use App\Services\Config\MedicineTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MedicineTypeController extends Controller
{
    protected $medicineTypeService;

    public function __construct(MedicineTypeService $medicineTypeService)
    {
        $this->medicineTypeService = $medicineTypeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $medicineTypes = MedicineType::paginate(25);
      return view('medicine_types.index', compact('medicineTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('medicine_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicineTypeRequest $request)
    {
      try {
        $this->medicineTypeService->create($request->validated());
        return redirect()->route('medicine-types.index')
          ->with('success_message', 'Medicine Type was successfully added.');
      } catch (\Exception $e) {
        Log::error('Medicine Type Create failed: ' . $e->getMessage());
        return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
      }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      $medicineType = MedicineType::findOrFail($id);
      return view('medicine_types.show', compact('medicineType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
      $medicineType = MedicineType::findOrFail($id);
      return view('medicine_types.edit', compact('medicineType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicineTypeRequest $request, string $id)
    {
      try {
        $medicineType = MedicineType::findOrFail($id);
        $this->medicineTypeService->update($medicineType, $request->validated());
        return redirect()->route('medicine-types.index')
          ->with('success_message', 'Medicine Type was successfully updated.');
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
        $medicineType = MedicineType::findOrFail($id);
        $this->medicineTypeService->delete($medicineType);

        return redirect()->route('medicine-types.index')
          ->with('success_message', 'Medicine Type was successfully deleted.');
      } catch (\Exception $e) {
        return back()->withInput()
          ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
      }
    }
}
