<?php

use Illuminate\Database\Seeder;

class FriendRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('friend_requests')->insert([
            'id' => 1,
            'requested_user_id' => 4,
            'sender_user_id' => 3,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        DB::table('friend_requests')->insert([
            'id' => 2,
            'requested_user_id' => 5,
            'sender_user_id' => 3,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        DB::table('friend_requests')->insert([
            'id' => 3,
            'requested_user_id' => 4,
            'sender_user_id' => 5,
            'created_at' => now(),
            'updated_at' => null,
        ]);

    }
}
