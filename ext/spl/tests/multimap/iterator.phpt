--TEST--
SplMultiMap: Iterator
--FILE--
<?php
$mm = new SplMultiMap();

echo "Empty multimap iteration:\n";
foreach ($mm as $key => $value) {
    echo "Should not print\n";
}
echo "Done with empty iteration\n";

$mm->put('colors', 'red');
$mm->put('colors', 'blue');
$mm->put('numbers', 42);
$mm->put('numbers', 84);

echo "\nNormal iteration:\n";
$results = [];
foreach ($mm as $key => $value) {
    $results[] = "Key: $key, Value: " . (is_array($value) ? 'array' : $value);
}

sort($results);
foreach ($results as $result) {
    echo $result . "\n";
}

echo "\nUsing getIterator():\n";
$iterator = $mm->getIterator();
var_dump($iterator instanceof Iterator);

echo "\nInterface check:\n";
var_dump($mm instanceof IteratorAggregate);
var_dump($mm instanceof Countable);
?>
--EXPECT--
Empty multimap iteration:
Done with empty iteration

Normal iteration:
Key: colors, Value: blue
Key: colors, Value: red
Key: numbers, Value: 42
Key: numbers, Value: 84

Using getIterator():
bool(true)

Interface check:
bool(true)
bool(true)
