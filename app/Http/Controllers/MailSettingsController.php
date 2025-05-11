<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MailSetting;
use Illuminate\Http\Request;
use Exception;

class MailSettingsController extends Controller
{

    /**
     * Display a listing of the mail settings.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $default_id = 1;
        $mailSetting = MailSetting::where('id', $default_id)->first();
        if (!$mailSetting) {
            return view('mail_settings.create');
        } else {
            return view('mail_settings.edit', compact('mailSetting'));
        }
    }

    public function mailCheck()
    {
        $default_id = 1;
        $mailSetting = MailSetting::where('id', $default_id)->first();
        if (!$mailSetting) {
            return "Update first mail setting ";
        } else {
            return view('mail_settings.mail-check');
        }
    }

    public function sendMailCheck(Request $request)
    {
        return $request;
    }

    /**
     * Show the form for creating a new mail setting.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {


        return view('mail_settings.create');
    }

    /**
     * Store a new mail setting in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);

        MailSetting::create($data);

        return redirect()->route('mail_settings.mail_setting.index')
            ->with('success_message', 'Mail Setting was successfully added.');
    }

    /**
     * Display the specified mail setting.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $mailSetting = MailSetting::findOrFail($id);

        return view('mail_settings.show', compact('mailSetting'));
    }

    /**
     * Show the form for editing the specified mail setting.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $mailSetting = MailSetting::findOrFail($id);


        return view('mail_settings.edit', compact('mailSetting'));
    }

    /**
     * Update the specified mail setting in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

        $data = $this->getData($request);

        $mailSetting = MailSetting::findOrFail($id);
        $mailSetting->update($data);

        return redirect()->route('mail_settings.mail_setting.index')
            ->with('success_message', 'Mail Setting was successfully updated.');
    }

    /**
     * Remove the specified mail setting from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $mailSetting = MailSetting::findOrFail($id);
            $mailSetting->delete();

            return redirect()->route('mail_settings.mail_setting.index')
                ->with('success_message', 'Mail Setting was successfully deleted.');
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
            'email_from_name' => 'nullable|string|min:0',
            'email_from_address' => 'nullable',
            'mailing_driver' => 'string|min:1|nullable',
            'mail_user_name' => 'string|min:1|nullable',
            'mail_password' => 'nullable',
            'smpt_host' => 'string|min:1|nullable',
            'smpt_port' => 'string|min:1|nullable',
            'smtp_secure' => 'string|min:1|nullable',
        ];


        $data = $request->validate($rules);




        return $data;
    }
}
