<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\SugarUnit;
use App\Services\Config\SugarUnitService;
use Illuminate\Http\Request;

class SugarUnitController extends Controller
{
    protected $sugarUnitService;
    public function __construct(SugarUnitService $sugarUnitService)
    {
        $this->sugarUnitService = $sugarUnitService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sugarUnits = SugarUnit::paginate(25);
        return view('sugar_units.index', compact('sugarUnits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
