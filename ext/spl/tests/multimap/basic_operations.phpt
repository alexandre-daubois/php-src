--TEST--
SplMultiMap: Basic operations (put, get, count, isEmpty)
--FILE--
<?php
$mm = new SplMultiMap();

var_dump($mm->isEmpty());
var_dump($mm->count());
var_dump($mm->get('nonexistent'));

$mm->put('colors', 'red');
$mm->put('colors', 'blue');
$mm->put('colors', 'red');
$mm->put('numbers', 42);

var_dump($mm->get('colors'));
var_dump($mm->get('numbers'));
var_dump($mm->get('nonexistent'));

var_dump($mm->count());
var_dump(count($mm));
var_dump($mm->isEmpty());
?>
--EXPECT--
bool(true)
int(0)
array(0) {
}
array(3) {
  [0]=>
  string(3) "red"
  [1]=>
  string(4) "blue"
  [2]=>
  string(3) "red"
}
array(1) {
  [0]=>
  int(42)
}
array(0) {
}
int(4)
int(4)
bool(false)
