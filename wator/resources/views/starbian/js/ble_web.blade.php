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
    WATOR.characteristic.writeValue(msg);
  }
}


function onDBCForward(elem) {
  console.log('onDBCForward=<',onDBCForward,'>');
  write2DBC('hello');
}

function onDBCLeft(elem) {
  console.log('onDBCLeft=<',onDBCLeft,'>');
}

function onDBCStop(elem) {
  console.log('onDBCStop=<',onDBCStop,'>');
}

function onDBCRight(elem) {
  console.log('onDBCRight=<',onDBCRight,'>');
}

function onDBCBack(elem) {
  console.log('onDBCLeft=<',onDBCBack,'>');
}



</script>
