<?php

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
            'name'       => 'Public',
            'permission' => 0,
            'rights'     => null,
        ]);

        DB::table('user_roles')->insert([
            'name'       => 'User',
            'permission' => 1,
            'rights'     => null,
        ]);


        DB::table('user_roles')->insert([
            'name'       => 'Member',
            'permission' => 2,
            'rights'     => null,
        ]);

        DB::table('user_roles')->insert([
            'name'       => 'Editor',
            'permission' => 3,
            'rights'     => json_encode(['admin_area', 'blogpost', 'user', 'page', 'media']),
        ]);

        DB::table('user_roles')->insert([
            'name'       => 'Manager',
            'permission' => 4,
            'rights'     => json_encode(['admin_area', 'blogpost', 'user', 'page', 'media', 'themes&apps', 'settings']),
        ]);

        DB::table('user_roles')->insert([
            'name'       => 'Administrator',
            'permission' => 5,
            'rights'     => json_encode(['admin_area', 'blogpost', 'user', 'page', 'media', 'themes&apps', 'settings']),
        ]);
    }
}
