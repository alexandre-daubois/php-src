--TEST--
Bug #73329 (Float)"Nano" == NAN
--FILE--
<?php
    var_dump(
        (float)"nanite",
        (float)"nan",
        (float)"inf",
        (float)"infusorian"
    );
?>
--EXPECTF--
Deprecated: Implicit conversion from non-numeric string "nanite" to float in %s on line %d

Deprecated: Implicit conversion from non-numeric string "nan" to float in %s on line %d

Deprecated: Implicit conversion from non-numeric string "inf" to float in %s on line %d

Deprecated: Implicit conversion from non-numeric string "infusorian" to float in %s on line %d
float(0)
float(0)
float(0)
float(0)
