<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
          $user = new User();
          $user->name = str_random(10);
          $user->email = str_random(10).'@gmail.com';
          $user->password = bcrypt('secret');
          $user->created_at = Carbon::now()->format('Y-m-d H:i:s');
          $user->updated_at = Carbon::now()->format('Y-m-d H:i:s');
          $profile = new \App\Profile();
          $profile->nickname = str_random(4);
          $user->save();
          $user->profile()->save($profile);
        }

        User::find(5)->groups()->attach([7, 8, 9]);
    }
}
