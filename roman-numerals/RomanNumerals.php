<?php

/*
 * By adding type hints and enabling strict type checking, code can become
 * easier to read, self-documenting and reduce the number of potential bugs.
 * By default, type declarations are non-strict, which means they will attempt
 * to change the original type to match the type specified by the
 * type-declaration.
 *
 * In other words, if you pass a string to a function requiring a float,
 * it will attempt to convert the string value to a float.
 *
 * To enable strict mode, a single declare directive must be placed at the top
 * of the file.
 * This means that the strictness of typing is configured on a per-file basis.
 * This directive not only affects the type declarations of parameters, but also
 * a function's return type.
 *
 * For more info review the Concept on strict type checking in the PHP track
 * <link>.
 *
 * To disable strict typing, comment out the directive below.
 */

declare(strict_types = 1);

function toRoman(int $number) : string {
    $roman = '';

    while ($number > 0) switch ($number) {
        case $number >= 1000:
            $roman .= 'M';
            $number -= 1000;
            break;
        case $number >= 900:
            $roman .= 'CM';
            $number -= 900;
            break;
        case $number >= 500:
            $roman .= 'D';
            $number -= 500;
            break;
        case $number >= 400:
            $roman .= 'CD';
            $number -= 400;
            break;
        case $number >= 100:
            $roman .= 'C';
            $number -= 100;
            break;
        case $number >= 90:
            $roman .= 'XC';
            $number -= 90;
            break;
        case $number >= 50:
            $roman .= 'L';
            $number -= 50;
            break;
        case $number >= 40:
            $roman .= 'XL';
            $number -= 40;
            break;
        case $number >= 10:
            $roman .= 'X';
            $number -= 10;
            break;
        case $number >= 9:
            $roman .= 'IX';
            $number -= 9;
            break;
        case $number >= 5:
            $roman .= 'V';
            $number -= 5;
            break;
        case $number >= 4:
            $roman .= 'IV';
            $number -= 4;
            break;
        case $number >= 1:
            $roman .= 'I';
            $number -= 1;
            break;
    }

    return $roman;
}
