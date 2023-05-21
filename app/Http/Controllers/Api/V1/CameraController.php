<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreCameraRequest;
use App\Http\Requests\Api\V1\UpdateCameraRequest;
use App\Http\Resources\Api\V1\CameraCollection;
use App\Http\Resources\Api\V1\CameraResource;
use App\Models\Camera;
use App\Models\Recorder;
use App\Models\User;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use function PHPUnit\Framework\isFalse;

class CameraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->tokenCan('installer')){
            $recodreIds= Recorder::whereIn('installer_id',[Auth::user()->id])->get('id');
            $cameras=Camera::whereIn('recorder_id',$recodreIds)->get();
        }
        if (Auth::user()->tokenCan('change:CameraName')){
            $recodreIds= Recorder::whereIn('customer_id',[Auth::user()->id])->get('id');
            $cameras=Camera::whereIn('recorder_id',$recodreIds)->get();
        }
        return new CameraCollection($cameras);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCameraRequest $request)
    {
        if (Auth::user()->tokenCan('installer')) {
            $request = $this->dataCrypter($request->all());
            new CameraResource(Camera::create($request));
            return response()->json(['alert' => ['type' => 'success', 'message' => 'A kamera sikeresen létrehozva!']]);
        }
        return response()->json(['alert' => ['type' => 'danger', 'message' => 'Ehhez a funciohoz nincs jogosultságod!']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Camera $camera)
    {
        if (Auth::user()->tokenCan('installer')){
        return new  CameraResource($camera);
        }
        return response()->json(['alert' => ['type' => 'danger', 'message' => 'Ehez a funciohoz nincs jogosultságod!']]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Camera $camera)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCameraRequest $request, Camera $camera)
    {
        $camera->update($this->dataCrypter($request->all()));
        return response()->json(['alert' =>['type' => 'success', 'message' => 'A Kamera adatai sikeresen modositva!']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Camera $camera)
    {

        if (Auth::user()->tokenCan('installer')){
            $camera->delete();

        return response()->json(['alert' =>['type' => 'success', 'message' => 'A kamera törlése sikeres!']]);
        }
        return response()->json(['alert' => ['type' => 'danger', 'message' => 'Ehez a funciohoz nincs jogosultságod!']]);
    }
    protected  function dataCrypter($data){
        if (isset($data['name'])) $data['name'] = Crypt::encryptString($data['name']);
        if (isset($data['camera_img'])) $data['camera_img']= Crypt::encryptString($data['camera_img']);
        if (isset($data['local_ip'])) $data['local_ip']=Crypt::encryptString($data['local_ip']);
        if (isset($data['local_mask']))$data['local_mask']= Crypt::encryptString($data['local_mask']);
        if (isset($data['local_gateway'])) $data['local_gateway'] = Crypt::encryptString($data['local_gateway']);
        if (isset($data['users'])) $data['users'] =Crypt::encryptString($data['users']);
        return $data;
    }

}
