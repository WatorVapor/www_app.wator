<script type="text/javascript">

const LS_KEY_CAMERA_SETTING = 'wator-starbian-camera-setting';

/**
* @classdesc This is StarBianRtc.
* @constructor
* @param {string} channelKey
*/
class StarBianRtc {
  constructor(channelKey) {
    if(!channelKey) {
      throw 'please give me a dist device.';
      return;
    }
    this.wait_ = false;
    this.call_ = false;
    this.createStarBian_(keyChannel);
  }
  /**
  */
  waitPeer() {
    this.wait_ = true;
  }
  /**
  */
  callPeer() {
    this.call_ = true;
  }
  
  // private

  createStarBian_(keyChannel) {
    this.starbian_ = new StarBian(keyChannel);
    this.starbian_.isReady = false;
    let self = this;
    this.starbian_.onReady = () => {
      self.starbian_.publish({start:true});
      self.starbian_.isReady = true;
    };
    this.starbian_.subscribe( (msg) => {
      try {
        self.onIpfsMessage_(msg);
      } catch( err ) {
        console.error('starbian_.subscribe:err=<',err,'>');
      };
    });
  }
  
  // private
  onIpfsMessage_(msg) {
    console.log('onIpfsMessage_:msg=<',msg,'>');
    console.log('starbian.subcribe:msg=<',msg,'>');
    if(msg && msg.start) {
      startWebRTC();
    }
    if(msg && msg.answer) {
      onRemoteAnswer(msg.answer);
    }
    if(msg && msg.ice) {
      onRemoteICE(msg.ice);
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
    navigator.mediaDevices.getUserMedia(config)
    .then( (stream) => {
      console.log('_createRTCStreaming:stream=<',stream,'>');
      localStreamCache = stream;
    })
    .catch( (err) => {
      console.error('_createRTCStreaming:err=<',err,'>');
    });
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
}

/*
let localOfferCache = false;
let localICECache = [];
function sendLocalCache() {
  if(localOfferCache) {
    notify.publish({offer:localOfferCache});
  }
  if(localICECache) {
    notify.publish({ice:localICECache});
  }
}
const configuration = {
  iceServers: [
    {urls: 'stun:stun.l.google.com:19302'},
    {urls: 'stun:stun1.l.google.com:19302'},
    {urls: 'stun:stun2.l.google.com:19302'}
  ]
};
startCamera();
let localStreamCache = false;
function startCamera() {
  let option = {video: true, audio: true}
  console.log('startCamera=<',option,'>');
  let pMedia = navigator.mediaDevices.getUserMedia(option);
  pMedia.then(onStreamGot);
  pMedia.catch(onStreamError);
}
function onStreamError(error) {
  console.log('onStreamError:error=<',error,'>');
}
function onStreamGot(stream) {
  console.log('onStreamGot:stream=<',stream,'>');
  localStreamCache = stream;
}
let pc = false;
function startWebRTC() {
  if(!localStreamCache) {
    console.log('startWebRTC !!! eroor localStreamCache=<',localStreamCache,'>');
    return;
  }
  pc = new RTCPeerConnection(configuration);
  pc.onicecandidate = ({candidate}) => { 
    console.log('onicecandidate:candidate=<',candidate,'>');
    if(candidate) {
      sendICE(candidate);
    }
  }
  pc.addStream(localStreamCache);
  let pOffer = pc.createOffer();
  pOffer.then(onOfferGot);
  pOffer.catch(onOfferError);
}
function onOfferError(error) {
  console.log('onOfferError:error=<',error,'>');
}
function onOfferGot(offer) {
  console.log('onOfferGot:offer=<',offer,'>');
  pc.setLocalDescription(offer);
  sendOffer(offer);
}
function sendOffer(offer) {
  if(starbian.isReady) {
    starbian.publish({offer:offer});
  } else {
    localOfferCache = offer;
  }
}
function sendICE(ice) {
  if(starbian.isReady) {
    starbian.publish({ice:ice});
  } else {
    localICECache.push(ice);
  }
}
function onRemoteAnswer(answer) {
  console.log('onRemoteAnswer:answer=<',answer,'>');  
  let sdp = new RTCSessionDescription(answer);
  console.log('onRemoteAnswer:sdp=<',sdp,'>');
  let pRsdp =pc.setRemoteDescription(sdp);
  pRsdp.then(onSetRemoteDescriptionGot);
  pRsdp.catch(onSetRemoteDescriptionError);
}
function onSetRemoteDescriptionError(error) {
  console.log('onSetRemoteDescriptionError:error=<',error,'>');
}
function onSetRemoteDescriptionGot() {
}
function onRemoteICE(ice) {
  console.log('onRemoteICE:typeof ice=<',typeof ice,'>');  
  console.log('onRemoteICE:ice=<',ice,'>');
  pc.addIceCandidate( new RTCIceCandidate(ice));
}
*/


</script>
