@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('js/ajax-notifications-nav-tabs.js') }}"></script>
    <script src="{{ asset('js/ajax-notifications-accept-decline-friend.js') }}"></script>
@endpush

@section('content')

<div class="px-5">

    <h2 class="my-5">Notifications</h2>

{{--    variables passed to the view   --}}
{{--        $allNotifications        --}}
{{--        $deletedNotifications    --}}
{{--        $notDeletedNotifications --}}

    <ul class="nav nav-tabs justify-content-around mx-auto mb-4 w-50" id="notifications-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="all-tab" data-bs-toggle="tab" href="#all" role="tab" aria-controls="all">All ( {{ count($allNotifications) }} )</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="not-deleted-tab" data-bs-toggle="tab" href="#not-deleted" role="tab" aria-controls="not-deleted">Unreaded ( {{ count($notDeletedNotifications) }} )</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="deleted-tab" data-bs-toggle="tab" href="#deleted" role="tab" aria-controls="deleted">Deleted ( {{ count($deletedNotifications) }} )</a>
        </li>
    </ul>
    <div class="tab-content notifications-view my-5">
        <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="all-tab">
            @if(count($allNotifications) < 1)
                <p class="bg-dark text-white text-center mx-auto w-75">There are no notifications.</p>
            @else
                <div class="notifications-card card w-75 m-auto">
                    <ul class="notification-list list-group list-group-flush">
                        @foreach($allNotifications as $notification)
                            <li class="list-group-item clearfix d-flex align-items-center">
                                {{ $notification->body }}

                                <div class="buttons ml-auto">
                                    @if($notification->name == 'Friend Request' && empty($notification->deleted_at))
                                        <button data-sender-id="{{ $notification->sender_id }}" data-notification-id="{{ $notification->id }}" class="decline-friend-btn btn btn-danger float-right ml-1">Decline</button>
                                        <button data-sender-id="{{ $notification->sender_id }}" data-notification-id="{{ $notification->id }}" class="accept-friend-btn btn btn-primary float-right ml-1 mb-1">Accept</button>
                                    @else
                                        <button data-section="all" @if(!empty($notification->deleted_at))data-deleted="true" @else data-deleted="false" @endif data-notification-id="{{ $notification->id }}" style="outline: none" class="remove-notification-btn close float-right @if(!empty($notification->deleted_at)) text-danger @endif" aria-label="Close">&times;</button>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="tab-pane fade show active" id="not-deleted" role="tabpanel" aria-labelledby="not-deleted-tab">
            @if(count($notDeletedNotifications) < 1)
                <p class="bg-dark text-white text-center mx-auto w-75">There are no notifications.</p>
            @else
                <div class="notifications-card card w-75 m-auto">
                    <ul class="notification-list list-group list-group-flush">
                        @foreach($notDeletedNotifications as $notification)
                            <li class="list-group-item clearfix d-flex align-items-center">
                                {{ $notification->body }}

                                <div class="buttons ml-auto">
                                    @if($notification->name == 'Friend Request' && empty($notification->deleted_at))
                                        <button data-sender-id="{{ $notification->sender_id }}" data-notification-id="{{ $notification->id }}" class="decline-friend-btn btn btn-danger float-right ml-1">Decline</button>
                                        <button data-sender-id="{{ $notification->sender_id }}" data-notification-id="{{ $notification->id }}" class="accept-friend-btn btn btn-primary float-right ml-1 mb-1">Accept</button>
                                    @else
                                        <button data-section="not-deleted" @if(!empty($notification->deleted_at))data-deleted="true" @else data-deleted="false" @endif data-notification-id="{{ $notification->id }}" style="outline: none" class="remove-notification-btn close float-right" aria-label="Close">&times;</button>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="tab-pane fade" id="deleted" role="tabpanel" aria-labelledby="deleted-tab">
            @if(count($deletedNotifications) < 1)
                <p class="bg-dark text-white text-center mx-auto w-75">There are no notifications.</p>
            @else
                <div class="notifications-card card w-75 m-auto">
                    <ul class="notification-list list-group list-group-flush">
                        @foreach($deletedNotifications as $notification)
                            <li class="list-group-item clearfix d-flex align-items-center">
                                {{ $notification->body }}

                                <div class="buttons ml-auto">
                                    <button data-section="deleted" data-deleted="true" data-notification-id="{{ $notification->id }}" style="outline: none" class="remove-notification-btn close float-right text-danger" aria-label="Close">&times;</button>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <input type="hidden" value="{{url('/')}}" id="url" name="url">
    <input type="hidden" value="{{ Auth::id() }}" id="user-id" name="user-id">

</div>

@endsection