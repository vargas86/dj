import io from 'socket.io-client';

const socket = io(
    ws
)
socket.request = function request(type, data = {}) {
    return new Promise((resolve, reject) => {
        socket.emit(type, data, (data) => {
            if (data.error) {
                reject(data.error)
            } else {
                resolve(data)
            }
        })
    })
}
socket.on('ntfd', ({ n_id }) => {
    var ajax = new XMLHttpRequest();
    ajax.open("GET", "/notification/" + n_id);
    ajax.send();

    ajax.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            let response = JSON.parse(this.response);
            let notifications_list = document.getElementById('notifications_list')
            let notification_count = document.getElementById('notification_count')
            if (notifications_list) {
                notifications_list.innerHTML = response.html.trim() + notifications_list.innerHTML;
            }
            if (notification_count) {
                notification_count.innerText = response.count
            }
        }
    };
})
document.addEventListener("DOMContentLoaded", async function () {
    if (notification_user_id != '') notification_user_id = parseInt(notification_user_id);
        await socket.request('connectForNotification', { user_id: notification_user_id });
})
