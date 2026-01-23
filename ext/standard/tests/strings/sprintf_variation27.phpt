--TEST--
Test sprintf() function : usage variations - char formats with char values
--FILE--
<?php
echo "*** Testing sprintf() : char formats with char values ***\n";

// array of char values
$char_values = array( 'a', "a", 67, -67, 99, ' ', '', 'A', "A" );

// array of char formats
$char_formats = array(
  "%c", "%lc", " %c", "%c ",
  "\t%c", "\n%c", "%4c", "%30c",
);

$count = 1;
foreach($char_values as $char_value) {
  echo "\n-- Iteration $count --\n";

  foreach($char_formats as $format) {
    var_dump( sprintf($format, $char_value) );
  }
  $count++;
};

echo "Done";
?>
--EXPECTF--
*** Testing sprintf() : char formats with char values ***

-- Iteration 1 --

Deprecated: Implicit conversion from non-numeric string "a" to int in %s on line %d
string(1) "%0"

Deprecated: Implicit conversion from non-numeric string "a" to int in %s on line %d
string(1) "%0"

Deprecated: Implicit conversion from non-numeric string "a" to int in %s on line %d
string(2) " %0"

Deprecated: Implicit conversion from non-numeric string "a" to int in %s on line %d
string(2) "%0 "

Deprecated: Implicit conversion from non-numeric string "a" to int in %s on line %d
string(2) "	%0"

Deprecated: Implicit conversion from non-numeric string "a" to int in %s on line %d
string(2) "
%0"

Deprecated: Implicit conversion from non-numeric string "a" to int in %s on line %d
string(1) "%0"

Deprecated: Implicit conversion from non-numeric string "a" to int in %s on line %d
string(1) "%0"

-- Iteration 2 --

Deprecated: Implicit conversion from non-numeric string "a" to int in %s on line %d
string(1) "%0"

Deprecated: Implicit conversion from non-numeric string "a" to int in %s on line %d
string(1) "%0"

Deprecated: Implicit conversion from non-numeric string "a" to int in %s on line %d
string(2) " %0"

Deprecated: Implicit conversion from non-numeric string "a" to int in %s on line %d
string(2) "%0 "

Deprecated: Implicit conversion from non-numeric string "a" to int in %s on line %d
string(2) "	%0"

Deprecated: Implicit conversion from non-numeric string "a" to int in %s on line %d
string(2) "
%0"

Deprecated: Implicit conversion from non-numeric string "a" to int in %s on line %d
string(1) "%0"

Deprecated: Implicit conversion from non-numeric string "a" to int in %s on line %d
string(1) "%0"

-- Iteration 3 --
string(1) "C"
string(1) "C"
string(2) " C"
string(2) "C "
string(2) "	C"
string(2) "
C"
string(1) "C"
string(1) "C"

-- Iteration 4 --
string(1) "�"
string(1) "�"
string(2) " �"
string(2) "� "
string(2) "	�"
string(2) "
�"
string(1) "�"
string(1) "�"

-- Iteration 5 --
string(1) "c"
string(1) "c"
string(2) " c"
string(2) "c "
string(2) "	c"
string(2) "
c"
string(1) "c"
string(1) "c"

-- Iteration 6 --

Deprecated: Implicit conversion from non-numeric string " " to int in %s on line %d
string(1) "%0"

Deprecated: Implicit conversion from non-numeric string " " to int in %s on line %d
string(1) "%0"

Deprecated: Implicit conversion from non-numeric string " " to int in %s on line %d
string(2) " %0"

Deprecated: Implicit conversion from non-numeric string " " to int in %s on line %d
string(2) "%0 "

Deprecated: Implicit conversion from non-numeric string " " to int in %s on line %d
string(2) "	%0"

Deprecated: Implicit conversion from non-numeric string " " to int in %s on line %d
string(2) "
%0"

Deprecated: Implicit conversion from non-numeric string " " to int in %s on line %d
string(1) "%0"

Deprecated: Implicit conversion from non-numeric string " " to int in %s on line %d
string(1) "%0"

-- Iteration 7 --

Deprecated: Implicit conversion from non-numeric string "" to int in %s on line %d
string(1) "%0"

Deprecated: Implicit conversion from non-numeric string "" to int in %s on line %d
string(1) "%0"

Deprecated: Implicit conversion from non-numeric string "" to int in %s on line %d
string(2) " %0"

Deprecated: Implicit conversion from non-numeric string "" to int in %s on line %d
string(2) "%0 "

Deprecated: Implicit conversion from non-numeric string "" to int in %s on line %d
string(2) "	%0"

Deprecated: Implicit conversion from non-numeric string "" to int in %s on line %d
string(2) "
%0"

Deprecated: Implicit conversion from non-numeric string "" to int in %s on line %d
string(1) "%0"

Deprecated: Implicit conversion from non-numeric string "" to int in %s on line %d
string(1) "%0"

-- Iteration 8 --

Deprecated: Implicit conversion from non-numeric string "A" to int in %s on line %d
string(1) "%0"

Deprecated: Implicit conversion from non-numeric string "A" to int in %s on line %d
string(1) "%0"

Deprecated: Implicit conversion from non-numeric string "A" to int in %s on line %d
string(2) " %0"

Deprecated: Implicit conversion from non-numeric string "A" to int in %s on line %d
string(2) "%0 "

Deprecated: Implicit conversion from non-numeric string "A" to int in %s on line %d
string(2) "	%0"

Deprecated: Implicit conversion from non-numeric string "A" to int in %s on line %d
string(2) "
%0"

Deprecated: Implicit conversion from non-numeric string "A" to int in %s on line %d
string(1) "%0"

Deprecated: Implicit conversion from non-numeric string "A" to int in %s on line %d
string(1) "%0"

-- Iteration 9 --

Deprecated: Implicit conversion from non-numeric string "A" to int in %s on line %d
string(1) "%0"

Deprecated: Implicit conversion from non-numeric string "A" to int in %s on line %d
string(1) "%0"

Deprecated: Implicit conversion from non-numeric string "A" to int in %s on line %d
string(2) " %0"

Deprecated: Implicit conversion from non-numeric string "A" to int in %s on line %d
string(2) "%0 "

Deprecated: Implicit conversion from non-numeric string "A" to int in %s on line %d
string(2) "	%0"

Deprecated: Implicit conversion from non-numeric string "A" to int in %s on line %d
string(2) "
%0"

Deprecated: Implicit conversion from non-numeric string "A" to int in %s on line %d
string(1) "%0"

Deprecated: Implicit conversion from non-numeric string "A" to int in %s on line %d
string(1) "%0"
Done
