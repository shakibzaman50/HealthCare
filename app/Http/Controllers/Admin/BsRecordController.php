<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BsRecord\StoreBsRecordRequest;
use App\Models\Profile;
use App\Services\Config\BsRecordService;
use Illuminate\Http\Request;

class BsRecordController extends Controller
{
    public function __construct(
        public BsRecordService $bsRecordService
    ) {
    }

    /**
     * Get paginated list of blood sugar records
     */
    public function index()
    {
        $bsRecords = $this->bsRecordService->list();
        $profiles = Profile::query()->get();
        return view('admin.config.bs_record.index', compact('bsRecords', 'profiles'));
    }

    /**
     * Create new blood sugar record
     */
    public function store(StoreBsRecordRequest $request)
    {
        $this->bsRecordService->create($request->validated());

        return redirect()->back();
    }

    /**
     * Delete blood sugar record
     */
    public function destroy($id)
    {
        $this->bsRecordService->delete($id);

        return redirect()->route('admin.config.bs_record.index')
            ->with('success_message', 'Blood Sugar Record was successfully deleted.');
    }

    /**
     * Export blood sugar records to CSV
     */
    public function exportToCsv(Request $request)
    {
        return $this->bsRecordService->exportToCsv($request->ids);
    }
}