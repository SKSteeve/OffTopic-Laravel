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
         *  DOM manipulation
         *
         * @param data
         */
        function newFriendNotificationAndRefreshFriendList(data) {
            // notifications, notificationId, friends -> variables returned from back-end
            addNotificationInAllAndUnreadedTabs(data);

            let notificationCloseButtonInAllTabContainer = $(`#all .notification-list .remove-notification-btn[data-notification-id=` + data.notificationId + ']');
            notificationCloseButtonInAllTabContainer.on('click', ajaxRemoveNotification);

            let notificationCloseButtonInUnreadedTabContainer = $(`#not-deleted .notification-list .remove-notification-btn[data-notification-id=` + data.notificationId + ']');
            notificationCloseButtonInUnreadedTabContainer.on('click', ajaxRemoveNotification);

            let friends = data.friends;
            rightSidebarRefactorHtml(friends);
            updateFriendsCount(friends);
            updateFriendList(friends);
        }
    }


    function ajaxDeclineRequest(e) {
        let senderUserId = e.target.getAttribute('data-sender-id');

        deleteNotifications(e, 'decline-friend-btn');

        $.ajax({
            url: `${base_path}/users/decline-friend-request/${loggedUser}/${senderUserId}`,
            type: "GET",
            success: updateCountOfNotificationsAndRefactorTabContainersHtmlIfNeeded,
            error: errorReturned
        });

        /**
         *  DOM manipulation
         *
         * @param data
         */
        function updateCountOfNotificationsAndRefactorTabContainersHtmlIfNeeded(data) {
            console.log(data.success);

            let allTabContainer = $('#all .notification-list');
            let unreadedTabContainer = $('#not-deleted .notification-list');

            let notificationsCountAllTabContainer = allTabContainer.children().length;
            let notificationsCountUnreadedTabContainer = unreadedTabContainer.children().length;

            updateNotificationTabCount('#all-tab', notificationsCountAllTabContainer);
            updateNotificationTabCount('#not-deleted-tab', notificationsCountUnreadedTabContainer);

            updateRightSidebarNotificationBadge('-');

            if(notificationsCountAllTabContainer < 1) {
                $('#all .notifications-card').remove();
                addParagraphNotification('#all');
            }

            if(notificationsCountUnreadedTabContainer < 1) {
                $('#not-deleted .notifications-card').remove();
                addParagraphNotification('#not-deleted');
            }
        }
    }


    function ajaxRemoveNotification(e) {

        var notificationId = e.target.getAttribute('data-notification-id');
        var isNotificationDeleted = e.target.getAttribute('data-deleted');

        let hardOrSoft = 'soft';
        if(isNotificationDeleted == 'true') {
            hardOrSoft = 'hard';
        }

        $.ajax({
            url: `${base_path}/users/${loggedUser}/notifications/${notificationId}/delete/${hardOrSoft}`,
            type: "GET",
            success: updateNotificationsTabsAndContainersAndCounts,
            error: errorReturned
        });

        function updateNotificationsTabsAndContainersAndCounts() {
            let notificationList = e.target.parentNode.parentNode;

            let allTabContainer = $('#all .notification-list');
            let deletedTabContainer = $('#deleted .notification-list');
            let unreadedTabContainer = $('#not-deleted .notification-list');

            let notificationsCountAllTabContainer = allTabContainer.children().length;
            let notificationsCountDeletedTabContainer = deletedTabContainer.children().length;
            let notificationsCountUnreadedTabContainer = unreadedTabContainer.children().length;

            let notificationSection = e.target.getAttribute('data-section');

            switch (notificationSection) {
                case 'all':
                    if(isNotificationDeleted == 'true') {
                        deleteNotifications(e, 'remove-notification-btn');
                        notificationsCountAllTabContainer -= 1;
                        notificationsCountDeletedTabContainer -= 1;

                        if(notificationsCountAllTabContainer < 1) {
                            let allContainerMain = $('#all');
                            allContainerMain.empty();
                            addParagraphNotification('#all');
                        }

                        if(notificationsCountDeletedTabContainer < 1) {
                            let deletedContainerMain = $('#deleted');
                            deletedContainerMain.empty();
                            addParagraphNotification('#deleted');
                        }

                        updateNotificationTabCount('#all-tab', notificationsCountAllTabContainer);
                        updateNotificationTabCount('#deleted-tab', notificationsCountDeletedTabContainer);

                    } else {
                        e.target.classList.add('text-danger');
                        e.target.setAttribute('data-deleted', 'true');

                        let unreadedNotification = $(`#not-deleted .notification-list .remove-notification-btn[data-notification-id=` + notificationId + ']').parent().parent();
                        unreadedNotification.remove();
                        notificationsCountUnreadedTabContainer -= 1;

                        if(notificationsCountUnreadedTabContainer < 1) {
                            let unreadedContainerMain = $('#not-deleted');
                            unreadedContainerMain.empty();
                            addParagraphNotification('#not-deleted');
                        }
                        addNotificationListToDeletedTabContainer(deletedTabContainer, notificationList);
                        notificationsCountDeletedTabContainer += 1;

                        let notificationCloseButtonInDeletedTabContainer = $(`#deleted .notification-list .remove-notification-btn[data-notification-id=` + notificationId + ']');
                        notificationCloseButtonInDeletedTabContainer.attr('data-section', 'deleted');
                        notificationCloseButtonInDeletedTabContainer.attr('data-deleted', 'true');
                        notificationCloseButtonInDeletedTabContainer.on('click', ajaxRemoveNotification);

                        updateNotificationTabCount('#not-deleted-tab', notificationsCountUnreadedTabContainer);
                        updateNotificationTabCount('#deleted-tab', notificationsCountDeletedTabContainer);
                        updateRightSidebarNotificationBadge('-');
                    }
                    break;
                case 'not-deleted':
                    notificationList.remove();
                    notificationsCountUnreadedTabContainer -= 1;

                    if(notificationsCountUnreadedTabContainer < 1) {
                        let unreadedContainerMain = $('#not-deleted');
                        unreadedContainerMain.empty();
                        addParagraphNotification('#not-deleted');
                    }

                    addNotificationListToDeletedTabContainer(deletedTabContainer, notificationList);
                    notificationsCountDeletedTabContainer += 1;

                    let notificationCloseButtonInDeletedTabContainer = $(`#deleted .notification-list .remove-notification-btn[data-notification-id=` + notificationId + ']');
                    notificationCloseButtonInDeletedTabContainer.attr('data-section', 'deleted');
                    notificationCloseButtonInDeletedTabContainer.attr('data-deleted', 'true');
                    notificationCloseButtonInDeletedTabContainer.addClass('text-danger');
                    notificationCloseButtonInDeletedTabContainer.on('click', ajaxRemoveNotification);

                    let notificationCloseButtonInAllTabContainer = $(`#all .notification-list .remove-notification-btn[data-notification-id=` + notificationId + ']');
                    notificationCloseButtonInAllTabContainer.attr('data-section', 'all');
                    notificationCloseButtonInAllTabContainer.attr('data-deleted', 'true');
                    notificationCloseButtonInAllTabContainer.addClass('text-danger');

                    updateNotificationTabCount('#deleted-tab', notificationsCountDeletedTabContainer);
                    updateNotificationTabCount('#not-deleted-tab', notificationsCountUnreadedTabContainer);
                    updateRightSidebarNotificationBadge('-');
                    break;
                case 'deleted':
                    deleteNotifications(e, 'remove-notification-btn');

                    notificationsCountDeletedTabContainer -= 1;
                    notificationsCountAllTabContainer -= 1;

                    if(notificationsCountDeletedTabContainer < 1) {
                        let deletedContainerMain = $('#deleted');
                        deletedContainerMain.empty();
                        addParagraphNotification('#deleted');
                    }

                    if(notificationsCountAllTabContainer < 1) {
                        let allContainerMain = $('#all');
                        allContainerMain.empty();
                        addParagraphNotification('#all');
                    }

                    updateNotificationTabCount('#deleted-tab', notificationsCountDeletedTabContainer);
                    updateNotificationTabCount('#all-tab', notificationsCountAllTabContainer);
                    break;
            }
        }

    }


    /**
     *  Print the error in the console
     *
     * @param error
     */
    function errorReturned(error) {
        console.log(error);
    }

    /**
     *  Add notification to deletedTabContainer and refactor the code if we didnt have any notifications
     *  before that
     *
     * @param deletedTabContainer
     * @param notificationList
     */
    function addNotificationListToDeletedTabContainer(deletedTabContainer, notificationList) {
        let cloneNotificationList = notificationList.cloneNode(true);


        let deletedTabContainerMain = $('#deleted');
        let foundParagraph = deletedTabContainerMain.find("p");

        if(foundParagraph.length > 0) {
            foundParagraph.remove();

            let notificationsCard = $('<div>');
            notificationsCard.addClass('notifications-card card w-75 m-auto');

            let notificationsList = $('<ul>');
            notificationsList.addClass('notification-list list-group list-group-flush');

            notificationsList.append(cloneNotificationList);
            notificationsCard.append(notificationsList);
            deletedTabContainerMain.append(notificationsCard);
        } else {
            deletedTabContainer.prepend(cloneNotificationList);
        }
    }
    
    /**
     *  Update the notifications badge count on right sidebar
     *
     * @param operator
     */
    function updateRightSidebarNotificationBadge(operator) {
        let notificationsBadge = $('.notifications-count');
        let notificationsBadgeValue = notificationsBadge.text();

        switch (operator) {
            case '-':
                notificationsBadge.text(+notificationsBadgeValue - 1);
                break;
            case '+':
                notificationsBadge.text(+notificationsBadgeValue + 1);
                break;
        }
    }
    
    /**
     *  Get the tab button from the given selector and update its count with the given
     *
     * @param notificationTabSelector
     * @param notificationTabContainerCount
     */
    function updateNotificationTabCount(notificationTabSelector, notificationTabContainerCount) {
        let tabButton = $(`${notificationTabSelector}`);

        switch (notificationTabSelector) {
            case '#all-tab':
                tabButton.text(`All ( ${notificationTabContainerCount} )`);
                break;
            case '#not-deleted-tab':
                tabButton.text(`Unreaded ( ${notificationTabContainerCount} )`);
                break;
            case '#deleted-tab':
                tabButton.text(`Deleted ( ${notificationTabContainerCount} )`);
                break;
        }
    }
    
    /**
     *  Add notification paragraph to the given tabContainerSelector
     *
     * @param tabContainerSelector
     */
    function addParagraphNotification(tabContainerSelector) {
        let p = $('<p>');
        p.addClass('bg-dark text-white text-center mx-auto w-75');
        p.text('There are no notifications.');

        let tabContainerElement = $(`${tabContainerSelector}`);
        tabContainerElement.append(p);
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
        liForAllTabContainer.html(`${data.notification}<div class="buttons ml-auto"><button data-section="all" data-deleted="false" data-notification-id="${data.notificationId}" style="outline: none" class="remove-notification-btn close float-right" aria-label="Close">&times;</button></div>`);

        let liForUnreadedTabContainer = $('<li>');
        liForUnreadedTabContainer.addClass('list-group-item clearfix d-flex align-items-center');
        liForUnreadedTabContainer.html(`${data.notification}<div class="buttons ml-auto"><button data-section="not-deleted" data-deleted="false" data-notification-id="${data.notificationId}" style="outline: none" class="remove-notification-btn close float-right" aria-label="Close">&times;</button></div>`);

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