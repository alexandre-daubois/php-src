--TEST--
settype() fuzzy cast deprecation
--FILE--
<?php

set_error_handler(function($code, $msg) {
    echo "DEPRECATED: $msg\n";
    return true;
});

$v = "123"; settype($v, "int");
echo "Clean: "; var_dump($v);

$v = "123abc"; settype($v, "int");
echo "Partial: "; var_dump($v);

$v = "abc"; settype($v, "int");
echo "Non-numeric: "; var_dump($v);

$v = "12.5"; settype($v, "float");
echo "Clean: "; var_dump($v);

$v = "12.5foo"; settype($v, "float");
echo "Partial: "; var_dump($v);

$v = "abc"; settype($v, "float");
echo "Non-numeric: "; var_dump($v);

$v = 42; settype($v, "object");
echo "Int: "; var_dump($v);

$v = "hello"; settype($v, "object");
echo "String: "; var_dump($v);

$v = ['a' => 1]; settype($v, "object");
echo "Array (no deprecation): "; var_dump($v);

?>
--EXPECTF--
Clean: int(123)
DEPRECATED: Implicit conversion from non-numeric string "123abc" to int
Partial: int(123)
DEPRECATED: Implicit conversion from non-numeric string "abc" to int
Non-numeric: int(0)

Clean: float(12.5)
DEPRECATED: Implicit conversion from non-numeric string "12.5foo" to float
Partial: float(12.5)
DEPRECATED: Implicit conversion from non-numeric string "abc" to float
Non-numeric: float(0)

DEPRECATED: Conversion from int to object is deprecated
Int: object(stdClass)#%d (1) {
  ["scalar"]=>
  int(42)
}
DEPRECATED: Conversion from string to object is deprecated
String: object(stdClass)#%d (1) {
  ["scalar"]=>
  string(5) "hello"
}
Array (no deprecation): object(stdClass)#%d (1) {
  ["a"]=>
  int(1)
}
