--TEST--
GH-19134: openssl.allow_self_signed INI option
--INI--
openssl.allow_self_signed=1
--SKIPIF--
<?php
if (!extension_loaded('openssl')) die('skip openssl not loaded');
if (!function_exists('stream_socket_client')) die('skip stream_socket_client not available');
?>
--FILE--
<?php
var_dump(ini_get('openssl.allow_self_signed'));
?>
--EXPECT--
string(1) "1"
