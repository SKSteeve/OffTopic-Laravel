$(document).ready(function () {

    var base_path = $("#url").val();

    $("#name").keyup(function () {

        let name = $("#name").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: `${base_path}/api/search-profile`,
            type: 'GET',
            data: {
                name: name
            },
            success: profiles,
            error: errorReturned
        });

        function profiles(data) {
            let users = data.data;


            let table = $('.user-profiles .t-data');
            table.empty();
            for (let u = 0; u < users.length; u++) {
                let user = users[u];
                let tr = $('<tr>');

                tr.attr('data-href', `${base_path}/users/profile/${user.id}`);
                tr.on('click', function (e) {
                    let tareget = e.target.parentNode;
                    window.location.href = tareget.dataset.href;
                });

                for(let item in user) {
                    console.log(user[item]);

                    if(item === 'id') {
                        continue;
                    }

                    let td = $('<td>');
                    td.text(user[item]);
                    tr.append(td);
                }
                table.append(tr);
            }
        }

        function errorReturned(error) {
            console.log(error);
        }

    });
});