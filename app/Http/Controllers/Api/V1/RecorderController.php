<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreRecorderRequest;
use App\Http\Requests\Api\V1\UpdateRecorderRequest;
use App\Http\Resources\Api\V1\RecorderCollection;
use App\Http\Resources\Api\V1\RecorderResource;
use App\Models\Customer;
use App\Models\Recorder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class RecorderController extends Controller
{
    //todo: Ellenőrizni miért nem mennek a get requestek errora ftnak.
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        //bug: Apibol hívva a tokenCan folytat nem hatodik végre és beletér az if elágzásba ahova nem volna szabad
        //ügyvél nézet ellenőrzés
        if(Auth::user()->tokenCan('customer:wive')){
//            return response()->json(['token Cen customer', 'user'=> $request->user()->tokenCen('customer:wive')]);
            $includeCameras=$request->query('includeCameras');
            //todo: Ha customer To Recorder null tárjen vissza Nincs hozzárendelve rögzitő.
//            $userSystem=User::find(Auth::user()->id)->costumer->customerToRecorders;
            if ($includeCameras){
                print ("includeCameras");
//                $userSystem->load('recorderToCameras');
            }
            //visszatérés csak az ügyfélhez tartozó rögzitők megjelenités
//            return new RecorderCollection($userSystem->append($request->query()));
        }
        if (Auth::user()->tokenCan('installer')){

            //todo ügyfél nevét is visszaadni Akihez hozzá van rendelve a rögzitő ha nincs akkor null.
            $includeCameras=$request->query('includeCameras');
            $recorders=User::find(Auth::user()->id)->installer;
            if ($includeCameras){
                $recorders=$recorders->with('recorderToCameras');
            };
            return new RecorderCollection($recorders->append($request->query()));
        }
        return response()->json(['alert'=>['type'=>'danger', 'message'=>'Ehez a funkcióhoz nincs hozzáférésed!']]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * POST
     * Store a newly created resource in storage.
     */
    public function store(StoreRecorderRequest $request)
    {
        //todo: user->installer ellenőrizni kell hgoy a rőgzitö a felhasználóhoz tartózik-e
        $request=$this->dataCrypter($request->all());

       new RecorderResource(Recorder::create($request));
        return response()->json(['alert'=>['type'=>'success','message'=>'A rögzitő sikeresen létrehozva!']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Recorder $recorder, Request $request)
    {
        //todo: user->tokenCan(installer)
        //todo: user()->tokenCan('customer:wive')
        //bug: "message": "Call to a member function load() on null",
        //    "exception": "Error",
        //    "file": "D:\\web\\camLink\\app\\Http\\Controllers\\Api\\V1\\RecorderController.php",
        //    "line": 72,

        if (Customer::find($recorder->customer_id)->load('costumerToUser')->id==Auth::user()->id){
        $includeCameras=$request->query('includeCameras');
        if ($includeCameras){
            return new RecorderResource($recorder->loadMissing('recorderToCameras'));
        }
        return new RecorderResource($recorder);
        }
        return response()->json(['alert',['type'=>'warning','message'=>'Hibás adatbevitel.']]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recorder $recorder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecorderRequest $request, Recorder $recorder)
    {
        if (Auth::user()->tokenCan('installer')){


        //todo: user->installer ellenőrizni kell hgoy a rőgzitö a felhasználóhoz tartózik-e
        $recorder->update($this->dataCrypter($request->all()));
        return response()->json(['alert' =>['type' => 'success', 'message' => 'A Rögtitő adatai sikeresen modositva!']]);
        }
        return response()->json(['alert' => ['type' => 'danger', 'message' => 'Ehhez a funciohoz nincs jogosultságod!']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recorder $recorder)
    {
        if (Auth::user()->tokenCan('installer')){
            $recorder->delete();
            return response()->json(['alert' =>['type' => 'success', 'message' => 'A rögzitő törlése sikeres!']]);
        }
        return response()->json(['alert' =>['type' => 'danger', 'message' => 'A kamera törlése sikeres!']]);
    }
    protected  function dataCrypter($data){
        if (isset($data['name'])) $data['name'] = Crypt::encryptString($data['name']);
        if (isset($data['serial_number'])) $data['serial_number']= Crypt::encryptString($data['serial_number']);
        if (isset($data['local_ip'])) $data['local_ip']=Crypt::encryptString($data['local_ip']);
        if (isset($data['local_mask']))$data['local_mask']= Crypt::encryptString($data['local_mask']);
        if (isset($data['local_gateway'])) $data['local_gateway'] = Crypt::encryptString($data['local_gateway']);
        if (isset($data['users'])) $data['users'] =Crypt::encryptString($data['users']);
        if (isset($data['channels'])) $data['channels'] = Crypt::encryptString($data['channels']);
        return $data;
    }
}
