<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{

  public function index(){
      return view('events.eventAdd');
  }

  public function search(Request $request){
      if ($request->ajax()){
          $output = "";
          $citizens= DB::table('citizens')->where('full_name','LIKE','%'.$request->search."%")->get();

          if ($citizens){
              foreach ($citizens as $key => $citizen){
                  $output ='<tr>';
                  '<td>'.$citizen->id.'</td>'.
                  '<td>'.$citizen->full_name.'</td>'.
                  '<td>'.$citizen->date_birth.'</td>'.
                  '</tr>';
              }
              return response($output);
          }
      }
  }
}
