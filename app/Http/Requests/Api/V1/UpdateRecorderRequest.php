<?php

namespace App\Http\Requests\Api\V1;

use App\Models\Recorder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UpdateRecorderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        //todo: Serial_number ellenőrzésre valami szebb modot találni!
        $method=$this->method();
        if ($method==="PUT"){
            $rules=['name' => 'required',
                'serial_number' => 'required',
                'local_ip' => 'required',
                'local_mask' => 'required',
                'local_gateway' => 'required',
                'users' => 'required',
                'channels' => 'required',
                'customer_id' => 'required',];
            $data=Recorder::all();
            foreach ($data as $item) {
                $item = Crypt::decryptString($item->serial_number);
                if ($item === $this->serial_number) {
                    $rules['serial_number']= 'max:1';
                }
            }
        return $rules;
        }else {
            $rules=['name' => 'sometimes|required',
                'serial_number' => 'sometimes|required',
                'local_ip' => 'sometimes|required',
                'local_mask' => 'sometimes|required',
                'local_gateway' => 'sometimes|required',
                'users' => 'sometimes|required',
                'channels' => 'sometimes|required',
                'customer_id' => 'sometimes|required'];
            //todo: Serial_number ellenőrzésre valami szebb modot találni!

            $data=Recorder::all();
            foreach ($data as $item) {
                $item = Crypt::decryptString($item->serial_number);
                if ($item === $this->serial_number) {
                    $rules['serial_number']= 'max:1';
                }
            }

            return $rules;
        }
    }
    protected function prepareForValidation()
    {

        $merge =[];
        if ($this->users) $merge['users'] = json_encode($this->users);
        if ($this->serialNumber) $merge['serial_number'] = $this->serialNumber;
        if ($this->localIp) $merge['local_ip'] = $this->localIp;
        if ($this->localGateway) $merge['local_gateway'] = $this->localGateway;
        if ($this->localMask) $merge['local_mask'] =$this->localMask;
        if ($this->installerId) $merge['installer_id'] = $this->installerId;
        if ($this->customerId) $merge['customer_id'] = $this->customerId;
        if ($this->channels) $merge['channels'] =json_encode($this->channels);
        $this->merge($merge);
    }
    public  function messages()
    {
        return[
            'name.required'=>'A név megadása kötelező.',
            'serial_number.required'=>'A sorozatszám megadása kötelező.',
            'serial_number.max'=>'A sorozatszám már szerepel a rendszerben!',
            'local_ip.required'=>'Az ip cím megadása kötelező megadása kötelező!',
            'local_mask.required'=>'A hálozati massk megadása kötelező. megadás kötelező!',
            'local_gateway.required'=>'A az alapértelemezet átjáró megadás kötelező!',
            'users.required'=>'A felhasználói adatok megadása kötelező!',
            'channels.required'=>'A csatornák megadása kötelező!',
            'costumer_id'=>'Az ügyvél kiválasztása kötelező!',
        ];
    }
}
