@extends('layouts.app')

@section('content')
    <div class="px-5 mt-5 mb-4">
        <div class="m-0 mt-5 mb-0">
            <h2 class="mb-5 d-inline-block">{{ $user->name }}'s Profile</h2>
            @if(Auth::user()->can('edit-user-profile') || Auth::id() == $id)
                <a href="{{ url('/users/profile',$user->id) }}/edit" class="btn btn-warning float-right text-decoration-none text-white">Edit</a>
            @endif
            @can('delete-user-profile')
                <button class="btn btn-danger float-right mr-1" onclick="document.getElementById('delete-form').submit();">Delete</button>
                <form id="delete-form" action="{{ url('/users/profile',$id) }}/delete" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            @endcan
        </div>
        <div class="profile_info mx-3">
            <div class="row mb-5">
                <div class="col-6 d-flex justify-content-center" >
                    <img id="profile-pic" src="{{ asset('storage/profile_pictures') }}/{{ @$profileInfo->profile_picture }}" style="border-radius: 50%; object-fit: cover;" alt="Profile Pic" width="240" height="240">
                </div>
                <div class="col-6 bg-light py-3"><strong>Description: </strong>{{ @$profileInfo->description }}</div>
            </div>
            <div class="row bg-light">
                <div class="col-6 mb-3 mt-3"><strong>Name: </strong>{{ $user->name }}</div>
                <div class="col-6 mb-3 mt-3"><strong>Gender: </strong>{{ @$profileInfo->gender }}</div>
                <div class="col-6 mb-3"><strong>Country: </strong>{{ @$profileInfo->country }}</div>
                <div class="col-6 mb-3"><strong>City: </strong>{{ @$profileInfo->city }}</div>
                <div class="col-6 mb-3"><strong>Date of Birth: </strong>{{ @$profileInfo->birthday }}</div>
                <div class="col-6 mb-3"><strong>Email: </strong>{{ @$user->email }}</div>
                <div class="col-6 mb-3"><strong>Website: </strong>{{ @$profileInfo->website }}</div>
                <div class="col-6 mb-3"><strong>Phone Number: </strong>{{ @$profileInfo->tel_number }}</div>
            </div>
        </div>

    </div>

@endsection