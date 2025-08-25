--TEST--
Operator overloading proof of concept
--FILE--
<?php
class Money {
    public int $amount;
    public function __construct(int $a) { $this->amount = $a; }

    public static operator (+) (Money $lhs, Money $rhs): Money {
        return new static($lhs->amount + $rhs->amount);
    }
}

$a = new Money(10);
$b = new Money(5);
$c = $a + $b;

var_dump($c->amount);

class Euro extends Money {}

$e1 = new Euro(20);
$e2 = new Euro(30);
$e3 = $e1 + $e2;

var_dump($e3 instanceof Euro);
?>
--EXPECT--
int(15)
bool(true)
