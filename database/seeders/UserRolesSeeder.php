<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            'name' => 'Public',
            'permission' => 0,
            'rights' => NULL,
        ]);

        DB::table('user_roles')->insert([
            'name' => 'User',
            'permission' => 1,
            'rights' => NULL,
        ]);


        DB::table('user_roles')->insert([
            'name' => 'Member',
            'permission' => 2,
            'rights' => NULL,
        ]);

        DB::table('user_roles')->insert([
            'name' => 'Editor',
            'permission' => 3,
            'rights' => json_encode(['admin_area','blogpost','blogpostcategory','blogpostcomment','user','page','filemanager','headerimage','search']),
        ]);

        DB::table('user_roles')->insert([
            'name' => 'Manager',
            'permission' => 4,
            'rights' => json_encode(['admin_area','blogpost','blogpostcategory','blogpostcomment','user','userrole','page','plugin','filemanager','headerimage','search']),
        ]);

         DB::table('user_roles')->insert([
            'name' => 'Admin',
            'permission' => 5,
            'rights' => json_encode(['admin_area','blogpost','blogpostcategory','blogpostcomment','user','userrole','page','theme','plugin','filemanager','headerimage','schedule','search','settings']),
        ]);


    }
}