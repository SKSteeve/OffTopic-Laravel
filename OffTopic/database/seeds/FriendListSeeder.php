<?php

use Illuminate\Database\Seeder;

class FriendListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('friend_list')->insert([
            'id' => 1,
            'user_id' => 4,
            'friend_id' => 1,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        DB::table('friend_list')->insert([
            'id' => 2,
            'user_id' => 1,
            'friend_id' => 4,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        DB::table('friend_list')->insert([
            'id' => 3,
            'user_id' => 4,
            'friend_id' => 2,
            'created_at' => now(),
            'updated_at' => null,
        ]);

        DB::table('friend_list')->insert([
            'id' => 4,
            'user_id' => 2,
            'friend_id' => 4,
            'created_at' => now(),
            'updated_at' => null,
        ]);
    }
}
