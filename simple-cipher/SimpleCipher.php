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

class SimpleCipher {

    private array $letters = [
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
        'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
    ];

    private array $lettersByIndexCached = [];

    private int|null $lettersCount = null;

    public function __construct(public ?string $key = null) {
        $this->validateKey();

        $this->lettersCount = count($this->letters);
        $this->lettersByIndexCached = array_flip($this->letters);
    }

    public function encode(string $plainText) : string {
        $cipherText = '';

        for ($i = 0; $i < strlen($plainText); $i++) {
            $keyShift = $this->getLetterIndex($this->key[$i]);
            $plainTextShift = $this->getLetterIndex($plainText[$i]);

            // Wrap around to the start of the alphabet
            $shift = ($keyShift + $plainTextShift) % $this->lettersCount;

            $cipherText .= $this->letters[$shift];
        }

        return $cipherText;
    }

    public function decode(string $cipherText) : string {
        $plainText = '';

        for ($i = 0; $i < strlen($cipherText); $i++) {
            $keyShift = $this->getLetterIndex($this->key[$i]);
            $cipherTextShift = $this->getLetterIndex($cipherText[$i]);

            $shift = $cipherTextShift - $keyShift;

            // Wrap around to the end of the alphabet
            // If the shift is negative, add the length of the alphabet
            if ($shift < 0) {
                $shift += $this->lettersCount;
            }

            $plainText .= $this->letters[$shift];
        }

        return $plainText;
    }

    private function getLetterIndex(string $letter) : int {
        $index = $this->lettersByIndexCached[$letter] ?? false;

        if ($index === false) {
            throw new InvalidArgumentException('Invalid letter: '.$letter);
        }

        return $index;
    }

    private function validateKey() : void {
        if ($this->key === null) {
            $this->key = $this->generateRandomKey();
            return;
        }

        if ($this->key === '') {
            throw new InvalidArgumentException('Key must be at least one character.');
        }

        if (strtoupper($this->key) === $this->key) {
            throw new InvalidArgumentException('Key cannot be uppercase.');
        }

        if (preg_match('/\d/', $this->key)) {
            throw new InvalidArgumentException('Key cannot contain numbers.');
        }
    }

    private function generateRandomKey() : string {
        return substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz', 5)), 0, 100);
    }
}
