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

class Bob {

    const RESPONSES = [
        'question' => 'Sure.',
        'shouting' => 'Whoa, chill out!',
        'shouting_question' => 'Calm down, I know what I\'m doing!',
        'silence' => 'Fine. Be that way!',
        'default' => 'Whatever.'
    ];

    public function respondTo(string $str) : string {
        $str = trim($str);

        if (empty($str)) {
            return static::say('silence');
        }

        if (preg_match("/[a-zA-Z]/", $str) && strtoupper($str) === $str) {
            if (str_ends_with($str, "?")) {
                return static::say('shouting_question');
            }
            return static::say('shouting');
        }

        if (str_ends_with($str, "?")) {
            return static::say('question');
        }

        return static::say('default');
    }

    private static function say(string $key) : string {
        return self::RESPONSES[$key] ?? 'Whatever.';
    }
}
