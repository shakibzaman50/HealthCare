<?php

namespace App\Exports\Api;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements FromView
{
    private $heartRates, $bloodPressures, $bloodSugars, $bloodOxygens, $waterIntake;

    public function __construct($heartRates=[], $bloodPressures=[], $bloodSugars=[], $bloodOxygens=[], $waterIntake=[]){
        $this->heartRates     = $heartRates;
        $this->bloodPressures = $bloodPressures;
        $this->bloodSugars    = $bloodSugars;
        $this->bloodOxygens   = $bloodOxygens;
        $this->waterIntake    = $waterIntake;
    }

    /**
    * @return View
    */
    public function view(): View{
        return view('export.report', [
            'heartRates'     => $this->heartRates,
            'bloodPressures' => $this->bloodPressures,
            'bloodSugars'    => $this->bloodSugars,
            'bloodOxygens'   => $this->bloodOxygens,
            'waterIntake'    => $this->waterIntake
        ]);
    }
}
