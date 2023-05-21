<?php

namespace Database\Factories;

use App\Models\Recorder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;
use Psy\Util\Json;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Camera>
 */
class CameraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->lastName;
        $users=[
            'username'=>$this->faker->lastName,
            'password'=>$this->faker->password(8),
        ];
        $users= Json::encode($users,JSON_UNESCAPED_SLASHES);
        $randomImg='https://picsum.photos/200/300?random=' . $this->faker->randomNumber(5);
        $local_ip=$this->faker->ipv4;
        $local_netMask=$this->faker->ipv4;
        $local_defaultGw=$this->faker->ipv4;
        $recorderId=Recorder::factory();

        $local_ip=Crypt::encryptString($local_ip);
        $local_netMask=Crypt::encryptString($local_netMask);
        $local_defaultGw=Crypt::encryptString($local_defaultGw);
        $users=Crypt::encryptString($users);
        $randomImg=Crypt::encryptString($randomImg);
        $name=Crypt::encryptString($name);
        return [
            'name' => $name,
            'camera_img' => $randomImg,
            'local_ip' => $local_ip,
            'local_mask'=>$local_netMask,
            'local_gateway'=>$local_defaultGw,
            'users' => $users,
            'recorder_id' => $recorderId
        ];
    }
}
