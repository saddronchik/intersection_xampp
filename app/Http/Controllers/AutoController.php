<?php

namespace App\Http\Controllers;

use App\Exports\AvtosExport;
use App\Http\Requests\AvtoCreateRequest;
use App\Imports\AvtosImport;
use App\Imports\AvtosImportNoHead;
use App\Models\Avto;
use App\Models\Citizen;
use App\Models\Record;
use App\Models\User;
use App\Repositories\AutoRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AutoController extends Controller
{
    private $autoRepository;

    public function __construct(AutoRepository $autoRepository)
    {
        $this->middleware('auth');
        $this->autoRepository = $autoRepository;
    }

    public function index()
    {
        $autos = $this->autoRepository->getAll();

        return view('autos.index', compact('autos'));
    }

    public function listByUser()
    {
        $autos = $this->autoRepository->getWithRecordsByUser(Auth::id());

        return view('autos.auto_user', compact('autos'));
    }


    public function create()
    {
        $citizens = Citizen::select('citizens.id', 'citizens.full_name')->get();
        $users = User::select('users.id', 'users.username')->get();

        return view('autos.create', compact('citizens', 'users'));
    }

    public function search(Request $request)
    {
        $search = $request->get('s');
        $autos = $this->autoRepository->searchAutos($search);

        return view('autos.index', compact('autos'));
    }

    public function searchAutoUser(Request $request)
    {
        if ($search = $request->get('s')) {
            $autos = $this->autoRepository->serchAvtosJoinRecordsUsers($search, Auth::id());
            return view('autos.auto_user', compact('autos'));
        }

        $autos = $this->autoRepository->getWithRecordsByUser(Auth::id());

        return view('autos.auto_user', compact('autos'));
    }

    public function store(AvtoCreateRequest $request)
    {
        if ($path = $request->file('photo')) {
            $path = $request->file('photo')->store('avtos');
        } else {
            $path = null;
        }
        $params = $request->only(['id_citisen', 'brand_avto', 'regis_num', 'color', 'photo', 'addit_inf', 'who_noticed', 'where_notice', 'detection_time', 'user', 'id_user']);
        $params['photo'] = $path;
        $params['user'] = Auth::user()->username;
        $params['id_user'] = Auth:: user()->id;

        $avto = Avto::create($params);
        $avto->save();
        $id_avto = $avto->id;

        foreach ($request->user as $user) {
            $records = Record::create([
                "id_user" => $user,
                "id_avto" => $id_avto
            ]);
        }

        return redirect()->route('auto.index');
    }

    public function showBorderAutos($id)
    {
        $autos = $this->autoRepository->getByBorder($id);

        return view('autos.autos_border', compact('autos'));

    }

    public function show(int $id)
    {
        $auto = Avto::query()->find($id);
        $users = User::query()->select('id', 'username')->get();

        return view('autos.show', compact('auto', 'users'));
    }

    public function update(AvtoCreateRequest $request, Avto $avto)
    {
        $params = $request->all();
        $avto = Avto::find($params['id']);
        $params['user'] = $avto['user'];
        if ($request->photo == null) {
            $result = $avto->fill($params)->save();

            $id_avto = $avto->id;

            Record::where('id_avto', $id_avto)->delete();

            foreach ($request->user as $user) {
                $records = Record::create([
                    "id_user" => $user,
                    "id_avto" => $id_avto
                ]);
            }
            $avto->save();
            return redirect()->route('avtoslist');
        } else {
            Storage::delete($avto->photo);

            $path = $request->file('photo')->store('avtos');
            $params['photo'] = $path;
            $avto->fill($params)->save();

            $id_avto = $avto->id;

            Record::where('id_avto', $id_avto)->delete();
            foreach ($request->user as $user) {
                $records = Record::create([
                    "id_user" => $user,
                    "id_avto" => $id_avto
                ]);
            }
            $avto->save();
            return redirect()->route('auto.index');
        }
    }

    public function destroy($id): RedirectResponse
    {
        Avto::destroy($id);
        return redirect()->back();
    }
}
