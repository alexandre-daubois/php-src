--TEST--
SplMultiMap: Edge cases and special values
--FILE--
<?php
$mm = new SplMultiMap();

$mm->put('', 'empty key value');
var_dump($mm->get(''));
var_dump($mm->containsKey(''));

$mm->put("null\0byte", 'null byte value');
var_dump($mm->get("null\0byte"));

$mm->put('123', 'numeric string key');
var_dump($mm->containsKey('123'));

echo "\nTesting different value types:\n";
$mm->put('mixed', null);
$mm->put('mixed', false);
$mm->put('mixed', 0);
$mm->put('mixed', '');
$mm->put('mixed', []);
$mm->put('mixed', new stdClass());

var_dump($mm->count()); // Should be 9 (1 + 1 + 1 + 6)

$obj1 = new stdClass();
$obj2 = new stdClass();
$mm->clear();
$mm->put('objects', $obj1);
$mm->put('objects', $obj2);

var_dump($mm->containsValue('objects', $obj1)); // true
var_dump($mm->containsValue('objects', $obj2)); // true
var_dump($mm->containsValue('objects', new stdClass())); // false (different object)

$mm->clear();
$arr1 = [1, 2, 3];
$arr2 = [1, 2, 3];
$mm->put('arrays', $arr1);

var_dump($mm->containsValue('arrays', $arr1));
var_dump($mm->containsValue('arrays', $arr2));
var_dump($mm->containsValue('arrays', [1, 2, 3]));
var_dump($mm->containsValue('arrays', [1, 2]));
?>
--EXPECT--
array(1) {
  [0]=>
  string(15) "empty key value"
}
bool(true)
array(1) {
  [0]=>
  string(15) "null byte value"
}
bool(true)

Testing different value types:
int(9)
bool(true)
bool(true)
bool(false)
bool(true)
bool(true)
bool(true)
bool(false)
