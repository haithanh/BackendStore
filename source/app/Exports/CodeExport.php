<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use App\Code;
use Maatwebsite\Excel\Concerns\FromView;

class CodeExport implements FromView
{

    private $oData;

    public function __construct($oData)
    {
        $this->oData = $oData;
    }

    public function view()
    : View
    {
        return view('exports.code', [
            'codes' => $this->oData
        ]);
    }
}
