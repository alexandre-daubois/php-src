--TEST--
Explicit cast of leading numeric strings should still work without warning
--FILE--
<?php

var_dump((int) "2px");
var_dump((float) "2px");
var_dump((int) "2.5px");
var_dump((float) "2.5px");

?>
--EXPECTF--
Deprecated: Implicit conversion from non-numeric string "2px" to int in %s on line %d
int(2)

Deprecated: Implicit conversion from non-numeric string "2px" to float in %s on line %d
float(2)

Deprecated: Implicit conversion from non-numeric string "2.5px" to int in %s on line %d
int(2)

Deprecated: Implicit conversion from non-numeric string "2.5px" to float in %s on line %d
float(2.5)
