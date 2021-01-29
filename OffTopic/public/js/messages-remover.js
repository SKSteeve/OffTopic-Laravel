$(function() {
    //$('.messages-success-error').hide(8000);

    setTimeout(function(){
        let messageContainer = $('.messages-success-error');

        if (messageContainer.length > 0) {
            messageContainer.remove();
        }
    }, 5000)
});