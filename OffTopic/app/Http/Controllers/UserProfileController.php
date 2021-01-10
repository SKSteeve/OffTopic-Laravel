<?php

namespace App\Http\Controllers;

use App\Services\UserProfileService;
use App\User;
use App\UserProfile;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;

class UserProfileController extends Controller
{
    /**
     * Display a view with form to search for a specific resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profile_views.search-profile');
    }


    /**
     * Display the User Profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::check()) {
            $user = User::findOrFail($id);
            $profileInfo = $user->profile;

            if(FriendListController::checkIfFriends($id)) {
                $friendshipButtonText = 'Unfriend';
                $friendshipButtonValue = 'deleteFriend';
                $friendshipButtonClass = 'btn-danger';
            } else {
                if(FriendRequestsController::checkIfRequestExist($id, Auth::id())) {
                    $friendshipButtonText = 'Requested';
                    $friendshipButtonValue = 'deleteRequest';
                    $friendshipButtonClass = 'btn-secondary';
                } else if(FriendRequestsController::checkIfRequestExist(Auth::id(), $id)) {
                    $friendshipButtonText = 'Accept Friend';
                    $friendshipButtonValue = 'acceptFriend';
                    $friendshipButtonClass = 'btn-secondary';
                } else {
                    $friendshipButtonText = 'Send Friend Request';
                    $friendshipButtonValue = 'createRequest';
                    $friendshipButtonClass = 'btn-primary';
                }
            }

            return view('profile_views.profile')->with(['id' => $id, 'user' => $user, 'profileInfo' => $profileInfo, 'friendshipBtnText' => $friendshipButtonText, 'friendshipBtnValue' => $friendshipButtonValue, 'friendshipBtnClass' => $friendshipButtonClass]);
        }

        return redirect('/login')->with('error', 'You must be logged to see profiles.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::allows('edit-user-profile') || Auth::id() == $id) {
            $user = User::findOrFail($id);

            if($user->profile && !empty($user->profile->birthday)) {
                $birthday = $user->profile->birthday;
                list($birthYear, $birthMonth, $birthDate) = explode('-', $birthday);
            } else {
                $birthYear = '-';
                $birthMonth = '-';
                $birthDate = '-';
            }

            $userProfileService = new UserProfileService;

            return view('profile_views.edit')->with([
                    'user' => $user,
                    'birthDate' => $birthDate,
                    'birthMonth' => $birthMonth,
                    'birthYear' => $birthYear,

                    'countries' => $userProfileService->getCountries(),
                    'days' => $userProfileService->getDays(),
                    'months' => $userProfileService->getMonths(),
                    'years' => $userProfileService->getYears(),
                ]);
        }

        return redirect('/users/profile')->with('error', 'Access denied!');
    }


    /**
     *  Take the input data, validate it and prepare it for update or create
     *  Check if we are updating or creating new UserProfile
     *  and call the specified function
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createOrUpdate(Request $request, $id)
    {
        if(Auth::check() && (Auth::id() == $id || Gate::allows('edit-user-profile'))) {

            $validateResponse = UserProfileService::validateUserProfileFields($request->all());

            if($validateResponse['status'] == -1) {
                $errors = $validateResponse['errors'];
                return redirect("/users/profile/$id/edit")->with(['errors' => $errors,
                    'name' => $request->input('name'),
                    'city' => $request->input('city'),
                    'tel_number' => $request->input('tel_number'),
                    'website' => $request->input('website'),
                    'description' => $request->input('description'),
                ]);
            }

            $year = $request->input('year');
            $month = $request->input('month');
            $date = $request->input('date');

            if(empty($year) ||  empty($month) || empty($date)) {
                $birthday = null;
            } else {
                $birthday = "$year-$month-$date";
            }

            if($request->hasFile('profile_picture')) {
                $fileNameWithExtension = $request->file('profile_picture')->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
                $extension = $request->file('profile_picture')->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                $path = $request->file('profile_picture')->storeAs('public/profile_pictures', $fileNameToStore);

            } else {
                $fileNameToStore = 'noimage.jpg';
            }

            $userProfile = UserProfile::where('user_id', $id);

            if($userProfile->exists()) {                                // update user profile details
                return $this->update($request, $id, $userProfile, $birthday, $fileNameToStore);
            } else {                                                    // create user profile details
                return $this->create($request, $id, $birthday, $fileNameToStore);
            }
        }
        return redirect('/users/profile')->with('error', 'Access denied!');
    }



    /**
     *  Create the specified resource in table users_profiles.
     *  Accessible with UserProfile model
     *
     * @param Request $request
     * @param $id
     * @param $birthday
     * @param $fileNameToStore
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create(Request $request, $id, $birthday, $fileNameToStore)
    {
        UserProfile::create([
            'user_id' => $id,
            'website' => $request->input('website'),
            'tel_number' => $request->input('tel_number'),
            'city' => $request->input('city'),
            'description' => $request->input('description'),
            'gender' => $request->input('gender'),
            'birthday' => $birthday,
            'country' => $request->input('country'),
            'profile_picture' => $fileNameToStore,
        ]);

        User::find($id)->update([
            'name' => $request->input('name'),
        ]);

        return redirect("/users/profile/$id")->with(['success' => 'You updated your profile successfully!']);
    }

    /**
     * Update the specified UserProfile in table users_profiles in db.
     *
     * @param Request $request
     * @param $id
     * @param $userProfile
     * @param $birthday
     * @param $fileNameToStore
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id, $userProfile, $birthday, $fileNameToStore)
    {
        $userProfile = $userProfile->first();
        if(!$request->hasFile('profile_picture')) {
            $fileNameToStore = $userProfile->profile_picture;
        }

        $userProfile->update([
            'website' => $request->input('website'),
            'tel_number' => $request->input('tel_number'),
            'city' => $request->input('city'),
            'description' => $request->input('description'),
            'gender' => $request->input('gender'),
            'birthday' => $birthday,
            'country' => $request->input('country'),
            'profile_picture' => $fileNameToStore,
        ]);

        User::find($id)->update([
            'name' => $request->input('name'),
        ]);

        return redirect("/users/profile/$id")->with(['success' => 'You updated your profile successfully!']);
    }

    /**
     *  Delete specified UserProfile from table users_profiles
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $userProfile = UserProfile::where('user_id', $id);

        if(Gate::allows('delete-user-profile')) {
            if($userProfile->exists()) {
                $userProfile->delete();
                return redirect("/users/profile/$id")->with('success', 'Successfully deleted profile data!');
            }
            return redirect("/users/profile/$id")->with('error', 'There is no such profile data to delete.');
        }

        return redirect("/users/profile/$id")->with('error', 'Access denied! You cant delete that profile.');
    }
}
