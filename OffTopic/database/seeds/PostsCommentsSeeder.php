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
            'body' => 'Komentar za tema s id 3',
            'post_id' => 3,
            'user_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('posts_comments')->insert([
            'id' => 2,
            'body' => 'Komentar za tema s id 1',
            'post_id' => 1,
            'user_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('posts_comments')->insert([
            'id' => 3,
            'body' => 'Komentar za tema s id 1',
            'post_id' => 1,
            'user_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('posts_comments')->insert([
            'id' => 4,
            'body' => 'Komentar za tema s id 1',
            'post_id' => 1,
            'user_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('posts_comments')->insert([
            'id' => 5,
            'body' => 'Komentar za tema s id 5',
            'post_id' => 5,
            'user_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('posts_comments')->insert([
            'id' => 6,
            'body' => 'Komentar za tema s id 2',
            'post_id' => 2,
            'user_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('posts_comments')->insert([
            'id' => 7,
            'body' => 'Komentar za tema s id 2',
            'post_id' => 2,
            'user_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
