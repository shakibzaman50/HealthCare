<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\PhysicalCondition;
use App\Http\Requests\Config\PhysicalConditionRequest;
use App\Services\Config\PhysicalConditionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;

class PhysicalConditionsController extends Controller
{
    protected PhysicalConditionService $physicalConditionService;

    public function __construct(PhysicalConditionService $physicalConditionService)
    {
        $this->physicalConditionService = $physicalConditionService;
    }

    public function index(): View
    {
        $physicalConditions = PhysicalCondition::paginate(25);
        return view('admin.config.physical_conditions.index', compact('physicalConditions'));
    }

    public function create(): View
    {
        return view('admin.config.physical_conditions.create');
    }

    public function store(PhysicalConditionRequest $request): RedirectResponse
    {
        try {
            $this->physicalConditionService->create($request->validated());

            return redirect()->route('physical-conditions.index')
                ->with('success_message', 'Physical Condition was successfully added.');
        } catch (\Exception $e) {
            \Log::error('Create failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
        }
    }

    public function show(int $id): View
    {
        $physicalCondition = PhysicalCondition::findOrFail($id);
        return view('admin.config.physical_conditions.show', compact('physicalCondition'));
    }

    public function edit(int $id): View
    {
        $physicalCondition = PhysicalCondition::findOrFail($id);
        return view('admin.config.physical_conditions.edit', compact('physicalCondition'));
    }

    public function update(int $id, PhysicalConditionRequest $request): RedirectResponse
    {
        try {
            $physicalCondition = PhysicalCondition::findOrFail($id);
            $this->physicalConditionService->update($physicalCondition, $request->validated());

            return redirect()->route('physical-conditions.index')
                ->with('success_message', 'Physical Condition was successfully updated.');
        } catch (\Exception $e) {
            \Log::error('Update failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong.']);
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $physicalCondition = PhysicalCondition::findOrFail($id);
            $this->physicalConditionService->delete($physicalCondition);

            return redirect()->route('physical-conditions.index')
                ->with('success_message', 'Physical Condition was successfully deleted.');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}