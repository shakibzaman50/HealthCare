<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\BpUnit;
use App\Http\Requests\Config\BpUnitRequest;
use App\Services\Config\BpUnitService;
use Exception;

class BpUnitsController extends Controller
{
    protected $bpUnitService;

    public function __construct(BpUnitService $bpUnitService)
    {
        $this->bpUnitService = $bpUnitService;
    }

    public function index()
    {
        $bpUnits = BpUnit::paginate(25);
        return view('bp_units.index', compact('bpUnits'));
    }

    public function create()
    {
        return view('bp_units.create');
    }

    public function store(BpUnitRequest $request)
    {
        try {
            $this->bpUnitService->create($request->validated());
            return redirect()->route('bp-units.bp-unit.index')
                ->with('success_message', 'Bp Unit was successfully added.');
        } catch (\Exception $e) {
            \Log::error('Create failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
        }
    }


    public function show($id)
    {
        $bpUnit = BpUnit::findOrFail($id);
        return view('bp_units.show', compact('bpUnit'));
    }

    public function edit($id)
    {
        $bpUnit = BpUnit::findOrFail($id);
        return view('bp_units.edit', compact('bpUnit'));
    }


    public function update(BpUnitRequest $request, $id)
    {
        try {
            $bpUnit = BpUnit::findOrFail($id);
            $this->bpUnitService->update($bpUnit, $request->validated());

            return redirect()->route('bp-units.bp-unit.index')
                ->with('success_message', 'Bp Unit was successfully updated.');
        } catch (\Exception $e) {
            \Log::error('Updated failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
        }
    }

    public function destroy($id)
    {
        try {
            $bpUnit = BpUnit::findOrFail($id);
            $this->bpUnitService->delete($bpUnit);

            return redirect()->route('bp-units.bp-unit.index')
                ->with('success_message', 'Bp Unit was successfully deleted.');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
