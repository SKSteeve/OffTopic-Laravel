<?php


namespace App\Services;
use App\Post;
use App\PostComment;
use Illuminate\Support\Facades\Validator;

class PostsService
{
    public static function validatePostFields($fields)
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

    public static function validateCommentFields($fields)
    {
        $validator = Validator::make($fields, PostComment::$rules, PostComment::$messages);

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