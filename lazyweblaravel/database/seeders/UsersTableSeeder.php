<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;




class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        define("NUM_USERS", 100);

        for ($i = 1; $i <= NUM_USERS; $i++)
        {
            /* Username: user1, user2, user3... */
            $curr_user = 'user' . strval($i);

            /* Insert random users into database */
            DB::table('users')->insert([
                'firstname' => str_random(10),
                'lastname' => str_random(10),
                'username' => $curr_user,
                'password' => Hash::make("secret"),
                'auth_provider' => Arr::random(['Google', 'Kakao', 'None']),
                'id_external' => str_random(10),
                'faceshot_url' => str_random(10),
                'email' => str_random(10) . '@company.com',
                'cell' => strval(rand(100,999)) . '-' . strval(rand(1000,9999)) .
                            '-' . strval(rand(100,999)),
                'stream_id' => str_random(32),
                'status' => 'FINE',
                'response' => 'RESOLVED',
                'privacy' => 'PRIVATE',
                'proxy_enable' => 1,
                'password_hint' => 'my hint',
                'hint_answer' => 'my answer'
            ]);

            /*
            DB::table('friends')->insert([
                'uid_guardian'      => ,
                'uid_protected'     => ,
                'signed_guardian'   => ,
                'signed_protected'  =>
            ]);
            */

            /* Update current user's credit */
            DB::table('credit')->insert([
                'uid' => strval($i),
                'credits' => '0'
            ]);


            /* Create one random report per user */
            $status = Arr::random(['DANGER_URGENT_RESPONSE',
                                    'DANGER_MEASURED_RESPONSE',
                                    'DANGER_PUBLIC_RESPONSE',
                                    'FINE']);
            if ($status == 'FINE')
                $response = 'RESOLVED';
            else
                $response  = Arr::random(['RESPONSE_REQUIRED',
                                        'FIRST_RESPONDERS_DISPATCHED',
                                        'FIRST_RESPONDERS_ARRIVED',
                                        'RESOLVING',
                                        'RESOLVED']);

            DB::table('reports')->insert([
                'uid'           => strval($i),
                'status'        => $status,
                'response'      => $response,
                'responders'    => '',
                'description'   => '',
                'stream_key'    => Hash::make(str_random(10)),
            ]);



        }

        DB::table('friendship')->insert([
            'uid_user1'        => strval(2),
            'uid_user2'        => strval(3)
        ]);
    }
}
