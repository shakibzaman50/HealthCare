<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use App\Services\EnrollmentService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use function Symfony\Component\VarDumper\Dumper\esc;

class CustomerController extends Controller
{
    public function list()
    {
        $lists = User::where('type', 3)->paginate(20);
        return view('customer.list', compact('lists'));
    }
    public function profile()
    {
        $user = auth()->guard('customer')->user();
        return view('customer.profile.profile', compact('user'));
    }

    public function enroll_lifetime_package(Request $request)
    {
        $pay = new PaymentService();
        $enroll = new EnrollmentService();
        $user = auth()->guard('customer')->user();
        $payment = $pay->getPayment();
        if ($payment) {
            auth()->guard('customer')->user()->update([
                'lifetime_package' => $request->package
            ]);

            $enroll->commissionCalculator($user, $request->package);

            return redirect()->back()->with('success', 'Enrolled successfully');
        } else {
            return redirect()->back()->with('error', 'Payment error');
        }
    }

    public function subscribers()
    {
        $subscribers = auth()->guard('customer')->user()->subscribers;
        return view('customer.profile.subscribers', compact('subscribers'));
    }


    public function enroll_monthly_package(Request $request)
    {
        $pay = new PaymentService();
        $enroll = new EnrollmentService();
        $user = auth()->guard('customer')->user();
        $payment = $pay->getPayment();
        if ($payment) {
            auth()->guard('customer')->user()->update([
                'monthly_package' => $request->package,
                'monthly_package_enrolled_at' => date('Y-m-d'),
                'monthly_package_status' => 'active'
            ]);

            $enroll->monthlyCommissionCalculator($user, $request->package);

            return redirect()->back()->with('success', 'Enrolled successfully');
        } else {
            return redirect()->back()->with('error', 'Payment error');
        }
    }
}
