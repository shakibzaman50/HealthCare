<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\BsMeasurementType;
use Illuminate\Http\Request;
use Exception;

class BsMeasurementTypeController extends Controller
{
    /**
     * Display a listing of the blood sugar measurement types.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $bsMeasurementTypes = BsMeasurementType::paginate(25);

        return view('admin.config.bs_measurement_type.index', compact('bsMeasurementTypes'));
    }

    /**
     * Show the form for creating a new blood sugar measurement type.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.config.bs_measurement_type.create');
    }

    /**
     * Store a new blood sugar measurement type in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = $this->getData($request);

        BsMeasurementType::create($data);

        return redirect()->route('admin.config.bs_measurement_type.index')
            ->with('success_message', 'Blood Sugar Measurement Type was successfully added.');
    }

    /**
     * Display the specified blood sugar measurement type.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $bsMeasurementType = BsMeasurementType::findOrFail($id);

        return view('admin.config.bs_measurement_type.show', compact('bsMeasurementType'));
    }

    /**
     * Show the form for editing the specified blood sugar measurement type.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $bsMeasurementType = BsMeasurementType::findOrFail($id);

        return view('admin.config.bs_measurement_type.edit', compact('bsMeasurementType'));
    }

    /**
     * Update the specified blood sugar measurement type in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {
            $data = $this->getData($request);

            $bsMeasurementType = BsMeasurementType::findOrFail($id);
            $bsMeasurementType->update($data);

            return redirect()->route('admin.config.bs_measurement_type.index')
                ->with('success_message', 'Blood Sugar Measurement Type was successfully updated.');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Remove the specified blood sugar measurement type from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $bsMeasurementType = BsMeasurementType::findOrFail($id);
            $bsMeasurementType->delete();

            return redirect()->route('admin.config.bs_measurement_type.index')
                ->with('success_message', 'Blood Sugar Measurement Type was successfully deleted.');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request $request 
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ];

        return $request->validate($rules);
    }
}