@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('js/ajax-search-profile.js') }}"></script>
@endpush

@section('content')
    <div class="px-5 mt-5 mb-2">
        <h2 class="mb-4">Search for user profile</h2>
        <form method="GET"  class="mb-3">
            <div class="form-group">
                <input type="text" name="name" id="name" class="form-control" placeholder="User name">
            </div>
        </form>
        <table class="user-profiles table table-hover table-bordered table-sm  my-5 mx-auto">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Country</th>
                </tr>
            </thead>
            <tbody class="t-data">

            </tbody>
        </table>
    </div>
    <input type="hidden" value="{{url('/')}}" id="url" name="url">
@endsection