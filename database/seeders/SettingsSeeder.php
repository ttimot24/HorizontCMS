<?php

namespace Database\Seeders;

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
            'setting' => 'favicon',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'scroll_text',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'default_email',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'default_phone',
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
            'value' => 'TheWright',
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'language',
            'value' => 'en',
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'date_format',
            'value' => "Y.m.d H:i:s",
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
            'setting' => 'favicon',
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
            'setting' => 'admin_broadcast',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'website_type',
            'value' => "website",
            'more' => '1',
        ]);
        
        DB::table('settings')->insert([
            'setting' => 'blogposts_on_page',
            'value' => "5",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'default_user_role',
            'value' => "2",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'auto_upgrade_check',
            'value' => "1",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'use_https',
            'value' => "0",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'social_link_facebook',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'social_link_youtube',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'social_link_twitter',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'social_link_instagram',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'social_link_google',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'social_link_linkedin',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'social_link_github',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'social_link_gitlab',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'social_link_spotify',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'social_link_soundcloud',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'social_link_steam',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'setting' => 'social_link_reddit',
            'value' => "",
            'more' => '1',
        ]);

    }
}

