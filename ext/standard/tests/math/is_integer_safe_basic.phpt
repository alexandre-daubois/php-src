--TEST--
Test is_integer_safe() - basic function test is_integer_safe()
--FILE--
<?php
$values = array(0,
                1,
                -1,
                9007199254740991,
                -9007199254740991,
                9007199254740992,
                -9007199254740992,
                1.0,
                -1.0,
                1.5,
                0.0,
                9007199254740991.0,
                -9007199254740991.0,
                9007199254740992.0,
                -9007199254740992.0,
                INF,
                -INF,
                NAN,
                "123",
                true,
                false);

for ($i = 0; $i < count($values); $i++) {
    $res = is_integer_safe($values[$i]);
    echo "is_integer_safe(" . var_export($values[$i], true) . ") = ";
    var_dump($res);
}
?>
--EXPECT--
is_integer_safe(0) = bool(true)
is_integer_safe(1) = bool(true)
is_integer_safe(-1) = bool(true)
is_integer_safe(9007199254740991) = bool(true)
is_integer_safe(-9007199254740991) = bool(true)
is_integer_safe(9007199254740992) = bool(false)
is_integer_safe(-9007199254740992) = bool(false)
is_integer_safe(1.0) = bool(true)
is_integer_safe(-1.0) = bool(true)
is_integer_safe(1.5) = bool(false)
is_integer_safe(0.0) = bool(true)
is_integer_safe(9007199254740991.0) = bool(true)
is_integer_safe(-9007199254740991.0) = bool(true)
is_integer_safe(9007199254740992.0) = bool(false)
is_integer_safe(-9007199254740992.0) = bool(false)
is_integer_safe(INF) = bool(false)
is_integer_safe(-INF) = bool(false)
is_integer_safe(NAN) = bool(false)
is_integer_safe('123') = bool(true)
is_integer_safe(true) = bool(true)
is_integer_safe(false) = bool(true)