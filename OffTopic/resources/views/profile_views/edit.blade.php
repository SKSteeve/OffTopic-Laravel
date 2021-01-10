@extends('layouts.app')

@section('content')
    <div class="px-5 mt-5 mb-2">
        @if(Auth::id() == $user->id)
            <h2 class="mb-5">Edit your profile</h2>
        @elseif(Auth::user()->can('edit-user-profile'))
            <h2 class="mb-5">Edit {{ $user->name }}'s profile</h2>
        @endif

        <form action="{{ url('/users/profile', $user->id) }}/update" method="POST" enctype="multipart/form-data" class="bg-light mb-4">
            @csrf
            @method('POST')

            <div class="row mx-4 pt-4">
                <div class="col-4">
                    <label for="name">Name</label><br/>
                    <input type="text" name="name" id="name" value="@if(isset($user->name)) {{ $user->name }} @else {{session('name')}} @endif">
                </div>
                <div class="col-4">
                    <label for="city">City</label><br/>
                    <input type="text" name="city" id="city" value="@if(isset($user->profile->city)) {{ $user->profile->city }} @else {{session('city')}} @endif">
                </div>
                <div class="col-4">
                    <label for="tel_number">Tel. Number</label><br/>
                    <input type="text" name="tel_number" id="tel_number" value="@if(isset($user->profile->tel_number)) {{ $user->profile->tel_number }} @else {{session('tel_number')}} @endif">
                </div>
            </div>
            <div class="row mx-4 pt-4">
                <div class="col-4">
                    <label for="website">Website</label><br/>
                    <input type="text" name="website" id="website" value="@if(isset($user->profile->website)) {{ $user->profile->website }} @else {{session('website')}} @endif">
                </div>
                <div class="col-4">
                    <label for="country">Country</label><br/>
                    <select id="country" name="country" style="width:180px; height: 30px" >
                        @foreach($countries as $key => $country)
                            <option value="{{ $key }}" @if($country == @$user->profile->country) selected="selected" @endif>{{ $country }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <label for="year">Birthday</label><br/>
                    <select name="year" id="year">
                        @foreach($years as $key => $year)
                            <option value="{{ $key }}" @if($year == $birthYear) selected="selected" @endif>{{ $year }}</option>
                        @endforeach
                    </select>
                    <select name="month">
                        @foreach($months as $key => $month)
                            <option value="{{ $key }}" @if($month == $birthMonth) selected="selected" @endif>{{ $month }}</option>
                        @endforeach
                    </select>
                    <select name="date">
                        @foreach($days as $key => $day)
                            <option value="{{ $key }}" @if($day == $birthDate) selected="selected" @endif>{{ $day }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mx-4 pt-4">
                <div class="col-4">
                    <label for="description">Description</label><br/>
                    <textarea name="description" id="description" rows="5">@if(isset($user->profile->description)) {{ $user->profile->description }} @else {{session('description')}} @endif</textarea>
                </div>
                <div class="col-4">
                    <label>Gender</label><br>
                    <input type="radio" value="male" name="gender" id="male" class="mt-3"  @if(@$user->profile->gender == 'male') checked @endif>
                    <label for="male">Male</label><br>
                    <input type="radio" value="female" name="gender" id="female"  @if(@$user->profile->gender == 'female') checked @endif>
                    <label for="female">Female</label>
                </div>
                <div class="col-4">
                    <label for="profile-pic">Profile Picture</label><br/>
                    <input type="file" name="profile_picture"  id="profile-pic"><br>
                </div>
            </div>


            <div class="d-flex justify-content-center">
                <a class="btn btn-dark text-decoration-none text-white my-3 mr-1" href="{{ url('/users/profile', $user->id) }}"><span>Cancel</span></a>
                <button type="submit" class="btn btn-success my-3">Save changes</button>
            </div>
        </form>
    </div>
@endsection