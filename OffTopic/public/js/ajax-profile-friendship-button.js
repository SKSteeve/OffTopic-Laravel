$(function() {
    var friendshipBtn = $('.friendship-button');
    var base_path = $("#url").val();
    var id = $('#profile-user-id').val();   // this id is the id on the profile we are at
    var authUser = $('#auth-user-id').val();

    friendshipBtn.on('click', ajaxAddFriendOrUnfriend);

    // the button has 3 states
    // 1. Send Friend Request -> value = createRequest
    // 2. Requested -> value = deleteRequest
    // 3. Unfriend -> value = deleteFriend
    // 4. Accept Friend -> value = acceptFriend

    function ajaxAddFriendOrUnfriend(e) {
        e.preventDefault();

        let button = e.target;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if(button.value === 'createRequest') {
            $.ajax({
                url: `${base_path}/friend-request/${id}/create`,
                type: "GET",
                success: changeButtonToRequested,
                error: errorReturned
            });

        } else if(button.value === 'deleteRequest') {
            $.ajax({
                url: `${base_path}/friend-request/${id}/delete`,
                type: "GET",
                success: changeButtonToSendFriendRequest,
                error: errorReturned
            });

        } else if (button.value === 'acceptFriend') {
            $.ajax({
                url: `${base_path}/users/accept-friend-request/${authUser}/${id}`,
                type: "GET",
                success: changeButtonToUnfriendAndUpdateFriendList,
                error: errorReturned
            });

        } else if(button.value === 'deleteFriend') {
            $.ajax({
                url: `${base_path}/users/delete-friendship/${id}/delete`,
                type: "GET",
                success: changeButtonToSendFriendRequestAndUpdateFriendList,
                error: errorReturned
            });

        } else {
            console.log('Error');
        }
    }
    
    function changeButtonToRequested(data) {
        let profileContainer = $('.profile');
        let messageAlert = $('<div>');

        let message = '';

        if(data.success) {
            message = data.success;

            friendshipBtn.text('Requested');
            friendshipBtn.attr('value', 'deleteRequest');
            friendshipBtn.removeClass('btn-primary');
            friendshipBtn.addClass('btn-secondary');

            messageAlert.addClass('alert alert-success');
        } else if (data.newFriend) {
            message = data.newFriend;

            friendshipBtn.text('Unfriend');
            friendshipBtn.attr('value', 'deleteFriend');
            friendshipBtn.removeClass('btn-primary');
            friendshipBtn.addClass('btn-danger');

            messageAlert.addClass('alert alert-success');
        } else {
            message = data.error;

            messageAlert.addClass('alert alert-danger');
        }

        messageAlert.addClass('messages-success-error');
        messageAlert.text(message);
        profileContainer.prepend(messageAlert);

        //removeMessage();
    }

    function changeButtonToSendFriendRequest(data) {
        if(data.success) {
            let profileContainer = $('.profile');
            let messageAlert = $('<div>');

            friendshipBtn.text('Send Friend Request');
            friendshipBtn.attr('value', 'createRequest');
            friendshipBtn.removeClass('btn-secondary');
            friendshipBtn.addClass('btn-primary');

            messageAlert.addClass('alert alert-success messages-success-error');
            messageAlert.text(data.success);
            profileContainer.prepend(messageAlert);

            //removeMessage();
        }
    }

    function changeButtonToUnfriendAndUpdateFriendList(data) {
        // success, notification, friends

        let profileContainer = $('.profile');
        let messageAlert = $('<div>');

        friendshipBtn.text('Unfriend');
        friendshipBtn.attr('value', 'deleteFriend');
        friendshipBtn.removeClass('btn-secondary');
        friendshipBtn.addClass('btn-danger');

        messageAlert.addClass('alert alert-success messages-success-error');
        messageAlert.text(data.notification);
        profileContainer.prepend(messageAlert);

        let friends = data.friends;

        if(friends.length === 1) {
            let secondRowFriendList = $('.second-row-tables');
            secondRowFriendList.empty();

            let p = $('<p>');
            p.addClass('mx-auto pt-1');
            p.html("Friends ( <span class='friends-count'>1</span> )");

            let friendsCard = $('<div>');
            friendsCard.addClass('friends-card w-100');

            let friendList = $('<ul>');
            friendList.addClass('friend-list list-group list-group-flush');

            friendsCard.append(friendList);
            secondRowFriendList.append(p);
            secondRowFriendList.append(friendsCard);
        }

        let friendCount = $('.friends-count');
        friendCount.text(friends.length);

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

        //removeMessage();
    }
    
    function changeButtonToSendFriendRequestAndUpdateFriendList(data) {
        if(data.success) {
            let profileContainer = $('.profile');
            let messageAlert = $('<div>');

            friendshipBtn.text('Send Friend Request');
            friendshipBtn.attr('value', 'createRequest');
            friendshipBtn.removeClass('btn-danger');
            friendshipBtn.addClass('btn-primary');

            messageAlert.addClass('alert alert-success messages-success-error');
            messageAlert.text(data.success);
            profileContainer.prepend(messageAlert);

            //display all friends in right sidebar
            let friends = data.friends;

            if(friends.length < 1) {        // the logged user had 1 friend at least before he clicked on unfriend on the profile of the user
                                            // so we had the card and ul elemnts in the html
                                            // now we check if we dont have even 1 friend, then remove card and ul and add paragraph msg

                let secondRowFriends = $('.second-row-tables');
                secondRowFriends.empty();

                let p = $('<p>');
                p.addClass('w-100 d-flex justify-content-center mt-4');

                p.text('You still dont have friends.');
                secondRowFriends.append(p);

            } else {                        // we had at least 1 friend and the card and ul elements in the html
                                            // so we empty the whole ul and refill with the friends

                let friendCount = $('.friends-count');
                friendCount.text(friends.length);

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

            //removeMessage();
        }
    }


    function errorReturned(error) {
        console.log(error);
    }

    function removeMessage() {
        setTimeout(function(){
            let messageContainer = $('.messages-success-error');
            messageContainer.remove();

        }, 5000)
    }
});