$(function() {
    var secondRowFriends = $('.second-row-tables');
    let base_path = $('#url').val();
    let currentPage = $('#page').val();

    secondRowFriends.on('click', 'li', function (e) {

        let userToUnfriendId = e.target.getAttribute('id');
        console.log(e.target);

        if(userToUnfriendId) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: `${base_path}/users/delete-friendship/${userToUnfriendId}/delete`,
                type: "GET",
                success: refreshFriendList,
                error: errorReturned
            });

        }

        function refreshFriendList(data) {
            if(data.success) {
                let container = document.getElementsByClassName('page-content-wrapper')[0];

                let messageAlert = document.createElement('div');
                messageAlert.classList.add('alert', 'alert-success', 'messages-success-error', 'messages-create', 'my-4', 'mx-4');
                messageAlert.textContent = data.success;

                container.prepend(messageAlert);

                let friends = data.friends;

                if(friends.length < 1) {
                    $('.second-row-tables').empty();

                    let p = $('<p>');
                    p.addClass('w-100 d-flex justify-content-center mt-4');
                    p.text('You still dont have friends.');

                    secondRowFriends.append(p);

                } else {

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

                if(data.notificationId > 0 && currentPage == 'notifications') {
                    updateNotifications(data.notificationId);
                } else {
                    updateBadge();
                }

                let userProfileId = $('#profile-user-id').val();

                if(userToUnfriendId === userProfileId) {
                    updateProfileButton();
                }
            }
        }
        
        function updateProfileButton() {
            let friendshipBtn = $('.friendship-button');
            friendshipBtn.text('Send Friend Request');
            friendshipBtn.attr('value', 'createRequest');
            friendshipBtn.removeClass('btn-danger');
            friendshipBtn.addClass('btn-primary');
        }

        function updateNotifications(notificationId) {
            let notificationsButtons = $(`.notification-list .remove-notification-btn[data-notification-id=` + notificationId + ']');
            let notificationsListsElements = notificationsButtons.parent().parent();

            notificationsListsElements.remove();

            let allTabContainer = $('#all .notification-list');
            let unreadedTabContainer = $('#not-deleted .notification-list');
            let deletedTabContainer = $('#deleted .notification-list');

            let notificationsCountAllTabContainer = allTabContainer.children().length;
            let notificationsCountUnreadedTabContainer = unreadedTabContainer.children().length;
            let notificationsCountDeletedTabContainer = deletedTabContainer.children().length;



            if(notificationsCountAllTabContainer < 1) {
                let allContainerMain = $('#all');
                allContainerMain.empty();

                let p = $('<p>');
                p.addClass('bg-dark text-white text-center mx-auto w-75');
                p.text('There are no notifications.');

                allContainerMain.append(p);
            }

            if(notificationsCountUnreadedTabContainer < 1) {
                let unreadedContainerMain = $('#not-deleted');
                unreadedContainerMain.empty();

                let p = $('<p>');
                p.addClass('bg-dark text-white text-center mx-auto w-75');
                p.text('There are no notifications.');

                unreadedContainerMain.append(p);
            }

            if(notificationsCountDeletedTabContainer < 1) {
                let deletedContainerMain = $('#deleted');
                deletedContainerMain.empty();

                let p = $('<p>');
                p.addClass('bg-dark text-white text-center mx-auto w-75');
                p.text('There are no notifications.');

                deletedContainerMain.append(p);
            }

            let allTabBtn = $('#all-tab');
            let notDeletedTabBtn = $('#not-deleted-tab');
            let deletedTabBtn = $('#deleted-tab');

            allTabBtn.text(`All ( ${notificationsCountAllTabContainer} )`);
            notDeletedTabBtn.text(`Unreaded ( ${notificationsCountUnreadedTabContainer} )`);
            deletedTabBtn.text(`Deleted ( ${notificationsCountDeletedTabContainer} )`);

            let notificationsBadge = $('.notifications-count');
            notificationsBadge.text(notificationsCountUnreadedTabContainer);

        }

        function updateBadge() {
            let rightSidebarBadge = $('.notifications-count');
            let profileBadge = $('.notifications-badge');

            let rightSidebarBadgeCount = rightSidebarBadge.text();
            let profileBadgeCount = profileBadge.text();

            rightSidebarBadge.text(+rightSidebarBadgeCount - 1);
            profileBadge.text(+profileBadgeCount - 1);
        }
        
        function errorReturned(error) {
            console.log(error);
        }

    })
});