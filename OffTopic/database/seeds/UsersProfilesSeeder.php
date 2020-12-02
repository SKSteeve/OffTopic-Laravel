<?php

use Illuminate\Database\Seeder;

class UsersProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_profiles')->insert([
            'id' => 1,
            'user_id' => 1,
            'website' => 'Tosho-Blog.com',
            'tel_number' => '0891233341',
            'city' => 'Sofia',
            'description' => 'Hi im Tosho and I like programming a lot.',
            'gender' => 'male',
            'birthday' => now()->toDateString(),
            'country' => 'Bulgaria',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users_profiles')->insert([
            'id' => 2,
            'user_id' => 2,
            'website' => 'marakuq.com',
            'tel_number' => '0891999941',
            'city' => 'Sofia',
            'description' => 'Hi im Marto and I like to travel, workout and program. I have a lot of experience with Js. You can visit my website if u want and learn some tips.',
            'gender' => 'male',
            'birthday' => now()->toDateString(),
            'country' => 'Bulgaria',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users_profiles')->insert([
            'id' => 3,
            'user_id' => 3,
            'website' => 'robot-shop.com',
            'tel_number' => '0891113341',
            'city' => 'Burgas',
            'description' => 'Straci never give up!',
            'gender' => 'male',
            'birthday' => now()->toDateString(),
            'country' => 'Bulgaria',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users_profiles')->insert([
            'id' => 4,
            'user_id' => 4,
            'tel_number' => '0891177346',
            'city' => 'Sofia',
            'description' => 'Hi im the admin. If you have questions, ask on my email.',
            'gender' => 'male',
            'birthday' => now()->toDateString(),
            'country' => 'Turkey',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users_profiles')->insert([
            'id' => 5,
            'user_id' => 5,
            'tel_number' => '0896177778',
            'city' => 'Sofia',
            'description' => 'Your current situation is not your final destination.',
            'gender' => 'male',
            'birthday' => now()->toDateString(),
            'country' => 'Bulgaria',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
