<script type="text/javascript">

var WATOR = WATOR || {};
WATOR.WebBle = {};
WATOR.WebBle.READ_INTERVAL = 20;

function awaitCall() {
/*
  console.log(navigator.bluetooth);
  console.log(BluetoothUUID);
  let option = { acceptAllDevices:true,optionalServices:[0x00FF,0x00EE] };
  const device = await navigator.bluetooth.requestDevice(option);
  console.log('device=<',device,'>');
  const server = await device.gatt.connect();
  console.log('server=<',server,'>');
  const service = await server.getPrimaryService(0x00FF);
  console.log('service=<',service,'>');
  const characteristics = await service.getCharacteristics();
  console.log('characteristics=<',characteristics,'>');
  for (const characteristic of characteristics) {
    console.log('characteristic=<',characteristic,'>');
    WATOR.WebBle.read_timer = setTimeout(onReadValue,WATOR.WebBle.READ_INTERVAL,characteristic);
  }
 */
}

function runBLESource(){
  //awaitCall();
  thenCall();
}

setTimeout(function() {
  thenCall();
},1000);

function thenCall() {
  console.log('navigator.bluetooth=<',navigator.bluetooth,'>');
  navigator.bluetooth.requestDevice({ acceptAllDevices:true,optionalServices:[0x00FF,0x00EE] })
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
    return server.getPrimaryService(0x00FF);
  })
  .then(service => {
    console.log('service=<',service,'>');
    return service.getCharacteristics();
  })
  .then(characteristics => {
    characteristics.forEach(characteristic => {
      WATOR.WebBle.read_timer = setTimeout(onReadValue,WATOR.WebBle.READ_INTERVAL,characteristic);
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

</script>
