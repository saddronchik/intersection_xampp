<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Exports\CitisenExport;
use App\Exports\CitisensExport;
use App\Imports\CitisensImport;
use App\Imports\CitisenImportNoHead;
use App\Imports\CitisensImportNoHead;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Border;
use App\Models\Citizen;

class CitisensServices{

    public function CitisenExport(){
        return Excel::download(new CitisensExport, 'citisen.xlsx');
    }

    public function CitisenImport(Request $request)
    {
        if ($request['haveHead'] == true) {
            Excel::import(new  CitisensImport, $request->file('files'));

            return back()->withStatus('Успешно импортировано c шапкой!');

        } elseif ($request['haveHead'] == null) {

            Excel::import(new CitisensImportNoHead, $request->file('files'));

            return back()->withStatus('Успешно импортировано без шапки!');
        }
    }

    public function remove($id){
        $eventIds = Event::where('id_citizen',$id)->get('id');
        foreach ($eventIds as $eventId) {
            Record::where('id_event',$eventId->id)->delete();
        }

        Event::where('id_citizen',$id)->delete();
        Citizen::destroy($id);

        Border::destroy($id);

        return back()->withStatus('200');

    }
}
