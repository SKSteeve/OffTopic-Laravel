<?php

use Illuminate\Database\Seeder;

class NotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notifications')->insert([
            'id' => 1,
            'name' => 'New Friend',
            'body' => 'You are now friends with Tosho',
            'user_id' => 4,
            'sender_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
            'deleted_at' => null,
        ]);

        DB::table('notifications')->insert([
            'id' => 2,
            'name' => 'System',
            'body' => 'Your email is not secured! Please change it as soon as possible!',
            'user_id' => 4,
            'sender_id' => null,
            'created_at' => now(),
            'updated_at' => null,
            'deleted_at' => null,
        ]);

        DB::table('notifications')->insert([
            'id' => 3,
            'name' => 'Friend Request',
            'body' => 'You received new friend request from Stracimir',
            'user_id' => 4,
            'sender_id' => 3,
            'created_at' => now(),
            'updated_at' => null,
            'deleted_at' => null,
        ]);

        DB::table('notifications')->insert([
            'id' => 4,
            'name' => 'New Friend',
            'body' => 'You are now friends with Martin',
            'user_id' => 4,
            'sender_id' => 2,
            'created_at' => now(),
            'updated_at' => null,
            'deleted_at' => null,
        ]);

        DB::table('notifications')->insert([
            'id' => 5,
            'name' => 'Friend Request',
            'body' => 'You received new friend request from Stracimir',
            'user_id' => 5,
            'sender_id' => 3,
            'created_at' => now(),
            'updated_at' => null,
            'deleted_at' => null,
        ]);

        DB::table('notifications')->insert([
            'id' => 6,
            'name' => 'Friend Request',
            'body' => 'You received new friend request from Ivan',
            'user_id' => 4,
            'sender_id' => 5,
            'created_at' => now(),
            'updated_at' => null,
            'deleted_at' => null,
        ]);
    }
}
