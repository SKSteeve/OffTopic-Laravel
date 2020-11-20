<?php


namespace App\Services;
use App\Post;
use Illuminate\Support\Facades\Validator;

class PostsService
{
    public static function validate($fields)
    {
        $validator = Validator::make($fields, Post::$rules, Post::$messages);

        if($validator->fails()) {
            return [
                'status' => -1,
                'errors' => $validator->errors()
            ];
        }

        return $response = [
            'status' => 1
        ];
    }
}