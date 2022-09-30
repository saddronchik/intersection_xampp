<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')
                    ->Join('model_has_roles','model_has_roles.model_id','=','users.id')
                    ->Join('roles','roles.id','=','model_has_roles.role_id')
                    ->select('users.id','users.username','model_has_roles.role_id','roles.name','roles.full_name')
                    ->groupBy('users.id')
                    ->get();

        $roles = DB::table('model_has_roles')
            ->join('roles','roles.id','=','model_has_roles.role_id')
            ->join('users','users.id','=','model_has_roles.model_id')
            ->select(DB::raw("GROUP_CONCAT(roles.full_name SEPARATOR ', ') as `role`"),'users.id','users.username')
            ->groupBy('model_id')
            ->get();
        return view('users.users',[
            "users"=>$users,
            "roles"=>$roles,
        ]);
    }
    public function indexUser(){
        return view('users.addusers');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = User::create([
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
        ]);
        $user->assignRole($request['role_citisen']);
        $user->assignRole($request['role_citisen_add']);
        $user->assignRole($request['role_citisen_upd']);
        $user->assignRole($request['role_avto']);
        $user->assignRole($request['role_avto_add']);
        $user->assignRole($request['role_avto_upd']);
        $user->assignRole($request['role_border']);
        $user->assignRole($request['role_border_add']);
        $user->assignRole($request['role_border_upd']);
        $user->assignRole($request['role_admin']);

        return $user->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('users.showUsers',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $params = $request->only(['id','username']);
        $users = User::find($params['id']);

        $users->username = $params["username"];

       DB::table('model_has_roles')->where('model_id',$users->id)->delete();
       $users->assignRole($request['role_citisen']);
       $users->assignRole($request['role_citisen_add']);
       $users->assignRole($request['role_citisen_upd']);
       $users->assignRole($request['role_avto']);
       $users->assignRole($request['role_avto_add']);
       $users->assignRole($request['role_avto_upd']);
       $users->assignRole($request['role_border']);
       $users->assignRole($request['role_border_add']);
       $users->assignRole($request['role_border_upd']);
       $users->assignRole($request['role_admin']);

       $users->save();

       return redirect()->route('users.list');
    //    return  $users;
    }

    public function updatePassword(Request $request){
        $params = $request->all();
        $params["password"] = Hash::make($request['password']);
        $user = User::find($params['id']);
        $user->username = $params["username"];
        $user->password = $params["password"];

        $user->save();
        return redirect()->route('users.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $messageFromUser = Message::where('from_user','=',$id)->delete();

        User::destroy($id);

        return redirect()->route('users.list');
    }
}
