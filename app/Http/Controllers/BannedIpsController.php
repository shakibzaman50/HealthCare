<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BannedIp;
use Illuminate\Http\Request;
use Exception;

class BannedIpsController extends Controller
{

    /**
     * Display a listing of the banned ips.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $bannedIps = BannedIp::paginate(25);

        return view('banned_ips.index', compact('bannedIps'));
    }

    /**
     * Show the form for creating a new banned ip.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('banned_ips.create');
    }

    /**
     * Store a new banned ip in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $data = $this->getData($request);
        
        BannedIp::create($data);

        return redirect()->route('banned_ips.banned_ip.index')
            ->with('success_message', 'Banned Ip was successfully added.');
    }

    /**
     * Display the specified banned ip.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $bannedIp = BannedIp::findOrFail($id);

        return view('banned_ips.show', compact('bannedIp'));
    }

    /**
     * Show the form for editing the specified banned ip.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $bannedIp = BannedIp::findOrFail($id);
        

        return view('banned_ips.edit', compact('bannedIp'));
    }

    /**
     * Update the specified banned ip in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        $data = $this->getData($request);
        
        $bannedIp = BannedIp::findOrFail($id);
        $bannedIp->update($data);

        return redirect()->route('banned_ips.banned_ip.index')
            ->with('success_message', 'Banned Ip was successfully updated.');  
    }

    /**
     * Remove the specified banned ip from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $bannedIp = BannedIp::findOrFail($id);
            $bannedIp->delete();

            return redirect()->route('banned_ips.banned_ip.index')
                ->with('success_message', 'Banned Ip was successfully deleted.');
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
                'ip_address' => 'string|min:1|nullable',
            'status' => 'string|min:1|nullable', 
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

}
