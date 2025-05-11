<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\CustomerDashboardService;
use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->guard('customer')->user();
        $customer = new CustomerDashboardService();
        $referral = $customer->generateReferralLink();
//        $r = $customer->calculateCommission();
        $packages = $customer->lifetilePackages();
        $monthlyPackages = $customer->monthlyPackages();
        return view('customer.dashboard',compact('referral','packages','monthlyPackages','user'));
    }

    public function enroll_lifetime_package(Request $request)
    {
        auth()->guard('customer')->user()->update([
            'lifetime_package' => $request->package
        ]);

        return redirect()->back()->with('success', 'Enrolled successfully');
    }

    public function enroll_monthly_package(Request $request)
    {
        auth()->guard('customer')->user()->update([
            'monthly_package' => $request->package
        ]);

        return redirect()->back()->with('success', 'Enrolled successfully');
    }
}
