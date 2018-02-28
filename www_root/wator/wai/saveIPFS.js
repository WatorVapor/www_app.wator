//const Buffer = window.IpfsApi().Buffer;
//let ipfs = window.IpfsApi({host:'www.wator.xyz', port:'443', protocol: 'https'});
onmessage = function (evt) {
  postMessage('saveIPFS::evt=<',evt,'>');
};

/*
ipfs.id(function (err, identity) {
  if (err) {
    throw err
  }
  console.log('ipfs.id:identity=<',identity,'>');
});
*/
