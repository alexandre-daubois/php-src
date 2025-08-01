--TEST--
GH-19134: OpenSSL INI options default values
--SKIPIF--
<?php
if (!extension_loaded('openssl')) die('skip openssl not loaded');
?>
--FILE--
<?php
echo "openssl.allow_self_signed default: " . ini_get('openssl.allow_self_signed') . "\n";
echo "openssl.verify_peer default: " . ini_get('openssl.verify_peer') . "\n";
echo "openssl.verify_peer_name default: " . ini_get('openssl.verify_peer_name') . "\n";

echo "Setting allow_self_signed to 1: " . (ini_set('openssl.allow_self_signed', '1') ? 'success' : 'failed') . "\n";
echo "New value: " . ini_get('openssl.allow_self_signed') . "\n";

echo "Setting verify_peer to 0: " . (ini_set('openssl.verify_peer', '0') ? 'success' : 'failed') . "\n";
echo "New value: " . ini_get('openssl.verify_peer') . "\n";

echo "Setting verify_peer_name to 0: " . (ini_set('openssl.verify_peer_name', '0') ? 'success' : 'failed') . "\n";
echo "New value: " . ini_get('openssl.verify_peer_name') . "\n";
?>
--EXPECT--
openssl.allow_self_signed default: 0
openssl.verify_peer default: 
openssl.verify_peer_name default: 
Setting allow_self_signed to 1: failed
New value: 0
Setting verify_peer to 0: failed
New value: 
Setting verify_peer_name to 0: failed
New value: 