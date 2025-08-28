--TEST--
SplMultiMap: Bulk operations (putAll, replaceAll)
--FILE--
<?php
$mm = new SplMultiMap();

$mm->putAll('fruits', ['apple', 'banana', 'cherry']);
var_dump($mm->get('fruits'));
var_dump($mm->count());

$mm->putAll('fruits', ['date', 'elderberry']);
var_dump($mm->get('fruits'));
var_dump($mm->count());

$mm->replaceAll('fruits', ['grape', 'honeydew']);
var_dump($mm->get('fruits'));
var_dump($mm->count());

$mm->replaceAll('vegetables', ['carrot', 'broccoli']);
var_dump($mm->get('vegetables'));
var_dump($mm->count());

$mm->replaceAll('fruits', []);
var_dump($mm->get('fruits'));
var_dump($mm->containsKey('fruits'));
var_dump($mm->count());
?>
--EXPECT--
array(3) {
  [0]=>
  string(5) "apple"
  [1]=>
  string(6) "banana"
  [2]=>
  string(6) "cherry"
}
int(3)
array(5) {
  [0]=>
  string(5) "apple"
  [1]=>
  string(6) "banana"
  [2]=>
  string(6) "cherry"
  [3]=>
  string(4) "date"
  [4]=>
  string(10) "elderberry"
}
int(5)
array(2) {
  [0]=>
  string(5) "grape"
  [1]=>
  string(8) "honeydew"
}
int(2)
array(2) {
  [0]=>
  string(6) "carrot"
  [1]=>
  string(8) "broccoli"
}
int(4)
array(0) {
}
bool(false)
int(2)
