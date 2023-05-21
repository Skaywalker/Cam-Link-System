<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class RecorderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        if(isset($this->name)) $this->name=Crypt::decryptString($this->name);
        if (isset($this->serial_number))$this->serial_number=Crypt::decryptString($this->serial_number);
        if (isset($this->local_ip)) $this->local_ip=Crypt::decryptString($this->local_ip);
        if(isset($this->local_mask)) $this->local_mask=Crypt::decryptString($this->local_mask);
        if(isset($this->local_gateway)) $this->local_gateway=Crypt::decryptString($this->local_gateway);
        if(isset($this->chenels)) $this->channels=Crypt::decryptString($this->channels);
        if(isset($this->users)) $this->users=Crypt::decryptString($this->users);
        if(isset($this->users)) $this->users=json_decode($this->users);
        if(isset($this->channels)) $this->channels=json_decode($this->channels);

        return ['id' => $this->id,
            'name' => $this->name,
            'serialNumber'=>$this->serial_number,
            'localIp'=>$this->local_ip,
            'localMask'=>$this->local_mask,
            'localGateway'=>$this->local_gateway,
            'users'=>$this->users,
            'channels'=>$this->channels,
            'installerId'=>$this->installer_id,
            'cameras'=>CameraResource::collection($this->whenLoaded('recorderToCameras'))
        ];
    }
}
