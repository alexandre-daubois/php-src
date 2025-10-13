--TEST--
Nullable string cast: basic functionality
--FILE--
<?php

var_dump((?string) null);
var_dump((?string) "hello");
var_dump((?string) 123);
var_dump((?string) 45.67);
var_dump((?string) true);
var_dump((?string) false);

?>
--EXPECT--
NULL
string(5) "hello"
string(3) "123"
string(5) "45.67"
string(1) "1"
string(0) ""
