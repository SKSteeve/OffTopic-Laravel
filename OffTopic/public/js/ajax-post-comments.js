$(document).ready(function () {
    var base_path = $("#url").val();

    var commentFormSubmitBtn = $('.comment-form-submit-btn');
    var addCommentBtn = $('.add-comment-btn');
    var editModeText = $('.edit-mode-text');
    var commentEditMessageSection = $('.edit-comment-message');
    var collapseCommentForm = $('#collapse-comment-form');
    var createEditModeBtnSection = $('.create-editmode-comment-btn-section');

    $('.edit-comment').on('click', ajaxCommentEdit);
    commentFormSubmitBtn.on('click', ajaxCommentUpdateOrCreate);

    /**
     * AJAX GET
     * Fill the comment textarea for editing comment
     * Adding button with event, id attr to commentBody, text and other visual changes to comment form
     *
     * @param {event} e
     */
    function ajaxCommentEdit(e) {
        e.preventDefault();

        let editBtn = e.target;
        let commentId = editBtn.value;

        let closeEditModeBtn = $('<button>');
        let editModeBtn = $('.edit-mode-btn');

        editModeBtn.remove();
        closeEditModeBtn.addClass('edit-mode-btn btn btn-warning float-right mr-2');
        closeEditModeBtn.text('Leave Edit Mode');
        closeEditModeBtn.on('click', changeModeEditOrCreate);
        createEditModeBtnSection.append(closeEditModeBtn);

        editModeText.text('You are going to edit one of your comments! If you want to add new comment instead, please click on "Leave Edit Mode" button .');
        editModeText.removeClass('text-success');
        editModeText.addClass('text-danger');

        addCommentBtn.text('Edit comment');
        collapseCommentForm.attr('class', 'show');
        commentFormSubmitBtn.text('Update comment');

        $('html, body').animate({
            scrollTop: collapseCommentForm.offset().top
        }, 2000);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: `${base_path}/comment/${commentId}/edit`,
            type: "GET",
            success: fillForm,
            error: errorReturned
        });

        function fillForm(data) {
            let commentBody = data.commentBody;
            let commentFormTextArea = $('.comment-body-for-submit');

            commentFormTextArea.attr('id', commentId);
            commentFormTextArea.val(commentBody);
        }
    }

    /**
     * AJAX PUT
     * Update Comment Or Create
     * (actually the back-end handles the whole create process without Ajax or any js)
     *
     * @param {event} e
     */
    function ajaxCommentUpdateOrCreate(e) {

        // -------------  UPDATE Comment ---------------
        if(checkAction()) {
            e.preventDefault();

            console.log('Edit Mode');

            let commentFormTextArea = $('.comment-body-for-submit');
            let commentId = commentFormTextArea.attr('id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: `${base_path}/comment/update`,
                type: "PUT",
                data: {
                    id: commentId,
                    body: commentFormTextArea.val()
                },
                success: update,
                error: errorReturned
            });

            function update(data) {

                let editButton = $(`[value=${data.commentData.id}]`);
                let commentForEditSection = editButton.parent().parent();
                let commentBodyForEdit = commentForEditSection.find("p");
                commentBodyForEdit.text(data.commentData.body);

                let messageElement = $('<div>');
                messageElement.text(data.success);
                messageElement.addClass('messages-success-error alert alert-success');

                commentEditMessageSection.append(messageElement);

                collapseCommentForm.removeClass('show');
                collapseCommentForm.addClass('collapse');

                changeModeEditOrCreate($('.edit-mode-btn'));
            }
        }

        // ------------- CREATE Comment ---------------
        // Handled by the back-edn cuz we dont preventDefault
    }


    /**
     * Check if we should update or create comment after click on submit
     * If commentId is undefined or null we creat, otherwise we edit
     *
     * @returns {boolean}
     */
    function checkAction() {
        let commentBody = $('.comment-body-for-submit');
        let commentId = commentBody.attr('id');

        if(commentId != null) {        // Edit Comment
            return true;
        }

        return false;                  // Create Comment
    }

    /**
     * Remove the id attribute from textarea, making the next submit to create comment
     * removing and adding other visual changes
     *
     * @param {Object} e jQuery element Object
     */
    function changeModeEditOrCreate(e) {
        if(e.target) {
            e.target.remove();
        } else {
            e.remove();
        }

        let commentFormTextArea = $('.comment-body-for-submit');

        addCommentBtn.text('Add Comment');
        commentFormSubmitBtn.text('Post Comment');
        commentFormTextArea.removeAttr('id');
        commentFormTextArea.val('');
        editModeText.text('You are about to create new comment!');
        editModeText.removeClass('text-danger');
        editModeText.addClass('text-success');
    }

    /**
     * Used To return Errors from both Ajax
     *
     * @param {error} error
     */
    function errorReturned(error) {
        console.log(error)
    }
});