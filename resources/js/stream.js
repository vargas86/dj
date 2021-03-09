import RoomClient from './stream-client/RoomClient.js';
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

// Updates the select element with the provided set of cameras
function updateCameraList(cameras) {
    let listElement = document.querySelector('select#videoSelect');
    listElement.innerHTML = '';
    cameras.forEach(camera => {
        const cameraOption = document.createElement('option');
        cameraOption.label = camera.label;
        cameraOption.value = camera.deviceId;
        listElement.appendChild(cameraOption)
    })
}

// Fetch an array of devices of a certain type
async function getConnectedDevices(type) {
    const devices = await navigator.mediaDevices.enumerateDevices()
    return devices.filter(device => device.kind === type)
}


// Listen for changes to media devices and update the list accordingly
navigator.mediaDevices.addEventListener('devicechange', event => {
    const newCameraList = getConnectedDevices('video');
    updateCameraList(newCameraList);
});
var audioDevice = null;
var videoDevice = null;

let audioSelect = document.getElementById('audioSelect')
let videoSelect = document.getElementById('videoSelect')


if (audioSelect) {
    audioSelect.addEventListener('change', function (e) {
        if (rc && rc.sharedPeer == null && rc.producerLabel.get('audioType')) {
            rc.closeProducer('audioType')
            rc.produce('audioType', e.target.value)
            if (rc.producerLabel.get('videoType')) {
                rc.closeProducer('videoType')
                rc.produce('videoType', videoSelect.value)
            }
        }
    });
}
if (videoSelect) {
    videoSelect.addEventListener('change', function (e) {
        navigator.mediaDevices.getUserMedia({ video: { deviceId: { exact: e.target.value } }, audio: false, }).then(
            (stream) => {
                localMediaMiniature.querySelector("video").srcObject = stream
            }
        )
        if (rc && rc.sharedPeer == null && rc.producerLabel.get('videoType')) {
            rc.closeProducer('videoType')
            rc.produce('videoType', e.target.value)
            if (rc.producerLabel.get('audioType')) {
                rc.closeProducer('audioType')
                rc.produce('audioType', audioSelect.value)
            }
        }
    });

}

// CHAT
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

document.addEventListener("DOMContentLoaded", async function () {
    await navigator.mediaDevices.getUserMedia({ audio: true, video: true });


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
    localMediaMiniature.appendChild(miniature)

    // Get the initial set of cameras connected
    const videoCameras = await getConnectedDevices('videoinput');
    updateCameraList(videoCameras);

});


let rc = null
var localMedia = document.getElementById('video_main');
var remoteVideos = document.getElementById('remote-videos');
var remoteAudios = document.getElementById('remote-audios');
var localMediaMiniature = document.getElementById('miniature-video')
async function init(name, room_id) {
    return new Promise(function (resolve, reject) {
        audioDevice = audioSelect.value
        videoDevice = videoSelect.value
        resolve(new RoomClient(localMedia, localMediaMiniature, audioDevice, videoDevice, remoteVideos, remoteAudios, window.mediasoupClient, socket, room_id, name, roomOpen));
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
        window.rc = rc;
        window.RoomClient = RoomClient;
    }

}

function roomOpen() {
    console.log('SUCCESS');
}


function addListeners(rc) {
    rc.on(RoomClient.EVENTS.startScreen, () => {
    })

    rc.on(RoomClient.EVENTS.stopScreen, () => {

    })

    rc.on(RoomClient.EVENTS.stopAudio, () => {

    })
    rc.on(RoomClient.EVENTS.startAudio, () => {
    })

    rc.on(RoomClient.EVENTS.startVideo, () => {
    })
    rc.on(RoomClient.EVENTS.stopVideo, () => {
    })
    rc.on(RoomClient.EVENTS.exitRoom, () => {
        localMediaMiniature.innerHTML = ''
        localMedia.innerHTML = ''
    })
}


var startStopBtn = document.querySelector('#startStopStream');
if (startStopBtn) {
    startStopBtn.addEventListener('click', function (e) {
        if (e.target.id === 'startStopStream') {
            var target = e.target
        } else {
            var target = e.target.parentNode
        }
        if (rc && rc.isOpen()) {
            rc.exit();
            target.style.backgroundColor = '#28a745'
            target.innerHTML = '<i class="uil uil-play-circle"></i>Start stream'
        } else {
            joinRoom(user_name, live_slug)
            target.style.backgroundColor = 'red'
            target.innerHTML = '<i class="uil uil-pause-circle"></i>End stream'
            notify_subscribers.forEach(element => {
                let sub_id = element.subscriber_id
                var formData = new FormData();
                formData.append("title", user_name + " strated a live stream.");
                formData.append("message", user_name + " strated a live stream.");
                formData.append("user_id", sub_id);
                formData.append("target_url", '/live/' + live_slug);
                var ajax = new XMLHttpRequest();
                var token = document.getElementsByName('csrf-token')[0].content;
                ajax.open("POST", "/member/notification");
                ajax.setRequestHeader("X-CSRF-Token", token);
                ajax.send(formData);

                ajax.onreadystatechange = async function () {
                    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                        await socket.request('ntf', { n_id: JSON.parse(this.response).n_id, user_id: parseInt(sub_id) });
                    }
                };
            });
        }


    })
}
let shareProducer = null
let audioShareProducer = null

document.addEventListener('click', async function (e) {
    if (e.target.classList.contains('share-viewer')) {

        // SHARE VIDEO
        let track
        let remoteVideo = e.target.closest('li').querySelector('video')
        let remoteAudio = e.target.closest('li').querySelector('audio')
        let peersinfo = JSON.parse(await rc.socket.request('getPeersInfo'));


        if (remoteVideo && !remoteAudio) {
            // VIDEO & NO AUDIO
            let stream = remoteVideo.srcObject;
            track = stream.getVideoTracks()[0];
            const params = {
                track
            }
            params.encodings = [{
                rid: 'r0',
                maxBitrate: 100000,
                scalabilityMode: 'S1T3'
            },
            {
                rid: 'r1',
                maxBitrate: 300000,
                scalabilityMode: 'S1T3'
            },
            {
                rid: 'r2',
                maxBitrate: 900000,
                scalabilityMode: 'S1T3'
            }
            ]
            params.codecOptions = {
                videoGoogleStartBitrate: 1000
            }
            let producer_id = rc.producerLabel.get('videoType')
            if (producer_id) {
                await rc.socket.emit('producerClosed', {
                    producer_id
                })
                rc.producers.delete(producer_id)
                rc.producerLabel.delete('videoType')
            }
            let found = peersinfo.find(element => {
                return (element.consumer_id === remoteVideo.id);
            });
            rc.sharedPeer = found.peer_id
            shareProducer = await rc.producerTransport.produce(params)
            localMedia.querySelector('video').srcObject = stream
            rc.producerLabel.set('videoType', shareProducer.id)
            rc.producers.set(shareProducer.id, shareProducer)
            rc.shareProducer = remoteVideo.id
            document.getElementById('stop-sharing').style.cursor = 'pointer'
            document.getElementById('stop-sharing').style.backgroundColor = '#767779'
        } else if (remoteAudio && !remoteVideo) {
            // AUDIO & NO VIDEO
            let audioStream = remoteAudio.srcObject;
            track = audioStream.getAudioTracks()[0];
            const audioParams = {
                track
            };
            let audioProducer_id = rc.producerLabel.get('audioType')
            if (audioProducer_id) {
                await rc.socket.emit('producerClosed', {
                    producer_id: audioProducer_id
                })
                rc.producers.delete(audioProducer_id)
                rc.producerLabel.delete('audioType')
            }
            let found = peersinfo.find(element => {
                return (element.consumer_id === remoteAudio.id);
            });
            rc.sharedPeer = found.peer_id
            audioShareProducer = await rc.producerTransport.produce(audioParams)
            let shareAudioEl = document.createElement('audio')
            shareAudioEl.srcObject = audioStream
            localMedia.appendChild(shareAudioEl)
            rc.producerLabel.set('audioType', audioShareProducer.id)
            rc.producers.set(audioShareProducer.id, audioShareProducer)
            rc.audioShareProducer = remoteAudio.id
            localMedia.innerHTML = ''
            let producer_id = rc.producerLabel.get('videoType')
            if (producer_id) {
                await rc.socket.emit('producerClosed', {
                    producer_id
                })
                rc.producers.delete(producer_id)
                rc.producerLabel.delete('videoType')
            }
            document.getElementById('stop-sharing').style.cursor = 'pointer'
            document.getElementById('stop-sharing').style.backgroundColor = '#767779'
        } else if (remoteAudio && remoteVideo) {
            // VIDEO
            let stream = remoteVideo.srcObject
            track = stream.getVideoTracks()[0]
            const params = {
                track
            };
            params.share = true
            params.encodings = [{
                rid: 'r0',
                maxBitrate: 100000,
                scalabilityMode: 'S1T3'
            },
            {
                rid: 'r1',
                maxBitrate: 300000,
                scalabilityMode: 'S1T3'
            },
            {
                rid: 'r2',
                maxBitrate: 900000,
                scalabilityMode: 'S1T3'
            }
            ];
            params.codecOptions = {
                videoGoogleStartBitrate: 1000
            };
            let producer_id = rc.producerLabel.get('videoType')
            if (producer_id) {
                await rc.socket.emit('producerClosed', {
                    producer_id
                })
                rc.producers.delete(producer_id)
                rc.producerLabel.delete('videoType')
            }
            let found = peersinfo.find(element => {
                return (element.consumer_id === remoteAudio.id);
            });
            rc.sharedPeer = found.peer_id
            shareProducer = await rc.producerTransport.produce(params)
            rc.sharedAudioProducer = shareProducer
            localMedia.querySelector('video').srcObject = stream;
            rc.shareProducer = remoteVideo.id;
            rc.producerLabel.set('videoType', shareProducer.id)
            rc.producers.set(shareProducer.id, shareProducer)

            //Audio
            let audioStream = remoteAudio.srcObject;
            let audiotrack = audioStream.getAudioTracks()[0];
            const audioParams = {
                track: audiotrack
            };
            let audioProducer_id = rc.producerLabel.get('audioType')
            if (audioProducer_id) {
                await rc.socket.emit('producerClosed', {
                    producer_id: audioProducer_id
                })
                rc.producers.delete(audioProducer_id)
                rc.producerLabel.delete('audioType')
            }
            audioShareProducer = await rc.producerTransport.produce(audioParams)
            let shareAudioEl = document.createElement('audio')
            shareAudioEl.srcObject = audioStream
            localMedia.appendChild(shareAudioEl)
            rc.audioShareProducer = remoteAudio.id;
            rc.producerLabel.set('audioType', audioShareProducer.id)
            rc.producers.set(audioShareProducer.id, audioShareProducer)
            document.getElementById('stop-sharing').style.cursor = 'pointer'
            document.getElementById('stop-sharing').style.backgroundColor = '#767779'

        }

    }
})


document.getElementById('stop-sharing').addEventListener('click', async (e) => {
    if (rc && rc.shareProducer) {
        let close = rc.producerLabel.get('videoType')
        rc.producers.delete(close)
        rc.producerLabel.delete('videoType')
        await rc.socket.emit('producerClosed', {
            producer_id: close
        })
        rc.sharedPeer = null
        rc.localMediaEl.innerHTML = ''
        rc.produce('videoType');
        rc.shareProducer = null
        document.getElementById('stop-sharing').style.cursor = 'disabled'
        document.getElementById('stop-sharing').style.backgroundColor = 'rgb(201, 200, 200)'
    }
    if (rc && rc.audioShareProducer) {

        let close = rc.producerLabel.get('audioType')
        rc.producers.delete(close)
        rc.producerLabel.delete('audioType')
        await rc.socket.emit('producerClosed', {
            producer_id: close
        })
        rc.localMediaEl.innerHTML = ''
        rc.sharedPeer = null
        rc.produce('audioType', rc.audioDevice);
        rc.audioShareProducer = null
        document.getElementById('stop-sharing').style.cursor = 'pointer'
        document.getElementById('stop-sharing').style.backgroundColor = 'rgb(201, 200, 200)'
    }
})


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
                rc.closeProducer('audioType')
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
                rc.closeProducer('videoType')
            }

        }
    });
}

if (enableVideo) {
    enableVideo.addEventListener('click', function (e) {
        if (disableVideo) {
            if (rc && rc.sharedPeer == null && !rc.producerLabel.get('videoType')) {
                disableVideo.style.display = 'block';
                e.target.style.display = 'none';
                rc.produce('videoType', videoSelect.value)
            }
        }
    });
}