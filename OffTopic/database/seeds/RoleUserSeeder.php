<?php

use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_user')->insert([
            'id' => 1,
            'role_id' => 2,
            'user_id' => 3
        ]);

        DB::table('role_user')->insert([
            'id' => 2,
            'role_id' => 1,
            'user_id' => 4
        ]);

        DB::table('role_user')->insert([
            'id' => 3,
            'role_id' => 3,
            'user_id' => 5
        ]);

        DB::table('role_user')->insert([
            'id' => 4,
            'role_id' => 3,
            'user_id' => 2
        ]);

        DB::table('role_user')->insert([
            'id' => 5,
            'role_id' => 3,
            'user_id' => 1
        ]);

        DB::table('role_user')->insert([
            'id' => 6,
            'role_id' => 2,
            'user_id' => 4
        ]);

        DB::table('role_user')->insert([
            'id' => 7,
            'role_id' => 3,
            'user_id' => 4
        ]);
    }
}
