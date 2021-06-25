<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Faker\Factory as Faker;




class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        define("NUM_USERS", 5000000);

        for ($i = 1; $i <= NUM_USERS; $i++) {
            /* Username: user1, user2, user3... */
            $uid = $i;
            $username = 'testuser' . strval($i);


            /* User Profiles */
            DB::table('users')->insert([
                'firstname'         => $faker->firstName(),
                'lastname'          => $faker->lastName,
                'username'          => $username,
                'password'          => Hash::make("password"),
                'auth_provider'     => Arr::random(['Google', 'Kakao', 'None']),
                'uid_oauth'         => str_random(10),
                'email'             => $faker->unique()->email,
                'cell'              => '010' . '-' . strval(rand(100, 9999)) . '-' . strval(rand(1000, 9999)),
                'stream_id'         => str_random(32),
                'stream_key'        => str_random(32),
                'status'            => 'FINE',
                'response'          => 'RESOLVED',
                'privacy'           => 'PRIVATE',
                'proxy_enable'      => true,
                'password_hint'     => 'my hint',
                'hint_answer'       => 'my answer'
            ]);


            /* Camera Registration */
            DB::table('camera_registered')->insert([
                'model_no'  => $username . strval('1'),
                'revision'  => strval(1),
                'cam_id'    => $faker->unique()->numberBetween(1000, 10000000),
                'owner_uid' => $uid
            ]);


            /* Update current user's credit */
            DB::table('credits')->insert([
                'uid' => $uid,
                'credits' => '1000'
            ]);

            if ((intval($uid) % 5) == 4) {
                for ($iter = 0; $iter < 4; $iter++) {
                    DB::table('guardianship')->insert([
                        'uid_protected' => $uid,
                        'uid_guardian'  => ($uid - ($uid % 5)) + $iter,
                        'signed_protected' => 'ACCEPTED',
                        'signed_guardian' => 'ACCEPTED'
                    ]);
                }
            }



            /* Create one random report per user */
            /*
            $status = Arr::random([
                'DANGER_URGENT_RESPONSE',
                'DANGER_MEASURED_RESPONSE',
                'DANGER_PUBLIC_RESPONSE',
                'FINE'
            ]);
            if ($status == 'FINE')
                $response = 'RESOLVED';
            else
                $response  = Arr::random([
                    'RESPONSE_REQUIRED',
                    'FIRST_RESPONDERS_DISPATCHED',
                    'FIRST_RESPONDERS_ARRIVED',
                    'RESOLVING',
                    'RESOLVED'
                ]);

            DB::table('reports')->insert([
                'uid'           => strval($i),
                'status'        => $status,
                'response'      => $response,
                'responders'    => '',
                'description'   => '',
                'stream_key'    => Hash::make(str_random(10)),
            ]);
            */
        }
    }
}
