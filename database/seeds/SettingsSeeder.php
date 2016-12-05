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
            'setting' => 'title',
            'value' => "Your title",
            'more' => '1',
        ]);


        DB::table('settings')->insert([
            'setting' => 'site_name',
            'value' => "Your site",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'slogan',
            'value' => "Your awesome slogan",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'scroll_text',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'contact',
            'value' => "",
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

        DB::table('settings')->insert([
            'setting' => 'website_down',
            'value' => "0",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'logo',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'admin_logo',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'website_debug',
            'value' => "0",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'admin_debug',
            'value' => "0",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'website_type',
            'value' => "website",
            'more' => '1',
        ]);
        

        DB::table('settings')->insert([
            'setting' => 'auto_upgrade_check',
            'value' => "1",
            'more' => '1',
        ]);

    }
}

