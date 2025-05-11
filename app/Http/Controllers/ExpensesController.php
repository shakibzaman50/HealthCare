<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Expensecategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class ExpensesController extends Controller
{

    /**
     * Display a listing of the expenses.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $expenses = Expense::with('expensecategory', 'creator', 'receivedby', 'updator')->orderBy('id', 'desc')->paginate(25);

        return view('expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new expense.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $Expensecategories = Expensecategory::pluck('name', 'id')->all();
        $receivedBies = User::pluck('name', 'id')->all();

        return view('expenses.create', compact('Expensecategories',  'receivedBies'));
    }

    /**
     * Store a new expense in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        info('Expense', [$request->all()]);
        $data = $this->getData($request);
        $data['created_by'] = Auth::Id();
        Expense::create($data);

        return redirect()->route('expenses.expense.index')
            ->with('success_message', 'Expense was successfully added.');
    }

    /**
     * Display the specified expense.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $expense = Expense::with('expensecategory', 'creator', 'receivedby', 'deletedBy', 'updator')->findOrFail($id);

        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified expense.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $Expensecategories = Expensecategory::pluck('name', 'id')->all();
        $receivedBies = User::pluck('name', 'id')->all();

        return view('expenses.edit', compact('expense', 'Expensecategories',  'receivedBies'));
    }

    /**
     * Update the specified expense in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {

        $data = $this->getData($request);

        $expense = Expense::findOrFail($id);
        $data['updated_by'] = Auth::Id();

        $expense->update($data);

        return redirect()->route('expenses.expense.index')
            ->with('success_message', 'Expense was successfully updated.');
    }

    /**
     * Remove the specified expense from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $expense = Expense::findOrFail($id);
            $expense->deleted_by = auth()->id();
            $expense->save();

            $expense->delete();

            return redirect()->route('expenses.expense.index')
                ->with('success_message', 'Expense was successfully deleted.');
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
            'category_id' => 'nullable',
            'description' => 'string|min:1|max:1000|nullable',
            'amount' => 'string|min:1|nullable',
            'created_by' => 'nullable',
            'received_by' => 'nullable',
            'payment_date' => 'nullable',
            'Invoice' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048', 'nullable', 'file'],
        ];

        // if ($request->route()->getAction()['as'] == 'expenses.expense.store' || $request->has('custom_delete_Invoice')) {
        //     array_push($rules['Invoice'], 'required');
        // }
        $data = $request->validate($rules);

        if ($request->has('custom_delete_Invoice')) {
            $data['Invoice'] = null;
        }
        if ($request->hasFile('Invoice')) {
            $data['Invoice'] = $this->moveFile($request->file('Invoice'));
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
