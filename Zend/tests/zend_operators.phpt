--TEST--
Operator precedence
--FILE--
<?php

var_dump((object)1 instanceof stdClass);
var_dump(! (object)1 instanceof Exception);

?>
--EXPECTF--
Deprecated: Conversion from int to object is deprecated in %s on line %d
bool(true)

Deprecated: Conversion from int to object is deprecated in %s on line %d
bool(true)
