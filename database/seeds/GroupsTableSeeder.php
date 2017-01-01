<?php

use Illuminate\Database\Seeder;
use App\Group;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      for ($i = 0; $i < 10; $i++) {
        $group = new App\Group();
        $group->setAttribute('name', "group $i");
        $group->save();
        //$group->users()->attach([1, 2, 3]);
        $group->save();
      }
    }
}
