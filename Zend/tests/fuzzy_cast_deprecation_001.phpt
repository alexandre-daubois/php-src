--TEST--
Fuzzy cast deprecation for string to int/float
--FILE--
<?php

error_reporting(E_ALL);

set_error_handler(function($code, $msg) {
    echo "DEPRECATED: $msg\n";
    return true;
});

echo "Clean numeric: ";
var_dump((int) "123");

echo "With whitespace: ";
var_dump((int) "  42  ");

echo "\nPartial numeric: ";
var_dump((int) "123abc");

echo "Fully non-numeric: ";
var_dump((int) "abc");

echo "Empty string: ";
var_dump((int) "");

echo "Whitespace only: ";
var_dump((int) "  ");

echo "Clean numeric: ";
var_dump((float) "12.5");

echo "Scientific notation: ";
var_dump((float) "1e3");

echo "\nPartial numeric: ";
var_dump((float) "12.5foo");

echo "Fully non-numeric: ";
var_dump((float) "abc");

echo "Empty string: ";
var_dump((float) "");

?>
--EXPECT--
Clean numeric: int(123)
With whitespace: int(42)

Partial numeric: DEPRECATED: Implicit conversion from non-numeric string "123abc" to int
int(123)
Fully non-numeric: DEPRECATED: Implicit conversion from non-numeric string "abc" to int
int(0)
Empty string: DEPRECATED: Implicit conversion from non-numeric string "" to int
int(0)
Whitespace only: DEPRECATED: Implicit conversion from non-numeric string "  " to int
int(0)

Clean numeric: float(12.5)
Scientific notation: float(1000)

Partial numeric: DEPRECATED: Implicit conversion from non-numeric string "12.5foo" to float
float(12.5)
Fully non-numeric: DEPRECATED: Implicit conversion from non-numeric string "abc" to float
float(0)
Empty string: DEPRECATED: Implicit conversion from non-numeric string "" to float
float(0)
