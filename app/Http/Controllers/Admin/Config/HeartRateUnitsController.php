<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\HeartRateUnit;
use App\Http\Requests\Config\HeartRateUnitRequest;
use App\Services\Config\HeartRateUnitService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;

class HeartRateUnitsController extends Controller
{
    protected HeartRateUnitService $heartRateUnitService;

    public function __construct(HeartRateUnitService $heartRateUnitService)
    {
        $this->heartRateUnitService = $heartRateUnitService;
    }

    public function index(): View
    {
        $heartRateUnits = HeartRateUnit::paginate(25);
        return view('admin.config.heart_rate_units.index', compact('heartRateUnits'));
    }

    public function create(): View
    {
        return view('admin.config.heart_rate_units.create');
    }

    public function store(HeartRateUnitRequest $request): RedirectResponse
    {
        try {
            $this->heartRateUnitService->create($request->validated());

            return redirect()->route('heart-rate-units.index')
                ->with('success_message', 'Heart Rate Unit was successfully added.');
        } catch (\Exception $e) {
            \Log::error('Create failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
        }
    }

    public function show(int $id): View
    {
        $heartRateUnit = HeartRateUnit::findOrFail($id);
        return view('admin.config.heart_rate_units.show', compact('heartRateUnit'));
    }

    public function edit(int $id): View
    {
        $heartRateUnit = HeartRateUnit::findOrFail($id);
        return view('admin.config.heart_rate_units.edit', compact('heartRateUnit'));
    }

    public function update(int $id, HeartRateUnitRequest $request): RedirectResponse
    {
        try {
            $heartRateUnit = HeartRateUnit::findOrFail($id);
            $this->heartRateUnitService->update($heartRateUnit, $request->validated());

            return redirect()->route('heart-rate-units.index')
                ->with('success_message', 'Heart Rate Unit was successfully updated.');
        } catch (\Exception $e) {
            \Log::error('Create Update: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $heartRateUnit = HeartRateUnit::findOrFail($id);
            $this->heartRateUnitService->delete($heartRateUnit);

            return redirect()->route('heart-rate-units.index')
                ->with('success_message', 'Heart Rate Unit was successfully deleted.');
        } catch (Exception $e) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
