<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camera extends Model
{
    protected $fillable=[
        'name',
        'camera_img',
        'local_ip',
        'local_mask',
        'local_gateway',
        'users',
        'recorder_id'
    ];
    use HasFactory;
    public function cameraToRecorders(){
        return $this->belongsTo(Recorder::class);
    }
}
