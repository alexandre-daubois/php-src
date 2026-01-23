--TEST--
Fuzzy cast deprecation for scalar to object
--FILE--
<?php

error_reporting(E_ALL);

set_error_handler(function($code, $msg) {
    echo "DEPRECATED: $msg\n";
    return true;
});

echo "Integer: ";
$obj = (object) 42;
var_dump($obj);

echo "\nString: ";
$obj = (object) "hello";
var_dump($obj);

echo "\nBoolean true: ";
$obj = (object) true;
var_dump($obj);

echo "\nBoolean false: ";
$obj = (object) false;
var_dump($obj);

echo "\nFloat: ";
$obj = (object) 3.14;
var_dump($obj);

$obj = (object) ['a' => 1, 'b' => 2];
var_dump($obj);

$obj = (object) null;
var_dump($obj);

?>
--EXPECTF--
Integer: DEPRECATED: Conversion from int to object is deprecated
object(stdClass)#%d (1) {
  ["scalar"]=>
  int(42)
}

String: DEPRECATED: Conversion from string to object is deprecated
object(stdClass)#%d (1) {
  ["scalar"]=>
  string(5) "hello"
}

Boolean true: DEPRECATED: Conversion from bool to object is deprecated
object(stdClass)#%d (1) {
  ["scalar"]=>
  bool(true)
}

Boolean false: DEPRECATED: Conversion from bool to object is deprecated
object(stdClass)#%d (1) {
  ["scalar"]=>
  bool(false)
}

Float: DEPRECATED: Conversion from float to object is deprecated
object(stdClass)#%d (1) {
  ["scalar"]=>
  float(3.14)
}
object(stdClass)#%d (2) {
  ["a"]=>
  int(1)
  ["b"]=>
  int(2)
}
object(stdClass)#%d (0) {
}
