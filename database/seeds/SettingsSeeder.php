<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('settings')->insert([
            'setting' => 'site_name',
            'value' => "Your site",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'theme',
            'value' => 'creative',
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'language',
            'value' => 'en',
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'home_page',
            'value' => 1,
            'more' => '1',
        ]);
    }
}
