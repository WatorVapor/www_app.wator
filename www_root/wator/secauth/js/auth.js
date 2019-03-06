var SecAuth = SecAuth || {};
SecAuth.debug = SecAuth.debug || true;

SecAuth.LS_AUTH_KEY_PRV = 'wator.auth.ecdsa.key.private';
SecAuth.LS_AUTH_KEY_PUB = 'wator.auth.ecdsa.key.public';
SecAuth.LS_AUTH_KEY_TOKEN = 'wator.auth.ecdsa.key.token';
SecAuth.LS_AUTH_KEY_ID = 'wator.auth.ecdsa.key.id';
SecAuth.getPubKey = function() {
  return localStorage.getItem(SecAuth.LS_AUTH_KEY_PUB);
}
SecAuth.getPriKey = function() {
  return localStorage.getItem(SecAuth.LS_AUTH_KEY_PRV);
}
SecAuth.getToken = function() {
  return localStorage.getItem(SecAuth.LS_AUTH_KEY_TOKEN);
}
SecAuth.getKeyID = function() {
  return localStorage.getItem(SecAuth.LS_AUTH_KEY_ID);
}
