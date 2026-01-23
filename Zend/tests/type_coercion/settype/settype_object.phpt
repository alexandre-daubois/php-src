--TEST--
casting different variables to object using settype()
--FILE--
<?php

$r = fopen(__FILE__, "r");

class test {
    function  __toString() {
        return "10";
    }
}

$o = new test;

$vars = array(
    "string",
    "8754456",
    "",
    "\0",
    9876545,
    0.10,
    array(),
    array(1,2,3),
    false,
    true,
    NULL,
    $r,
    $o
);

foreach ($vars as $var) {
    settype($var, "object");
    var_dump($var);
}

echo "Done\n";
?>
--EXPECTF--
Deprecated: Conversion from string to object is deprecated in %s on line %d
object(stdClass)#%d (1) {
  ["scalar"]=>
  string(6) "string"
}

Deprecated: Conversion from string to object is deprecated in %s on line %d
object(stdClass)#%d (1) {
  ["scalar"]=>
  string(7) "8754456"
}

Deprecated: Conversion from string to object is deprecated in %s on line %d
object(stdClass)#%d (1) {
  ["scalar"]=>
  string(0) ""
}

Deprecated: Conversion from string to object is deprecated in %s on line %d
object(stdClass)#%d (1) {
  ["scalar"]=>
  string(1) "%0"
}

Deprecated: Conversion from int to object is deprecated in %s on line %d
object(stdClass)#%d (1) {
  ["scalar"]=>
  int(9876545)
}

Deprecated: Conversion from float to object is deprecated in %s on line %d
object(stdClass)#%d (1) {
  ["scalar"]=>
  float(0.1)
}
object(stdClass)#%d (0) {
}
object(stdClass)#%d (3) {
  ["0"]=>
  int(1)
  ["1"]=>
  int(2)
  ["2"]=>
  int(3)
}

Deprecated: Conversion from bool to object is deprecated in %s on line %d
object(stdClass)#%d (1) {
  ["scalar"]=>
  bool(false)
}

Deprecated: Conversion from bool to object is deprecated in %s on line %d
object(stdClass)#%d (1) {
  ["scalar"]=>
  bool(true)
}
object(stdClass)#%d (0) {
}

Deprecated: Conversion from resource to object is deprecated in %s on line %d
object(stdClass)#%d (1) {
  ["scalar"]=>
  resource(%d) of type (stream)
}
object(test)#%d (0) {
}
Done
