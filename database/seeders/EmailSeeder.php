<?php

namespace Database\Seeders;

use App\Models\Email;
use App\Models\Phone;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('emails')->insert([
            [
                "email"=>"valeryyselivanova0@gmail.com",
                "is_active"=>true,
                "user_id"=>1,
                "email_verified_at"=>now()
            ],

            [
                "email"=>"arnoldsvarcneger86@gmail.com",
                "is_active"=>false,
                "user_id"=>1,
                "email_verified_at"=>now()
            ],

            [
                "email"=>"dreffka@gmail.com",
                "is_active"=>true,
                "user_id"=>2,
                "email_verified_at"=>now()
            ],

            [
                "email"=>"mustafa@gmail.com",
                "is_active"=>true,
                "user_id"=>3,
                "email_verified_at"=>now()
            ],

        ]);

        $users = User::all()->except([1, 2, 3]);

        foreach ($users as $user){

            $phones_quantity = rand(1,4);
            $emails_quantity = rand(1,4);

            Phone::factory()->count(1)->state(['user_id'=> $user->id, 'is_active'=>1])->create();
            Email::factory()->count(1)->state(['user_id'=> $user->id, 'is_active'=>1])->create();

            DB::table('token2fas')->insert([
                'user_id'=>$user->id
            ]);


                DB::table('role_user')->insert([
                    "role_id" => 4,
                    "user_id" => $user->id
                ]);

            if($phones_quantity > 1)
                Phone::factory()->count($phones_quantity-1)->state(['user_id'=> $user->id])
                    ->create();
            }

            if($emails_quantity > 1)
                Email::factory()->count($emails_quantity-1)->state(['user_id'=> $user->id])->create();
        }

}
