--TEST--
SplMultiMap: Iterator by-reference throws Error
--FILE--
<?php
$mm = new SplMultiMap();
$mm->put('key', 'value');

try {
    foreach ($mm as $k => &$v) {
        echo "Should not reach this\n";
    }
} catch (Error $e) {
    echo "Caught Error: " . $e->getMessage() . "\n";
}
?>
--EXPECT--
Caught Error: An iterator cannot be used with foreach by reference
