--TEST--
floatval() fuzzy cast deprecation
--FILE--
<?php

set_error_handler(function($code, $msg) {
    echo "DEPRECATED: $msg\n";
    return true;
});

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
--EXPECT--
Clean numeric: float(12.5)
Scientific: float(1000)
Partial numeric: DEPRECATED: Implicit conversion from non-numeric string "12.5foo" to float
float(12.5)
Fully non-numeric: DEPRECATED: Implicit conversion from non-numeric string "abc" to float
float(0)
Empty string: DEPRECATED: Implicit conversion from non-numeric string "" to float
float(0)
