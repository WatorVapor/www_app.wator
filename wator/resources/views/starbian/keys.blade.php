@extends('wator.app')
@section('content')
<div class="container-fluid bg-warning">
  <div class="row">
    <div class="col-md-12">
      <h3>In order to connect remote device secuirtily,you should share public rsa key to each other.</h3>
    </div>
  </div>
</div>
<div class="container-fluid bg-warning container-mime-key">
  <div class="row">
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h6>Public Key belong to this device.</h6>
        </div>
        <div class="panel-body">
          <button type="button" class="btn btn-danger btn-sm" id="btn-create-key">recreate</button>
          <span class="label label-info">Send public key to another device by e-mail,sns etc.</span>
          <button type="button" class="btn btn-primary btn-sm  pull-right btn-clipboard" id="btn-copy-key" data-clipboard-target="#text-this-device-key">Copy</button>
          <pre id="text-this-device-key" class="text-danger small" rows="20"></pre>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h6>Public Key from remote device.</h6>
        </div>
        <div class="panel-body">
          <div class="form-group">
            <button type="button" class="btn btn-success btn-sm" id="btn-add-key">+</button>
            <span class="label label-info">Paste public key of remote device.</span>
            <textarea class="form-control input-sm" id="text-remote-device-key" rows="15"></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="container-fluid bg-success">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h6>Remote devices list:</h6>
        </div>
        <div class="panel-body">
          <table class="table table-striped table-bordered">
            <tbody id="key-table-body"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  new Clipboard('.btn-clipboard');
</script>
<script type="text/javascript">
  $(document).ready(function() {
    PeerRSA.debug = true;
    PeerRSA.Key.A.onLoadCheckSuccess = function() {
      updatePublicKey();
    }
    function updatePublicKey() {
      var pubKeyStr = PeerRSA.Key.A.readKeyStr();
      $('#text-this-device-key').text(pubKeyStr);
    }
    updatePublicKey();
    
    $('#btn-create-key').click(function(){
      $('#text-this-device-key').text('...');
      PeerRSA.Key.A.createKey( function(msg) {
        //console.log(msg);
        updatePublicKey();
      });
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    function updateKeysView() {
      var pairs = PeerRSA.Key.B.getPairDevices();
      $('#key-table-body').empty();
      for(var i = 0 ;i < pairs.length;i++) {
        console.log(pairs[i]);
        var row = '<tr>';
        row += '<td>';
        row += '<button type="button" class="btn btn-danger btn-sm remove-key-btn" ';
        row += 'value="';
        row += pairs[i];
        row += '" ';
        row += '>-</button>';
        row += '</td>';
        row += '<td>' + pairs[i] + '</td>';
        row += '</tr>';
        console.log(row);
        $('#key-table-body').append(row);
      }
    }
    $('#key-table-body').on('click','.remove-key-btn',function(){
      var token = $(this).val();
      console.log(token);
      PeerRSA.Key.B.removeDevice(token);
      updateKeysView();
    });
    $('#btn-add-key').click(function(){
      var key = $('#text-remote-device-key').val();
      //console.log(key);
      PeerRSA.Key.B.addKey(key);
      updateKeysView();
    });
    updateKeysView();
  });
</script>

@endsection

