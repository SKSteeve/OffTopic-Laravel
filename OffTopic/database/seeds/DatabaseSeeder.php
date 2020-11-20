<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // use this command -> php artisan migrate:fresh --seed

        $this->call(UsersSeeder::class);
        $this->call(PostsSeeder::class);
        $this->call(PostsCommentsSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(RoleUserSeeder::class);
    }
}
