<script type="text/javascript">

var WATOR = WATOR || {};
WATOR.WebBle = {};
WATOR.WebBle.READ_INTERVAL = 20;
WATOR.WebBle.serviceID = '9a10ba1d-cd1c-4f00-9cca-1f3178d5fe8a';
WATOR.characteristic = false;

function runBLESource(){
  thenCall();
}

function onBLEConnect(){
  thenCall();
}

function thenCall() {
  console.log('navigator.bluetooth=<',navigator.bluetooth,'>');
  navigator.bluetooth.requestDevice({ acceptAllDevices:true,optionalServices:[WATOR.WebBle.serviceID] })
  .then(device => {
    console.log('device=<',device,'>');
    device.addEventListener('gattserverdisconnected', onDisconnected);
    doConnect(device.gatt);
  })
  .catch(error => {
    console.warn(error);
  });
}

function onNotification(event) {
  console.log(event);
}

function doConnect(gatt) {
  console.log(gatt);
  gatt.connect().then(server => {
    console.log('server=<',server,'>');
    return server.getPrimaryService(WATOR.WebBle.serviceID);
  })
  .then(service => {
    console.log('service=<',service,'>');
    return service.getCharacteristics();
  })
  .then(characteristics => {
    characteristics.forEach(characteristic => {
      console.log('characteristic=<',characteristic,'>');
      WATOR.characteristic = characteristic;
    });
  })
  gatt.connect();
}
function onDisconnected(event) {
  console.log(event);
  if(WATOR.WebBle.read_timer) {
    clearTimeout(WATOR.WebBle.read_timer);
    WATOR.WebBle.read_timer = null;
  }
  setTimeout(doConnect,5000,event.currentTarget.gatt);
}
function onReadValue(characteristic) {
  characteristic.readValue().then(value => {
    console.log(value.getInt8());
    WATOR.WebBle.read_timer =  setTimeout(onReadValue,WATOR.WebBle.READ_INTERVAL,characteristic);
  });
}



function write2DBC(msg) {
  console.log('WATOR.characteristic=<',WATOR.characteristic,'>');
  if(WATOR.characteristic) {
    let buffer = new TextEncoder("utf-8").encode(msg);
    WATOR.characteristic.writeValue(buffer);
  }
}


function onDBCForward(elem) {
  console.log('onDBCForward=<',onDBCForward,'>');
  write2DBC('forword');
}

function onDBCLeft(elem) {
  console.log('onDBCLeft=<',onDBCLeft,'>');
  write2DBC('left');
}

function onDBCStop(elem) {
  console.log('onDBCStop=<',onDBCStop,'>');
  write2DBC('stop');
}

function onDBCRight(elem) {
  console.log('onDBCRight=<',onDBCRight,'>');
  write2DBC('right');
}

function onDBCBack(elem) {
  console.log('onDBCLeft=<',onDBCBack,'>');
  write2DBC('back');
}
function onSpeedChange(elem){
  console.log('onSpeedChange::elem=<',elem,'>');
  let value = elem.value;
  console.log('onSpeedChange::value=<',value,'>');
  write2DBC('speed_' + value);
}


</script>
