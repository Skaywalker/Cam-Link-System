<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations;
use App\Models\Camera;


class Recorder extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'serial_number',
        'local_ip',
        'local_mask',
        'local_gateway',
        'users',
        'channels',
        'installer_id',
        'customer_id',
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recorderToCameras(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Camera::class, 'recorder_id','id');
    }
}
