<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\BsMeasurementType;
use App\Models\BsRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class BsRecordController extends Controller
{
    /**
     * Display a listing of the blood sugar records.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $bsRecords = BsRecord::with(['measurementType', 'user'])->paginate(25);

        return view('admin.config.bs_record.index', compact('bsRecords'));
    }

    /**
     * Show the form for creating a new blood sugar record.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $users = User::select('id', 'name')->get();
        $measurementTypes = BsMeasurementType::select('id', 'name')->get();
        return view('admin.config.bs_record.create', compact('users', 'measurementTypes'));
    }

    /**
     * Store a new blood sugar record in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = $this->getData($request);

        BsRecord::create($data);

        return redirect()->route('admin.config.bs_record.index')
            ->with('success_message', 'Blood Sugar Record was successfully added.');
    }

    /**
     * Display the specified blood sugar record.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $bsRecord = BsRecord::with(['measurementType', 'user'])->findOrFail($id);

        return view('admin.config.bs_record.show', compact('bsRecord'));
    }

    /**
     * Show the form for editing the specified blood sugar record.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $bsRecord = BsRecord::findOrFail($id);

        return view('admin.config.bs_record.edit', compact('bsRecord'));
    }

    /**
     * Update the specified blood sugar record in the storage.
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

            $bsRecord = BsRecord::findOrFail($id);
            $bsRecord->update($data);

            return redirect()->route('admin.config.bs_record.index')
                ->with('success_message', 'Blood Sugar Record was successfully updated.');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Remove the specified blood sugar record from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $bsRecord = BsRecord::findOrFail($id);
            $bsRecord->delete();

            return redirect()->route('admin.config.bs_record.index')
                ->with('success_message', 'Blood Sugar Record was successfully deleted.');
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
            'user_id' => 'required|exists:users,id',
            'measurement_type_id' => 'required|exists:bs_measurement_types,id',
            'value' => 'required|numeric',
            'recorded_at' => 'required|date',
            'notes' => 'nullable|string',
            'status' => 'nullable|boolean',
        ];

        return $request->validate($rules);
    }
}