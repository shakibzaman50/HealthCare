<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Validation\ValidatesRequests; // Add this line

class PermissionController extends Controller
{
    use ValidatesRequests;
    function __construct()
    {
        $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:permission-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permissions = Permission::orderBy('id', 'DESC')->paginate(20);
        return view('permissions.index', compact('permissions'))->with('i', ($request->input('page', 1) - 1) * 20);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->input('name')]);

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permission = Permission::find($id);
        return view('permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permission = Permission::find($id);
        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name,' . $id,
        ]);

        $permission = Permission::find($id);
        $permission->name = $request->input('name');
        $permission->save();

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Permission::find($id)->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully');
    }
}
