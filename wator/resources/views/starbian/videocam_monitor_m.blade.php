@extends('wator.app')
@section('content')
<script src="/wator/starbian/js/starbian.js" type="text/javascript"></script>
@include('starbian.js.m_localstorage')
@include('starbian.js.starbian_tts')


<div class="row mt-lg-5 justify-content-center">

  <div class="col-10" id="vue-ui-detect-person">
    <div class="row mt-lg-5 justify-content-center">
      <div class="col-2">
        @if (isset($mobile))
        <a type="button" class="btn btn-success btn-lg btn-block"
          v-bind:href="from.rcvurl" target="_blank">
          <i class="material-icons">video_call</i>
        </a>
        @else
        <a type="button" class="btn btn-success btn-block"
          v-bind:href="from.rcvurl" target="_blank">
          <i class="material-icons">video_call</i>
        </a>
        @endif
      </div>
      <div class="col-6">
        <span class="label label-info d-inline-block text-truncate" style="white-space: pre-wrap ; font-size: large;">@{{ from.key }}</span>
      </div>
    </div>
  </div>

</div>

<script type="text/javascript">
  onShowLinkOfDetectedCam = (channelKey) => {
    @if (isset($mobile))
    let rcvurl = 'https://www.wator.xyz/starbian/cloud/m/videocam_recv/' + channelKey;
    @else
    let rcvurl = 'https://www.wator.xyz/starbian/cloud/videocam_recv/' + channelKey;
    @endif
    let app2 = new Vue({
      el: '#vue-ui-detect-person',
      data: {
        from: { 
          rcvurl:rcvurl,
          key:channelKey
        }
      }
    });
  }
</script>

<script type="text/javascript">

$(document).ready(function(){
  onInitMonitor();
});

onInitMonitor = () => {
let remotekeys = StarBian.getRemoteKey();
  console.log('remotekeys=<' , remotekeys , '>');
  for(let i = 0;i < remotekeys.length;i++) {
    createStarBian(remotekeys[i]);
  }
  console.log('sbConnectionList=<' , sbConnectionList , '>');
}
let sbConnectionList = []; 
createStarBian = (keyChannel) => {
  let starbian = new StarBian.Peer(keyChannel);
  starbian.isReady = false;
  starbian.onReady = () => {
  };
  starbian.subscribe( (msg,from) => {
    console.log('starbian.subcribe:msg=<',msg,'>');
    console.log('starbian.subcribe:from=<',from,'>');
    if(msg && msg.detect && msg.detect.persion) {
      onShowLinkOfDetectedCam(from);
      sayCheckDoorCamera();
    }
  });
  console.log('starbian=<',starbian,'>');
  sbConnectionList.push(starbian);
}

</script>


@endsection
