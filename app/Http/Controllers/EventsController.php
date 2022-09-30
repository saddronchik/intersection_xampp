<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventsRequest;
use App\Models\Citizen;
use App\Models\Event;
use App\Models\Record;
use App\Models\User;
use App\Repositories\CitisensRepository;
use App\Services\CitisensServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class EventsController extends Controller
{
    private $citisensRepository;
    private $citisensServices;

    public function __construct(CitisensRepository $citisensRepository, CitisensServices $citisensServices)
    {
        $this->middleware('auth');
        $this->citisensRepository = $citisensRepository;
        $this->citisensServices = $citisensServices;
    }


    public function index(){
        $events =  DB::table('events')
            ->orderBy('id')
            ->paginate(5);
        $authUser = Auth::user()->id;
        $authUsername = Auth::user()->username;
        return view('home', [
            'events'=>$events,
            'authUser' => $authUser,
            'authUsername' => $authUsername,
        ]);
    }

    public function searchEvent(Request $request){
        $authUser = Auth::user()->id;
        $authUsername = Auth::user()->username;
        $s = $request->s;
        $events = Event::query()->where('full_name','LIKE',"%{$s}%")
            ->orWhere('date_birth','LIKE',"%{$s}%")
            ->orWhere('id','LIKE',"%{$s}%")
            ->orderBy('full_name')
            ->paginate(5);

        return view('home', [
            'events' => $events,
            'authUser' => $authUser,
            'authUsername' => $authUsername,
        ]);
    }

    public function searchEventForUser(){

    }

    public function create(){
        $citizens = Citizen::select('id', 'full_name','date_birth')->get();
        $users = User::select('id','username')->get();
        return view('events.eventAdd',compact('users','citizens'));
    }

    public function store(EventsRequest $request){
        try {
            $params = $request->all();
            $citizens = Citizen::where('id', '=', $request->id_citizen)->select('id', 'full_name', 'date_birth')->get();
            foreach ($citizens as $citizen) {
                $params['full_name'] = $citizen->full_name;
                $params['date_birth'] = $citizen->date_birth;
            }
            $params['user'] = Auth::user()->username;
            $params['id_user'] = Auth::user()->id;

            $event = Event::create($params);
            $event->save();

            $id_event = $event->id;
            foreach ($request->user as $user) {
                $records = Record::create([
                    "id_user" => $user,
                    "id_event" => $id_event
                ]);
            };
            return redirect()->route('home');
        }catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($id){
        $event = Event::find($id);
        $users = $this->citisensRepository->getUsers();

        return view('events.showEvent',["users"=>$users,"event"=>$event]);
    }

    public function update(Request $request){
        $params = $request->all();
        $event = Event::find($params['id']);
        $params['user']= $event['user'];
        $result = $event->fill($params)->save();

        $id_event = $event ->id;
        Record::where('id_event',$id_event)->delete();

        foreach ($request->user as $user) {
            $records = Record::create([
                "id_user"=>$user,
                "id_event"=>$id_event]);
        }
        $records->save();

        return redirect()->route('home');
    }

    public function delete($id){

        try{
            Record::where('id_event',$id)->delete();
            Event::destroy($id);
            return redirect()->route('home');
        }
        catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

}
