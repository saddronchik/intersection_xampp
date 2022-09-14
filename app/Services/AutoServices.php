<?php

namespace App\Services;

use App\Exports\AvtosExport;
use App\Imports\AvtosImport;
use App\Imports\AvtosImportNoHead;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class AutoServices
{
    public function export()
    {
        return Excel::download(new AvtosExport, 'avtos.xlsx');
    }

    public function import(Request $request)
    {
        if ($request['haveHead'] == true) {
            Excel::import(new  AvtosImport, $request->file('files'));

            return back()->withStatus('Успешно импортировано c шапкой!');
        } elseif ($request['haveHead'] == null) {
            Excel::import(new AvtosImportNoHead, $request->file('files'));

            return back()->withStatus('Успешно импортировано без шапки!');
        }
    }
}
