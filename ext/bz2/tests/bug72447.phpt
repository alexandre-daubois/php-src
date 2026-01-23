--TEST--
Bug #72447: Type Confusion in php_bz2_filter_create()
--EXTENSIONS--
bz2
--FILE--
<?php
$input = "AAAAAAAA";
$param = array('blocks' => $input);

$fp = fopen('testfile', 'w');
stream_filter_append($fp, 'bzip2.compress', STREAM_FILTER_WRITE, $param);
fclose($fp);
?>
--CLEAN--
<?php
unlink('testfile');
?>
--EXPECTF--
Deprecated: Implicit conversion from non-numeric string "AAAAAAAA" to int in %s on line %d

Warning: stream_filter_append(): Invalid parameter given for number of blocks to allocate (0) in %s%ebug72447.php on line %d
