<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\SearchProfileResource;

class SearchProfileController extends Controller
{
    public function index(Request $request)
    {
        $searchingName = $request->input('name');
        $users = User::where('name', 'LIKE', "{$searchingName}%")->with('profile')->get();

        return SearchProfileResource::collection($users);
        // return response()->json([$searchingName, $users]);
    }
}
