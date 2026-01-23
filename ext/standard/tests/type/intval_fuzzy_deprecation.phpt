--TEST--
intval() fuzzy cast deprecation with different bases
--FILE--
<?php

error_reporting(E_ALL);

echo "Clean: ";
var_dump(intval("123"));

echo "With trailing: ";
var_dump(intval("123abc"));

echo "Clean: ";
var_dump(intval("1010", 2));

echo "With trailing: ";
var_dump(intval("1010abc", 2));

echo "Clean: ";
var_dump(intval("77", 8));

echo "With trailing: ";
var_dump(intval("77garbage", 8));

echo "Clean: ";
var_dump(intval("1F", 16));

echo "With trailing: ";
var_dump(intval("1Fzzz", 16));

echo "Clean: ";
var_dump(intval("0b1010", 0));

echo "With trailing: ";
var_dump(intval("0b1010xyz", 0));

echo "Clean: ";
var_dump(intval("0b1010", 2));

echo "With trailing: ";
var_dump(intval("0b1010xyz", 2));

?>
--EXPECTF--
Clean: int(123)
With trailing: 
Deprecated: Implicit conversion from non-numeric string "123abc" to int in %s on line %d
int(123)
Clean: int(10)
With trailing: 
Deprecated: intval(): Argument #1 ($num) contains non-numeric trailing data in %s on line %d
int(10)
Clean: int(63)
With trailing: 
Deprecated: intval(): Argument #1 ($num) contains non-numeric trailing data in %s on line %d
int(63)
Clean: int(31)
With trailing: 
Deprecated: intval(): Argument #1 ($num) contains non-numeric trailing data in %s on line %d
int(31)
Clean: int(10)
With trailing: 
Deprecated: intval(): Argument #1 ($num) contains non-numeric trailing data in %s on line %d
int(10)
Clean: int(10)
With trailing: 
Deprecated: intval(): Argument #1 ($num) contains non-numeric trailing data in %s on line %d
int(10)
