--TEST--
SplMultiMap: Removal operations (remove, removeAll)
--FILE--
<?php
$mm = new SplMultiMap();

$mm->put('colors', 'red');
$mm->put('colors', 'blue');
$mm->put('colors', 'red'); // Duplicate
$mm->put('numbers', 42);
$mm->put('numbers', 84);

echo "Initial state:\n";
var_dump($mm->get('colors'));
var_dump($mm->count());

echo "\nAfter removing 'red' once:\n";
var_dump($mm->remove('colors', 'red'));
var_dump($mm->get('colors'));
var_dump($mm->count());

echo "\nTrying to remove non-existent value:\n";
var_dump($mm->remove('colors', 'green'));
var_dump($mm->get('colors'));

echo "\nTrying to remove from non-existent key:\n";
var_dump($mm->remove('missing', 'value'));

echo "\nRemoving all values from colors:\n";
var_dump($mm->remove('colors', 'blue'));
var_dump($mm->remove('colors', 'red'));
var_dump($mm->containsKey('colors'));
var_dump($mm->count());

echo "\nTesting removeAll:\n";
var_dump($mm->get('numbers'));
var_dump($mm->removeAll('numbers'));
var_dump($mm->get('numbers'));
var_dump($mm->containsKey('numbers'));
var_dump($mm->count());

echo "\nTesting removeAll on non-existent key:\n";
var_dump($mm->removeAll('missing'));
?>
--EXPECT--
Initial state:
array(3) {
  [0]=>
  string(3) "red"
  [1]=>
  string(4) "blue"
  [2]=>
  string(3) "red"
}
int(5)

After removing 'red' once:
bool(true)
array(2) {
  [0]=>
  string(4) "blue"
  [1]=>
  string(3) "red"
}
int(4)

Trying to remove non-existent value:
bool(false)
array(2) {
  [0]=>
  string(4) "blue"
  [1]=>
  string(3) "red"
}

Trying to remove from non-existent key:
bool(false)

Removing all values from colors:
bool(true)
bool(true)
bool(false)
int(2)

Testing removeAll:
array(2) {
  [0]=>
  int(42)
  [1]=>
  int(84)
}
bool(true)
array(0) {
}
bool(false)
int(0)

Testing removeAll on non-existent key:
bool(false)
