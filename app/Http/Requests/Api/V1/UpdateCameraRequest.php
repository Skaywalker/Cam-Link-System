<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCameraRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
//        todo: Jogosultság kezelés! Felhasználó csak camera Namet tőlthet fel, installer az összes adatot kezelheti.
        if (Auth::user()->tokenCan('installer')|Auth::user()->tokenCan('change:CameraName')){
        return true;
    }
        return false;
    }



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        if (Auth::user()->tokenCan('installer')) {
            if ($this->method() == 'PUT') {
                return [
                    'name' => 'required',
                    'camera_img' => 'sometimes|required',
                    'local_ip' => 'required',
                    'local_mask' => 'required',
                    'local_gateway' => 'required',
                    'users' => 'sometimes|required',
                    'recorder_id' => 'required',
                ];
            } else {
                return [
                    'name' => 'sometimes|required',
                    'camera_img' => 'sometimes|required',
                    'local_ip' => 'sometimes|required',
                    'local_mask' => 'sometimes|required',
                    'local_gateway' => 'sometimes|required',
                    'users' => 'sometimes|required',
                    'recorder_id' => 'sometimes|required',
                ];
            }
        }
        if (Auth::user()->tokenCan('change:CameraName')) {
            if ($this->method() === 'PATCH') {
                return [
                    'name' => 'required'
                ];
            }
        }
        return [];
    }
    public function messages()
    {
        return [
            'name.required'=>'A név megadása kötelező!',
            'camera_img.required'=>'A kamera kép megadása kötelező!',
            'local_ip.required'=>'Az ip cím megadása kötelező!',
            'local_mask.required'=>'A net mask megadása kötelező!',
            'local_gateway.required'=>'A alapértelmezett átjáró megadása kötelező!',
            'users.required'=>'A felhasználómegadása kötelező!',
            'recorder_id.required'=>'A rögzitő megadása kötelező!',
        ];
    }
    public function prepareForValidation()
    {
        $merge =[];
        if ($this->users) $merge['users'] = json_encode($this->users);
        if ($this->name) $merge['name'] = $this->name;
        if ($this->cameraImg) $merge['camera_img'] = $this->cameraImg;
        if ($this->localIp) $merge['local_ip'] = $this->localIp;
        if ($this->localGateway) $merge['local_gateway'] = $this->localGateway;
        if ($this->localMask) $merge['local_mask'] =$this->localMask;
        if ($this->recorderId) $merge['recorder_id'] = $this->recorderId;
        $this->merge($merge);
    }
}
