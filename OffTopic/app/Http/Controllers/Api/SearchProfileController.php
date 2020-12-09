<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\SearchProfileResource;
class SearchProfileController extends Controller
{
    public function index(Request $request)
    {
        $searchingName = $request->input('name');

        // name, gender and country
        // get name from User model
        // get gender and country from UserProfile model

        $users = User::where('name', 'LIKE', "{$searchingName}%")->with('profile')->get();

        // TODO crate service that makes the search by name or pseudonym and return array
        return SearchProfileResource::collection($users);
//        return response()->json([$searchingName, $users]);
    }
}
