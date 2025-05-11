<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    use ValidatesRequests;
    /**
     * @param Request $request
     * @return \Illuminate\Container\Container|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed|object
     */
    public function index(Request $request)
    {
        $countries = Country::select('id', 'name')->where('is_active', 1)->get();

        return view('admin.customer.index', compact('countries'));
    }

    public function datatable(Request $request)
    {
        $customers = Customer::select(['id', 'name', 'email', 'balance', 'status', 'ip_address','lifetime_package','monthly_package_status']);
        if ($request->name) {
            $customers = $customers->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->email) {
            $customers = $customers->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->country) {
            $customers = $customers->where('country_id', 'like', '%' . $request->country . '%');
        }
        if ($request->city) {
            $customers = $customers->where('city', 'like', '%' . $request->city . '%');
        }
        if ($request->ip) {
            $customers = $customers->where('ip_address', 'like', '%' . $request->ip . '%');
        }
        return DataTables::of($customers)
          ->addColumn('status',function ($customer){
            if ($customer->status == 1){
              return "<span class='badge bg-label-primary me-1'>Active</span>";
            }
            if ($customer->status == 2){
              return '<span class="badge bg-label-warning me-1">Inactive</span>';
            }
            if ($customer->status == 3){
              return '<span class="badge bg-label-danger me-1">Banned</span>';
            }
          })
          ->addColumn('lifetime_package', function ($customer) {
            if ($customer->lifetime_package == null){
              return '<label class="switch switch-danger">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
            }
            else{
              return '<label class="switch switch-success">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
            }
          })
          ->addColumn('monthly_package_status', function ($customer) {
            return $customer->monthly_package_status == 'active'
              ? '<label class="switch switch-success">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>
                            <span class="switch-label"></span>
                          </label>'
              : '<label class="switch switch-danger">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
          })
          ->addColumn('actions', function ($customer) {
              $viewButton = '<a href="' . route('manage-member-customers.show', $customer->id) . '" class="btn btn-xs btn-primary">View</a>';
              $editButton = '<a href="' . route('manage-member-customers.edit', $customer->id) . '" class="btn btn-xs btn-warning">Edit</a>';
              $deleteButton = '<button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete(' . $customer->id . ')">Delete</button>';

              return $viewButton . ' ' . $editButton . ' ' . $deleteButton;
          })
          ->rawColumns(['actions','status','lifetime_package','monthly_package_status'])
          ->make(true);
    }
    /**
     * @param $id
     * @return \Illuminate\Container\Container|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed|object
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customer.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $countries = Country::where('is_active', 1)->get();
        return view('admin.customer.edit', compact('customer', 'countries'));
    }

    public function update($id, Request $request)
    {
        $customer = Customer::findOrFail($id);

        $data = $request->all();

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $customer->update($data);

        return redirect()->back()->with('success', 'User updated successfully');
    }



    /**
     * @param Request $request
     * @return \Illuminate\Container\Container|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed|object
     */
    public function paid()
    {
        $countries = Country::select('id', 'name')->where('is_active', 1)->get();
        return view('admin.customer.paid', compact('countries'));
    }

    public function paidData(Request $request)
    {
        $customers = Customer::select(['id', 'name', 'email', 'balance', 'status', 'ip_address','lifetime_package','monthly_package_status'])
            ->whereNotNull('lifetime_package');
        if ($request->name) {
            $customers = $customers->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->email) {
            $customers = $customers->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->country) {
            $customers = $customers->where('country_id', 'like', '%' . $request->country . '%');
        }
        if ($request->city) {
            $customers = $customers->where('city', 'like', '%' . $request->city . '%');
        }
        if ($request->ip) {
            $customers = $customers->where('ip_address', 'like', '%' . $request->ip . '%');
        }
        return DataTables::of($customers)
          ->addColumn('status',function ($customer){
            if ($customer->status == 1){
              return "<span class='badge bg-label-primary me-1'>Active</span>";
            }
            if ($customer->status == 2){
              return '<span class="badge bg-label-warning me-1">Inactive</span>';
            }
            if ($customer->status == 3){
              return '<span class="badge bg-label-danger me-1">Banned</span>';
            }
          })
          ->addColumn('lifetime_package', function ($customer) {
            if ($customer->lifetime_package == null){
              return '<label class="switch switch-danger">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
            }
            else{
              return '<label class="switch switch-success">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
            }
          })
          ->addColumn('monthly_package_status', function ($customer) {
            return $customer->monthly_package_status == 'active'
              ? '<label class="switch switch-success">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>
                            <span class="switch-label"></span>
                          </label>'
              : '<label class="switch switch-danger">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
          })
          ->addColumn('actions', function ($customer) {
            $viewButton = '<a href="' . route('manage-member-customers.show', $customer->id) . '" class="btn btn-xs btn-primary">View</a>';
            $editButton = '<a href="' . route('manage-member-customers.edit', $customer->id) . '" class="btn btn-xs btn-warning">Edit</a>';
            $deleteButton = '<button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete(' . $customer->id . ')">Delete</button>';

            return $viewButton . ' ' . $editButton . ' ' . $deleteButton;
          })
          ->rawColumns(['actions','status','lifetime_package','monthly_package_status'])
          ->make(true);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Container\Container|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed|object
     */
    public function monthlySubscriber(Request $request)
    {
        $countries = Country::select('id', 'name')->where('is_active', 1)->get();

        return view('admin.customer.monthlySubscriber', compact('countries'));
    }

    public function monthlySubscriberData(Request $request)
    {
        $customers = Customer::select(['id', 'name', 'email', 'balance', 'status', 'ip_address','lifetime_package','monthly_package_status'])
            ->whereNotNull('monthly_package');
        if ($request->name) {
            $customers = $customers->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->email) {
            $customers = $customers->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->country) {
            $customers = $customers->where('country_id', 'like', '%' . $request->country . '%');
        }
        if ($request->city) {
            $customers = $customers->where('city', 'like', '%' . $request->city . '%');
        }
        if ($request->ip) {
            $customers = $customers->where('ip_address', 'like', '%' . $request->ip . '%');
        }
        return DataTables::of($customers)
          ->addColumn('status',function ($customer){
            if ($customer->status == 1){
              return "<span class='badge bg-label-primary me-1'>Active</span>";
            }
            if ($customer->status == 2){
              return '<span class="badge bg-label-warning me-1">Inactive</span>';
            }
            if ($customer->status == 3){
              return '<span class="badge bg-label-danger me-1">Banned</span>';
            }
          })
          ->addColumn('lifetime_package', function ($customer) {
            if ($customer->lifetime_package == null){
              return '<label class="switch switch-danger">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
            }
            else{
              return '<label class="switch switch-success">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
            }
          })
          ->addColumn('monthly_package_status', function ($customer) {
            return $customer->monthly_package_status == 'active'
              ? '<label class="switch switch-success">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>
                            <span class="switch-label"></span>
                          </label>'
              : '<label class="switch switch-danger">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
          })
          ->addColumn('actions', function ($customer) {
            $viewButton = '<a href="' . route('manage-member-customers.show', $customer->id) . '" class="btn btn-xs btn-primary">View</a>';
            $editButton = '<a href="' . route('manage-member-customers.edit', $customer->id) . '" class="btn btn-xs btn-warning">Edit</a>';
            $deleteButton = '<button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete(' . $customer->id . ')">Delete</button>';

            return $viewButton . ' ' . $editButton . ' ' . $deleteButton;
          })
          ->rawColumns(['actions','status','lifetime_package','monthly_package_status'])
          ->make(true);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Container\Container|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed|object
     */
    public function monthlySubscriptionInactive(Request $request)
    {
        $countries = Country::select('id', 'name')->where('is_active', 1)->get();

        return view('admin.customer.monthlySubscriptionInactive', compact('countries'));
    }

    public function monthlySubscriptionInactiveData(Request $request)
    {
        $customers = Customer::select(['id', 'name', 'email', 'balance', 'status', 'ip_address','lifetime_package','monthly_package_status'])
            ->where('monthly_package_status', 'inactive');
        if ($request->name) {
            $customers = $customers->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->email) {
            $customers = $customers->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->country) {
            $customers = $customers->where('country_id', 'like', '%' . $request->country . '%');
        }
        if ($request->city) {
            $customers = $customers->where('city', 'like', '%' . $request->city . '%');
        }
        if ($request->ip) {
            $customers = $customers->where('ip_address', 'like', '%' . $request->ip . '%');
        }
        return DataTables::of($customers)
          ->addColumn('status',function ($customer){
            if ($customer->status == 1){
              return "<span class='badge bg-label-primary me-1'>Active</span>";
            }
            if ($customer->status == 2){
              return '<span class="badge bg-label-warning me-1">Inactive</span>';
            }
            if ($customer->status == 3){
              return '<span class="badge bg-label-danger me-1">Banned</span>';
            }
          })
          ->addColumn('lifetime_package', function ($customer) {
            if ($customer->lifetime_package == null){
              return '<label class="switch switch-danger">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
            }
            else{
              return '<label class="switch switch-success">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
            }
          })
          ->addColumn('monthly_package_status', function ($customer) {
            return $customer->monthly_package_status == 'active'
              ? '<label class="switch switch-success">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>
                            <span class="switch-label"></span>
                          </label>'
              : '<label class="switch switch-danger">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
          })
          ->addColumn('actions', function ($customer) {
            $viewButton = '<a href="' . route('manage-member-customers.show', $customer->id) . '" class="btn btn-xs btn-primary">View</a>';
            $editButton = '<a href="' . route('manage-member-customers.edit', $customer->id) . '" class="btn btn-xs btn-warning">Edit</a>';
            $deleteButton = '<button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete(' . $customer->id . ')">Delete</button>';

            return $viewButton . ' ' . $editButton . ' ' . $deleteButton;
          })
          ->rawColumns(['actions','status','lifetime_package','monthly_package_status'])
          ->make(true);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Container\Container|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed|object
     */
    public function monthlyUnsubscriber(Request $request)
    {
        $countries = Country::select('id', 'name')->where('is_active', 1)->get();

        return view('admin.customer.monthlyUnsubscriber', compact('countries'));
    }

    public function monthlyUnsubscriberData(Request $request)
    {
        $customers = Customer::select(['id', 'name', 'email', 'balance', 'status', 'ip_address','lifetime_package','monthly_package_status'])
            ->whereNull('monthly_package');
        if ($request->name) {
            $customers = $customers->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->email) {
            $customers = $customers->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->country) {
            $customers = $customers->where('country_id', 'like', '%' . $request->country . '%');
        }
        if ($request->city) {
            $customers = $customers->where('city', 'like', '%' . $request->city . '%');
        }
        if ($request->ip) {
            $customers = $customers->where('ip_address', 'like', '%' . $request->ip . '%');
        }
        return DataTables::of($customers)
          ->addColumn('status',function ($customer){
            if ($customer->status == 1){
              return "<span class='badge bg-label-primary me-1'>Active</span>";
            }
            if ($customer->status == 2){
              return '<span class="badge bg-label-warning me-1">Inactive</span>';
            }
            if ($customer->status == 3){
              return '<span class="badge bg-label-danger me-1">Banned</span>';
            }
          })
          ->addColumn('lifetime_package', function ($customer) {
            if ($customer->lifetime_package == null){
              return '<label class="switch switch-danger">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
            }
            else{
              return '<label class="switch switch-success">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
            }
          })
          ->addColumn('monthly_package_status', function ($customer) {
            return $customer->monthly_package_status == 'active'
              ? '<label class="switch switch-success">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>
                            <span class="switch-label"></span>
                          </label>'
              : '<label class="switch switch-danger">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
          })
          ->addColumn('actions', function ($customer) {
            $viewButton = '<a href="' . route('manage-member-customers.show', $customer->id) . '" class="btn btn-xs btn-primary">View</a>';
            $editButton = '<a href="' . route('manage-member-customers.edit', $customer->id) . '" class="btn btn-xs btn-warning">Edit</a>';
            $deleteButton = '<button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete(' . $customer->id . ')">Delete</button>';

            return $viewButton . ' ' . $editButton . ' ' . $deleteButton;
          })
          ->rawColumns(['actions','status','lifetime_package','monthly_package_status'])
          ->make(true);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Container\Container|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed|object
     */
    public function free(Request $request)
    {
        $countries = Country::select('id', 'name')->where('is_active', 1)->get();

        return view('admin.customer.free', compact('countries'));
    }

    public function freeData(Request $request)
    {
        $customers = Customer::select(['id', 'name', 'email', 'balance', 'status', 'ip_address','lifetime_package','monthly_package_status'])
            ->whereNull('lifetime_package');
        if ($request->name) {
            $customers = $customers->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->email) {
            $customers = $customers->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->country) {
            $customers = $customers->where('country_id', 'like', '%' . $request->country . '%');
        }
        if ($request->city) {
            $customers = $customers->where('city', 'like', '%' . $request->city . '%');
        }
        if ($request->ip) {
            $customers = $customers->where('ip_address', 'like', '%' . $request->ip . '%');
        }
        return DataTables::of($customers)
          ->addColumn('status',function ($customer){
            if ($customer->status == 1){
              return "<span class='badge bg-label-primary me-1'>Active</span>";
            }
            if ($customer->status == 2){
              return '<span class="badge bg-label-warning me-1">Inactive</span>';
            }
            if ($customer->status == 3){
              return '<span class="badge bg-label-danger me-1">Banned</span>';
            }
          })
          ->addColumn('lifetime_package', function ($customer) {
            if ($customer->lifetime_package == null){
              return '<label class="switch switch-danger">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
            }
            else{
              return '<label class="switch switch-success">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
            }
          })
          ->addColumn('monthly_package_status', function ($customer) {
            return $customer->monthly_package_status == 'active'
              ? '<label class="switch switch-success">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>
                            <span class="switch-label"></span>
                          </label>'
              : '<label class="switch switch-danger">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
          })
          ->addColumn('actions', function ($customer) {
            $viewButton = '<a href="' . route('manage-member-customers.show', $customer->id) . '" class="btn btn-xs btn-primary">View</a>';
            $editButton = '<a href="' . route('manage-member-customers.edit', $customer->id) . '" class="btn btn-xs btn-warning">Edit</a>';
            $deleteButton = '<button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete(' . $customer->id . ')">Delete</button>';

            return $viewButton . ' ' . $editButton . ' ' . $deleteButton;
          })
          ->rawColumns(['actions','status','lifetime_package','monthly_package_status'])
          ->make(true);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Container\Container|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed|object
     */
    public function banned(Request $request)
    {
        $countries = Country::select('id', 'name')->where('is_active', 1)->get();

        return view('admin.customer.banned', compact('countries'));
    }

    public function bannedData(Request $request)
    {
        $customers = Customer::select(['id', 'name', 'email', 'balance', 'status', 'ip_address','lifetime_package','monthly_package_status'])
            ->whereStatus(3);
        if ($request->name) {
            $customers = $customers->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->email) {
            $customers = $customers->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->country) {
            $customers = $customers->where('country_id', 'like', '%' . $request->country . '%');
        }
        if ($request->city) {
            $customers = $customers->where('city', 'like', '%' . $request->city . '%');
        }
        if ($request->ip) {
            $customers = $customers->where('ip_address', 'like', '%' . $request->ip . '%');
        }
        return DataTables::of($customers)
          ->addColumn('status',function ($customer){
            if ($customer->status == 1){
              return "<span class='badge bg-label-primary me-1'>Active</span>";
            }
            if ($customer->status == 2){
              return '<span class="badge bg-label-warning me-1">Inactive</span>';
            }
            if ($customer->status == 3){
              return '<span class="badge bg-label-danger me-1">Banned</span>';
            }
          })
          ->addColumn('lifetime_package', function ($customer) {
            if ($customer->lifetime_package == null){
              return '<label class="switch switch-danger">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
            }
            else{
              return '<label class="switch switch-success">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
            }
          })
          ->addColumn('monthly_package_status', function ($customer) {
            return $customer->monthly_package_status == 'active'
              ? '<label class="switch switch-success">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>
                            <span class="switch-label"></span>
                          </label>'
              : '<label class="switch switch-danger">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
          })
          ->addColumn('actions', function ($customer) {
            $viewButton = '<a href="' . route('manage-member-customers.show', $customer->id) . '" class="btn btn-xs btn-primary">View</a>';
            $editButton = '<a href="' . route('manage-member-customers.edit', $customer->id) . '" class="btn btn-xs btn-warning">Edit</a>';
            $deleteButton = '<button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete(' . $customer->id . ')">Delete</button>';

            return $viewButton . ' ' . $editButton . ' ' . $deleteButton;
          })
          ->rawColumns(['actions','status','lifetime_package','monthly_package_status'])
          ->make(true);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Container\Container|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed|object
     */
    public function emailUnverified(Request $request)
    {
        $countries = Country::select('id', 'name')->where('is_active', 1)->get();

        return view('admin.customer.emailUnverified', compact('countries'));
    }

    public function emailUnverifiedData(Request $request)
    {
        $customers = Customer::select(['id', 'name', 'email', 'balance', 'status', 'ip_address','lifetime_package','monthly_package_status'])
            ->whereNull('email_verified_at');
        if ($request->name) {
            $customers = $customers->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->email) {
            $customers = $customers->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->country) {
            $customers = $customers->where('country_id', 'like', '%' . $request->country . '%');
        }
        if ($request->city) {
            $customers = $customers->where('city', 'like', '%' . $request->city . '%');
        }
        if ($request->ip) {
            $customers = $customers->where('ip_address', 'like', '%' . $request->ip . '%');
        }
        return DataTables::of($customers)
          ->addColumn('status',function ($customer){
            if ($customer->status == 1){
              return "<span class='badge bg-label-primary me-1'>Active</span>";
            }
            if ($customer->status == 2){
              return '<span class="badge bg-label-warning me-1">Inactive</span>';
            }
            if ($customer->status == 3){
              return '<span class="badge bg-label-danger me-1">Banned</span>';
            }
          })
          ->addColumn('lifetime_package', function ($customer) {
            if ($customer->lifetime_package == null){
              return '<label class="switch switch-danger">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
            }
            else{
              return '<label class="switch switch-success">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
            }
          })
          ->addColumn('monthly_package_status', function ($customer) {
            return $customer->monthly_package_status == 'active'
              ? '<label class="switch switch-success">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>
                            <span class="switch-label"></span>
                          </label>'
              : '<label class="switch switch-danger">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
          })
          ->addColumn('actions', function ($customer) {
            $viewButton = '<a href="' . route('manage-member-customers.show', $customer->id) . '" class="btn btn-xs btn-primary">View</a>';
            $editButton = '<a href="' . route('manage-member-customers.edit', $customer->id) . '" class="btn btn-xs btn-warning">Edit</a>';
            $deleteButton = '<button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete(' . $customer->id . ')">Delete</button>';

            return $viewButton . ' ' . $editButton . ' ' . $deleteButton;
          })
          ->rawColumns(['actions','status','lifetime_package','monthly_package_status'])
          ->make(true);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Container\Container|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed|object
     */
    public function numberUnverified(Request $request)
    {
        $countries = Country::select('id', 'name')->where('is_active', 1)->get();

        return view('admin.customer.numberUnverified', compact('countries'));
    }

    public function numberUnverifiedData(Request $request)
    {
        $customers = Customer::select(['id', 'name', 'email', 'balance', 'status', 'ip_address','lifetime_package','monthly_package_status'])
            ->whereNull('phone_verified_at');
        if ($request->name) {
            $customers = $customers->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->email) {
            $customers = $customers->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->country) {
            $customers = $customers->where('country_id', 'like', '%' . $request->country . '%');
        }
        if ($request->city) {
            $customers = $customers->where('city', 'like', '%' . $request->city . '%');
        }
        if ($request->ip) {
            $customers = $customers->where('ip_address', 'like', '%' . $request->ip . '%');
        }
        return DataTables::of($customers)
          ->addColumn('status',function ($customer){
            if ($customer->status == 1){
              return "<span class='badge bg-label-primary me-1'>Active</span>";
            }
            if ($customer->status == 2){
              return '<span class="badge bg-label-warning me-1">Inactive</span>';
            }
            if ($customer->status == 3){
              return '<span class="badge bg-label-danger me-1">Banned</span>';
            }
          })
          ->addColumn('lifetime_package', function ($customer) {
            if ($customer->lifetime_package == null){
              return '<label class="switch switch-danger">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
            }
            else{
              return '<label class="switch switch-success">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
            }
          })
          ->addColumn('monthly_package_status', function ($customer) {
            return $customer->monthly_package_status == 'active'
              ? '<label class="switch switch-success">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>
                            <span class="switch-label"></span>
                          </label>'
              : '<label class="switch switch-danger">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
          })
          ->addColumn('actions', function ($customer) {
            $viewButton = '<a href="' . route('manage-member-customers.show', $customer->id) . '" class="btn btn-xs btn-primary">View</a>';
            $editButton = '<a href="' . route('manage-member-customers.edit', $customer->id) . '" class="btn btn-xs btn-warning">Edit</a>';
            $deleteButton = '<button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete(' . $customer->id . ')">Delete</button>';

            return $viewButton . ' ' . $editButton . ' ' . $deleteButton;
          })
          ->rawColumns(['actions','status','lifetime_package','monthly_package_status'])
          ->make(true);
    }

  public function withBalance(Request $request)
  {
    $countries = Country::select('id', 'name')->where('is_active', 1)->get();

    return view('admin.customer.withbalance', compact('countries'));
  }

  public function withBalanceData(Request $request)
  {
    $customers = Customer::select(['id', 'name', 'email', 'balance', 'status', 'ip_address','lifetime_package','monthly_package_status'])
      ->where('balance', '>', 0);
    if ($request->name) {
      $customers = $customers->where('name', 'like', '%' . $request->name . '%');
    }
    if ($request->email) {
      $customers = $customers->where('email', 'like', '%' . $request->email . '%');
    }
    if ($request->country) {
      $customers = $customers->where('country_id', 'like', '%' . $request->country . '%');
    }
    if ($request->city) {
      $customers = $customers->where('city', 'like', '%' . $request->city . '%');
    }
    if ($request->ip) {
      $customers = $customers->where('ip_address', 'like', '%' . $request->ip . '%');
    }
    return DataTables::of($customers)
      ->addColumn('status',function ($customer){
        if ($customer->status == 1){
          return "<span class='badge bg-label-primary me-1'>Active</span>";
        }
        if ($customer->status == 2){
          return '<span class="badge bg-label-warning me-1">Inactive</span>';
        }
        if ($customer->status == 3){
          return '<span class="badge bg-label-danger me-1">Banned</span>';
        }
      })
      ->addColumn('lifetime_package', function ($customer) {
        if ($customer->lifetime_package == null){
          return '<label class="switch switch-danger">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
        }
        else{
          return '<label class="switch switch-success">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
        }
      })
      ->addColumn('monthly_package_status', function ($customer) {
        return $customer->monthly_package_status == 'active'
          ? '<label class="switch switch-success">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>
                            <span class="switch-label"></span>
                          </label>'
          : '<label class="switch switch-danger">
                            <input type="checkbox" class="switch-input" checked="">
                            <span class="switch-toggle-slider">
                              <span class="switch-on">
                                <i class="ti ti-check"></i>
                              </span>
                              <span class="switch-off">
                                <i class="ti ti-x"></i>
                              </span>
                            </span>

                          </label>';
      })
      ->addColumn('actions', function ($customer) {
        $viewButton = '<a href="' . route('manage-member-customers.show', $customer->id) . '" class="btn btn-xs btn-primary">View</a>';
        $editButton = '<a href="' . route('manage-member-customers.edit', $customer->id) . '" class="btn btn-xs btn-warning">Edit</a>';
        $deleteButton = '<button type="button" class="btn btn-xs btn-danger" onclick="confirmDelete(' . $customer->id . ')">Delete</button>';

        return $viewButton . ' ' . $editButton . ' ' . $deleteButton;
      })
      ->rawColumns(['actions','status','lifetime_package','monthly_package_status'])
      ->make(true);
  }

    public function create()
    {
        $countries = Country::where('is_active', 1)->get();
        return view('admin.customer.create', compact('countries'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:customers',
            'password' => 'required|min:8',
            'country_id' => 'required|exists:countries,id',
            'city' => 'required|max:255',
            'phone' => 'required|unique:customers',
            'address' => 'nullable|max:255',
        ]);
        $data = $request->all();;
        if ($request->hasFile('image')) {
            $data['image'] = $this->moveFile($request->file('image'));
        }
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $data['type'] = 2;
        $user = User::create($data);

        $data['user_id'] = $user->id;
        Customer::create($data);

        return redirect()->back()->with('success', 'Customer created successfully');
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);
        $user = User::find($customer->user_id);
        $user->delete();
        $customer->delete();
        return redirect()->back()->with('success', 'Customer deleted successfully');
    }

    protected function moveFile($file)
    {
        if (!$file->isValid()) {
            return '';
        }

        $path = config('laravel-code-generator.files_upload_path', 'uploads');
        $saved = $file->store('public/' . $path, config('filesystems.default'));

        return substr($saved, 7);
    }

    public function topRecruiter()
    {
        return view('admin.customer.topRecruter');
    }

    public function topRecruiterData()
    {
      $customers = Customer::withCount([
        'subscribers as active_subscribers_count' => function ($query) {
          $query->where('monthly_package_status', 'active'); // Adjust the condition based on your schema
        },
        'subscribers as inactive_subscribers_count' => function ($query) {
          $query->where('monthly_package_status', 'inactive'); // Adjust the condition based on your schema
        }
        ])->orderBy('active_subscribers_count', 'desc');

      return DataTables::of($customers)

        ->addColumn('reward_point',function ($query){
        return 0;
        })
        ->addColumn('stats', function ($query){
          return 0;
        })->make(true);
    }
}
