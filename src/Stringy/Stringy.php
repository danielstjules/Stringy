<?php

namespace Stringy;

class Stringy
{
    public $str;

    public $encoding;

    /**
     * Creates a Stringy object and assigns both str and encoding properties
     * the supplied values. If $encoding is not specified, it defaults to
     * mb_internal_encoding(). It then returns the instantiated object.
     *
     * @param   string   $str       String to modify
     * @param   string   $encoding  The character encoding
     * @return  Stringy  A Stringy object
     */
    public static function create($str, $encoding = null)
    {
        $encoding = $encoding ?: mb_internal_encoding();

        $stringyObj = new Stringy();
        $stringyObj->str = $str;
        $stringyObj->encoding = $encoding;

        return $stringyObj;
    }

    /**
     * Returns the value in $str.
     *
     * @return  string  The current value of the $str property
     */
    public function __toString()
    {
        return $this->str;
    }

    /**
     * Converts the first character of the string to upper case.
     *
     * @return  Stringy  Object with the first character of $str being upper case
     */
    public function upperCaseFirst()
    {
        $first = mb_substr($this->str, 0, 1, $this->encoding);
        $rest = mb_substr($this->str, 1, $this->length() - 1,
            $this->encoding);

        $this->str = mb_strtoupper($first, $this->encoding) . $rest;

        return $this;
    }

    /**
     * Converts the first character of the string to lower case.
     *
     * @return  Stringy  Object with the first character of $str being lower case
     */
    public function lowerCaseFirst()
    {
        $first = mb_substr($this->str, 0, 1, $this->encoding);
        $rest = mb_substr($this->str, 1, $this->length() - 1,
            $this->encoding);

        $this->str = mb_strtolower($first, $this->encoding) . $rest;

        return $this;
    }

    /**
     * Converts the string to camelCase. Trims surrounding spaces, capitalizes
     * letters following digits, spaces, dashes and underscores, and removes
     * spaces, dashes, underscores.
     *
     * @return  Stringy  Object with $str in camelCase
     */
    public function camelize()
    {
        $encoding = $this->encoding;

        $camelCase = preg_replace_callback(
            '/[-_\s]+(.)?/u',
            function ($match) use (&$encoding) {
                return $match[1] ? mb_strtoupper($match[1], $encoding) : "";
            },
            $this->trim()->lowerCaseFirst()
        );

        $this->str = preg_replace_callback(
            '/[\d]+(.)?/u',
            function ($match) use (&$encoding) {
                return mb_strtoupper($match[0], $encoding);
            },
            $camelCase
        );

        return $this;
    }

    /**
     * Converts the string to UpperCamelCase. Trims surrounding spaces, capitalizes
     * letters following digits, spaces, dashes and underscores, and removes
     * spaces, dashes, underscores.
     *
     * @return  Stringy  Object with $str in UpperCamelCase
     */
    public function upperCamelize()
    {
        $this->camelize()->upperCaseFirst();

        return $this;
    }

    /**
     * Sets the string to lowercase, trims it, and seperates is by dashes. Dashes
     * are inserted before uppercase characters (with the exception of the first
     * character of the string), and in place of spaces as well as underscores.
     *
     * @return  Stringy  Object with a dasherized $str
     */
    public function dasherize()
    {
        // Save current regex encoding so we can reset it after
        $regexEncoding = mb_regex_encoding();
        mb_regex_encoding($this->encoding);

        $dasherized = mb_ereg_replace('\B([A-Z])', '-\1', $this->trim());
        $dasherized = mb_ereg_replace('[-_\s]+', '-', $dasherized);

        mb_regex_encoding($regexEncoding);
        $this->str = mb_strtolower($dasherized, $this->encoding);

        return $this;
    }

    /**
     * Sets $str to a lowercase and trimmed string seperated by underscores.
     * Underscores are inserted before uppercase characters (with the exception
     * of the first character of the string), and in place of spaces as well as
     * dashes.
     *
     * @return  Stringy  Object with an underscored $str
     */
    public function underscored()
    {
        // Save current regex encoding so we can reset it after
        $regexEncoding = mb_regex_encoding();
        mb_regex_encoding($this->encoding);

        $underscored = mb_ereg_replace('\B([A-Z])', '_\1', $this->trim());
        $underscored = mb_ereg_replace('[-_\s]+', '_', $underscored);

        mb_regex_encoding($regexEncoding);
        $this->str = mb_strtolower($underscored, $this->encoding);

        return $this;
    }

    /**
     * Sets $str to a case swapped version of the string.
     *
     * @return  Stringy  Object whose $str has each character's case swapped
     */
    public function swapCase()
    {
        $encoding = $this->encoding;

        $this->str = preg_replace_callback(
            '/[\S]/u',
            function ($match) use (&$encoding) {
                if ($match[0] == mb_strtoupper($match[0], $encoding))
                    return mb_strtolower($match[0], $encoding);
                else
                    return mb_strtoupper($match[0], $encoding);
            },
            $this->str
        );

        return $this;
    }

    /**
     * Capitalizes the first letter of each word in $str, after trimming.
     * Ignores the case of other letters, allowing for the use of acronyms.
     * Also accepts an array, $ignore, allowing you to list words not to be
     * capitalized.
     *
     * @param   array    $ignore    An array of words not to capitalize
     * @return  Stringy  Object with a titleized $str
     */
    public function titleize($ignore = null)
    {
        $encoding = $this->encoding;
        $that = $this;

        $this->str = preg_replace_callback(
            '/([\S]+)/u',
            function ($match) use (&$encoding, &$ignore, &$that) {
                if ($ignore && in_array($match[0], $ignore))
                    return $match[0];
                $that->str = $match[0];
                return $that->upperCaseFirst();
            },
            $this->trim()->str
        );

        return $this;
    }

    /**
     * Capitalizes the first word of $str, replaces underscores with spaces,
     * and strips '_id'.
     *
     * @return  Stringy  Object with a humanized $str
     */
    public function humanize()
    {
        $humanized = str_replace('_id', '', $this->str);
        $this->str = str_replace('_', ' ', $humanized);

        return $this->trim()->upperCaseFirst();
    }

    /**
     * Replaces smart quotes, ellipsis characters, and dashes from Windows-1252
     * (and commonly used in Word documents) with their ASCII equivalents.
     *
     * @return  Stringy  Object whose $str has those characters removed
     */
    public function tidy()
    {
        $this->str = preg_replace('/\x{2026}/u', '...', $this->str);
        $this->str = preg_replace('/[\x{201C}\x{201D}]/u', '"', $this->str);
        $this->str = preg_replace('/[\x{2018}\x{2019}]/u', "'", $this->str);
        $this->str = preg_replace('/[\x{2013}\x{2014}]/u', '-', $this->str);

        return $this;
    }

    /**
     * Trims $str and replaces consecutive whitespace characters with a single
     * space. This inclues tabs and newline characters.
     *
     * @return  Stringy  Object with a trimmed $str with condensed whitespace
     */
    public function collapseWhitespace()
    {
        $this->str = preg_replace('/\s+/u', ' ', $this->trim());

        return $this;
    }

    /**
     * Converts some non-ASCII characters to their closest ASCII counterparts.
     *
     * @return  Stringy  Object whose $str had those characters replaced
     */
    public function standardize()
    {
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
            $this->str = str_replace($value, $key, $this->str);
        }

        return $this;
    }

    /**
     * Pads $str to a given length with another string. If length is less than
     * or equal to the length of $str, then no padding takes places. The default
     * string used for padding is a space, and the default type (one of 'left',
     * 'right', 'both') is 'right'. Throws an exception if $padType isn't one
     * of those 3 values.
     *
     * @param   int      $length    Desired string length after padding
     * @param   string   $padStr    String used to pad, defaults to space
     * @param   string   $padType   One of 'left', 'right', 'both'
     * @return  Stringy  Object with a padded $str
     * @throws  InvalidArgumentException If $padType isn't one of 'right',
     *          'left' or 'both'
     */
    public function pad($length, $padStr = ' ', $padType = 'right')
    {
        if (!in_array($padType, array('left', 'right', 'both'))) {
            throw new InvalidArgumentException('Pad expects $padType ' .
                "to be one of 'left', 'right' or 'both'");
        }

        $strLength = $this->length();
        $padStrLength = mb_strlen($padStr, $this->encoding);

        if ($length <= $strLength || $padStrLength <= 0)
            return $this;

        // Number of times to repeat the padStr if left or right
        $times = ceil(($length - $strLength) / $padStrLength);
        $paddedStr = '';

        if ($padType == 'left') {
            // Repeat the pad, cut it, and prepend
            $leftPad = str_repeat($padStr, $times);
            $leftPad = mb_substr($leftPad, 0, $length - $strLength, $this->encoding);
            $this->str = $leftPad . $this->str;
        } elseif ($padType == 'right') {
            // Append the repeated pad and get a substring of the given length
            $this->str = $this->str . str_repeat($padStr, $times);
            $this->str = mb_substr($this->str, 0, $length, $this->encoding);
        } else {
            // Number of times to repeat the padStr on both sides
            $paddingSize = ($length - $strLength) / 2;
            $times = ceil($paddingSize / $padStrLength);

            // Favour right padding over left, as with str_pad()
            $rightPad = str_repeat($padStr, $times);
            $rightPad = mb_substr($rightPad, 0, ceil($paddingSize), $this->encoding);

            $leftPad = str_repeat($padStr, $times);
            $leftPad = mb_substr($leftPad, 0, floor($paddingSize), $this->encoding);

            $this->str = $leftPad . $this->str . $rightPad;
        }

        return $this;
    }

    /**
     * Pads $str to a given length from the begining of the string.
     * Alias for pad($length, $padStr, 'left')
     *
     * @param   int      $length    Desired string length after padding
     * @param   string   $padStr    String used to pad, defaults to space
     * @return  Stringy  Object with a left padded $str
     */
    public function padLeft($length, $padStr = ' ')
    {
        return $this->pad($length, $padStr, 'left');
    }

    /**
     * Pads $str to a given length from the end of the string.
     * Alias for pad($length, $padStr, 'left')
     *
     * @param   int     $length    Desired string length after padding
     * @param   string  $padStr    String used to pad, defaults to space
     * @return  string  Object with a right padded $str
     */
    public function padRight($length, $padStr = ' ')
    {
        return $this->pad($length, $padStr, 'right');
    }

    /**
     * Pads $str to a given length such that both sides of the string string are
     * padded. Alias for pad($str, $length, $padStr, 'both', $encoding)
     *
     * @param   int      $length    Desired string length after padding
     * @param   string   $padStr    String used to pad, defaults to space
     * @return  Stringy  The padded string
     */
    public function padBoth($length, $padStr = ' ')
    {
        return $this->pad($length, $padStr, 'both');
    }

    /**
     * Returns true if $str begins with $substring, false otherwise. By default,
     * the comparison is case-sensitive, but can be made insensitive by setting
     * $caseSensitive to false.
     *
     * @param   string  $substring      The substring to look for
     * @param   bool    $caseSensitive  Whether or not to enfore case-sensitivity
     * @return  bool    Whether or not $str starts with $substring
     */
    public function startsWith($substring, $caseSensitive = true)
    {
        $substringLength = mb_strlen($substring, $this->encoding);
        $startOfStr = mb_substr($this->str, 0, $substringLength, $this->encoding);

        if (!$caseSensitive) {
            $substring = mb_strtolower($substring, $this->encoding);
            $startOfStr = mb_strtolower($startOfStr, $this->encoding);
        }

        return $substring === $startOfStr;
    }

    /**
     * Returns true if $str ends with $substring, false otherwise. By default,
     * the comparison is case-sensitive, but can be made insensitive by setting
     * $caseSensitive to false.
     *
     * @param   string  $substring      The substring to look for
     * @param   bool    $caseSensitive  Whether or not to enfore case-sensitivity
     * @return  bool    Whether or not $str ends with $substring
     */
    public function endsWith($substring, $caseSensitive = true)
    {
        $substringLength = mb_strlen($substring, $this->encoding);
        $strLength = $this->length();

        $endOfStr = mb_substr($this->str, $strLength - $substringLength,
            $substringLength, $this->encoding);

        if (!$caseSensitive) {
            $substring = mb_strtolower($substring, $this->encoding);
            $endOfStr = mb_strtolower($endOfStr, $this->encoding);
        }

        return $substring === $endOfStr;
    }

    /**
     * Converts each tab in $str to some number of spaces, as defined by
     * $tabLength. By default, each tab is converted to 4 consecutive spaces.
     *
     * @param   int      $tabLength  Number of spaces to replace each tab with
     * @return  Stringy  Object whose $str has had tabs switched to spaces
     */
    public function toSpaces($tabLength = 4)
    {
        $spaces = str_repeat(' ', $tabLength);
        $this->str = str_replace("\t", $spaces, $this->str);

        return $this;
    }

    /**
     * Converts each occurence of some consecutive number of spaces, as defined
     * by $tabLength, to a tab. By default, each 4 consecutive spaces are
     * converted to a tab.
     *
     * @param   int      $tabLength  Number of spaces to replace with a tab
     * @return  Stringy  Object whose $str has had spaces switched to tabs
     */
    public function toTabs($tabLength = 4)
    {
        $spaces = str_repeat(' ', $tabLength);
        $this->str = str_replace($spaces, "\t", $this->str);

        return $this;
    }

    /**
     * Converts $str into an URL slug. This includes replacing non-ASCII
     * characters with their closest ASCII equivalents, removing non-alphanumeric
     * and non-ASCII characters, and replacing whitespace with dashes. The string
     * is also converted to lowercase.
     *
     * @return  Stringy  Object whose $str has been converted to an URL slug
     */
    public function slugify()
    {
        $this->str = preg_replace('/[^a-zA-Z\d -]/u', '', $this->standardize());
        $this->collapseWhitespace();
        $this->str = str_replace(' ', '-', strtolower($this->str));

        return $this;
    }

    /**
     * Returns true if $str contains $needle, false otherwise.
     *
     * @param   string  $needle    Substring to look for
     * @return  bool    Whether or not $str contains $needle
     */
    public function contains($needle)
    {
        if (mb_strpos($this->str, $needle, 0, $this->encoding) !== false)
            return true;

        return false;
    }

    /**
     * Surrounds $str with the given substring.
     *
     * @param   string   $substring  The substring to add to both sides
     * @return  Stringy  Object whose $str had the substring prepended and appended
     */
    public function surround($substring)
    {
        $this->str = implode('', array($substring, $this->str, $substring));

        return $this;
    }

    /**
     * Inserts $substring into $str at the $index provided.
     *
     * @param   string   $substring  String to be inserted
     * @param   int      $index      The index at which to insert the substring
     * @return  Stringy  Object with the resulting $str after the insertion
     */
    public function insert($substring, $index)
    {
        if ($index > $this->length())
            return $this;

        $start = mb_substr($this->str, 0, $index, $this->encoding);
        $end = mb_substr($this->str, $index, $this->length(), $this->encoding);

        $this->str = $start . $substring . $end;

        return $this;
    }

    /**
     * Truncates $str to a given length, while ensuring that it does not chop
     * words. If $substring is provided, and truncating occurs, the string
     * is further truncated so that the substring may be appended without
     * exceeding the desired length.
     *
     * @param   int      $length       Desired length of the truncated string
     * @param   string   $substring    The substring to append if it can fit
     * @return  Stringy  Object with the resulting $str after truncating
     */
    public function safeTruncate($length, $substring = '')
    {
        if ($length >= $this->length())
            return $this;

        // Need to further trim the string so we can append the substring
        $substringLength = mb_strlen($substring, $this->encoding);
        $length = $length - $substringLength;

        $truncated = mb_substr($this->str, 0, $length, $this->encoding);

        // If the last word was truncated
        if (mb_strpos($this->str, ' ', $length - 1, $this->encoding) != $length) {
            // Find pos of the last occurence of a space, and get everything up until
            $lastPos = mb_strrpos($truncated, ' ', 0, $this->encoding);
            $truncated = mb_substr($truncated, 0, $lastPos, $this->encoding);
        }

        $this->str = $truncated . $substring;

        return $this;
    }

    /**
     * Reverses $str. A multibyte version of strrev.
     *
     * @return  Stringy  Object with a reversed $str
     */
    public function reverse()
    {
        $strLength = $this->length();
        $reversed = '';

        // Loop from last index of string to first
        for ($i = $strLength - 1; $i >= 0; $i--) {
            $reversed .= mb_substr($this->str, $i, 1, $this->encoding);
        }

        $this->str = $reversed;

        return $this;
    }

    /**
     * A multibyte str_shuffle function. It randomizes the order of characters
     * in $str.
     *
     * @return  Stringy  Object with a shuffled $str
     */
    public function shuffle()
    {
        $indexes = range(0, $this->length() - 1);
        shuffle($indexes);

        $shuffledStr = '';
        foreach ($indexes as $i) {
            $shuffledStr .= mb_substr($this->str, $i, 1, $this->encoding);
        }

        $this->str = $shuffledStr;

        return $this;
    }

    /**
     * Trims $str. An alias for PHP's trim() function.
     *
     * @return  Stringy  Object with a trimmed $str
     */
    public function trim()
    {
        $this->str = trim($this->str);

        return $this;
    }

    /**
     * Finds the longest common prefix between $str and $otherStr.
     *
     * @return  Stringy  Object with its $str being the longest common prefix
     */
    public function longestCommonPrefix($otherStr)
    {
        $maxLength = min($this->length(), mb_strlen($otherStr, $this->encoding));

        $longestCommonPrefix = '';
        for ($i = 0; $i < $maxLength; $i++) {
            $char = mb_substr($this->str, $i, 1, $this->encoding);

            if ($char == mb_substr($otherStr, $i, 1, $this->encoding)) {
                $longestCommonPrefix .= $char;
            } else {
                break;
            }
        }

        $this->str = $longestCommonPrefix;

        return $this;
    }

    /**
     * Finds the longest common suffix between $str and $otherStr.
     *
     * @return  Stringy  Object with its $str being the longest common suffix
     */
    public function longestCommonSuffix($otherStr)
    {
        $maxLength = min($this->length(), mb_strlen($otherStr, $this->encoding));

        $longestCommonSuffix = '';
        for ($i = 1; $i <= $maxLength; $i++) {
            $char = mb_substr($this->str, -$i, 1, $this->encoding);

            if ($char == mb_substr($otherStr, -$i, 1, $this->encoding)) {
                $longestCommonSuffix = $char . $longestCommonSuffix;
            } else {
                break;
            }
        }

        $this->str = $longestCommonSuffix;

        return $this;
    }

    /**
     * Finds the longest common substring between $str and $otherStr. In the
     * case of ties, returns that which occurs first.
     *
     * @return  Stringy  Object with its $str being the longest common substring
     */
    public function longestCommonSubstring($otherStr)
    {
        // Uses dynamic programming to solve
        // http://en.wikipedia.org/wiki/Longest_common_substring_problem
        $strLength = $this->length();
        $otherLength = mb_strlen($otherStr, $this->encoding);

        // Return if either string is empty
        if ($strLength == 0 || $otherLength == 0) {
            $this->str = '';
            return $this;
        }

        $len = 0;
        $end = 0;
        $table = array_fill(0, $strLength + 1, array_fill(0, $otherLength + 1, 0));

        for ($i = 1; $i <= $strLength; $i++){
            for ($j = 1; $j <= $otherLength; $j++){
                $strChar = mb_substr($this->str, $i - 1, 1, $this->encoding);
                $otherChar = mb_substr($otherStr, $j - 1, 1, $this->encoding);

                if ($strChar == $otherChar) {
                    $table[$i][$j] = $table[$i - 1][$j - 1] + 1;
                    if ($table[$i][$j] > $len) {
                        $len = $table[$i][$j];
                        $end = $i;
                    }
                } else {
                    $table[$i][$j] = 0;
                }
            }
        }

        $this->str = mb_substr($this->str, $end - $len, $len, $this->encoding);

        return $this;
    }

    /**
     * Returns the length of $str. An alias for PHP's mb_strlen() function.
     *
     * @return  int  The number of characters in $str given the encoding
     */
    public function length()
    {
        return mb_strlen($this->str, $this->encoding);
    }
}
