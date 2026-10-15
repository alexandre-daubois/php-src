--TEST--
"$x = f($x, ...)" hands $x over to functions consuming their first argument
--EXTENSIONS--
opcache
--INI--
opcache.enable=1
opcache.enable_cli=1
opcache.optimization_level=-1
--FILE--
<?php
namespace Foo {
    if (true) {
        function array_replace(array &$a, array $b) {
            $a[] = 'by-ref';
            return \array_replace($a, $b);
        }
    }

    function shadowed(array $a) {
        $r = $a;
        $r = array_replace($r, [5 => 2]);
        var_dump($r);
    }

    shadowed([1]);
}

namespace {
    function accumulate(int $n) {
        $packed = [];
        $map = [];
        for ($i = 0; $i < $n; $i++) {
            $packed = array_merge($packed, [$i]);
            $map = array_replace($map, ["k$i" => $i]);
        }
        var_dump($packed, $map);
    }

    function by_reference(array &$y) {
        $x = &$y;
        $x = array_merge($x, [2]);
    }

    function shared(array $a) {
        $r = $a;
        $r[] = 2;
        $copy = $r;
        $r = array_merge($r, [3]);
        var_dump($copy, $r);
    }

    function throws_in_callee(array $a) {
        $r = $a;
        $r[] = 2;
        $r = array_merge($r, 'not an array');
    }

    function throws_in_args(array $a) {
        $r = $a;
        $r[] = 2;
        $r = array_merge($r, (function () { throw new Exception('in args'); })());
    }

    function not_consuming(array $a) {
        $r = $a;
        $r[] = 2;
        $r = array_reverse($r);
        var_dump($r);
    }

    function undefined() {
        $r = array_merge($r, []);
    }

    function suspended(array $a) {
        $r = $a;
        $r[] = 2;
        $r = array_merge($r, yield);
        return $r;
    }

    accumulate(3);

    $y = [1];
    by_reference($y);
    var_dump($y);

    shared([1]);
    not_consuming([1]);

    foreach (['throws_in_callee', 'throws_in_args', 'undefined'] as $f) {
        try {
            $f([1]);
        } catch (Throwable $e) {
            echo $e::class, ': ', $e->getMessage(), "\n";
        }
    }

    $gen = suspended([1]);
    $gen->current();
    unset($gen);

    $gen = suspended([1]);
    $gen->current();
    $gen->send([3]);
    var_dump($gen->getReturn());
}
?>
--EXPECTF--
array(3) {
  [0]=>
  int(1)
  [1]=>
  string(6) "by-ref"
  [5]=>
  int(2)
}
array(3) {
  [0]=>
  int(0)
  [1]=>
  int(1)
  [2]=>
  int(2)
}
array(3) {
  ["k0"]=>
  int(0)
  ["k1"]=>
  int(1)
  ["k2"]=>
  int(2)
}
array(2) {
  [0]=>
  int(1)
  [1]=>
  int(2)
}
array(2) {
  [0]=>
  int(1)
  [1]=>
  int(2)
}
array(3) {
  [0]=>
  int(1)
  [1]=>
  int(2)
  [2]=>
  int(3)
}
array(2) {
  [0]=>
  int(2)
  [1]=>
  int(1)
}
TypeError: array_merge(): Argument #2 must be of type array, string given
Exception: in args

Warning: Undefined variable $r in %s on line %d
TypeError: array_merge(): Argument #1 must be of type array, null given
array(3) {
  [0]=>
  int(1)
  [1]=>
  int(2)
  [2]=>
  int(3)
}
