<script type="text/javascript">
  function GotCapture() {
    let video = document.getElementById('video-face');
    console.log('GotCapture video=<',video,'>');
    let canvas = document.getElementById('canvas-face');
    console.log('GotCapture canvas=<',canvas,'>');
    let width = video.getAttribute('width');
    let height = video.getAttribute('height');
    canvas.width = width;
    canvas.height = width;
    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
  }
</script>

<script type="text/javascript">
  $(document).ready(function(){
    onInitVideoCam();
  });
  onInitVideoCam = () => {
    let elemKey = document.getElementById('wator-remote-key');
    const keyChannel = elemKey.textContent.trim();
    console.log('keyChannel=<' , keyChannel , '>');
    if(keyChannel) {
      createWebRTCConnection(keyChannel);
    } else {
      let remotekeys = StarBian.getRemoteKey();
      console.log('remotekeys=<' , remotekeys , '>');
      for(let i = 0;i < remotekeys.length;i++) {
        createWebRTCConnection(remotekeys[i]);
      }
    }
  }

  let rtcConnectionList = [];
  createWebRTCConnection = (keyChannel) => {
    let rtc = new StarBianRtc(keyChannel,'offer');
    rtc.subscribeMedia( (event) => {
      console.log('subscribeMedia event=<',event,'>');
      //document.getElementById("video").srcObject = event.streams[0];
    });
    rtc.subscribeLocalMedia((localStream) => {
      console.log('subscribeMedia localStream=<',localStream,'>');
      let cvVideo = document.getElementById("video-face");
      cvVideo.srcObject = localStream;
      setInterval(GotCapture,1000);
    });
    rtc.subscribeMsg( (msg,channel) => {
      console.log('subscribeMsg msg=<',msg,'>');
      console.log('subscribeMsg channel=<',channel,'>');
    });
    rtcConnectionList.push(rtc);
  }
</script>
