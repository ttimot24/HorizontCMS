<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->insert([
            'id' => 1,
            'name' => 'Home',
            'slug' => 'home',
            'url' => '',
            'visibility' => 1,
            'parent_id' => NULL,
            'queue' => 1,
            'page' => 'Welcome on the homepage of your site!',
            'author_id' => 1,
            'image' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => NULL,
            'active' => 1
        ]);

        DB::table('blogposts')->insert([
            'id' => 1,
            'title' => 'First post',
            'slug' => 'first-post',
            'summary' => 'Your very first post.',
            'text' => 'If you see this, the install was successfull!',
            'category_id' => 1,
            'comments_enabled' => 1,
            'author_id' => 1,
            'image' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => NULL,
            'active' => 1
        ]);

        DB::table('blogpost_categories')->insert([
            'id' => 1,
            'name' => 'default',
            'author_id' => 1,
            'image' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => NULL,
        ]);


    }
}