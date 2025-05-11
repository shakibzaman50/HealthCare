<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;
use Illuminate\Http\Request;
use Exception;

class GlobalSettingsController extends Controller
{

    /**
     * Display a listing of the global settings.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $globalSetting = GlobalSetting::where('id', 1)->first();
        if ($globalSetting) {
            return view('global_settings.show', compact('globalSetting'));
        } else {
            return view('global_settings.create');
        }
    }

    /**
     * Show the form for creating a new global setting.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {


        return view('global_settings.create');
    }

    /**
     * Store a new global setting in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);

        GlobalSetting::create($data);

        return redirect()->route('global_settings.global_setting.index')
            ->with('success_message', 'Global Setting was successfully added.');
    }

    /**
     * Display the specified global setting.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $globalSetting = GlobalSetting::findOrFail($id);

        return view('global_settings.show', compact('globalSetting'));
    }

    /**
     * Show the form for editing the specified global setting.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $globalSetting = GlobalSetting::findOrFail($id);


        return view('global_settings.edit', compact('globalSetting'));
    }

    /**
     * Update the specified global setting in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

        $data = $this->getData($request);

        $globalSetting = GlobalSetting::findOrFail($id);
        $globalSetting->update($data);

        return redirect()->route('global_settings.global_setting.index')
            ->with('success_message', 'Global Setting was successfully updated.');
    }

    /**
     * Remove the specified global setting from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $globalSetting = GlobalSetting::findOrFail($id);
            $globalSetting->delete();

            return redirect()->route('global_settings.global_setting.index')
                ->with('success_message', 'Global Setting was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }


    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request 
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            'logo' => ['nullable', 'file'],
            'favicon' => ['nullable', 'file'],
            'site_title' => 'string|min:1|nullable',
            'slogan' => 'string|min:1|nullable',
            'phone' => 'string|min:1|nullable',
            'email' => 'nullable',
            'website' => 'string|min:1|nullable',
            'address' => 'string|min:1|nullable',
            'invoice_note' => 'string|min:1|nullable',
        ];


        $data = $request->validate($rules);

        if ($request->has('custom_delete_logo')) {
            $data['logo'] = null;
        }
        if ($request->hasFile('logo')) {
            $data['logo'] = $this->moveFile($request->file('logo'));
        }
        if ($request->has('custom_delete_favicon')) {
            $data['favicon'] = null;
        }
        if ($request->hasFile('favicon')) {
            $data['favicon'] = $this->moveFile($request->file('favicon'));
        }



        return $data;
    }

    /**
     * Moves the attached file to the server.
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return string
     */
    protected function moveFile($file)
    {
        if (!$file->isValid()) {
            return '';
        }

        $path = config('laravel-code-generator.files_upload_path', 'uploads');
        $saved = $file->store('public/' . $path, config('filesystems.default'));

        return substr($saved, 7);
    }
}
