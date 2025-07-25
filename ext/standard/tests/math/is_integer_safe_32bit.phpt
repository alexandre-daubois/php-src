--TEST--
Test is_integer_safe() - 32-bit specific tests
--SKIPIF--
<?php if (PHP_INT_SIZE != 4) print "skip this test is for 32bit platform only"; ?>
--FILE--
<?php
// Test values that are particularly relevant for 32-bit systems
$values = array(2147483647,
                -2147483648,
                2147483648.0,
                -2147483649.0,
                9007199254740991.0,
                -9007199254740991.0);

foreach ($values as $value) {
    $res = is_integer_safe($value);
    echo "is_integer_safe(" . var_export($value, true) . ") = ";
    var_dump($res);
}
?>
--EXPECT--
is_integer_safe(2147483647) = bool(true)
is_integer_safe(-2147483648.0) = bool(true)
is_integer_safe(2147483648.0) = bool(true)
is_integer_safe(-2147483649.0) = bool(true)
is_integer_safe(9007199254740991.0) = bool(true)
is_integer_safe(-9007199254740991.0) = bool(true)