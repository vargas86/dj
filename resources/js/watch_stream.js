import StudentRoomClient from './StudentRoomClient.js';
import io from 'socket.io-client';


if (location.href.substr(0, 5) !== 'https')
    location.href = 'https' + location.href.substr(4, location.href.length - 4)
const socket = io(
    Stream_URL
)
let producer = null;
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

var videoSelect = document.getElementById('videoDevices')
var audioSelect = document.getElementById('audioDevices')
let audioDevice = null;
let videoDevice = null;
let rc = null
var localMedia = document.getElementById('miniature-video');
var remoteVideos = document.getElementById('video_main');
var remoteAudios = document.getElementById('remote-audio');


document.addEventListener("DOMContentLoaded", async function () {
    // await navigator.mediaDevices.getUserMedia({ audio: true, video: true });


    // Load mediaDevice options
    navigator.mediaDevices.enumerateDevices().then(devices =>
        devices.forEach(device => {
            let el = null
            if ('audioinput' === device.kind) {
                el = audioSelect
            } else if ('videoinput' === device.kind) {
                el = videoSelect
            }
            if (!el) return

            let option = document.createElement('option')
            option.value = device.deviceId
            option.innerText = device.label
            el.appendChild(option)
        })
    )

});


async function init(name, room_id) {
    return new Promise(function (resolve, reject) {
        audioDevice = audioSelect.value
        videoDevice = videoSelect.value
        resolve(new StudentRoomClient(localMedia, remoteVideos, remoteAudios, audioDevice, videoDevice, window.mediasoupClient, socket, room_id, name, roomOpen));
    })
}
async function joinRoom(name, room_id) {
    if (rc && rc.isOpen()) {
        console.log('already connected to a room')
    } else {
        rc = await init(name, room_id).then(
            async function (rc) {
                addListeners(rc)
                return rc;
            }
        )
    }

}

joinRoom(user_name, live_slug)

function roomOpen() {
    console.log('SUCCESS');
}


function addListeners(rc) {
    rc.on(StudentRoomClient.EVENTS.startScreen, () => {
    })

    rc.on(StudentRoomClient.EVENTS.stopScreen, () => {

    })

    rc.on(StudentRoomClient.EVENTS.stopAudio, () => {

    })
    rc.on(StudentRoomClient.EVENTS.startAudio, () => {
    })

    rc.on(StudentRoomClient.EVENTS.startVideo, () => {
    })
    rc.on(StudentRoomClient.EVENTS.stopVideo, () => {
    })
    rc.on(StudentRoomClient.EVENTS.exitRoom, () => {
    })
}

// CHAT
if (document.getElementById("chat-submit")) {
    document.getElementById("chat-submit").addEventListener('click', function (e) {
        e.preventDefault();
        if (rc) {
            let msg = e.target.parentNode.querySelector("#chat-message").value
            let ajax = new XMLHttpRequest()
            ajax.open("POST", '/live/' + live_slug + '/chat');
            var token = document.getElementsByName('csrf-token')[0].content;
            ajax.setRequestHeader("X-CSRF-Token", token);
            let formData = new FormData();
            formData.set('message', msg)
            formData.set('user_id', user_id)
            ajax.onreadystatechange = function () {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    let response = JSON.parse(this.response);
                    rc.socket.request('newChat', { m: response.message_id });
                }
            }
            if (msg.length) {
                ajax.send(formData);
                e.target.parentNode.querySelector("#chat-message").value = ''
            }
        }
    })
}


if (audioSelect) {
    audioSelect.addEventListener('change', function (e) {
        if (rc && rc.sharedPeer == null && rc.producerLabel.get('audioType')) {
            // Close producer
            let producer_id = rc.producerLabel.get('audioType')
            rc.socket.emit('producerClosed', {
                producer_id
            })
            rc.producers.get(producer_id).close()
            rc.producers.delete(producer_id)
            rc.producerLabel.delete('audioType')
            rc.produce('audioType', e.target.value)
            if (rc.producerLabel.get('videoType')) {
                // Close producer
                let producer_id = rc.producerLabel.get('videoType')
                rc.socket.emit('producerClosed', {
                    producer_id
                })
                rc.producers.get(producer_id).close()
                rc.producers.delete(producer_id)
                rc.producerLabel.delete('videoType')
                rc.produce('videoType', videoSelect.value)
            }
        }
    });
}

let raiseHand = document.getElementById('raiseHand');
if (raiseHand) {
    raiseHand.addEventListener('click', function (e) {
        if (rc) {
            rc.socket.request('raiseHand', {
                peer: rc.socket.id
            })
        }
        let target;
        if (e.target.id) {
            target = e.target
        } else {
            target = e.target.parentNode
        }
        target.style.display = 'none'
        document.getElementById('stopRaiseHand').style.display = 'block'
    })
}

let stopRaiseHand = document.getElementById('stopRaiseHand');
if (stopRaiseHand) {
    stopRaiseHand.addEventListener('click', function (e) {
        if (rc) {
            rc.socket.request('stopRaiseHand', {
                peer: rc.socket.id
            })
        }
        let target;
        if (e.target.id) {
            target = e.target
        } else {
            target = e.target.parentNode
        }
        target.style.display = 'none'
        document.getElementById('raiseHand').style.display = 'block'
    })
}


if (videoSelect) {
    videoSelect.addEventListener('change', function (e) {
        navigator.mediaDevices.getUserMedia({ video: { deviceId: { exact: e.target.value } }, audio: false, }).then(
            (stream) => {
                localMedia.querySelector("video").srcObject = stream
            }
        )
        if (rc && rc.sharedPeer == null && rc.producerLabel.get('videoType')) {
            let producer_id = rc.producerLabel.get('videoType')
            rc.socket.emit('producerClosed', {
                producer_id
            })
            rc.producers.get(producer_id).close()
            rc.producers.delete(producer_id)
            rc.producerLabel.delete('videoType')
            rc.produce('videoType', e.target.value)
            if (rc.producerLabel.get('audioType')) {
                // Close producer
                let producer_id = rc.producerLabel.get('audioType')
                rc.socket.emit('producerClosed', {
                    producer_id
                })
                rc.producers.get(producer_id).close()
                rc.producers.delete(producer_id)
                rc.producerLabel.delete('audioType')
                rc.produce('audioType', audioSelect.value)
            }
        }
    });

}


let disableAudio = document.getElementById('disable-audio')
let enableAudio = document.getElementById('enable-audio')
let disableVideo = document.getElementById('disable-video')
let enableVideo = document.getElementById('enable-video')
if (disableAudio) {
    disableAudio.addEventListener('click', function (e) {
        if (enableAudio) {
            if (rc && rc.sharedPeer == null && rc.producerLabel.get('audioType')) {
                enableAudio.style.display = 'block';
                e.target.style.display = 'none';

                // Close producer
                let producer_id = rc.producerLabel.get('audioType')
                rc.socket.emit('producerClosed', {
                    producer_id
                })
                rc.producers.get(producer_id).close()
                rc.producers.delete(producer_id)
                rc.producerLabel.delete('audioType')
            }
        }
    });
}

if (enableAudio) {
    enableAudio.addEventListener('click', function (e) {
        if (disableAudio) {
            if (rc && rc.sharedPeer == null && !rc.producerLabel.get('audioType')) {
                disableAudio.style.display = 'block';
                e.target.style.display = 'none';
                rc.produce('audioType', audioSelect.value)
            }
        }
    });
}

if (disableVideo) {
    disableVideo.addEventListener('click', function (e) {
        if (enableVideo) {
            if (rc && rc.sharedPeer == null && rc.producerLabel.get('videoType')) {
                enableVideo.style.display = 'block';
                e.target.style.display = 'none';
                let producer_id = rc.producerLabel.get('videoType')
                rc.socket.emit('producerClosed', {
                    producer_id
                })
                rc.producers.get(producer_id).close()
                rc.producers.delete(producer_id)
                rc.producerLabel.delete('videoType')
                if(localMedia && localMedia.querySelector('video')){
                    localMedia.querySelector('video').remove()
                }
            }

        }
    });
}

if (enableVideo) {
    enableVideo.addEventListener('click', function (e) {
        if (disableVideo) {
            if (rc && rc.sharedPeer == null && !rc.producerLabel.get('videoType')) {
                let miniature
                miniature = document.createElement('video')
                navigator.mediaDevices.getUserMedia({ video: true }).then(
                    (stream) => {

                        miniature.srcObject = stream
                    }
                )
                miniature.playsinline = false
                miniature.autoplay = true
                miniature.style.setProperty('width', '234px')
                miniature.style.setProperty('height', '132px')
                localMedia.appendChild(miniature)
                disableVideo.style.display = 'block';
                e.target.style.display = 'none';
                rc.produce('videoType', videoSelect.value)
            }
        }
    });
}


