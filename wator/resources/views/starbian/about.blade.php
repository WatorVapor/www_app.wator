@extends('wator.app')
@section('appnavbar')
  @include('starbian.navbar')
@endsection

@section('content')
<div class="row">
  <div class="col">
    <div class="card card-default text-center">
      <div class="card-body">
        <h4 class="card-title">IPFS</h4>
      </div>
      <img class="card-img-top" src="/wator/images/starbian/ipfs.top.png" alt="Card image cap">
    </div>
  </div>
  <div class="col">
    <div class="card card-default text-center">
      <div class="card-body">
        <h4 class="card-title">P2P PubSub Based On IPFS</h4>
      </div>
      <img class="card-img-top" src="/wator/images/starbian/ipfs.pubsub.png" alt="Card image cap">
    </div>
  </div>
</div>

<div class="row">
  <div class="col">
    <div class="card card-default text-center">
      <div class="card-body">
        <h4 class="card-title">Security Digital Signature</h4>
      </div>
      <img class="card-img-top" src="/wator/images/starbian/ipfs.ecdsa.png" alt="Card image cap">
    </div>
  </div>
  <div class="col">
    <div class="card card-default text-center">
      <div class="card-body">
        <h4 class="card-title">Elliptic Curve Diffie–Hellman key Exchange</h4>
      </div>
      <img class="card-img-top" src="/wator/images/starbian/ipfs.ecdh.png" alt="Card image cap">
    </div>
  </div>
  <div class="col">
    <div class="card card-default text-center">
      <div class="card-body">
        <h4 class="card-title">AES-GCM Cryptographic</h4>
      </div>
      <img class="card-img-top" src="/wator/images/starbian/ipfs.aes.gcm.png" alt="Card image cap">
    </div>
  </div>
</div>


@endsection
