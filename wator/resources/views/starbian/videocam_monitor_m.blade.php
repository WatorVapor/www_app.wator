@extends('wator.app')
@section('content')
<script src="/wator/starbian/js/starbian.js" type="text/javascript"></script>
@include('starbian.js.m_localstorage')

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
  starbian.subscribe( (msg) => {
    console.log('starbian.subcribe:msg=<',msg,'>');
  });
  console.log('starbian=<',starbian,'>');
  sbConnectionList.push(starbian);
}

</script>


@endsection
