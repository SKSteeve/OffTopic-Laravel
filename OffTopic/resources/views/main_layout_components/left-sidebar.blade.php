<div class="border-right left-sidebar-wrapper col-1 pr-0">
    <div class="sidebar-h my-3">
        <a href="{{ url('/') }}" class="sidebar-heading px-1 text-decoration-none">{{ config('app.name', 'OffTopic') }}</a>
    </div>
    <div class="list-group list-group-flush">
        <a href="{{ url('/') }}" class="list-group-item list-group-item-action text-center border-bottom">Home</a>
        <a href="{{ url('/blog') }}" class="list-group-item list-group-item-action text-center border-bottom">Blog</a>
        <a href="{{ url('/forum') }}" class="list-group-item list-group-item-action text-center border-bottom">Forum</a>
        <a href="{{ url('/users') }}" class="list-group-item list-group-item-action text-center border-bottom">Users</a>
        <a href="{{ url('/about-me') }}" class="list-group-item list-group-item-action text-center px-1 border-bottom">About Me</a>
    </div>
</div>