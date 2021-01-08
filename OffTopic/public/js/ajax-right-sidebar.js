$(document).ready(function () {
    var secondRowFriends = $('.second-row-tables');
    let base_path = $('#url').val();

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
            }
        }

        function errorReturned(error) {
            console.log(error);
        }

    })
});