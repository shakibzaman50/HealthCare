<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PermissionSetting;
use Illuminate\Http\Request;
use Exception;

class PermissionSettingsController extends Controller
{

    /**
     * Display a listing of the permission settings.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $permissionSettings = PermissionSetting::paginate(25);

        return view('permission_settings.index', compact('permissionSettings'));
    }

    /**
     * Show the form for creating a new permission setting.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {


        return view('permission_settings.create');
    }

    /**
     * Store a new permission setting in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $data = $this->getData($request);

        PermissionSetting::create($data);

        return redirect()->route('permission_settings.permission_setting.index')
            ->with('success_message', 'Permission Setting was successfully added.');
    }

    /**
     * Display the specified permission setting.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $permissionSetting = PermissionSetting::findOrFail($id);

        return view('permission_settings.show', compact('permissionSetting'));
    }

    /**
     * Show the form for editing the specified permission setting.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $permissionSetting = PermissionSetting::findOrFail($id);


        return view('permission_settings.edit', compact('permissionSetting'));
    }

    /**
     * Update the specified permission setting in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $data['email_verification'] = $request->email_verification ?? 0;
        $data['two_fa_verification'] = $request->two_fa_verification ?? 0;
        $data['account_creation'] = $request->account_creation ?? 0;
        $data['user_deposit'] = $request->user_deposit ?? 0;
        $data['user_withdraw'] = $request->user_withdraw ?? 0;
        $data['user_send_money'] = $request->user_send_money ?? 0;
        $data['user_referral'] = $request->user_referral ?? 0;
        $data['signup_bonus'] = $request->signup_bonus ?? 0;
        $data['investment_referral_bounty'] = $request->investment_referral_bounty ?? 0;
        $data['deposit_referral_bounty'] = $request->deposit_referral_bounty ?? 0;
        $data['site_animation'] = $request->site_animation ?? 0;
        $data['site_back_to_top'] = $request->site_back_to_top ?? 0;
        $data['development_mode'] = $request->development_mode ?? 0;
        try {
            $permissionSetting = PermissionSetting::findOrFail($id);
            $update = $permissionSetting->update($data);
            info('Update Settings', [$update]);
            return redirect()->route('site_settings-global_settings-index')
                ->with('success_message', 'Permission Setting was successfully updated.');
        } catch (Exception $e) {
            info('Error while permission update', [$e->getMessage()]);
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified permission setting from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $permissionSetting = PermissionSetting::findOrFail($id);
            $permissionSetting->delete();

            return redirect()->route('permission_settings.permission_setting.index')
                ->with('success_message', 'Permission Setting was successfully deleted.');
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
            'email_verification' => 'nullable|boolean',
            'kyc_verification' => 'nullable|boolean',
            'two_fa_verification' => 'nullable|boolean',
            'account_creation' => 'nullable|boolean',
            'user_deposit' => 'nullable|boolean',
            'user_withdraw' => 'nullable|boolean',
            'user_send_money' => 'nullable|boolean',
            'user_referral' => 'nullable|boolean',
            'signup_bonus' => 'nullable|boolean',
            'investment_referral_bounty' => 'nullable|boolean',
            'deposit_referral_bounty' => 'nullable|boolean',
            'site_animation' => 'nullable|boolean',
            'site_back_to_top' => 'nullable|boolean',
            'development_mode' => 'nullable|boolean',
        ];


        $data = $request->validate($rules);




        return $data;
    }
}
