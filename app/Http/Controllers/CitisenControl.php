<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use Illuminate\Http\Request;
use App\Http\Requests\CitisenCreateRequest;
use App\Models\Message;
use App\Models\Record;
use App\Models\User;
use App\Models\Border;
use App\Models\Peoples;
use App\Repositories\CitisensRepository;
use App\Services\CitisensServices;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\VarDumper\Cloner\Data;

class CitisenControl extends Controller
{
    private $citisensRepository;
    private $citisensServices;

    public function __construct(CitisensRepository $citisensRepository, CitisensServices $citisensServices)
    {
        $this->middleware('auth');
        $this->citisensRepository = $citisensRepository;
        $this->citisensServices = $citisensServices;
    }

    public function create()
    {
        $users = User::query()->select('id','username')->get();
        return view('citisens.addcitisens', compact('users'));
    }


    public function store(CitisenCreateRequest $request)
    {
        try {
            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('folder');
            }else {
                $path = null;
            }
                $params = $request->all();

                $params['photo']=$path;
                $params['user']= Auth::user()->username;
                $params['id_user']= Auth::user()->id;
                $citizen = Citizen::create($params);

                $citizen->save();

                $id_citisen = $citizen -> id;

             foreach ($request->user as $user) {
                $records = Record::create([
                    "id_user"=>$user,
                    "id_citisen"=>$id_citisen
                ]);
            }
               return redirect()->route('citizen.list');

        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    public function show($id)
    {
        $citizen = Citizen::find($id);
        $users = $this->citisensRepository->getUsers();

        return view('citisens.showCitisen',["users"=>$users,"citizen"=>$citizen]);
    }

    public function showBorderCitisen($id){
        $citisens = $this->citisensRepository->getBorderCitisens($id);

        return view('citisens.citisens_border',["citisens"=>$citisens]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CitisenCreateRequest $request, Citizen $citizen)
    {
        if ($request->photo==null) {

            $params = $request->all();
            $citizen = Citizen::find($params['id']);
            $params['user']= $citizen['user'];
            $result = $citizen->fill($params)->save();

            $id_citisen = $citizen ->id;

           Record::where('id_citisen',$id_citisen)->delete();

            foreach ($request->user as $user) {
                $records = Record::create([
                "id_user"=>$user,
                "id_citisen"=>$id_citisen]);
            }
                $records->save();

            return redirect()->route('citizen.list');
        }else {

       $params = $request->all();
       $citizen = Citizen::find($params['id']);
       Storage::delete($citizen->photo);

        $path = $request->file('photo')->store('folder');
        $params['photo']=$path;
        $params['user']= $citizen['user'];
        $result = $citizen->fill($params)->save();
        $id_citisen = $citizen ->id;
        Record::where('id_citisen',$id_citisen)->delete();

            foreach ($request->user as $user) {
             $records = Record::create([
                "id_user"=>$user,
                "id_citisen"=>$id_citisen]);
            }
                $records->save();
                $citizen->save();
            return redirect()->route('citizen.list');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $this->citisensServices->remove($id);
            return redirect()->route('list_citizen');
        }
        catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }


}
