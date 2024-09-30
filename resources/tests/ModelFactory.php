<?php

class ModelFactory
{

    public static function createUser($active = false)
    {

        static $password;

        $name_array = ['John Doe', 'Jane Smith', 'Path Hacker', 'Rashmi Ramesh', 'Perpetua Gittel', 'Kamoliddin Florian', 'Walahfrid Germana'];

        $name = $name_array[array_rand($name_array)];

        $user = new \App\Model\User(
            [
                'name' => $name,
                'username' => str_replace(" ", ".", strtolower($name . " " . str_random(3))),
                'slug' => str_slug($name),
                'email' => strtolower(str_slug($name) . "@" . str_random(5) . ".com"),
                'password' =>  $password ?: $password = bcrypt('secret'),
                'remember_token' => str_random(10),
                'active' => $active ? 1 : 0,
            ]
        );

        $user->save();

        return $user;
    }
}
