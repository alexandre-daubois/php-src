--TEST--
SplMultiMap: Clone behavior - shallow clone with shared object references
--FILE--
<?php

$mm1 = new SplMultiMap();

$obj = new stdClass();
$obj->value = 'original';

$mm1->put('key1', $obj);
$mm1->put('key1', 'string_value');
$mm1->put('key2', [1, 2, 3]);

$mm2 = clone $mm1;

echo "Original count: " . $mm1->count() . "\n";
echo "Clone count: " . $mm2->count() . "\n";

$mm1->put('key3', 'only_in_original');
$mm2->put('key4', 'only_in_clone');

echo "Original has key3: " . ($mm1->containsKey('key3') ? 'true' : 'false') . "\n";
echo "Clone has key3: " . ($mm2->containsKey('key3') ? 'true' : 'false') . "\n";
echo "Original has key4: " . ($mm1->containsKey('key4') ? 'true' : 'false') . "\n";
echo "Clone has key4: " . ($mm2->containsKey('key4') ? 'true' : 'false') . "\n";

$obj->value = 'modified';

$values1 = $mm1->get('key1');
$values2 = $mm2->get('key1');

echo "Original object value: " . $values1[0]->value . "\n";
echo "Clone object value: " . $values2[0]->value . "\n";

echo "Same object reference: " . ($values1[0] === $values2[0] ? 'true' : 'false') . "\n";

?>
--EXPECT--
Original count: 3
Clone count: 3
Original has key3: true
Clone has key3: false
Original has key4: false
Clone has key4: true
Original object value: modified
Clone object value: modified
Same object reference: true
