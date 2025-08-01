--TEST--
GH-19134: openssl.verify_peer_name INI option
--INI--
openssl.verify_peer_name=0
--SKIPIF--
<?php
if (!extension_loaded('openssl')) die('skip openssl not loaded');
if (!function_exists('stream_socket_client')) die('skip stream_socket_client not available');
?>
--FILE--
<?php
var_dump(ini_get('openssl.verify_peer_name'));
?>
--EXPECT--
string(1) "0"
