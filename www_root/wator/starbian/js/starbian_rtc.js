const LS_KEY_CAMERA_SETTING = 'wator-starbian-rtc-media-setting';
/**
* @classdesc This is StarBianRtc.
* @constructor
* @param {string} channelKey
* @param {string} role 'offer' ? 'answer'
*/
class StarBianRtc {
  constructor(channelKey,role) {
    if(!channelKey) {
      throw 'please give me a dist device.';
      return;
    }
    this.configuration_ = {
      iceServers: [
        {urls: 'stun:stun.l.google.com:19302'},
        {urls: 'stun:stun1.l.google.com:19302'},
        {urls: 'stun:stun2.l.google.com:19302'}
      ]
    };
    this.localOfferCache_ = false;
    this.localICECache_ = [];
    if(role === 'offer') {
      this.isOffer_ = true;
    } else {
      this.isOffer_ = false;
    }
    this.createStarBian_(channelKey);
  }
  
  subscribeMedia(cb) {
    this.mediaCB_ = cb;
  }
  subscribeData(cb) {
    this.dataCB_ = cb;
  }
  subscribeLocalMedia(cb) {
    let self = this;
    setTimeout( ()=> {
      if(localStreamCache && typeof cb === 'function') {
        cb(localStreamCache);
      } else {
        self.subscribeLocalMedia(cb);
      }
    },5000);
  }
  subscribeMsg(cb) {
    this.msgCB_ = cb;
  }
  publish(msg) {
    this.starbian_.publish(msg);
  }
  
  // private
  createStarBian_(keyChannel) {
    this.starbian_ = new StarBian.Peer(keyChannel);
    this.starbian_.isReady = false;
    let self = this;
    this.starbian_.onReady = () => {
      self.myPubKey_ = self.starbian_.getPubKey();
      self.starbian_.publish({start:true,key:self.myPubKey_});
      self.starbian_.isReady = true;
    };
    this.starbian_.subscribe( (msg,channel) => {
      try {
        self.onIpfsMessage_(msg,channel);
      } catch( err ) {
        console.error('starbian_.subscribe:err=<',err,'>');
      };
    });
  }
  
  // private
  onIpfsMessage_(msg,channel) {
    console.log('onIpfsMessage_:msg=<',msg,'>');
    console.log('onIpfsMessage_:channel=<',channel,'>');
    if(msg && msg.start) {
      if(this.isOffer_) {
        this.startWebRTCOffer_();
      }
    } else if(msg && msg.answer) {
      this.onRemoteAnswer_(msg.answer);
    } else if(msg && msg.ice) {
      this.onRemoteICE_(msg.ice);
    } else if(msg && msg.offer) {
      this.onRemoteOffer_(msg.offer);
    } else if(msg && msg.offer_answer) {
      this.onOfferAndAnswerStatus_(msg.offer_answer);
    } else {
      //console.log('onIpfsMessage_:msg=<',msg,'>');
      //console.log('onIpfsMessage_:this.msgCB_=<',this.msgCB_,'>');
      if(typeof this.msgCB_ === 'function') {
        this.msgCB_(msg,channel);
      }
    }
  }
  // private
  static createRTCStreaming_() {
    let configStr =  localStorage.getItem(LS_KEY_CAMERA_SETTING);
    console.log('_createRTCStreaming:configStr=<',configStr,'>');
    if(!configStr) {
      return;
    }
    let config = JSON.parse(configStr);
    if(!config) {
      return;
    }
    if(!config.video && !config.audio ) {
      return;
    }
    console.log('_createRTCStreaming:config=<',config,'>');
    navigator.mediaDevices.getUserMedia(config)
    .then( (stream) => {
      console.log('_createRTCStreaming:stream=<',stream,'>');
      localStreamCache = stream;
    })
    .catch( (err) => {
      console.error('_createRTCStreaming:err=<',err,'>');
      configStr = JSON.stringify({});
      localStorage.setItem(LS_KEY_CAMERA_SETTING,configStr);
    });
  }
  
  
  
  startWebRTCOffer_ () {
    this.remoteIceCache_ = [];
    this.pc = new RTCPeerConnection(this.configuration_);
    let self = this;
    this.pc.onnegotiationneeded = (evt) => {
      console.log('startWebRTCOffer_::onnegotiationneeded:evt=<',evt,'>');
    };
    this.pc.onicecandidate = ({candidate}) => { 
      console.log('onicecandidate:candidate=<',candidate,'>');
      if(candidate) {
        self.sendICE_(candidate);
      }
    };
    this.pc.ontrack = (event) => {
      if(typeof self.mediaCB_ === 'function') {
        self.mediaCB_(event);
      }
    };
    if(localStreamCache) {
      this.pc.addStream(localStreamCache);
    }
    let pOffer = this.pc.createOffer();
    pOffer.then(this.onOfferGot_.bind(this));
    pOffer.catch(this.onOfferError_.bind(this));
  }
  onOfferError_(error) {
    console.error('onOfferError_:error=<',error,'>');
  }
  onOfferGot_(offer) {
    console.log('onOfferGot_:offer=<',offer,'>');
    this.pc.setLocalDescription(offer);
    this.sendOffer_(offer);
  }
  sendOffer_(offer) {
    if(this.starbian_.isReady) {
      this.starbian_.publish({offer:offer});
    } else {
      this.localOfferCache_ = offer;
    }
  }
  onRemoteAnswer_(answer) {
    console.log('onRemoteAnswer_:answer=<',answer,'>');  
    let sdp = new RTCSessionDescription(answer);
    console.log('onRemoteAnswer_:sdp=<',sdp,'>');
    let pRsdp = this.pc.setRemoteDescription(sdp);
    pRsdp.then(this.onAnswerSetRemoteDescriptionGot_.bind(this));
    pRsdp.catch(this.onAnswerSetRemoteDescriptionError_.bind(this));
  }
  onAnswerSetRemoteDescriptionError_(error) {
    console.error('onAnswerSetRemoteDescriptionError_:error=<',error,'>');
    this.sendOfferAnswerStatus_(false);
  }
  onAnswerSetRemoteDescriptionGot_() {
    console.log('onAnswerSetRemoteDescriptionGot_');
    this.sendOfferAnswerStatus_(true);
  }
  onRemoteOffer_(offer) {
    this.remoteIceCache_ = [];
    this.pc = new RTCPeerConnection(this.configuration_);
    let self = this;
    this.pc.onnegotiationneeded = (evt) => {
      console.log('onRemoteOffer_::onnegotiationneeded:evt=<',evt,'>');
    };
    this.pc.onicecandidate = ({candidate}) => { 
      console.log('onRemoteOffer_ onicecandidate:candidate=<',candidate,'>');
      if(candidate) {
        self.sendICE_(candidate);
      }
    };
    this.pc.ontrack = (event) => {
      if(typeof self.mediaCB_ === 'function') {
        self.mediaCB_(event);
      }
    };
    if(localStreamCache) {
      this.pc.addStream(localStreamCache);
    }
    console.log('onRemoteOffer_:offer=<',offer,'>');
    let sdp = new RTCSessionDescription(offer);
    console.log('onRemoteOffer_:sdp=<',sdp,'>');
    let pRsdp = this.pc.setRemoteDescription(sdp);
    pRsdp.then(this.onOfferSetRemoteDescriptionGot_.bind(this));
    pRsdp.catch(this.onOfferSetRemoteDescriptionError_.bind(this));
  }  
  
  onOfferSetRemoteDescriptionError_(error) {
    console.error('onOfferSetRemoteDescriptionError_:error=<',error,'>');
  }
  onOfferSetRemoteDescriptionGot_() {
    let pAnswer = this.pc.createAnswer();
    pAnswer.then(this.onAnswerGot_.bind(this));
    pAnswer.catch(this.onAnswerError_.bind(this));
  } 
  
  onAnswerError_(error) {
    console.error('onAnswerError_:error=<',error,'>');
    this.sendOfferAnswerStatus_(false);
  }
  onAnswerGot_(answer) {
    console.log('onAnswerGot_:answer=<',answer,'>');
    this.pc.setLocalDescription(answer);
    this.sendAnswer_(answer);
    this.sendOfferAnswerStatus_(true);
  }
  
  sendAnswer_(answer) {
    if(this.starbian_.isReady) {
      this.starbian_.publish({answer:answer});
    } else {
      console.log('sendAnswer_ wrong times!!!!:answer=<',answer,'>');
    }
  }  
  sendOfferAnswerStatus_(status) {
    if(this.starbian_.isReady) {
      this.starbian_.publish({offer_answer:{status:status}});
    }
  }
  sendICE_(ice) {
    if(this.starbian_.isReady) {
      this.starbian_.publish({ice:ice});
    } else {
      this.localICECache_.push(ice);
    }
  }
  onOfferAndAnswerStatus_(status) {
    console.log('onOfferAndAnswerStatus_:status=<',status,'>');
    this.iceAddReady_ = status;
    if(status) {
      console.log('onOfferAndAnswerStatus_:this.remoteIceCache_=<',this.remoteIceCache_,'>');
      for(let i = 0; i < this.remoteIceCache_.length;i++) {
        let ice = this.remoteIceCache_[i];
        this.pc.addIceCandidate( new RTCIceCandidate(ice));
     }
     this.remoteIceCache_ = [];
    }
  }
  onRemoteICE_(ice) {
    console.log('onRemoteICE_:typeof ice=<',typeof ice,'>');  
    console.log('onRemoteICE_:ice=<',ice,'>');
    if(this.iceAddReady_) {
      this.pc.addIceCandidate( new RTCIceCandidate(ice));
    } else {
      console.log('onRemoteICE_:this.remoteIceCache_=<',this.remoteIceCache_,'>');
      if(!this.remoteIceCache_) {
        this.remoteIceCache_ = [];
      }
      this.remoteIceCache_.push(ice);
    }
  }
}
$(document).ready(function(){
  setTimeout(function(){
    StarBianRtc.createRTCStreaming_();
  },0);
});
let localStreamCache = false;
class DeviceSetting {
  constructor() {
  }
  /**
  * @param {function} cb
  */
  static getDevice(cb) {
    navigator.mediaDevices.enumerateDevices()
    .then(function(devices) {
      cb(devices);
    })
    .catch(function(err) {
      console.log('getDevice:err=<',err,'>');
    });
  }
  /**
  * @param {object} config
  * @param {function} cb
  */
  static getStream(config,cb) {
    let configStr = JSON.stringify(config);
    console.log('getStream:configStr=<',configStr,'>');
    localStorage.setItem(LS_KEY_CAMERA_SETTING,configStr);
    let self = this;
    navigator.mediaDevices.getUserMedia(config)
    .then( (stream) => {
      if(typeof cb === 'function') {
        cb(stream);
      }
    })
    .catch( (err) => {
      console.error('DeviceSetting::getStream:err=<',err,'>');
    });
  }
  /**
  * @param {string} camera
  * @param {function} cb
  */
  static changeCamera(camera,cb) {
    let configStr =  localStorage.getItem(LS_KEY_CAMERA_SETTING);
    let config = {}
    if(configStr) {
      console.log('changeCamera:configStr=<',configStr,'>');
      config = JSON.parse(configStr);
      if(!config) {
        config = {};
      }
      if(!config.video) {
        config.video = {};
      }
      config.video.deviceId = camera;
    } else {
      config.video = {};
      config.video.deviceId = camera;
    }
    configStr = JSON.stringify(config);
    console.log('changeCamera:configStr=<',configStr,'>');
    localStorage.setItem(LS_KEY_CAMERA_SETTING,configStr);
    let self = this;
    navigator.mediaDevices.getUserMedia(config)
    .then( (stream) => {
      if(typeof cb === 'function') {
        cb(stream);
      }
    })
    .catch( (err) => {
      console.error('DeviceSetting::changeCamera:err=<',err,'>');
    });
  }
  /**
  * @param {object} mic
  * @param {function} cb
  */
  static changeMic(mic,cb) {
    let configStr =  localStorage.getItem(LS_KEY_CAMERA_SETTING);
    let config = {}
    if(configStr) {
      console.log('changeMic:configStr=<',configStr,'>');
      config = JSON.parse(configStr);
      if(!config) {
        config = {};
      }
      if(!config.audio) {
        config.audio = {};
      }
      config.audio.deviceId = mic;
    } else {
      config.audio = {};
      config.audio.deviceId = mic;
    }
    configStr = JSON.stringify(config);
    console.log('changeMic:configStr=<',configStr,'>');
    localStorage.setItem(LS_KEY_CAMERA_SETTING,configStr);
    let self = this;
    navigator.mediaDevices.getUserMedia(config)
    .then( (stream) => {
      if(typeof cb === 'function') {
        cb(stream);
      }
    })
    .catch( (err) => {
      console.error('DeviceSetting::changeMic:err=<',err,'>');
    });
  }
}
