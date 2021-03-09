(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[1],{

/***/ "./resources/js/stream-client/RoomClient.js":
/*!**************************************************!*\
  !*** ./resources/js/stream-client/RoomClient.js ***!
  \**************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);


function _createForOfIteratorHelper(o, allowArrayLike) { var it; if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var mediaType = {
  audio: 'audioType',
  video: 'videoType',
  screen: 'screenType'
};
var _EVENTS = {
  exitRoom: 'exitRoom',
  openRoom: 'openRoom',
  startVideo: 'startVideo',
  stopVideo: 'stopVideo',
  startAudio: 'startAudio',
  stopAudio: 'stopAudio',
  startScreen: 'startScreen',
  stopScreen: 'stopScreen'
};

var RoomClient = /*#__PURE__*/function () {
  function RoomClient(localMediaEl, remoteVideoEl, remoteAudioEl, mediasoupClient, socket, room_id, name, successCallback) {
    _classCallCheck(this, RoomClient);

    this.name = name;
    this.localMediaEl = localMediaEl;
    this.remoteVideoEl = remoteVideoEl;
    this.remoteAudioEl = remoteAudioEl;
    this.mediasoupClient = mediasoupClient;
    this.socket = socket;
    this.producerTransport = null;
    this.consumerTransport = null;
    this.device = null;
    this.room_id = room_id;
    this.consumers = new Map();
    this.producers = new Map();
    /**
     * map that contains a mediatype as key and producer_id as value
     */

    this.producerLabel = new Map();
    this._isOpen = false;
    this.eventListeners = new Map();
    Object.keys(_EVENTS).forEach(function (evt) {
      this.eventListeners.set(evt, []);
    }.bind(this));
    this.createRoom(room_id).then( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              _context.next = 2;
              return this.join(name, room_id);

            case 2:
              this.initSockets();
              this._isOpen = true;
              successCallback();

            case 5:
            case "end":
              return _context.stop();
          }
        }
      }, _callee, this);
    })).bind(this));
  } ////////// INIT /////////


  _createClass(RoomClient, [{
    key: "createRoom",
    value: function () {
      var _createRoom = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2(room_id) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _context2.next = 2;
                return this.socket.request('createRoom', {
                  room_id: room_id
                })["catch"](function (err) {
                  console.log(err);
                });

              case 2:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this);
      }));

      function createRoom(_x) {
        return _createRoom.apply(this, arguments);
      }

      return createRoom;
    }()
  }, {
    key: "join",
    value: function () {
      var _join = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee4(name, room_id) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                socket.request('join', {
                  name: name,
                  room_id: room_id
                }).then( /*#__PURE__*/function () {
                  var _ref2 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee3(e) {
                    var data, device;
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee3$(_context3) {
                      while (1) {
                        switch (_context3.prev = _context3.next) {
                          case 0:
                            console.log(e);
                            _context3.next = 3;
                            return this.socket.request('getRouterRtpCapabilities');

                          case 3:
                            data = _context3.sent;
                            _context3.next = 6;
                            return this.loadDevice(data);

                          case 6:
                            device = _context3.sent;
                            this.device = device;
                            _context3.next = 10;
                            return this.initTransports(device);

                          case 10:
                            this.socket.emit('getProducers');

                          case 11:
                          case "end":
                            return _context3.stop();
                        }
                      }
                    }, _callee3, this);
                  }));

                  return function (_x4) {
                    return _ref2.apply(this, arguments);
                  };
                }().bind(this))["catch"](function (e) {
                  console.log(e);
                });

              case 1:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4, this);
      }));

      function join(_x2, _x3) {
        return _join.apply(this, arguments);
      }

      return join;
    }()
  }, {
    key: "loadDevice",
    value: function () {
      var _loadDevice = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee5(routerRtpCapabilities) {
        var device;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                try {
                  device = new this.mediasoupClient.Device();
                } catch (error) {
                  if (error.name === 'UnsupportedError') {
                    console.error('browser not supported');
                  }

                  console.error(error);
                }

                _context5.next = 3;
                return device.load({
                  routerRtpCapabilities: routerRtpCapabilities
                });

              case 3:
                return _context5.abrupt("return", device);

              case 4:
              case "end":
                return _context5.stop();
            }
          }
        }, _callee5, this);
      }));

      function loadDevice(_x5) {
        return _loadDevice.apply(this, arguments);
      }

      return loadDevice;
    }()
  }, {
    key: "initTransports",
    value: function () {
      var _initTransports = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee9(device) {
        var data, _data;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee9$(_context9) {
          while (1) {
            switch (_context9.prev = _context9.next) {
              case 0:
                _context9.next = 2;
                return this.socket.request('createWebRtcTransport', {
                  forceTcp: false,
                  rtpCapabilities: device.rtpCapabilities
                });

              case 2:
                data = _context9.sent;

                if (!data.error) {
                  _context9.next = 6;
                  break;
                }

                console.error(data.error);
                return _context9.abrupt("return");

              case 6:
                this.producerTransport = device.createSendTransport(data);
                this.producerTransport.on('connect', /*#__PURE__*/function () {
                  var _ref4 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee6(_ref3, callback, errback) {
                    var dtlsParameters;
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee6$(_context6) {
                      while (1) {
                        switch (_context6.prev = _context6.next) {
                          case 0:
                            dtlsParameters = _ref3.dtlsParameters;
                            this.socket.request('connectTransport', {
                              dtlsParameters: dtlsParameters,
                              transport_id: data.id
                            }).then(callback)["catch"](errback);

                          case 2:
                          case "end":
                            return _context6.stop();
                        }
                      }
                    }, _callee6, this);
                  }));

                  return function (_x7, _x8, _x9) {
                    return _ref4.apply(this, arguments);
                  };
                }().bind(this));
                this.producerTransport.on('produce', /*#__PURE__*/function () {
                  var _ref6 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee7(_ref5, callback, errback) {
                    var kind, rtpParameters, _yield$this$socket$re, producer_id;

                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee7$(_context7) {
                      while (1) {
                        switch (_context7.prev = _context7.next) {
                          case 0:
                            kind = _ref5.kind, rtpParameters = _ref5.rtpParameters;
                            _context7.prev = 1;
                            _context7.next = 4;
                            return this.socket.request('produce', {
                              producerTransportId: this.producerTransport.id,
                              kind: kind,
                              rtpParameters: rtpParameters
                            });

                          case 4:
                            _yield$this$socket$re = _context7.sent;
                            producer_id = _yield$this$socket$re.producer_id;
                            callback({
                              id: producer_id
                            });
                            _context7.next = 12;
                            break;

                          case 9:
                            _context7.prev = 9;
                            _context7.t0 = _context7["catch"](1);
                            errback(_context7.t0);

                          case 12:
                          case "end":
                            return _context7.stop();
                        }
                      }
                    }, _callee7, this, [[1, 9]]);
                  }));

                  return function (_x10, _x11, _x12) {
                    return _ref6.apply(this, arguments);
                  };
                }().bind(this));
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
                _context9.next = 12;
                return this.socket.request('createWebRtcTransport', {
                  forceTcp: false
                });

              case 12:
                _data = _context9.sent;

                if (!_data.error) {
                  _context9.next = 16;
                  break;
                }

                console.error(_data.error);
                return _context9.abrupt("return");

              case 16:
                // only one needed
                this.consumerTransport = device.createRecvTransport(_data);
                this.consumerTransport.on('connect', function (_ref7, callback, errback) {
                  var dtlsParameters = _ref7.dtlsParameters;
                  this.socket.request('connectTransport', {
                    transport_id: this.consumerTransport.id,
                    dtlsParameters: dtlsParameters
                  }).then(callback)["catch"](errback);
                }.bind(this));
                this.consumerTransport.on('connectionstatechange', /*#__PURE__*/function () {
                  var _ref8 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee8(state) {
                    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee8$(_context8) {
                      while (1) {
                        switch (_context8.prev = _context8.next) {
                          case 0:
                            _context8.t0 = state;
                            _context8.next = _context8.t0 === 'connecting' ? 3 : _context8.t0 === 'connected' ? 4 : _context8.t0 === 'failed' ? 5 : 7;
                            break;

                          case 3:
                            return _context8.abrupt("break", 8);

                          case 4:
                            return _context8.abrupt("break", 8);

                          case 5:
                            this.consumerTransport.close();
                            return _context8.abrupt("break", 8);

                          case 7:
                            return _context8.abrupt("break", 8);

                          case 8:
                          case "end":
                            return _context8.stop();
                        }
                      }
                    }, _callee8, this);
                  }));

                  return function (_x13) {
                    return _ref8.apply(this, arguments);
                  };
                }().bind(this));

              case 19:
              case "end":
                return _context9.stop();
            }
          }
        }, _callee9, this);
      }));

      function initTransports(_x6) {
        return _initTransports.apply(this, arguments);
      }

      return initTransports;
    }()
  }, {
    key: "initSockets",
    value: function initSockets() {
      this.socket.on('consumerClosed', function (_ref9) {
        var consumer_id = _ref9.consumer_id;
        console.log('closing consumer:', consumer_id);
        this.removeConsumer(consumer_id);
      }.bind(this));
      /**
       * data: [ {
       *  producer_id:
       *  producer_socket_id:
       * }]
       */

      this.socket.on('newProducers', /*#__PURE__*/function () {
        var _ref10 = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee10(data) {
          var _iterator, _step, producer_id;

          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee10$(_context10) {
            while (1) {
              switch (_context10.prev = _context10.next) {
                case 0:
                  console.log('new producers', data);
                  _iterator = _createForOfIteratorHelper(data);
                  _context10.prev = 2;

                  _iterator.s();

                case 4:
                  if ((_step = _iterator.n()).done) {
                    _context10.next = 10;
                    break;
                  }

                  producer_id = _step.value.producer_id;
                  _context10.next = 8;
                  return this.consume(producer_id);

                case 8:
                  _context10.next = 4;
                  break;

                case 10:
                  _context10.next = 15;
                  break;

                case 12:
                  _context10.prev = 12;
                  _context10.t0 = _context10["catch"](2);

                  _iterator.e(_context10.t0);

                case 15:
                  _context10.prev = 15;

                  _iterator.f();

                  return _context10.finish(15);

                case 18:
                case "end":
                  return _context10.stop();
              }
            }
          }, _callee10, this, [[2, 12, 15, 18]]);
        }));

        return function (_x14) {
          return _ref10.apply(this, arguments);
        };
      }().bind(this));
      this.socket.on('disconnect', function () {
        this.exit(true);
      }.bind(this));
    } //////// MAIN FUNCTIONS /////////////

  }, {
    key: "produce",
    value: function () {
      var _produce = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee11(type) {
        var _this = this;

        var deviceId,
            mediaConstraints,
            audio,
            screen,
            stream,
            track,
            params,
            elem,
            _args11 = arguments;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee11$(_context11) {
          while (1) {
            switch (_context11.prev = _context11.next) {
              case 0:
                deviceId = _args11.length > 1 && _args11[1] !== undefined ? _args11[1] : null;
                mediaConstraints = {};
                audio = false;
                screen = false;
                _context11.t0 = type;
                _context11.next = _context11.t0 === mediaType.audio ? 7 : _context11.t0 === mediaType.video ? 10 : _context11.t0 === mediaType.screen ? 12 : 15;
                break;

              case 7:
                mediaConstraints = {
                  audio: {
                    deviceId: deviceId
                  },
                  video: false
                };
                audio = true;
                return _context11.abrupt("break", 17);

              case 10:
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
                };
                return _context11.abrupt("break", 17);

              case 12:
                mediaConstraints = false;
                screen = true;
                return _context11.abrupt("break", 17);

              case 15:
                return _context11.abrupt("return");

              case 17:
                if (!(!this.device.canProduce('video') && !audio)) {
                  _context11.next = 20;
                  break;
                }

                console.error('cannot produce video');
                return _context11.abrupt("return");

              case 20:
                if (!this.producerLabel.has(type)) {
                  _context11.next = 23;
                  break;
                }

                console.log('producer already exists for this type ' + type);
                return _context11.abrupt("return");

              case 23:
                console.log('mediacontraints:', mediaConstraints);
                _context11.prev = 24;

                if (!screen) {
                  _context11.next = 31;
                  break;
                }

                _context11.next = 28;
                return navigator.mediaDevices.getDisplayMedia();

              case 28:
                _context11.t1 = _context11.sent;
                _context11.next = 34;
                break;

              case 31:
                _context11.next = 33;
                return navigator.mediaDevices.getUserMedia(mediaConstraints);

              case 33:
                _context11.t1 = _context11.sent;

              case 34:
                stream = _context11.t1;
                console.log(navigator.mediaDevices.getSupportedConstraints());
                track = audio ? stream.getAudioTracks()[0] : stream.getVideoTracks()[0];
                params = {
                  track: track
                };

                if (!audio && !screen) {
                  params.encodings = [{
                    rid: 'r0',
                    maxBitrate: 100000,
                    //scaleResolutionDownBy: 10.0,
                    scalabilityMode: 'S1T3'
                  }, {
                    rid: 'r1',
                    maxBitrate: 300000,
                    scalabilityMode: 'S1T3'
                  }, {
                    rid: 'r2',
                    maxBitrate: 900000,
                    scalabilityMode: 'S1T3'
                  }];
                  params.codecOptions = {
                    videoGoogleStartBitrate: 1000
                  };
                }

                _context11.next = 41;
                return this.producerTransport.produce(params);

              case 41:
                producer = _context11.sent;
                console.log('producer', producer);
                this.producers.set(producer.id, producer);

                if (!audio) {
                  elem = document.createElement('video');
                  elem.srcObject = stream;
                  elem.id = producer.id;
                  elem.playsinline = false;
                  elem.autoplay = true;
                  elem.className = "vid";
                  this.localMediaEl.appendChild(elem);
                }

                producer.on('trackended', function () {
                  _this.closeProducer(type);
                });
                producer.on('transportclose', function () {
                  console.log('producer transport close');

                  if (!audio) {
                    elem.srcObject.getTracks().forEach(function (track) {
                      track.stop();
                    });
                    elem.parentNode.removeChild(elem);
                  }

                  _this.producers["delete"](producer.id);
                });
                producer.on('close', function () {
                  console.log('closing producer');

                  if (!audio) {
                    elem.srcObject.getTracks().forEach(function (track) {
                      track.stop();
                    });
                    elem.parentNode.removeChild(elem);
                  }

                  _this.producers["delete"](producer.id);
                });
                this.producerLabel.set(type, producer.id);
                _context11.t2 = type;
                _context11.next = _context11.t2 === mediaType.audio ? 52 : _context11.t2 === mediaType.video ? 54 : _context11.t2 === mediaType.screen ? 56 : 58;
                break;

              case 52:
                this.event(_EVENTS.startAudio);
                return _context11.abrupt("break", 60);

              case 54:
                this.event(_EVENTS.startVideo);
                return _context11.abrupt("break", 60);

              case 56:
                this.event(_EVENTS.startScreen);
                return _context11.abrupt("break", 60);

              case 58:
                return _context11.abrupt("return");

              case 60:
                _context11.next = 65;
                break;

              case 62:
                _context11.prev = 62;
                _context11.t3 = _context11["catch"](24);
                console.log(_context11.t3);

              case 65:
              case "end":
                return _context11.stop();
            }
          }
        }, _callee11, this, [[24, 62]]);
      }));

      function produce(_x15) {
        return _produce.apply(this, arguments);
      }

      return produce;
    }()
  }, {
    key: "consume",
    value: function () {
      var _consume = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee12(producer_id) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee12$(_context12) {
          while (1) {
            switch (_context12.prev = _context12.next) {
              case 0:
                //let info = await roomInfo()
                this.getConsumeStream(producer_id).then(function (_ref11) {
                  var consumer = _ref11.consumer,
                      stream = _ref11.stream,
                      kind = _ref11.kind;
                  this.consumers.set(consumer.id, consumer);
                  var elem;

                  if (kind === 'video') {
                    elem = document.createElement('video');
                    elem.srcObject = stream;
                    elem.id = consumer.id;
                    elem.playsinline = false;
                    elem.autoplay = true;
                    elem.className = "vid";
                    this.remoteVideoEl.appendChild(elem);
                  } else {
                    elem = document.createElement('audio');
                    elem.srcObject = stream;
                    elem.id = consumer.id;
                    elem.playsinline = false;
                    elem.autoplay = true;
                    this.remoteAudioEl.appendChild(elem);
                  }

                  consumer.on('trackended', function () {
                    this.removeConsumer(consumer.id);
                  }.bind(this));
                  consumer.on('transportclose', function () {
                    this.removeConsumer(consumer.id);
                  }.bind(this));
                }.bind(this));

              case 1:
              case "end":
                return _context12.stop();
            }
          }
        }, _callee12, this);
      }));

      function consume(_x16) {
        return _consume.apply(this, arguments);
      }

      return consume;
    }()
  }, {
    key: "getConsumeStream",
    value: function () {
      var _getConsumeStream = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee13(producerId) {
        var rtpCapabilities, data, id, kind, rtpParameters, codecOptions, consumer, stream;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee13$(_context13) {
          while (1) {
            switch (_context13.prev = _context13.next) {
              case 0:
                rtpCapabilities = this.device.rtpCapabilities;
                _context13.next = 3;
                return this.socket.request('consume', {
                  rtpCapabilities: rtpCapabilities,
                  consumerTransportId: this.consumerTransport.id,
                  // might be 
                  producerId: producerId
                });

              case 3:
                data = _context13.sent;
                id = data.id, kind = data.kind, rtpParameters = data.rtpParameters;
                codecOptions = {};
                _context13.next = 8;
                return this.consumerTransport.consume({
                  id: id,
                  producerId: producerId,
                  kind: kind,
                  rtpParameters: rtpParameters,
                  codecOptions: codecOptions
                });

              case 8:
                consumer = _context13.sent;
                stream = new MediaStream();
                stream.addTrack(consumer.track);
                return _context13.abrupt("return", {
                  consumer: consumer,
                  stream: stream,
                  kind: kind
                });

              case 12:
              case "end":
                return _context13.stop();
            }
          }
        }, _callee13, this);
      }));

      function getConsumeStream(_x17) {
        return _getConsumeStream.apply(this, arguments);
      }

      return getConsumeStream;
    }()
  }, {
    key: "closeProducer",
    value: function closeProducer(type) {
      if (!this.producerLabel.has(type)) {
        console.log('there is no producer for this type ' + type);
        return;
      }

      var producer_id = this.producerLabel.get(type);
      console.log(producer_id);
      this.socket.emit('producerClosed', {
        producer_id: producer_id
      });
      this.producers.get(producer_id).close();
      this.producers["delete"](producer_id);
      this.producerLabel["delete"](type);

      if (type !== mediaType.audio) {
        var elem = document.getElementById(producer_id);
        elem.srcObject.getTracks().forEach(function (track) {
          track.stop();
        });
        elem.parentNode.removeChild(elem);
      }

      switch (type) {
        case mediaType.audio:
          this.event(_EVENTS.stopAudio);
          break;

        case mediaType.video:
          this.event(_EVENTS.stopVideo);
          break;

        case mediaType.screen:
          this.event(_EVENTS.stopScreen);
          break;

        default:
          return;
          break;
      }
    }
  }, {
    key: "pauseProducer",
    value: function pauseProducer(type) {
      if (!this.producerLabel.has(type)) {
        console.log('there is no producer for this type ' + type);
        return;
      }

      var producer_id = this.producerLabel.get(type);
      this.producers.get(producer_id).pause();
    }
  }, {
    key: "resumeProducer",
    value: function resumeProducer(type) {
      if (!this.producerLabel.has(type)) {
        console.log('there is no producer for this type ' + type);
        return;
      }

      var producer_id = this.producerLabel.get(type);
      this.producers.get(producer_id).resume();
    }
  }, {
    key: "removeConsumer",
    value: function removeConsumer(consumer_id) {
      var elem = document.getElementById(consumer_id);
      elem.srcObject.getTracks().forEach(function (track) {
        track.stop();
      });
      elem.parentNode.removeChild(elem);
      this.consumers["delete"](consumer_id);
    }
  }, {
    key: "exit",
    value: function exit() {
      var offline = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;

      var clean = function () {
        this._isOpen = false;
        this.consumerTransport.close();
        this.producerTransport.close();
        this.socket.off('disconnect');
        this.socket.off('newProducers');
        this.socket.off('consumerClosed');
      }.bind(this);

      if (!offline) {
        this.socket.request('exitRoom').then(function (e) {
          return console.log(e);
        })["catch"](function (e) {
          return console.warn(e);
        })["finally"](function () {
          clean();
        }.bind(this));
      } else {
        clean();
      }

      this.event(_EVENTS.exitRoom);
    } ///////  HELPERS //////////

  }, {
    key: "roomInfo",
    value: function () {
      var _roomInfo = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee14() {
        var info;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee14$(_context14) {
          while (1) {
            switch (_context14.prev = _context14.next) {
              case 0:
                _context14.next = 2;
                return socket.request('getMyRoomInfo');

              case 2:
                info = _context14.sent;
                return _context14.abrupt("return", info);

              case 4:
              case "end":
                return _context14.stop();
            }
          }
        }, _callee14);
      }));

      function roomInfo() {
        return _roomInfo.apply(this, arguments);
      }

      return roomInfo;
    }()
  }, {
    key: "event",
    value: function event(evt) {
      if (this.eventListeners.has(evt)) {
        this.eventListeners.get(evt).forEach(function (callback) {
          return callback();
        });
      }
    }
  }, {
    key: "on",
    value: function on(evt, callback) {
      this.eventListeners.get(evt).push(callback);
    } //////// GETTERS ////////

  }, {
    key: "isOpen",
    value: function isOpen() {
      return this._isOpen;
    }
  }], [{
    key: "mediaType",
    get: function get() {
      return mediaType;
    }
  }, {
    key: "EVENTS",
    get: function get() {
      return _EVENTS;
    }
  }]);

  return RoomClient;
}();

/***/ })

}]);