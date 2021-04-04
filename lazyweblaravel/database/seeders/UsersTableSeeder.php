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
            $username = 'user' . strval($i);


            /* Insert random users into database */
            DB::table('users')->insert([
                'firstname'         => $faker->firstName(),
                'lastname'          => $faker->lastName,
                'username'          => $username,
                'password'          => Hash::make("secret" . strval($i)),
                'auth_provider'     => Arr::random(['Google', 'Kakao', 'None']),
                'uid_oauth'         => str_random(10),
                'faceshot_url'      => str_random(10),
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


            DB::table('camera_registered')->insert([
                'model_no'  => $username . strval('1'),
                'revision'  => strval(1),
                'cam_id'    => $faker->unique()->numberBetween(1000, 10000000),
                'owner_uid' => $uid
            ]);


            /* Update current user's credit */
            DB::table('credit')->insert([
                'uid' => $uid,
                'credits' => '0'
            ]);

            DB::table('guardianship')->insert([
                'uid_protected' => ($uid==2) ? 3 : 2,
                'uid_guardian'  => ($uid==2) ? 2 : $uid,
                'signed_protected' => 1,
                'signed_guardian' => 1
            ]);



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


        /*
        DB::table('friendship')->insert([
            'uid_user1'        => strval(rand(1, 200)),
            'uid_user2'        => strval(rand(1, 200))
        ]);
        */
    }
}
