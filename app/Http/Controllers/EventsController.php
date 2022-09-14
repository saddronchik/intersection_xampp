<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function create(){
        $users = User::select('id','username')->get();
        return view('events.eventAdd',compact('users'));
    }
}
