--TEST--
SplMultiMap: Query operations (containsKey, containsValue, keys, values)
--FILE--
<?php
$mm = new SplMultiMap();

$mm->put('colors', 'red');
$mm->put('colors', 'blue');
$mm->put('numbers', 42);
$mm->put('arrays', [1, 2]);

echo "containsKey tests:\n";
var_dump($mm->containsKey('colors'));
var_dump($mm->containsKey('numbers'));
var_dump($mm->containsKey('missing'));

// Test containsValue
echo "\ncontainsValue tests:\n";
var_dump($mm->containsValue('colors', 'red'));
var_dump($mm->containsValue('colors', 'green'));
var_dump($mm->containsValue('missing', 'red'));
var_dump($mm->containsValue('numbers', 42));
var_dump($mm->containsValue('numbers', '42'));

$testArray = [1, 2];
var_dump($mm->containsValue('arrays', $testArray));
var_dump($mm->containsValue('arrays', [1, 2]));

echo "\nkeys() test:\n";
var_dump($mm->keys());

echo "\nvalues() test:\n";
var_dump($mm->values());

echo "\nAfter clear:\n";
$mm->clear();
var_dump($mm->isEmpty());
var_dump($mm->count());
var_dump($mm->keys());
var_dump($mm->values());
?>
--EXPECT--
containsKey tests:
bool(true)
bool(true)
bool(false)

containsValue tests:
bool(true)
bool(false)
bool(false)
bool(true)
bool(false)
bool(true)
bool(true)

keys() test:
array(3) {
  [0]=>
  string(6) "colors"
  [1]=>
  string(7) "numbers"
  [2]=>
  string(6) "arrays"
}

values() test:
array(4) {
  [0]=>
  string(3) "red"
  [1]=>
  string(4) "blue"
  [2]=>
  int(42)
  [3]=>
  array(2) {
    [0]=>
    int(1)
    [1]=>
    int(2)
  }
}

After clear:
bool(true)
int(0)
array(0) {
}
array(0) {
}
