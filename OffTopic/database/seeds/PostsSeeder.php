<?php

use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'id' => 1,
            'title' => 'My project',
            'body' => 'Hello. Welcome to my project build to learn new technologies and get some experience. I used Laravel PHP framework, JS, jQuery, MySql, Bootstrap, HTML, CSS. The project is still in progress. I hope you like what you see for now.',
            'user_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('posts')->insert([
            'id' => 2,
            'title' => 'I like Laravel',
            'body' => 'Laravel has exploded in popularity. It has become one of the most popular, and widely used PHP frameworks in a short span of time. It\'s been close to 2 years since I have started using it; and I must confess, Laravel is indeed an elegant framework. This post will cover my experience using the Laravel framework, why I love it and why it is highly recommended for all the PHP developers. Laravel is an open source, modern PHP framework for building web applications rapidly. It also follows the Model-View-Controller (MVC) architectural pattern. Laravel ships with lots of great features which make building web applications simpler, expressive, easier, and faster. Some of these features which Laravel provides out of the box.',
            'user_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('posts')->insert([
            'id' => 3,
            'title' => 'How to use Gates in Laravel',
            'body' => 'Gates allow you to define an authorization rule using a simple closure-based approach. In other words, when you want to authorize an action that\'s not related to any specific model, the gate is the perfect place to implement that logic.',
            'user_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('posts')->insert([
            'id' => 4,
            'title' => 'Abut Bulgarian nature',
            'body' => '
                Before trying to astonish you, I need to tell you some facts about Bulgaria’s geography first:

                1. Tucked in the heart of the Balkan Peninsula in the South-Eastern part of Europe, at a crossroad between Europe and Asia, Bulgaria borders Turkey, Greece, Serbia, Macedonia, and Romania. Its natural borders are also the Black Sea and the Danube River.
                2. With a size of almost 111,000 km2 (~43,000 mi2), Bulgaria is as big as Ohio, slightly smaller than neighbouring Greece, somewhere between the sizes of North Korea and South Korea, and approximately half the size of Uganda.
                3. The highest Bulgarian mountain, Rila Mountain, is also the highest on the Balkans. Its tallest peak – Musala (2,925 m/9,596 ft.) – is higher than Mount Olympus by seven metres.
                4. The mountain range, which gave the Balkan Peninsula its name, runs through the whole width of Bulgaria. The former name of what we now call Stara planina (literally: Old Mountain) was Balkan. It stretches from Serbia, divides Bulgaria into Northern and Southern, and kisses the Black Sea at Cape Emine.
            ',
            'user_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('posts')->insert([
            'id' => 5,
            'title' => 'Security in Laravel',
            'body' => 'In my opinion, what you should be aware of:

                1- It is not only Laravel alone that is responsible for your web application security, but the environment surrounding it.
                    - Web server should be configured correctly and secure.
                    - It is an advantage to SSL (Certificate) among your domain.
                    - Do only use SFTP over SSH for file transfer and do only use SSH for console connection.
                    - Use trusted provider and physically secured Server environment.
                    - Backup your files and your database regularly and move the data out side your provider server location.
                    - Make different username and password for SSH console, database or other services.
                    - For SSH access and Database access, do not use admin or root username often, keep it only for emergency use, in stead create a sub admin/root account and use that in stead.
                
                2- Above all of that, when you further develop on your Laravel, you might risk performing bad programming which breaks the default security rules of Laravel.',
            'user_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
