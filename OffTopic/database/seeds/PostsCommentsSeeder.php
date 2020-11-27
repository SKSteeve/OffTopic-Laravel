<?php

use Illuminate\Database\Seeder;

class PostsCommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts_comments')->insert([
            'id' => 1,
            'body' => 'I cant understand, can u help me please ?',
            'post_id' => 3,
            'user_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('posts_comments')->insert([
            'id' => 2,
            'body' => 'Laravel suck dude, php suck, life suck HAHAAHA',
            'post_id' => 1,
            'user_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('posts_comments')->insert([
            'id' => 3,
            'body' => 'I want to spam ...................',
            'post_id' => 1,
            'user_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('posts_comments')->insert([
            'id' => 4,
            'body' => 'Nice. I like it too.',
            'post_id' => 1,
            'user_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('posts_comments')->insert([
            'id' => 5,
            'body' => 'Im working with laravel for last 4 years and I agree with this.',
            'post_id' => 5,
            'user_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('posts_comments')->insert([
            'id' => 6,
            'body' => 'By the end of 2017, 25 of 30 PHP developers in my technology firm switched from various other PHP frameworks: CodeIgniter, Yii, Zend, etc. to Laravel. This switch piqued my interest in Laravel and made me curious about this framework for php development. I decided to dig further only to find it isn’t just my firm everybody is making the switch.',
            'post_id' => 2,
            'user_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('posts_comments')->insert([
            'id' => 7,
            'body' => 'My journey with Laravel started back in 2015. As a senior developer I can say that its a pleasure to work on Laravel and make different projects ... from small to medium. Its easy and fast to build professional apps. Your choice for framework is good.',
            'post_id' => 2,
            'user_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('posts_comments')->insert([
            'id' => 8,
            'body' => 'Nice project. I like it, but u still have a lot of work to do.',
            'post_id' => 1,
            'user_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('posts_comments')->insert([
            'id' => 9,
            'body' => 'I like your project. Hope you get hired as soon as you complete it :)',
            'post_id' => 1,
            'user_id' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('posts_comments')->insert([
            'id' => 10,
            'body' => 'Yes, Laravel is probably the best php framework in 2020.',
            'post_id' => 2,
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('posts_comments')->insert([
            'id' => 11,
            'body' => 'I like it too.',
            'post_id' => 2,
            'user_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('posts_comments')->insert([
            'id' => 12,
            'body' => 'Its noobie project but keep going. One day you will become pro, just dont give up!',
            'post_id' => 1,
            'user_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
