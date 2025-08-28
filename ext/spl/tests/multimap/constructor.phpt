--TEST--
SplMultiMap: Constructor and instantiation
--FILE--
<?php

$mm1 = new SplMultiMap();
var_dump($mm1->isEmpty());

$mm2 = new SplMultiMap();
var_dump($mm2->count());

?>
--EXPECT--
bool(true)
int(0)
