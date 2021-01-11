@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('js/ajax-notifications-accept-decline-friend.js') }}"></script>
@endpush

@section('content')

<div class="px-5">

    <div class="notifications-view m-0 mt-5 mb-0 d-flex justify-content-center">
        @if(count($notifications) < 1)
            <p class="flex-fill bg-dark text-white text-center">There are no notifications.</p>
        @else
        <div class="notifications-card card w-75">

            <ul class="notification-list list-group list-group-flush">
                @foreach($notifications as $notification)
                    <li class="list-group-item clearfix d-flex align-items-center">
                        {{ $notification->body }}
                        @if($notification->name == 'Friend Request')
                            <div class="buttons ml-auto">
                                <button id="{{ $notification->sender_id }}" class="decline-friend-btn btn btn-danger float-right ml-1">Decline</button>
                                <button id="{{ $notification->sender_id }}" class="accept-friend-btn btn btn-primary float-right ml-1 mb-1">Accept</button>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        @endif
        <input type="hidden" value="{{url('/')}}" id="url" name="url">
        <input type="hidden" value="{{ Auth::id() }}" id="user-id" name="user-id">
    </div>
</div>

@endsection