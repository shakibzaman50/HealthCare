<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\BsRange;
use Illuminate\Http\Request;
use Exception;

class BsRangeController extends Controller
{
    /**
     * Display a listing of the blood sugar ranges.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $bsRanges = BsRange::paginate(25);

        return view('admin.config.bs_range.index', compact('bsRanges'));
    }

    /**
     * Show the form for creating a new blood sugar range.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.config.bs_range.create');
    }

    /**
     * Store a new blood sugar range in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = $this->getData($request);

        BsRange::create($data);

        return redirect()->route('admin.config.bs_range.index')
            ->with('success_message', 'Blood Sugar Range was successfully added.');
    }

    /**
     * Display the specified blood sugar range.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $bsRange = BsRange::findOrFail($id);

        return view('admin.config.bs_range.show', compact('bsRange'));
    }

    /**
     * Show the form for editing the specified blood sugar range.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $bsRange = BsRange::findOrFail($id);

        return view('admin.config.bs_range.edit', compact('bsRange'));
    }

    /**
     * Update the specified blood sugar range in the storage.
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

            $bsRange = BsRange::findOrFail($id);
            $bsRange->update($data);

            return redirect()->route('admin.config.bs_range.index')
                ->with('success_message', 'Blood Sugar Range was successfully updated.');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Remove the specified blood sugar range from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $bsRange = BsRange::findOrFail($id);
            $bsRange->delete();

            return redirect()->route('admin.config.bs_range.index')
                ->with('success_message', 'Blood Sugar Range was successfully deleted.');
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
            'min_value' => 'required|numeric',
            'max_value' => 'required|numeric',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ];

        return $request->validate($rules);
    }
}