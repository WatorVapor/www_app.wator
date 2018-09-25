<script type="text/javascript">
class WaiAudioProcess {
  constructor() {
    this.buffer = [];
  }  
  process(inputs, outputs) {
    console.log('WaiAudioProcess:process inputs=<',inputs,'>');
  }
}

function processRaw(inputs, outputs) {
  console.log('processRaw:process inputs=<',inputs,'>');
}
</script>
