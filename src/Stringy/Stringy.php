<?php

namespace Stringy;

class Stringy {

    /**
     * Converts the first character of the supplied string to upper case.
     *
     * @param   string  $str       String to modify
     * @param   string  $encoding  The character encoding
     * @return  string  String with the first character being upper case
     */
    public static function upperCaseFirst($str, $encoding = null) {
        $encoding = $encoding ?: mb_internal_encoding();

        $first = mb_substr($str, 0, 1, $encoding);
        $rest = mb_substr($str, 1, mb_strlen($str, $encoding) - 1, $encoding);

        return mb_strtoupper($first, $encoding) . $rest;
    }

    /**
     * Converts the first character of the supplied string to lower case.
     *
     * @param   string  $str       String to modify
     * @param   string  $encoding  The character encoding
     * @return  string  String with the first character being lower case
     */
    public static function lowerCaseFirst($str, $encoding = null) {
        $encoding = $encoding ?: mb_internal_encoding();

        $first = mb_substr($str, 0, 1, $encoding);
        $rest = mb_substr($str, 1, mb_strlen($str, $encoding) - 1, $encoding);

        return mb_strtolower($first, $encoding) . $rest;
    }

    /**
     * Returns a camelCase version of a supplied string. Trims surrounding
     * spaces, capitalizes letters following digits, spaces, dashes and
     * underscores, and removes spaces, dashes, underscores.
     *
     * @param   string  $str       String to convert to camelCase
     * @param   string  $encoding  The character encoding
     * @return  string  String in camelCase
     */
    public static function camelize($str, $encoding = null) {
        $encoding = $encoding ?: mb_internal_encoding();

        $camelCase = preg_replace_callback(
            '/[-_\s]+(.)?/u',
            function ($matches) use (&$encoding) {
                return $matches[1] ? mb_strtoupper($matches[1], $encoding) : "";
            },
            self::lowerCaseFirst(trim($str), $encoding)
        );

        $camelCase = preg_replace_callback(
            '/[\d]+(.)?/u',
            function ($matches) use (&$encoding) {
                return mb_strtoupper($matches[0], $encoding);
            },
            $camelCase
        );

        return $camelCase;
    }

    /**
     * Returns an UpperCamelCase version of a supplied string. Trims surrounding
     * spaces, capitalizes letters following digits, spaces, dashes and
     * underscores, and removes spaces, dashes, underscores.
     *
     * @param   string  $str       String to convert to UpperCamelCase
     * @param   string  $encoding  The character encoding
     * @return  string  String in UpperCamelCase
     */
    public static function upperCamelize($str, $encoding = null) {
        $encoding = $encoding ?: mb_internal_encoding();
        $camelCase = self::camelize($str, $encoding);

        return self::upperCaseFirst($camelCase, $encoding);
    }

    /**
     * Returns a lowercase and trimmed string seperated by dashes. Dashes are
     * inserted before uppercase characters (with the exception of the first
     * character of the string), and in place of spaces as well as underscores.
     *
     * @param   string  $str       String to convert
     * @param   string  $encoding  The character encoding
     * @return  string  Dasherized string
     */
    public static function dasherize($str, $encoding = null) {
        $encoding = $encoding ?: mb_internal_encoding();
        mb_regex_encoding($encoding);

        $dasherized = mb_ereg_replace('\B([A-Z])', '-\1', trim($str));
        $dasherized = mb_ereg_replace('[-_\s]+', '-', $dasherized);

        return mb_strtolower($dasherized, $encoding);
    }

    /**
     * Returns a lowercase and trimmed string seperated by underscores.
     * Underscores are inserted before uppercase characters (with the exception
     * of the first character of the string), and in place of spaces as well as
     * dashes.
     *
     * @param   string  $str       String to convert
     * @param   string  $encoding  The character encoding
     * @return  string  Underscored string
     */
    public static function underscored($str, $encoding = null) {
        $encoding = $encoding ?: mb_internal_encoding();
        mb_regex_encoding($encoding);

        $underscored = mb_ereg_replace('\B([A-Z])', '_\1', trim($str));
        $underscored = mb_ereg_replace('[-_\s]+', '_', $underscored);

        return mb_strtolower($underscored, $encoding);
    }

    /**
     * Returns a case swapped version of a string.
     *
     * @param   string  $str       String to swap case
     * @param   string  $encoding  The character encoding
     * @return  string  String with each character's case swapped
     */
    public static function swapCase($str, $encoding = null) {
        $encoding = $encoding ?: mb_internal_encoding();

        $swapped = preg_replace_callback(
            '/[\S]/u',
            function ($match) use (&$encoding) {
                if ($match[0] == mb_strtoupper($match[0], $encoding))
                    return mb_strtolower($match[0], $encoding);
                else
                    return mb_strtoupper($match[0], $encoding);
            },
            $str
        );

        return $swapped;
    }

    /**
     * Capitalizes the first letter of each word in a string, after trimming.
     * Ignores the case of other letters, allowing for the use of acronyms.
     * Also accepts an array, $ignore, allowing you to list words not to be
     * capitalized.
     *
     * @param   string  $str       String to titleize
     * @param   string  $encoding  The character encoding
     * @param   array   $ignore    An array of words not to capitalize
     * @return  string  Titleized string
     */
    public static function titleize($str, $ignore = null, $encoding = null) {
        $encoding = $encoding ?: mb_internal_encoding();

        $titleized = preg_replace_callback(
            '/([\S]+)/u',
            function ($match) use (&$encoding, &$ignore) {
                if ($ignore && in_array($match[0], $ignore))
                    return $match[0];
                return Stringy::upperCaseFirst($match[0], $encoding);
            },
            trim($str)
        );

        return $titleized;
    }

    /**
     * Capitalizes the first word of a string, replaces underscores with spaces,
     * and strips '_id'.
     *
     * @param   string  $str       String to humanize
     * @param   string  $encoding  The character encoding
     * @return  string  A humanized string
     */
    public static function humanize($str, $encoding = null) {
        $humanized = str_replace('_id', '', $str);
        $humanized = str_replace('_', ' ', $humanized);

        return self::upperCaseFirst(trim($humanized), $encoding);
    }

    /**
     * Replaces smart quotes, ellipsis characters, and dashes from Windows-1252
     * (and commonly used in Word documents) with their ASCII equivalents.
     *
     * @param   string  $str       String to remove special chars
     * @param   string  $encoding  The character encoding
     * @return  string  String with those characters removed
     */
    public static function tidy($str) {
        $tidied = preg_replace('/\x{2026}/u', '...', $str);
        $tidied = preg_replace('/[\x{201C}\x{201D}]/u', '"', $tidied);
        $tidied = preg_replace('/[\x{2018}\x{2019}]/u', "'", $tidied);
        $tidied = preg_replace('/[\x{2013}\x{2014}]/u', '-', $tidied);

        return $tidied;
    }

    /**
     * Trims the string and replaces consecutive whitespace characters with a
     * single space.
     *
     * @param   string  $str  The string to cleanup whitespace
     * @return  string  The trimmed string with condensed whitespace
     */
    public static function clean($str) {
        return preg_replace('/\s+/u', ' ', trim($str));
    }

    /**
     * Converts some non-ASCII characters to their closest ASCII counterparts.
     *
     * @param   string  $str  A string with non-ASCII characters
     * @return  string  The string after the replacements
     */
    public static function standardize($str) {
        $charsArray = array(
            'a' => array('à', 'á', 'â', 'ã', 'ă', 'ä', 'å', 'ą'),
            'c' => array('ć', 'č', 'ç'),
            'd' => array('ď', 'đ'),
            'e' => array('è', 'é', 'ê', 'ě', 'ë', 'ę'),
            'g' => array('ğ'),
            'i' => array('ì', 'í', 'ï', 'î'),
            'l' => array('ĺ', 'ł'),
            'n' => array('ń', 'ñ', 'ň'),
            'o' => array('ò', 'ó', 'ô', 'õ', 'ö', 'ø'),
            'r' => array('ř', 'ŕ'),
            's' => array('š', 'š', 'ş'),
            't' => array('ť', 'ţ'),
            'u' => array('ü', 'ù', 'ú', 'û', 'µ', 'ů'),
            'y' => array('ý', 'ÿ'),
            'z' => array('ź', 'ž', 'ż'),
            'A' => array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ă', 'Ą'),
            'C' => array('Ć', 'Č', 'Ç'),
            'D' => array('Ď', 'Ð'),
            'E' => array('È', 'É', 'Ê', 'Ë', 'Ě', 'Ę'),
            'G' => array('Ğ'),
            'I' => array('Ì', 'Í', 'Ï', 'Î'),
            'L' => array('Ĺ', 'Ł'),
            'N' => array('Ń', 'Ñ', 'Ň'),
            'O' => array('Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø'),
            'R' => array('Ř', 'Ŕ'),
            'S' => array('Š', 'Ş', 'Ś'),
            'T' => array('Ť', 'Ţ'),
            'U' => array('Ü', 'Ù', 'Ú', 'Û', 'Ů'),
            'Y' => array('Ý', 'Ÿ'),
            'Z' => array('Ź', 'Ž', 'Ż')
        );

        foreach ($charsArray as $key => $value) {
            $str = str_replace($value, $key, $str);
        }

        return $str;
    }

    /**
     * Pads a string to a given length with another string. If length is less
     * than or equal to the length of $str, then no padding takes places. The
     * default string used for padding is a space, and the default type (one of
     * 'left', 'right', 'both') is 'right'.
     *
     * @param   string  $str       String to pad
     * @param   int     $length    Desired string length after padding
     * @param   string  $padStr    String used to pad, defaults to space
     * @param   string  $padType   One of 'left', 'right', 'both'
     * @param   string  $encoding  The character encoding
     * @return  string  The padded string
     * @throws  InvalidArgumentException If $padType isn't one of 'right',
     *          'left' or 'both'
     */
    public static function pad($str, $length, $padStr = ' ', $padType = 'right',
                               $encoding = null) {
        $encoding = $encoding ?: mb_internal_encoding();

        if (!in_array($padType, array('left', 'right', 'both'))) {
            throw new InvalidArgumentException('Pad expects the fourth ' .
                "argument to be one of 'left', 'right' or 'both'");
        }

        $strLength = mb_strlen($str, $encoding);
        $padStrLength = mb_strlen($padStr, $encoding);

        if ($length <= $strLength || $padStrLength <= 0)
            return $str;

        // Number of times to repeat the padStr if left or right
        $times = ceil(($length - $strLength) / $padStrLength);
        $paddedStr = '';

        if ($padType == 'left') {
            // Repeat the pad, cut it, and prepend
            $leftPad = str_repeat($padStr, $times);
            $leftPad = mb_substr($leftPad, 0, $length - $strLength, $encoding);
            $paddedStr = $leftPad . $str;
        } elseif ($padType == 'right') {
            // Append the repeated pad and get a substring of the given length
            $paddedStr = $str . str_repeat($padStr, $times);
            $paddedStr = mb_substr($paddedStr, 0, $length, $encoding);
        } else {
            // Number of times to repeat the padStr on both sides
            $paddingSize = ($length - $strLength) / 2;
            $times = ceil($paddingSize / $padStrLength);

            // Favour right padding over left, as with str_pad()
            $rightPad = str_repeat($padStr, $times);
            $rightPad = mb_substr($rightPad, 0, ceil($paddingSize), $encoding);

            $leftPad = str_repeat($padStr, $times);
            $leftPad = mb_substr($leftPad, 0, floor($paddingSize), $encoding);

            $paddedStr = $leftPad . $str . $rightPad;
        }

        return $paddedStr;
    }

    /**
     * Returns a new string of a given length such that the beginning of the
     * string is padded. Alias for pad($str, $length, $padStr, 'left', $encoding)
     *
     * @param   string  $str       String to pad
     * @param   int     $length    Desired string length after padding
     * @param   string  $padStr    String used to pad, defaults to space
     * @param   string  $encoding  The character encoding
     * @return  string  The padded string
     */
    public static function padLeft($str, $length, $padStr = ' ', $encoding = null) {
        return self::pad($str, $length, $padStr, 'left', $encoding);
    }

    /**
     * Returns a new string of a given length such that the end of the string is
     * padded. Alias for pad($str, $length, $padStr, 'right', $encoding)
     *
     * @param   string  $str       String to pad
     * @param   int     $length    Desired string length after padding
     * @param   string  $padStr    String used to pad, defaults to space
     * @param   string  $encoding  The character encoding
     * @return  string  The padded string
     */
    public static function padRight($str, $length, $padStr = ' ', $encoding = null) {
        return self::pad($str, $length, $padStr, 'right', $encoding);
    }

    /**
     * Returns a new string of a given length such that both sides of the string
     * string are padded. Alias for pad($str, $length, $padStr, 'both', $encoding)
     *
     * @param   string  $str       String to pad
     * @param   int     $length    Desired string length after padding
     * @param   string  $padStr    String used to pad, defaults to space
     * @param   string  $encoding  The character encoding
     * @return  string  The padded string
     */
    public static function padBoth($str, $length, $padStr = ' ', $encoding = null) {
        return self::pad($str, $length, $padStr, 'both', $encoding);
    }

    /**
     * Returns true if the string $str begins with $substring, false otherwise.
     * By default, the comparison is case-sensitive, but can be made insensitive
     * by setting $caseSensitive to false.
     *
     * @param   string  $str            String to check the start of
     * @param   string  $substring      The substring to look for
     * @param   bool    $caseSensitive  Whether or not to enfore case-sensitivity
     * @param   string  $encoding       The character encoding
     * @return  bool    Whether or not $str starts with $substring
     */
    public static function startsWith($str, $substring, $caseSensitive = true,
                                      $encoding = null) {
        $encoding = $encoding ?: mb_internal_encoding();

        $substringLength = mb_strlen($substring, $encoding);
        $startOfStr = mb_substr($str, 0, $substringLength, $encoding);

        if (!$caseSensitive) {
            $substring = mb_strtolower($substring, $encoding);
            $startOfStr = mb_strtolower($startOfStr, $encoding);
        }

        return $substring === $startOfStr;
    }

    /**
     * Returns true if the string $str ends with $substring, false otherwise.
     * By default, the comparison is case-sensitive, but can be made insensitive
     * by setting $caseSensitive to false.
     *
     * @param   string  $str            String to check the end of
     * @param   string  $substring      The substring to look for
     * @param   bool    $caseSensitive  Whether or not to enfore case-sensitivity
     * @param   string  $encoding       The character encoding
     * @return  bool    Whether or not $str ends with $substring
     */
    public static function endsWith($str, $substring, $caseSensitive = true,
                                    $encoding = null) {
        $encoding = $encoding ?: mb_internal_encoding();

        $substringLength = mb_strlen($substring, $encoding);
        $strLength = mb_strlen($str, $encoding);

        $endOfStr = mb_substr($str, $strLength - $substringLength,
            $substringLength, $encoding);

        if (!$caseSensitive) {
            $substring = mb_strtolower($substring, $encoding);
            $endOfStr = mb_strtolower($endOfStr, $encoding);
        }

        return $substring === $endOfStr;
    }

    /**
     * Converts each tab in a string to some number of spaces, as defined by
     * $tabLength. By default, each tab is converted to 4 consecutive spaces.
     *
     * @param   string  $str        String to convert tabs to spaces
     * @param   int     $tabLength  Number of spaces to replace each tab with
     * @return  string  String with tabs switched to spaces
     */
    public static function toSpaces($str, $tabLength = 4) {
        $spaces = str_repeat(' ', $tabLength);

        return str_replace("\t", $spaces, $str);
    }

    /**
     * Converts each occurence of some consecutive number of spaces, as defined
     * by $tabLength, to a tab. By default, each 4 consecutive spaces are
     * converted to a tab.
     *
     * @param   string  $str        String to convert spaces to tabs
     * @param   int     $tabLength  Number of spaces to replace with a tab
     * @return  string  String with spaces switched to tabs
     */
    public static function toTabs($str, $tabLength = 4) {
        $spaces = str_repeat(' ', $tabLength);

        return str_replace($spaces, "\t", $str);
    }

}

?>
