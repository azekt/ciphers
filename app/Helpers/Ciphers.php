<?php
namespace App\Helpers;

class Ciphers
{
    /**
     * @param string $str
     * @param int $key
     * @return string
     */
    public static function caesar_encrypt(string $str, int $key = 13): string
    {
        if (($str == '') || ($key == 0)) {
            return $str;
        }

        $key = ($key % 26 + 26) % 26;
        $output = '';

        for ($i = 0; $i < strlen($str); $i++) {
            $char = $str[$i];

            if (ctype_alpha($char)) {
                $charOrd = ord($char);
                if (ctype_upper($char)) {
                    $charOrd = ($charOrd + $key - 65) % 26 + 65;
                    if ($charOrd < 65) {
                        $charOrd += 26;
                    }
                } else {
                    $charOrd = ($charOrd + $key - 97) % 26 + 97;
                    if ($charOrd < 97) {
                        $charOrd += 26;
                    }
                }
                $char = chr($charOrd);
            }

            $output .= $char;
        }
        return $output;
    }

    /**
     * @param string $str
     * @param int $key
     * @return string
     */
    public static function caesar_decrypt(string $str, int $key = 13): string
    {
        if (($str == '') || ($key == 0)) {
            return $str;
        }

        $key = ($key % 26 + 26) % 26;
        $output = '';

        for ($i = 0; $i < strlen($str); $i++) {
            $char = $str[$i];

            if (ctype_alpha($char)) {
                $charOrd = ord($char);
                if (ctype_upper($char)) {
                    $charOrd = ($charOrd - $key - 39) % 26 + 65;
                } else {
                    $charOrd = ($charOrd - $key - 71) % 26 + 97;
                }
                $char = chr($charOrd);
            }

            $output .= $char;
        }
        return $output;
    }

    /**
     * @param string $str
     * @return string
     */
    public static function atbash_encrypt(string $str): string
    {
        if ($str == '') {
            return $str;
        }

        $output = '';

        for ($i = 0; $i < strlen($str); $i++) {
            $char = $str[$i];

            if (ctype_alpha($char)) {
                $charOrd = ord($char);
                if (ctype_upper($char)) {
                    $charOrd = 90 - ($charOrd - 65);
                } else {
                    $charOrd = 122 - ($charOrd - 97);
                }
                $char = chr($charOrd);
            }

            // Są też inne sposoby podejścia do problemu
            // Można na przykład stworzyć tablicę wszystkich znaków i operować na niej

            $output .= $char;
        }

        return $output;
    }

    /**
     * @param string $str
     * @return string
     */
    public static function atbash_decrypt(string $str): string
    {
        return self::atbash_encrypt($str); // szyfr jest symetryczny
    }

    /**
     * @param string $str
     * @return string
     */
    public static function bacon_encrypt(string $str): string
    {
        if ($str == '') {
            return $str;
        }

        $output = '';

        for ($i = 0; $i < strlen($str); $i++) {
            $char = $str[$i];

            if (ctype_alpha($char)) {
                /* 1) zamieniamy literę na Wielką
                 * 2) bierzemy jej kod ASCII
                 * 3) zamieniamy go na postać binarną
                 * 4) uzupełniamy zerami wiodącymi do długości pięciu znaków
                 * 5) zamieniamy "0" na "a" oraz "1" na "b"
                 */
                $output .= str_replace([0,1], ['a', 'b'], str_pad(decbin(ord(strtoupper($char)) - 65), 5, 0, STR_PAD_LEFT));
            } else {
                $output .= $char;
            }

            // Są też inne sposoby podejścia do problemu
            // Można na przykład stworzyć tablicę wszystkich znaków i operować na niej
        }

        return $output;
    }

    /**
     * @param string $str
     * @return string
     */
    public static function bacon_decrypt(string $str): string
    {
        if ($str == '') {
            return $str;
        }

        $len = strlen($str);
        $i = 0;
        $output = '';

         /* 1) bierzemy kolejny znak
          * 2) jeśli jest literą to wycinamy wraz z nim kolejne 4 znaki
          * 3) sprawdzamy czy przypadkiem nie ma innych znaków w ciągu
          * 4) zamieniamy "a" na "0" oraz "b" na "1"
          * 5) zamieniamy liczbę binarną na dec, dodajemy 65 i zamieniamy na znak ASCII
          */
        do {
            if (ctype_alpha($str[$i])) {
                $letter = substr($str, $i, 5);
                if (preg_match('/^[ab]+$/', $letter)) {
                    $output .= chr(bindec(str_replace(['a', 'b'], [0,1], $letter)) + 65);
                } else {
                    $output .= '?';
                }
                $i += 5;
            } else {
                $output .= $str[$i];
                $i++;
            }
        } while ($i < $len);

        return $output;
    }
}
