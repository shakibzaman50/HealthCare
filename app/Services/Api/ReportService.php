<?php

namespace App\Services\Api;

use App\Exports\Api\ReportExport;
use App\Models\ReportPath;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;

class ReportService
{
    protected $profileId;
    protected array $data = [];

    public function __construct($id)
    {
        $this->profileId = $id;
    }

    protected function saveReport($path, $type)
    {
        $lastReport = ReportPath::where('profile_id', $this->profileId)->first();
        if ($lastReport) {
            unlink($lastReport->path);
            $lastReport->update(['path' => 'reports/'.$path]);
        } else {
            ReportPath::create([
                'path'       => 'reports/'.$path,
                'profile_id' => $this->profileId,
                'type'       => $type,
            ]);
        }
    }

    protected function makePfd()
    {
        $html = view('pdf.report', $this->data)->render();
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P'
        ]);
//        $path = Setting::find(1)?->report_icon;
//        $icon = file_exists($path) ? $path : 'icon.png';
//        $mpdf->SetWatermarkImage(public_path($icon), 0.2, [150, 100]);
        $mpdf->showWatermarkImage = true;
        $mpdf->SetHTMLFooter('
            <div style="text-align: center; font-size: 10px;">
                The information provided in this report is not intended as medical advice. For any health-related concerns, please consult a healthcare professional.
            </div>
            <div style="text-align: center; font-weight: bold; font-size: 10px;">Page {PAGENO} of {nbpg}</div>
        ');
        $mpdf->WriteHTML($html);

        $directory = public_path('reports');
        $filename = 'report-'. Str::random(10) . time() .'.pdf';

        $pdfContent = $mpdf->Output('report', 'S');
        file_put_contents($directory . '/' . $filename, $pdfContent);

        $this->saveReport($filename, 1);
        return asset('reports/' . $filename);
    }

    protected function makeCsv()
    {
        $directory = public_path('reports');
        $filename = 'doctor-report-' . Str::random(10) . '.csv';
        Excel::store(new ReportExport(
            $this->data['heartRates'],
            $this->data['bloodPressures'],
            $this->data['bloodSugars'],
            $this->data['bloodOxygens'],
            $this->data['waterIntakes']
        ),
          $filename, 'local');

        $tempPath = storage_path('app/' . $filename);
        $finalPath = $directory . '/' . $filename;

        if (file_exists($tempPath)) {
          copy($tempPath, $finalPath);
          unlink($tempPath);
        }

        $this->saveReport($filename, 2);
        return asset('reports/' . $filename);
    }

    public function makeReport($request, $heartRates, $bloodPressures, $bloodSugars, $bloodOxygens, $waterIntakes)
    {
        $this->data = [
            'profile'        => $this->profileId,
            'fromDate'       => Carbon::parse($request->from_date),
            'toDate'         => Carbon::parse($request->to_date),
            'days'           => $request->days,
            'heartRates'     => collect($heartRates),
            'bloodPressures' => collect($bloodPressures),
            'bloodSugars'    => collect($bloodSugars),
            'bloodOxygens'   => collect($bloodOxygens),
            'waterIntakes'   => collect($waterIntakes),
        ];

        return $request->file=='pdf' ? $this->makePfd() : $this->makeCsv();
    }
}
