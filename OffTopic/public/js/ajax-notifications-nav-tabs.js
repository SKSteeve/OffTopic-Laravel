$(function() {

    var allTab = $('#all-tab');
    var deletedTab = $('#deleted-tab');
    var notDeletedTab = $('#not-deleted-tab');

    var allNotificationsDataElement = $('#all');
    var deletedNotificationsDataElement = $('#deleted');
    var notDeletedNotificationsDataElement = $('#not-deleted');

    var notificationsTabs = $('#notifications-tabs');

    notificationsTabs.on('click', 'li', function (e) {

        let clickedTab = e.target;
        // console.log(clickedTab);

        allTab.removeClass('active');
        deletedTab.removeClass('active');
        notDeletedTab.removeClass('active');

        allNotificationsDataElement.removeClass('show active');
        deletedNotificationsDataElement.removeClass('show active');
        notDeletedNotificationsDataElement.removeClass('show active');

        clickedTab.classList.add('active');
        let clickedTabHref = clickedTab.getAttribute('href');

        let tabNotificationsDataElementId = clickedTabHref.substring(1);
        let tabNotificationsDataElement = $(`#${tabNotificationsDataElementId}`);

        tabNotificationsDataElement.addClass('show active');
        // console.log(tabNotificationsDataElement.text());
    })
});