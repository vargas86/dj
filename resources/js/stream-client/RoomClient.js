const mediaType = {
    audio: 'audioType',
    video: 'videoType',
    screen: 'screenType'
}
const _EVENTS = {
    exitRoom: 'exitRoom',
    openRoom: 'openRoom',
    startVideo: 'startVideo',
    stopVideo: 'stopVideo',
    startAudio: 'startAudio',
    stopAudio: 'stopAudio',
    startScreen: 'startScreen',
    stopScreen: 'stopScreen'
}

let producer = null;

class RoomClient {

    constructor(localMediaEl, localMediaMiniature, audioDevice, videoDevice, remoteVideoEl, remoteAudioEl, mediasoupClient, socket, room_id, name, successCallback) {
        this.name = name
        this.localMediaMiniature = localMediaMiniature
        this.localMediaEl = localMediaEl
        this.remoteVideoEl = remoteVideoEl
        this.remoteAudioEl = remoteAudioEl
        this.mediasoupClient = mediasoupClient
        this.shareProducer = null
        this.audioShareProducer = null
        this.sharedPeer = null
        this.socket = socket
        this.audioDevice = audioDevice
        this.videoDevice = videoDevice
        this.producerTransport = null
        this.consumerTransport = null
        this.device = null
        this.room_id = room_id
        this.localStream = null

        this.consumers = new Map()
        this.producers = new Map()

        /**
         * map that contains a mediatype as key and producer_id as value
         */
        this.producerLabel = new Map()

        this._isOpen = false
        this.eventListeners = new Map()
        Object.keys(_EVENTS).forEach(function (evt) {
            this.eventListeners.set(evt, [])
        }.bind(this))


        this.createRoom(room_id).then(async function () {
            await this.join(name, room_id, true)
            this.initSockets()
            this._isOpen = true
            successCallback()
        }.bind(this))




    }

    ////////// INIT /////////

    async createRoom(room_id) {
        await this.socket.request('createRoom', {
            room_id
        }).catch(err => {
            console.log(err)
        })
    }

    async join(name, room_id, isMain) {

        await this.socket.request('join', {
            name,
            room_id,
            isMain
        }).then(async function (e) {
            console.log(e)
            const data = await this.socket.request('getRouterRtpCapabilities');
            let device = await this.loadDevice(data)
            this.device = device
            await this.initTransports(device)
            // this.initLocalProducer()
            await this.produce(mediaType.video, this.videoDevice);
            await this.produce(mediaType.audio, this.audioDevice);
            this.socket.emit('getProducers')
        }.bind(this)).catch(e => {
            console.log(e)
        })
    }

    initLocalProducer() {
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
        this.localMediaMiniature.appendChild(miniature)
    }

    async loadDevice(routerRtpCapabilities) {
        let device
        try {
            device = new this.mediasoupClient.Device();
        } catch (error) {
            if (error.name === 'UnsupportedError') {
                console.error('browser not supported');
            }
            console.error(error)
        }
        await device.load({
            routerRtpCapabilities
        })
        return device

    }

    async initTransports(device) {

        // init producerTransport
        {
            const data = await this.socket.request('createWebRtcTransport', {
                forceTcp: false,
                rtpCapabilities: device.rtpCapabilities,
            })
            if (data.error) {
                console.error(data.error);
                return;
            }

            this.producerTransport = device.createSendTransport(data);

            this.producerTransport.on('connect', async function ({
                dtlsParameters
            }, callback, errback) {
                this.socket.request('connectTransport', {
                    dtlsParameters,
                    transport_id: data.id
                })
                    .then(callback)
                    .catch(errback)
            }.bind(this));
            this.producerTransport.on('produce', async function (data, callback, errback) {
                try {
                    let kind = data.kind
                    let rtpParameters = data.rtpParameters
                    const {
                        producer_id
                    } = await this.socket.request('produce', {
                        producerTransportId: this.producerTransport.id,
                        kind,
                        rtpParameters,
                        sharedPeer: this.sharedPeer
                    });
                    callback({
                        id: producer_id
                    });
                } catch (err) {
                    errback(err);
                }
            }.bind(this))

            this.producerTransport.on('connectionstatechange', function (state) {
                switch (state) {
                    case 'connecting':

                        break;

                    case 'connected':
                        //localVideo.srcObject = stream
                        break;

                    case 'failed':
                        this.producerTransport.close();
                        break;

                    default:
                        break;
                }
            }.bind(this));
        }

        // init consumerTransport
        {
            const data = await this.socket.request('createWebRtcTransport', {
                forceTcp: false,
            });
            if (data.error) {
                console.error(data.error);
                return;
            }

            // only one needed
            this.consumerTransport = device.createRecvTransport(data);
            this.consumerTransport.on('connect', function ({
                dtlsParameters
            }, callback, errback) {
                this.socket.request('connectTransport', {
                    transport_id: this.consumerTransport.id,
                    dtlsParameters
                })
                    .then(callback)
                    .catch(errback);
            }.bind(this));

            this.consumerTransport.on('connectionstatechange', async function (state) {
                switch (state) {
                    case 'connecting':
                        break;

                    case 'connected':
                        //remoteVideo.srcObject = await stream;
                        //await socket.request('resume');
                        break;

                    case 'failed':
                        this.consumerTransport.close();
                        break;

                    default:
                        break;
                }
            }.bind(this));
        }

    }

    initSockets() {
        this.socket.on('consumerClosed', async function ({
            consumer_id
        }) {
            console.log('closing consumer:', consumer_id)
            if (this.shareProducer && consumer_id === this.shareProducer) {

                this.localMediaEl.innerHTML = ''
                let producer_id = this.producerLabel.get('videoType')
                this.socket.emit('producerClosed', {
                    producer_id
                })
                this.producers.get(producer_id).close()
                this.producers.delete(producer_id)
                this.shareProducer = null
                this.producerLabel.delete('videoType')
                this.produce('videoType')
                let elem = document.getElementById(consumer_id)
                let audioId = (elem.closest('li').querySelector('audio')) != null ? elem.closest('li').querySelector('audio').id : null
                if (!audioId) elem.closest('li').remove()
                else elem.remove()
                document.getElementById('stop-sharing').style.cursor = 'pointer'
                document.getElementById('stop-sharing').style.backgroundColor = 'rgb(201, 200, 200)'
            } else if (this.audioShareProducer && consumer_id === this.audioShareProducer) {
                let producer_id = this.producerLabel.get('audioType')
                this.socket.emit('producerClosed', {
                    producer_id
                })
                this.producers.get(producer_id).close()
                this.producers.delete(producer_id)
                this.audioShareProducer = null

                let elem = document.getElementById(consumer_id)
                let videoId = (elem.closest('li').querySelector('video')) != null ? elem.closest('li').querySelector('video').id : null;
                elem.srcObject.getTracks().forEach(function (track) {
                    track.stop()
                })
                if (!videoId) elem.closest('li').remove()
                else elem.remove()
                this.produce('audioType');
                document.getElementById('stop-sharing').style.cursor = 'pointer'
                document.getElementById('stop-sharing').style.backgroundColor = 'rgb(201, 200, 200)'
            } else if (this.consumers.get(consumer_id) && this.consumers.get(consumer_id).kind == 'audio') {
                let elem = document.getElementById(consumer_id)
                let vidId = (elem.closest('li').querySelector('video')) != null ? elem.closest('li').querySelector('video').id : null;
                elem.srcObject.getTracks().forEach(function (track) {
                    track.stop()
                })
                let mute = document.createElement('i')
                mute.classList.add('mute')
                mute.classList.add('uil')
                mute.classList.add('uil-volume-mute')
                if (!vidId) elem.closest('li').remove()
                else {
                    elem.closest('li').querySelector('.video').appendChild(mute)
                    elem.remove()
                }
            } else if (this.consumers.get(consumer_id) && this.consumers.get(consumer_id).kind == 'video') {

                let elem = document.getElementById(consumer_id)
                let audioId = (elem.closest('li').querySelector('audio')) != null ? elem.closest('li').querySelector('audio').id : null;
                elem.srcObject.getTracks().forEach(function (track) {
                    track.stop()
                })
                if (!audioId) elem.closest('li').remove()
                else {
                    elem.remove()
                }
            }
        }.bind(this))

        /**
         * data: [ {
         *  producer_id:
         *  producer_socket_id:
         * }]
         */
        this.socket.on('newProducers', async function (data) {

            console.log('new producers', data);
            for (let {
                producer_id
            } of data) {
                if (!this.producers.has(producer_id))
                    await this.consume(producer_id)
            }
        }.bind(this))

        this.socket.on('disconnect', function () {
            this.exit(true)
        }.bind(this))

        this.socket.on('raiseHand', function ({ peer }) {
            let li = document.querySelector("[data-peer-id='" + peer + "']")
            let actions = document.createElement('div')
            actions.className = 'actions'
            let actions_innerHTML = "<a class='bt bt-success share-viewer' ><i class='uil uil-video'></i>Share Viewer Camera</a>"
            actions.innerHTML = actions_innerHTML.trim();
            li.querySelector(".video").appendChild(actions)
        })
        this.socket.on('stopRaiseHand', function ({ peer }) {
            let li = document.querySelector("[data-peer-id='" + peer + "']")
            let actions = li.querySelector(".actions")
            console.log(actions);
            if (actions) {
                li.querySelector(".video").removeChild(actions)
            }
        })

        this.socket.on('newChat', function (m) {
            let ajax = new XMLHttpRequest()
            ajax.open("GET", '/live/' + live_slug + '/chat/' + m);
            ajax.onreadystatechange = function () {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    document.querySelector('#chat_inner').innerHTML = document.querySelector('#chat_inner').innerHTML + this.response.trim()
                    document.querySelector('#chat_inner').scrollTop = document.querySelector('#chat_inner').scrollHeight
                }
            }
            ajax.send();
        })

    }




    //////// MAIN FUNCTIONS /////////////


    async produce(type, deviceId = null) {
        let mediaConstraints = {}
        let audio = false
        let screen = false
        switch (type) {
            case mediaType.audio:
                mediaConstraints = {
                    audio: {
                        deviceId: deviceId
                    },
                    video: false
                }
                audio = true
                break
            case mediaType.video:
                mediaConstraints = {
                    audio: false,
                    video: {
                        width: {
                            min: 640,
                            ideal: 1920
                        },
                        height: {
                            min: 400,
                            ideal: 1080
                        },
                        deviceId: deviceId
                        /*aspectRatio: {
                            ideal: 1.7777777778
                        }*/
                    }
                }
                break
            case mediaType.screen:
                mediaConstraints = false
                screen = true
                break;
            default:
                return
                break;
        }

        if (!this.device.canProduce('video') && !audio) {
            console.error('cannot produce video');
            return;
        }
        if (this.producerLabel.has(type)) {
            console.log('producer already exists for this type' + type)
            return
        }
        console.log('mediacontraints :', mediaConstraints)
        let stream;
        try {
            stream = screen ? await navigator.mediaDevices.getDisplayMedia() : await navigator.mediaDevices.getUserMedia(mediaConstraints)

            const track = audio ? stream.getAudioTracks()[0] : stream.getVideoTracks()[0]
            const params = {
                track
            };
            if (!audio && !screen) {
                params.encodings = [{
                    rid: 'r0',
                    maxBitrate: 100000,
                    //scaleResolutionDownBy: 10.0,
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
            }
            producer = await this.producerTransport.produce(params)
            this.producers.set(producer.id, producer)

            let elem
            if (!audio) {
                elem = document.createElement('video')
                elem.srcObject = stream
                this.localStream = stream
                elem.id = producer.id
                elem.playsinline = false
                elem.autoplay = true
                elem.className = "vid"
                elem.style.setProperty('width', '834px')
                elem.style.setProperty('height', '467px')
                this.localMediaEl.appendChild(elem)
            }

            producer.on('trackended', () => {
                this.closeProducer(type)
            })

            producer.on('transportclose', () => {
                console.log('producer transport close')
                if (!audio) {
                    elem.srcObject.getTracks().forEach(function (track) {
                        track.stop()
                    })
                    elem.parentNode.removeChild(elem)
                }
                this.producers.delete(producer.id)

            })

            producer.on('close', () => {
                console.log('closing producer')
                if (!audio) {
                    elem.srcObject.getTracks().forEach(function (track) {
                        track.stop()
                    })
                    elem.parentNode.removeChild(elem)
                }
                this.producers.delete(producer.id)

            })

            this.producerLabel.set(type, producer.id)

            switch (type) {
                case mediaType.audio:
                    this.event(_EVENTS.startAudio)
                    break
                case mediaType.video:
                    this.event(_EVENTS.startVideo)
                    break
                case mediaType.screen:
                    this.event(_EVENTS.startScreen)
                    break;
                default:
                    return
                    break;
            }
        } catch (err) {
            console.log(err)
        }
    }

    async consume(producer_id) {
        // console.log('remote:::' + producer_id);
        //let info = await roomInfo()

        this.getConsumeStream(producer_id).then(async function ({
            consumer,
            stream,
            kind
        }) {

            let elem;
            if (kind === 'video') {
                let audioId = await this.isPeerpresent(consumer.id, 'audio')
                let audioEl = document.getElementById(audioId)
                if (audioId && audioEl) {
                    elem = document.createElement('video')
                    elem.srcObject = stream
                    elem.id = consumer.id
                    elem.playsinline = false
                    elem.autoplay = true
                    elem.style.setProperty('max-width', '234px');
                    elem.style.setProperty('max-height', '133px');
                    audioEl.parentNode.appendChild(elem)
                } else {
                    let peers = JSON.parse(await rc.socket.request('getPeersInfo'));
                    let found = peers.find(element => {
                        return element.consumer_id === consumer.id
                    })
                    elem = document.createElement('video')
                    elem.srcObject = stream
                    elem.id = consumer.id
                    elem.playsinline = false
                    elem.autoplay = true
                    elem.className = "vid"
                    elem.style.setProperty('width', '234px');
                    elem.style.setProperty('height', '133px');
                    let elem_container;
                    elem_container = document.createElement('li');
                    elem_container.dataset.peerId = found.peer_id
                    elem_container.style.setProperty('width', '234px');
                    elem_container.style.setProperty('height', '133px');
                    let div = document.createElement('div')
                    div.className = "video"
                    div.style.backgroundColor = '#eee'
                    div.style.height = '135px'
                    div.style.width = '234px'
                    let div_2 = document.createElement('div')
                    div_2.style.height = '135px'
                    div_2.style.width = '234px'
                    div_2.appendChild(elem)
                    div.appendChild(div_2)
                    elem_container.appendChild(div)
                    this.remoteVideoEl.appendChild(elem_container)
                }

            } else {

                let videoId = await this.isPeerpresent(consumer.id, 'video');
                let vidEl = document.getElementById(videoId);
                if (videoId && vidEl) {
                    elem = document.createElement('audio')
                    elem.srcObject = stream
                    elem.id = consumer.id
                    elem.playsinline = false
                    elem.autoplay = true
                    let m;
                    if ((m = vidEl.closest('li').querySelector('.mute'))) {
                        m.remove();
                    }
                    vidEl.parentNode.appendChild(elem)
                } else {
                    let peers = JSON.parse(await rc.socket.request('getPeersInfo'));
                    let found = peers.find(element => {
                        return element.consumer_id === consumer.id
                    })
                    elem = document.createElement('audio')
                    elem.srcObject = stream
                    elem.id = consumer.id
                    elem.playsinline = false
                    elem.autoplay = true
                    let elem_container;
                    elem_container = document.createElement('li');
                    elem_container.dataset.peerId = found.peer_id
                    elem_container.style.setProperty('width', '234px');
                    elem_container.style.setProperty('height', '133px');
                    let div = document.createElement('div')
                    div.className = "video"
                    div.style.backgroundColor = '#eee'
                    div.style.height = '135px'
                    div.style.width = '234px'
                    let div_2 = document.createElement('div')
                    div_2.style.height = '135px'
                    div_2.style.width = '234px'
                    div_2.appendChild(elem)
                    div.appendChild(div_2)
                    elem_container.appendChild(div)
                    this.remoteVideoEl.appendChild(elem_container)
                }
            }

            this.consumers.set(consumer.id, consumer)

            consumer.on('trackended', function () {
                this.removeConsumer(consumer.id)
            }.bind(this))
            consumer.on('transportclose', function () {
                this.removeConsumer(consumer.id)
            }.bind(this))



        }.bind(this))
    }

    async getConsumeStream(producerId) {
        const {
            rtpCapabilities
        } = this.device
        const data = await this.socket.request('consume', {
            rtpCapabilities,
            consumerTransportId: this.consumerTransport.id, // might be 
            producerId
        });
        const {
            id,
            kind,
            rtpParameters,
        } = data;

        let codecOptions = {};
        const consumer = await this.consumerTransport.consume({
            id,
            producerId,
            kind,
            rtpParameters,
            codecOptions,
        })
        const stream = new MediaStream();
        stream.addTrack(consumer.track);
        return {
            consumer,
            stream,
            kind
        }
    }

    closeProducer(type) {
        if (!this.producerLabel.has(type)) {
            console.log('there is no producer for this type ' + type)
            return
        }
        let producer_id = this.producerLabel.get(type)
        this.socket.emit('producerClosed', {
            producer_id
        })
        this.producers.get(producer_id).close()
        this.producers.delete(producer_id)
        this.producerLabel.delete(type)

        if (type !== mediaType.audio) {
            let elem = document.getElementById(producer_id)
            elem.srcObject.getTracks().forEach(function (track) {
                track.stop()
            })
            elem.parentNode.removeChild(elem)
        }

        switch (type) {
            case mediaType.audio:
                this.event(_EVENTS.stopAudio)
                break
            case mediaType.video:
                this.event(_EVENTS.stopVideo)
                break
            case mediaType.screen:
                this.event(_EVENTS.stopScreen)
                break;
            default:
                return
                break;
        }

    }

    pauseProducer(type) {
        if (!this.producerLabel.has(type)) {
            console.log('there is no producer for this type ' + type)
            return
        }
        let producer_id = this.producerLabel.get(type)
        this.producers.get(producer_id).pause()

    }

    resumeProducer(type) {
        if (!this.producerLabel.has(type)) {
            console.log('there is no producer for this type ' + type)
            return
        }
        let producer_id = this.producerLabel.get(type)
        this.producers.get(producer_id).resume()

    }

    removeConsumer(consumer_id) {
        let elem = document.getElementById(consumer_id)
        elem.srcObject.getTracks().forEach(function (track) {
            track.stop()
        })
        let parent = elem.closest('li');
        elem.parentNode.removeChild(elem)
        parent.remove()
        this.consumers.delete(consumer_id)
        if (this.localMediaEl.querySelector('video') && !this.localMediaEl.querySelector('video').srcObject.active) {
            this.localMediaEl.querySelector('video').srcObject = this.localStream
        }
    }

    exit(offline = false) {

        let clean = function () {
            this._isOpen = false
            this.consumerTransport.close()
            this.producerTransport.close()
            this.socket.off('disconnect')
            this.socket.off('newProducers')
            this.socket.off('consumerClosed')
        }.bind(this)

        if (!offline) {
            this.socket.request('exitRoom').then(e => console.log(e)).catch(e => console.warn(e)).finally(function () {
                clean()
            }.bind(this))
        } else {
            clean()
        }

        this.event(_EVENTS.exitRoom)

    }

    ///////  HELPERS //////////

    async roomInfo() {
        let info = await this.socket.request('getMyRoomInfo')
        return info
    }

    static get mediaType() {
        return mediaType
    }

    event(evt) {
        if (this.eventListeners.has(evt)) {
            this.eventListeners.get(evt).forEach(callback => callback())
        }
    }

    on(evt, callback) {
        this.eventListeners.get(evt).push(callback)
    }


    async isPeerpresent(consumer_id, type) {
        let found = false
        let otherConsumerId = null
        let peersInfo = JSON.parse(await rc.socket.request('getPeersInfo'));
        found = peersInfo.find((e) => {
            return (e.consumer_id == consumer_id && e.peer_id != rc.socket.id)
        })
        if (found) {
            let otherConsumer = peersInfo.find((e) => {
                return (e.peer_id == found.peer_id && e.type == type)
            })
            otherConsumerId = otherConsumer ? otherConsumer.consumer_id : null
        }
        return otherConsumerId;
    }

    //////// GETTERS ////////

    isOpen() {
        return this._isOpen
    }

    static get EVENTS() {
        return _EVENTS
    }
}

export default RoomClient;