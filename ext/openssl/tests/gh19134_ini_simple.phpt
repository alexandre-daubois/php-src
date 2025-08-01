--TEST--
GH-19134: Simple INI setting test
--INI--
openssl.allow_self_signed=1
openssl.verify_peer=1
openssl.verify_peer_name=0
--FILE--
<?php
echo "openssl.allow_self_signed: \"" . ini_get('openssl.allow_self_signed') . "\"\n";
echo "openssl.verify_peer: \"" . ini_get('openssl.verify_peer') . "\"\n";
echo "openssl.verify_peer_name: \"" . ini_get('openssl.verify_peer_name') . "\"\n";
?>
--EXPECT--
openssl.allow_self_signed: "1"
openssl.verify_peer: "1"
openssl.verify_peer_name: "0"