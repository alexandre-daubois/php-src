--TEST--
Stringable objects accepted in strict mode for string parameters (user functions)
--FILE--
<?php
declare(strict_types=1);

class MyString implements Stringable {
    private string $value;

    public function __construct(string $value) {
        $this->value = $value;
    }

    public function __toString(): string {
        return $this->value;
    }
}

function takeString(string $s): string {
    return "Received: " . $s;
}

function takeNullableString(?string $s): string {
    return "Received: " . ($s ?? "null");
}

$obj = new MyString("hello");
echo takeString($obj), "\n";

$anon = new class implements Stringable {
    public function __toString(): string {
        return "anonymous";
    }
};
echo takeString($anon), "\n";

$obj2 = new MyString("world");
echo takeNullableString($obj2), "\n";

class NotStringable {
    public $value = "test";
}

try {
    takeString(new NotStringable());
} catch (TypeError $e) {
    echo "TypeError caught: non-Stringable object rejected\n";
}
?>
--EXPECT--
Received: hello
Received: anonymous
Received: world
TypeError caught: non-Stringable object rejected
