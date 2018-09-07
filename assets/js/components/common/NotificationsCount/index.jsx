function refreshDisplay(response) {
    if (response.headers.has('SHF-Notification-Count')) {
        let count = parseInt(response.headers.get('SHF-Notification-Count'));
        let content = "";
        if (0 < count) {
            content = "<span class='uk-badge'>" + count + "</span>";
        }

        document.getElementById('notifications-count').innerHTML = content;
    }
}

const NotificationsCount = {
    refreshDisplay
};

export default NotificationsCount;