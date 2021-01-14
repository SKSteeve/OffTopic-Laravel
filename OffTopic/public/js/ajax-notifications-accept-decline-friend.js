$(document).ready(function () {
    var acceptBtn = $('.accept-friend-btn');
    var declineBtn = $('.decline-friend-btn');
    var base_path = $("#url").val();
    var loggedUser = $("#user-id").val();

    acceptBtn.on('click', ajaxAcceptFriend);
    declineBtn.on('click', ajaxDeclineRequest);

    function ajaxAcceptFriend(e) {
        e.preventDefault();

        let notificationListTarget = e.target.parentNode.parentNode;
        let senderUserId = e.target.getAttribute('id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: `${base_path}/users/accept-friend-request/${loggedUser}/${senderUserId}`,
            type: "GET",
            success: newFriendNotificationAndRefreshFriendList,
            error: errorReturned
        });

        /**
         * Remove the current notification target and add new notification
         *
         * @param data
         */
        function newFriendNotificationAndRefreshFriendList(data) {
            notificationListTarget.remove();

            let li = $('<li>');
            li.addClass('list-group-item clearfix d-flex align-items-center');
            li.text(data.notification);

            let notificationList = $('.notification-list');
            notificationList.prepend(li);

            let friends = data.friends;

            if(friends.length === 1) {      // the logged user didnt have friends before he clicked on the notification to Accept the request,
                                            // so we delete the paragraph that says we dont have friends and after that we create the card and the ul

                $('.second-row-tables p').remove();
                let friendListColumn = $('.second-row-tables');

                let card = $('<div>');
                card.addClass('friends-card w-100');

                let friendList = $('<ul>');
                friendList.addClass('friend-list list-group list-group-flush');

                let p = $('<p>');
                p.addClass('mx-auto pt-1');
                p.html("Friends ( <span class='friends-count'>1</span> )");

                card.append(friendList);
                friendListColumn.append(p);
                friendListColumn.append(card);
            }

            let friendsCountElement = $('.friends-count');
            friendsCountElement.text(friends.length);

            let friendList = $('.friend-list');
            friendList.empty();

            friends.forEach( (friend) => {

                let li = $('<li>');
                li.addClass('list-group-item d-flex align-items-center justify-content-between text-white bg-dark');

                let a = $('<a>');
                a.attr('href', `${base_path}/users/profile/${friend.id}`);
                a.addClass('text-info');
                a.text(friend.name);

                let button = $('<button>');
                button.attr('id', friend.id);
                button.addClass('unfriend-btn btn btn-danger');
                button.text('Unfriend');

                li.append(a);
                li.append(button);

                friendList.append(li);
            });
        }
    }



    function ajaxDeclineRequest(e) {
        e.preventDefault();

        let notificationListTarget = e.target.parentNode.parentNode;
        let senderUserId = e.target.getAttribute('id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: `${base_path}/users/decline-friend-request/${loggedUser}/${senderUserId}`,
            type: "GET",
            success: removeNotification,
            error: errorReturned
        });

        function removeNotification(data) {
            console.log(data.success);

            notificationListTarget.remove();

            if(data.notificationsCount < 1) {
                $('.notifications-card').remove();

                let p = $('<p>');
                p.addClass('flex-fill bg-dark text-white text-center');
                p.text('There are no notifications.');

                let notificationsView = $('.notifications-view');
                notificationsView.append(p);
            }
        }
    }



    function errorReturned(error) {
        console.log(error);
    }
});