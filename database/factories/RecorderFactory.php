<?php

namespace Database\Factories;

use App\Models\Camera;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;
use Psy\Util\Json;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recorder>
 */
class RecorderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name();

        $serial=$this->faker->regexify('[A-Z0-9]{16}');
        $local_ip=$this->faker->ipv4;
        $local_netMassk=$this->faker->ipv4;
        $local_defaultGw=$this->faker->ipv4;
        $users=[
            'username'=>$this->faker->lastName(null),
            'password'=>$this->faker->password(8),
            'permissions'=>array([
                'id'=>'camera_id',
                'permissions'=>$this->faker->randomElement(['view','notView'])
            ],
            [
                'id'=>'camera_id',
                'permissions'=>$this->faker->randomElement(['view','notView'])
            ],[
                'id'=>'camera_id',
                'permissions'=>$this->faker->randomElement(['view','notView'])
            ],[
                'id'=>'camera_id',
                'permissions'=>$this->faker->randomElement(['view','notView'])
            ]),
            ];
        $users=Json::encode($users, JSON_UNESCAPED_SLASHES);
        $channels=[
          'ch1'=>'camera_id',
          'ch2'=>'camera_id'
        ];
        $channels=Json::encode($channels, JSON_UNESCAPED_SLASHES);
        $installer_id= $this->faker->randomElement([3,2]);
        $name=Crypt::encryptString($name);
        $serial=Crypt::encryptString($serial);
        $local_ip=Crypt::encryptString($local_ip);
        $local_netMassk=Crypt::encryptString($local_netMassk);
        $local_defaultGw=Crypt::encryptString($local_defaultGw);
        $users=Crypt::encryptString($users);
        $channels=Crypt::encryptString($channels);

        return [
            'name' =>$name,
            'serial_number'=>$serial,
            'local_ip'=>$local_ip,
            'local_mask'=>$local_netMassk,
            'local_gateway'=>$local_defaultGw,
            'users'=>$users,
            'channels'=>$channels,
            'installer_id'=>$installer_id,
            'customer_id'=>$this->faker->randomElement([1,1]),
            ];
    }
}
