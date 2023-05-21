<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreCameraRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
//       todo: Autentikáció megvalositásáa szűkséges!
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'camera_img' => 'sometimes|required',
            'local_ip' => 'required',
            'local_mask' => 'required',
            'local_gateway' => 'required',
            'users' => 'sometimes|required',
            'recorder_id' => 'required',
        ];
    }
    public function messages()
    {
        return[
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
        $users=json_encode($this->users);
        $this->merge([
            'local_ip'=>$this->localIp,
            'local_mask'=>$this->localMask,
            'camera_img'=>$this->cameraImg,
            'local_gateway'=>$this->localGateway,
            'recorder_id'=>$this->recorderId,
            'users'=>$users
        ]);

    }
}
