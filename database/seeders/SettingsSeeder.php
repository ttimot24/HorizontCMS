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
            'group' => 'website', 
            'setting' => 'title',
            'value' => "Your title",
            'more' => '1',
        ]);


        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'site_name',
            'value' => "Your site",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'slogan',
            'value' => "Your awesome slogan",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'favicon',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'scroll_text',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'default_email',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'address',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'default_phone',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'contact',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'theme',
            'value' => 'TheWright',
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'language',
            'value' => 'en',
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'date_format',
            'value' => "Y.m.d H:i:s",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'home_page',
            'value' => 1,
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'website_down',
            'value' => "0",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'logo',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'favicon',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'admin', 
            'setting' => 'admin_logo',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'website_debug',
            'value' => "0",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'admin', 
            'setting' => 'admin_debug',
            'value' => "0",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'admin', 
            'setting' => 'admin_broadcast',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'website_type',
            'value' => "website",
            'more' => '1',
        ]);
        
        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'blogposts_on_page',
            'value' => "5",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'admin', 
            'setting' => 'default_user_role',
            'value' => "2",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'admin', 
            'setting' => 'auto_upgrade_check',
            'value' => "1",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'use_https',
            'value' => "0",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'social_link_facebook',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'social_link_youtube',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'social_link_twitter',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'social_link_instagram',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'social_link_google',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'social_link_linkedin',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'social_link_github',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'social_link_gitlab',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'social_link_spotify',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'social_link_soundcloud',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'social_link_tiktok',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'social_link_steam',
            'value' => "",
            'more' => '1',
        ]);

        DB::table('settings')->insert([
            'group' => 'website', 
            'setting' => 'social_link_reddit',
            'value' => "",
            'more' => '1',
        ]);


        DB::table('settings')->insert([
            'group' => 'admin', 
            'setting' => 'scheduler',
            'value' => "not configured",
            'more' => '1',
        ]);

    }
}

