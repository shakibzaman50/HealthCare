<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use App\Rules\UniqueEmailAcrossTables;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    use ValidatesRequests;
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('customer.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Decrypt part


        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ref' => ['required'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', new UniqueEmailAcrossTables],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        //        $decryptedString = Crypt::decrypt($request->ref);
        //        $originalData = substr($decryptedString, 4); // Extract the original data
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => 1,
                'type' => 2, // Type 2 is for customer
                'avatar' => 'https://avatar.iran.liara.run/public'
            ]);
            info('User reguster is ', [$user]);
            $customer = Customer::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_id' => $user->id,
                'status' => 1,
                'reference_user' => 1
            ]);

            info('User ', [$customer]);
            event(new Registered($customer));
            // New Email is send to Customer
            Auth::guard('customer')->login($customer); // Login with user table data
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            info('Exception: ' . $e->getMessage());
            dd($e->getMessage());
            return redirect()->back();
        }


        return redirect(route('customer.dashboard', absolute: false));
    }
}
