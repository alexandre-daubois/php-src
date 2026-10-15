--TEST--
"$x = f($x, ...)" only moves $x when it isn't read again before being overwritten
--EXTENSIONS--
opcache
--INI--
opcache.enable=1
opcache.enable_cli=1
opcache.optimization_level=-1
opcache.opt_debug_level=0x20000
--FILE--
<?php
function moved(array $a, array $b) {
    $r = $a;
    $r = array_merge($r, array_replace($b, $b));
    return $r;
}

function kept(array $p, array $b) {
    $p = array_merge($p, $b);
    $r = $b;
    $r = array_merge($r, $r);
    $s = array_merge($r, $b);
    $r = array_merge($b, $r);
    return [$p, $r, $s];
}

function in_try(array $a, array $b) {
    $r = $a;
    try {
        $r = array_merge($r, $b);
    } catch (Error) {
    }
    return $r;
}

function indirect(array $a) {
    $r = $a;
    $r = array_merge($r, get_defined_vars());
    return $r;
}

$r = array_merge($argv, $argv);
$r = array_merge($r, $argv);
?>
--EXPECTF--

$_main:
     ; (lines=11, args=0, vars=2, tmps=1)
     ; (after optimizer)
     ; %s:1-35
0000 INIT_FCALL 2 112 string("array_merge")
0001 SEND_VAR CV1($argv) 1
0002 SEND_VAR CV1($argv) 2
0003 T2 = DO_ICALL
0004 ASSIGN CV0($r) T2
0005 INIT_FCALL 2 112 string("array_merge")
0006 SEND_VAR CV0($r) 1
0007 SEND_VAR CV1($argv) 2
0008 T2 = DO_ICALL
0009 ASSIGN CV0($r) T2
0010 RETURN int(1)

moved:
     ; (lines=13, args=2, vars=3, tmps=1)
     ; (after optimizer)
     ; %s:2-6
0000 CV0($a) = RECV 1
0001 CV1($b) = RECV 2
0002 CV2($r) = QM_ASSIGN CV0($a)
0003 INIT_FCALL 2 112 string("array_merge")
0004 SEND_VAR_MOVE CV2($r) 1
0005 INIT_FCALL 2 112 string("array_replace")
0006 SEND_VAR CV1($b) 1
0007 SEND_VAR CV1($b) 2
0008 T3 = DO_ICALL
0009 SEND_VAL T3 2
0010 T3 = DO_ICALL
0011 ASSIGN CV2($r) T3
0012 RETURN CV2($r)

kept:
     ; (lines=27, args=2, vars=4, tmps=1)
     ; (after optimizer)
     ; %s:8-15
0000 CV0($p) = RECV 1
0001 CV1($b) = RECV 2
0002 INIT_FCALL 2 112 string("array_merge")
0003 SEND_VAR CV0($p) 1
0004 SEND_VAR CV1($b) 2
0005 T4 = DO_ICALL
0006 ASSIGN CV0($p) T4
0007 CV2($r) = QM_ASSIGN CV1($b)
0008 INIT_FCALL 2 112 string("array_merge")
0009 SEND_VAR CV2($r) 1
0010 SEND_VAR CV2($r) 2
0011 T4 = DO_ICALL
0012 ASSIGN CV2($r) T4
0013 INIT_FCALL 2 112 string("array_merge")
0014 SEND_VAR CV2($r) 1
0015 SEND_VAR CV1($b) 2
0016 T4 = DO_ICALL
0017 CV3($s) = QM_ASSIGN T4
0018 INIT_FCALL 2 112 string("array_merge")
0019 SEND_VAR CV1($b) 1
0020 SEND_VAR CV2($r) 2
0021 T4 = DO_ICALL
0022 ASSIGN CV2($r) T4
0023 T4 = INIT_ARRAY 3 (packed) CV0($p) NEXT
0024 T4 = ADD_ARRAY_ELEMENT CV2($r) NEXT
0025 T4 = ADD_ARRAY_ELEMENT CV3($s) NEXT
0026 RETURN T4
LIVE RANGES:
     4: 0024 - 0026 (tmp/var)

in_try:
     ; (lines=11, args=2, vars=3, tmps=1)
     ; (after optimizer)
     ; %s:17-24
0000 CV0($a) = RECV 1
0001 CV1($b) = RECV 2
0002 ASSIGN CV2($r) CV0($a)
0003 INIT_FCALL 2 112 string("array_merge")
0004 SEND_VAR CV2($r) 1
0005 SEND_VAR CV1($b) 2
0006 T3 = DO_ICALL
0007 ASSIGN CV2($r) T3
0008 RETURN CV2($r)
0009 CATCH string("Error")
0010 RETURN CV2($r)
EXCEPTION TABLE:
     0003, 0009, -, -

indirect:
     ; (lines=10, args=1, vars=2, tmps=1)
     ; (after optimizer)
     ; %s:26-30
0000 CV0($a) = RECV 1
0001 ASSIGN CV1($r) CV0($a)
0002 INIT_FCALL 2 112 string("array_merge")
0003 SEND_VAR CV1($r) 1
0004 INIT_FCALL 0 80 string("get_defined_vars")
0005 T2 = DO_ICALL
0006 SEND_VAL T2 2
0007 T2 = DO_ICALL
0008 ASSIGN CV1($r) T2
0009 RETURN CV1($r)
