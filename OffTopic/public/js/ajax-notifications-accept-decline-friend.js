$(document).ready(function () {
    var base_path = $("#url").val();
    var loggedUser = $("#user-id").val();

    var acceptBtn = $('.accept-friend-btn');
    var declineBtn = $('.decline-friend-btn');
    var removeBtn = $('.remove-notification-btn');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    acceptBtn.on('click', ajaxAcceptFriend);
    declineBtn.on('click', ajaxDeclineRequest);
    removeBtn.on('click', ajaxRemoveNotification);

    function ajaxAcceptFriend(e) {
        let senderUserId = e.target.getAttribute('data-sender-id');

        deleteNotifications(e, 'accept-friend-btn');

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
            // notifications, notificationId, friends -> variables returned from back-end
            addNotificationInAllAndUnreadedTabs(data);

            let friends = data.friends;
            rightSidebarRefactorHtml(friends);
            updateFriendsCount(friends);
            updateFriendList(friends);
        }
    }


    function ajaxDeclineRequest(e) {
        console.log('decline req');
        // todo .. make function that searchs for that if we have a list items and if we dont to put paragraph
        // todo make refreshing the count on notifications function or refresh them manually ... getting their text and +1

        let senderUserId = e.target.getAttribute('data-sender-id');

        deleteNotifications(e, 'decline-friend-btn');

        // $.ajax({
        //     url: `${base_path}/users/decline-friend-request/${loggedUser}/${senderUserId}`,
        //     type: "GET",
        //     success: removeNotification,
        //     error: errorReturned
        // });
        //
        // function removeNotification(data) {
        //     console.log(data.success);
        //
        //
        //     if(data.notificationsCount < 1) {
        //         $('.notifications-card').remove();
        //
        //         let p = $('<p>');
        //         p.addClass('flex-fill bg-dark text-white text-center');
        //         p.text('There are no notifications.');
        //
        //         let notificationsView = $('.notifications-view');
        //         notificationsView.append(p);
        //     }
        // }
    }

    function ajaxRemoveNotification() {
        console.log('remove notif')
    }


    /**
     *  Print the error in the console
     *
     * @param error
     */
    function errorReturned(error) {
        console.log(error);
    }

    function createNotificationsCard() {
        
    }

    /**
     *  Adding the new notifications to All and Unreaded Tabs
     *
     * @param data
     */
    function addNotificationInAllAndUnreadedTabs(data) {

        let allTabContainer = $('#all .notification-list');
        let unreadedTabContainer = $('#not-deleted .notification-list');

        let liForAllTabContainer = $('<li>');
        liForAllTabContainer.addClass('list-group-item clearfix d-flex align-items-center');
        liForAllTabContainer.html(`${data.notification}<div class="buttons ml-auto"><button data-section="all" data-notification-id="${data.notificationId}" style="outline: none" class="remove-notification-btn close float-right" aria-label="Close">&times;</button></div>`);

        let liForUnreadedTabContainer = $('<li>');
        liForUnreadedTabContainer.addClass('list-group-item clearfix d-flex align-items-center');
        liForUnreadedTabContainer.html(`${data.notification}<div class="buttons ml-auto"><button data-section="not-deleted" data-notification-id="${data.notificationId}" style="outline: none" class="remove-notification-btn close float-right" aria-label="Close">&times;</button></div>`);

        allTabContainer.prepend(liForAllTabContainer);
        unreadedTabContainer.prepend(liForUnreadedTabContainer);
    }

    /**
     *  Refactoring the html in right sidebar if needed (if we didnt have friends)
     *
     * @param friends
     */
    function rightSidebarRefactorHtml(friends) {
        // before we clicked Accept we had 0 friends and we had paragraph instead of card, so we remove it
        // and add the card ready for filling with data from updateFriendList()

        if(friends.length === 1) {

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
    }

    /**
     *  Delete the notifications from DOM that have the same notification-id
     *
     * @param e
     * @param buttonClass
     */
    function deleteNotifications(e, buttonClass) {
        let notificationId = e.target.getAttribute('data-notification-id');
        let notificationsButtons = $(`.notification-list .${buttonClass}[data-notification-id=` + notificationId + ']');
        let notificationsListsElements = notificationsButtons.parent().parent();
        notificationsListsElements.remove();
    }

    /**
     *  Update the friends count in friend list right sidebar
     *
     * @param friends
     */
    function updateFriendsCount(friends) {
        let friendsCountElement = $('.friends-count');
        friendsCountElement.text(friends.length);
    }

    /**
     *  Update the friend list in the right sidebar
     *
     * @param friends
     */
    function updateFriendList(friends) {
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
});