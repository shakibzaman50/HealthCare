<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\Config\HeightUnitRequest;
use App\Models\HeightUnit;
use App\Services\Config\HeightUnitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HeightUnitController extends Controller
{
    protected $heightUnitService;

    public function __construct(HeightUnitService $heightUnitService)
    {
        $this->heightUnitService = $heightUnitService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heightUnits = HeightUnit::paginate(25);
        return view('height_units.index', compact('heightUnits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('height_units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HeightUnitRequest $request)
    {
        try {
            $this->heightUnitService->create($request->validated());
            return redirect()->route('height-units.index')
              ->with('success_message', 'Height Unit was successfully added.');
        } catch (\Exception $e) {
            Log::error('Height Unit Create failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $heightUnit = HeightUnit::findOrFail($id);
        return view('height_units.show', compact('heightUnit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $heightUnit = HeightUnit::findOrFail($id);
        return view('height_units.edit', compact('heightUnit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HeightUnitRequest $request, string $id)
    {
        try {
            $heightUnit = HeightUnit::findOrFail($id);
            $this->heightUnitService->update($heightUnit, $request->validated());
            return redirect()->route('height-units.index')
              ->with('success_message', 'Height Unit was successfully updated.');
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
            $heightUnit = HeightUnit::findOrFail($id);
            $this->heightUnitService->delete($heightUnit);

            return redirect()->route('height-units.index')
              ->with('success_message', 'Height Unit was successfully deleted.');
        } catch (\Exception $e) {
            return back()->withInput()
              ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
