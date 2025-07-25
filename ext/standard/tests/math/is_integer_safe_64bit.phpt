--TEST--
Test is_integer_safe() - 64-bit specific tests
--SKIPIF--
<?php if (PHP_INT_SIZE != 8) print "skip this test is for 64bit platform only"; ?>
--FILE--
<?php

$values = array(9223372036854775807,
                -9223372036854775808,
                9007199254740991,
                -9007199254740991,
                9007199254740992,
                -9007199254740992);

foreach ($values as $value) {
    $res = is_integer_safe($value);
    echo "is_integer_safe(" . var_export($value, true) . ") = ";
    var_dump($res);
}
?>
--EXPECT--
is_integer_safe(9223372036854775807) = bool(false)
is_integer_safe(-9.2233720368548E+18) = bool(false)
is_integer_safe(9007199254740991) = bool(true)
is_integer_safe(-9007199254740991) = bool(true)
is_integer_safe(9007199254740992) = bool(false)
is_integer_safe(-9007199254740992) = bool(false)