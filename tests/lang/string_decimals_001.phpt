--TEST--
String conversion with multiple decimal points
--FILE--
<?php
function test($str) {
  echo "\n--> Testing $str:\n";
  var_dump((int)$str);
  var_dump((float)$str);
  var_dump($str > 0);
}

test("..9");
test(".9.");
test("9..");
test("9.9.");
test("9.9.9");
?>
--EXPECTF--
--> Testing ..9:

Deprecated: Implicit conversion from non-numeric string "..9" to int in %s on line %d
int(0)

Deprecated: Implicit conversion from non-numeric string "..9" to float in %s on line %d
float(0)
bool(false)

--> Testing .9.:

Deprecated: Implicit conversion from non-numeric string ".9." to int in %s on line %d
int(0)

Deprecated: Implicit conversion from non-numeric string ".9." to float in %s on line %d
float(0.9)
bool(false)

--> Testing 9..:

Deprecated: Implicit conversion from non-numeric string "9.." to int in %s on line %d
int(9)

Deprecated: Implicit conversion from non-numeric string "9.." to float in %s on line %d
float(9)
bool(true)

--> Testing 9.9.:

Deprecated: Implicit conversion from non-numeric string "9.9." to int in %s on line %d
int(9)

Deprecated: Implicit conversion from non-numeric string "9.9." to float in %s on line %d
float(9.9)
bool(true)

--> Testing 9.9.9:

Deprecated: Implicit conversion from non-numeric string "9.9.9" to int in %s on line %d
int(9)

Deprecated: Implicit conversion from non-numeric string "9.9.9" to float in %s on line %d
float(9.9)
bool(true)
