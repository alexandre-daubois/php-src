--TEST--
floatval() fuzzy cast deprecation
--FILE--
<?php

echo "Clean numeric: ";
var_dump(floatval("12.5"));

echo "Scientific: ";
var_dump(floatval("1e3"));

echo "Partial numeric: ";
var_dump(floatval("12.5foo"));

echo "Fully non-numeric: ";
var_dump(floatval("abc"));

echo "Empty string: ";
var_dump(floatval(""));

?>
--EXPECTF--
Clean numeric: float(12.5)
Scientific: float(1000)
Partial numeric: 
Deprecated: Implicit conversion from non-numeric string "12.5foo" to float in %s on line %d
float(12.5)
Fully non-numeric: 
Deprecated: Implicit conversion from non-numeric string "abc" to float in %s on line %d
float(0)
Empty string: 
Deprecated: Implicit conversion from non-numeric string "" to float in %s on line %d
float(0)
