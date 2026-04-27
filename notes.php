<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>This is a Notes Page</p>
</body>
</html>

<?php

/*
String Methods:
- strlen(): Returns the length of a string.
- str_replace('char', 'replacement', $string): Replaces all occurrences
- strtoupper($string): Converts a string to uppercase.
- strtolower($string): Converts a string to lowercase.
- substr($string, start, length): Returns a portion of a string.uc
- strpos($string, 'char'): Finds the position of the first occurrence of a character in a string.
- trim($string): Removes whitespace from the beginning and end of a string.
- explode('delimiter', $string): Splits a string into an array based on a delimiter.
- ucwords($string): Capitalizes the first letter of each word in a string.
- str_word_count($string): Counts the number of words in a string.

Array Methods:
- count($array): Returns the number of elements in an array.
- array_rand($array, num): Returns one or more random keys from an array.

Date and Time Methods:
- date('Y-m-d H:i:s'): Returns the current date and time in a specified format.
- the format is as follows:
    - Y: Year (4 digits)
    - m: Month (2 digits)
    - d: Day of the month (2 digits)
    - H: Hour (24-hour format, 2 digits)
    - i: Minutes (2 digits)
    - s: Seconds (2 digits)

Number Methods:
- number_format($num, decimals): Formats a number with grouped thousands and specified decimal points.
- pow($base, $exp): Returns the result of raising a base to the power of an exponent.
- sqrt($num): Returns the square root of a number.
*/
    echo date('Y-m-d H:i:s') . '<br>';

    // This is a static page, so no PHP code is needed.
    // but we still do PHP
    $val = 121;
    $val2 = 11;
    $val3 = 'hello world';
    $val4 = true;

    echo $val . '<br>';
    echo $val2 . '<br>';
    echo $val3[4] . '<br>';
    echo $val4;

    $arr = array($val, $val2, $val3, $val4);

    foreach( $arr as $in){
        echo '<h1>' . $in . '</h1><br>';
    }

    $num = 7;
    if($num % 2 == 0){
        echo "$num is an Even Number";
    } else {
        echo "$num is an Odd Number";
    }

?>