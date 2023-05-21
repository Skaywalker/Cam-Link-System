<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class CameraResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        if (isset($this->name))$this->name=Crypt::decryptString($this->name);
        if(isset($this->camera_img))$this->camera_img=Crypt::decryptString($this->camera_img);
        if(isset($this->local_ip))$this->local_ip=Crypt::decryptString($this->local_ip);
        if(isset($this->local_mask)) $this->local_mask=Crypt::decryptString($this->local_mask);
        if(isset($this->local_gateway)) $this->local_gateway=Crypt::decryptString($this->local_gateway);
        if(isset($this->users)) $this->users=Crypt::decryptString($this->users);
        if(isset($this->users)) $this->users=json_decode($this->users);

        return [
            'id'=>$this->id,
            'name' => $this->name,
            'cameraImg'=>$this->camera_img,
            'localIp'=>$this->local_ip,
            'localMask'=>$this->local_mask,
            'localGateway'=>$this->local_gateway,
            'users'=>$this->users,
        ];
    }
}
