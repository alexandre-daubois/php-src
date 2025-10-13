--TEST--
Non-null float cast: basic functionality
--FILE--
<?php

var_dump((!float) 12.34);

var_dump((!float) 56);

var_dump((!float) "78.9");

var_dump((!float) true);
var_dump((!float) false);

?>
--EXPECT--
float(12.34)
float(56)
float(78.9)
float(1)
float(0)
