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

        $stringyObj = new self();
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

        $str = mb_strtoupper($first, $this->encoding) . $rest;

        return self::create($str, $this->encoding);
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

        $str = mb_strtolower($first, $this->encoding) . $rest;

        return self::create($str, $this->encoding);
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
        $stringy = self::create($this->str, $this->encoding);

        $camelCase = preg_replace_callback(
            '/[-_\s]+(.)?/u',
            function ($match) use (&$encoding) {
                return $match[1] ? mb_strtoupper($match[1], $encoding) : "";
            },
            $stringy->trim()->lowerCaseFirst()->str
        );

        $stringy->str = preg_replace_callback(
            '/[\d]+(.)?/u',
            function ($match) use (&$encoding) {
                return mb_strtoupper($match[0], $encoding);
            },
            $camelCase
        );

        return $stringy;
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
        return $this->camelize()->upperCaseFirst();
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

        $stringy = self::create($this->str, $this->encoding)->trim();
        $dasherized = mb_ereg_replace('\B([A-Z])', '-\1', $stringy->str);
        $dasherized = mb_ereg_replace('[-_\s]+', '-', $dasherized);

        mb_regex_encoding($regexEncoding);
        $stringy->str = mb_strtolower($dasherized, $stringy->encoding);

        return $stringy;
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

        $stringy = self::create($this->str, $this->encoding)->trim();
        $underscored = mb_ereg_replace('\B([A-Z])', '_\1', $stringy->str);
        $underscored = mb_ereg_replace('[-_\s]+', '_', $underscored);

        mb_regex_encoding($regexEncoding);
        $stringy->str = mb_strtolower($underscored, $stringy->encoding);

        return $stringy;
    }

    /**
     * Sets $str to a case swapped version of the string.
     *
     * @return  Stringy  Object whose $str has each character's case swapped
     */
    public function swapCase()
    {
        $stringy = self::create($this->str, $this->encoding);
        $encoding = $stringy->encoding;

        $stringy->str = preg_replace_callback(
            '/[\S]/u',
            function ($match) use (&$encoding) {
                if ($match[0] == mb_strtoupper($match[0], $encoding))
                    return mb_strtolower($match[0], $encoding);
                else
                    return mb_strtoupper($match[0], $encoding);
            },
            $stringy->str
        );

        return $stringy;
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
        $stringy = self::create($this->str, $this->encoding)->trim();
        $encoding = $stringy->encoding;

        $stringy->str = preg_replace_callback(
            '/([\S]+)/u',
            function ($match) use (&$encoding, &$ignore, &$stringy) {
                if ($ignore && in_array($match[0], $ignore))
                    return $match[0];
                $stringy->str = $match[0];
                return $stringy->upperCaseFirst();
            },
            $stringy->str
        );

        return $stringy;
    }

    /**
     * Capitalizes the first word of $str, replaces underscores with spaces,
     * and strips '_id'.
     *
     * @return  Stringy  Object with a humanized $str
     */
    public function humanize()
    {
        $stringy = self::create($this->str, $this->encoding);

        $humanized = str_replace('_id', '', $stringy->str);
        $stringy->str = str_replace('_', ' ', $humanized);

        return $stringy->trim()->upperCaseFirst();
    }

    /**
     * Replaces smart quotes, ellipsis characters, and dashes from Windows-1252
     * (and commonly used in Word documents) with their ASCII equivalents.
     *
     * @return  Stringy  Object whose $str has those characters removed
     */
    public function tidy()
    {
        $stringy = self::create($this->str, $this->encoding);

        $stringy->str = preg_replace('/\x{2026}/u', '...', $stringy->str);
        $stringy->str = preg_replace('/[\x{201C}\x{201D}]/u', '"', $stringy->str);
        $stringy->str = preg_replace('/[\x{2018}\x{2019}]/u', "'", $stringy->str);
        $stringy->str = preg_replace('/[\x{2013}\x{2014}]/u', '-', $stringy->str);

        return $stringy;
    }

    /**
     * Trims $str and replaces consecutive whitespace characters with a single
     * space. This inclues tabs and newline characters.
     *
     * @return  Stringy  Object with a trimmed $str with condensed whitespace
     */
    public function collapseWhitespace()
    {
        $stringy = self::create($this->str, $this->encoding);
        $stringy->str = preg_replace('/\s+/u', ' ', $stringy->trim());

        return $stringy;
    }

    /**
     * Converts some non-ASCII characters to their closest ASCII counterparts.
     *
     * @return  Stringy  Object whose $str had those characters replaced
     */
    public function standardize()
    {
        $stringy = self::create($this->str, $this->encoding);
        $charsArray = array(
            'a'  => array('à', 'á', 'â', 'ã', 'ā', 'ą', 'ă', 'å', 'α', 'ά', 'ἀ',
                          'ἁ', 'ἂ', 'ἃ', 'ἄ', 'ἅ', 'ἆ', 'ἇ', 'ᾀ', 'ᾁ', 'ᾂ', 'ᾃ',
                          'ᾄ', 'ᾅ', 'ᾆ', 'ᾇ', 'ὰ', 'ά', 'ᾰ', 'ᾱ', 'ᾲ', 'ᾳ', 'ᾴ',
                          'ᾶ', 'ᾷ'),
            'b'  => array('б', 'β'),
            'c'  => array('ç', 'ć', 'č', 'ĉ', 'ċ'),
            'd'  => array('ď', 'ð', 'đ', 'ƌ', 'ȡ', 'ɖ', 'ɗ', 'ᵭ', 'ᶁ', 'ᶑ'),
            'e'  => array('è', 'é', 'ê', 'ë', 'ē', 'ę', 'ě', 'ĕ', 'ė', 'ε', 'έ',
                          'ἐ', 'ἑ', 'ἒ', 'ἓ', 'ἔ', 'ἕ', 'ὲ', 'έ', 'е', 'ё', 'э'),
            'g'  => array('ĝ', 'ğ', 'ġ', 'ģ'),
            'h'  => array('ĥ', 'ħ'),
            'i'  => array('ì', 'í', 'î', 'ï', 'ī', 'ĩ', 'ĭ', 'į', 'ı', 'ι', 'ί',
                          'ϊ', 'ΐ', 'ἰ', 'ἱ', 'ἲ', 'ἳ', 'ἴ', 'ἵ', 'ἶ', 'ἷ', 'ὶ',
                          'ί', 'ῐ', 'ῑ', 'ῒ', 'ΐ', 'ῖ', 'ῗ'),
            'j'  => array('ĵ'),
            'k'  => array('ķ', 'ĸ'),
            'l'  => array('ł', 'ľ', 'ĺ', 'ļ', 'ŀ'),
            'n'  => array('ñ', 'ń', 'ň', 'ņ', 'ŉ', 'ŋ', 'ν'),
            'o'  => array('ò', 'ó', 'ô', 'õ', 'ø', 'ō', 'ő', 'ŏ', 'ο', 'ό', 'ὀ',
                          'ὁ', 'ὂ', 'ὃ', 'ὄ', 'ὅ', 'ὸ', 'ό', 'ö'),
            'r'  => array('ŕ', 'ř', 'ŗ'),
            's'  => array('ś', 'š', 'ş'),
            't'  => array('ť', 'ţ'),
            'u'  => array('ü', 'ù', 'ú', 'û', 'ū', 'ů', 'ű', 'ŭ', 'ũ', 'ų', 'µ'),
            'w'  => array('ŵ'),
            'y'  => array('ÿ', 'ý', 'ŷ'),
            'z'  => array('ź', 'ž', 'ż'),
            'oe' => array('œ'),
            'A'  => array('Á', 'Â', 'Ã', 'Å', 'Ā', 'Ą', 'Ă', 'Α', 'Ά', 'Ἀ', 'Ἁ',
                         'Ἂ', 'Ἃ', 'Ἄ', 'Ἅ', 'Ἆ', 'Ἇ', 'ᾈ', 'ᾉ', 'ᾊ', 'ᾋ', 'ᾌ',
                         'ᾍ', 'ᾎ', 'ᾏ', 'Ᾰ', 'Ᾱ', 'Ὰ', 'Ά', 'ᾼ'),
            'B'  => array('Б'),
            'C'  => array('Ć', 'Č', 'Ĉ', 'Ċ'),
            'D'  => array('Ď', 'Ð', 'Đ', 'Ɖ', 'Ɗ', 'Ƌ', 'ᴅ', 'ᴆ'),
            'E'  => array('É', 'Ê', 'Ë', 'Ē', 'Ę', 'Ě', 'Ĕ', 'Ė', 'Ε', 'Έ', 'Ἐ',
                          'Ἑ', 'Ἒ', 'Ἓ', 'Ἔ', 'Ἕ', 'Έ', 'Ὲ', 'Е', 'Ё', 'Э'),
            'G'  => array('Ğ', 'Ġ', 'Ģ'),
            'I'  => array('Í', 'Î', 'Ï', 'Ī', 'Ĩ', 'Ĭ', 'Į', 'İ', 'Ι', 'Ί', 'Ϊ',
                          'Ἰ', 'Ἱ', 'Ἳ', 'Ἴ', 'Ἵ', 'Ἶ', 'Ἷ', 'Ῐ', 'Ῑ', 'Ὶ', 'Ί'),
            'L'  => array('Ĺ', 'Ł'),
            'N'  => array('Ń', 'Ñ', 'Ň', 'Ņ', 'Ŋ',),
            'O'  => array('Ó', 'Ô', 'Õ', 'Ø', 'Ō', 'Ő', 'Ŏ', 'Ο', 'Ό', 'Ὀ', 'Ὁ',
                          'Ὂ', 'Ὃ', 'Ὄ', 'Ὅ', 'Ὸ', 'Ό'),
            'R'  => array('Ř', 'Ŕ'),
            'S'  => array('Ş', 'Ŝ', 'Ș', 'Š', 'Ś'),
            'T'  => array('Ť', 'Ţ', 'Ŧ', 'Ț'),
            'U'  => array('Ù', 'Ú', 'Û', 'Ū', 'Ů', 'Ű', 'Ŭ', 'Ũ', 'Ų'),
            'Y'  => array('Ý', 'Ÿ', 'Ῠ', 'Ῡ', 'Ὺ', 'Ύ'),
            'Z'  => array('Ź', 'Ž', 'Ż')
        );

        foreach ($charsArray as $key => $value) {
            $stringy->str = str_replace($value, $key, $stringy->str);
        }

        return $stringy;
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

        $stringy = self::create($this->str, $this->encoding);
        $strLength = $stringy->length();
        $padStrLength = mb_strlen($padStr, $stringy->encoding);

        if ($length <= $strLength || $padStrLength <= 0)
            return $stringy;

        // Number of times to repeat the padStr if left or right
        $times = ceil(($length - $strLength) / $padStrLength);
        $paddedStr = '';

        if ($padType == 'left') {
            // Repeat the pad, cut it, and prepend
            $leftPad = str_repeat($padStr, $times);
            $leftPad = mb_substr($leftPad, 0, $length - $strLength, $this->encoding);
            $stringy->str = $leftPad . $stringy->str;
        } elseif ($padType == 'right') {
            // Append the repeated pad and get a substring of the given length
            $stringy->str = $stringy->str . str_repeat($padStr, $times);
            $stringy->str = mb_substr($stringy->str, 0, $length, $this->encoding);
        } else {
            // Number of times to repeat the padStr on both sides
            $paddingSize = ($length - $strLength) / 2;
            $times = ceil($paddingSize / $padStrLength);

            // Favour right padding over left, as with str_pad()
            $rightPad = str_repeat($padStr, $times);
            $rightPad = mb_substr($rightPad, 0, ceil($paddingSize), $this->encoding);

            $leftPad = str_repeat($padStr, $times);
            $leftPad = mb_substr($leftPad, 0, floor($paddingSize), $this->encoding);

            $stringy->str = $leftPad . $stringy->str . $rightPad;
        }

        return $stringy;
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
        $stringy = self::create($this->str, $this->encoding);

        $spaces = str_repeat(' ', $tabLength);
        $stringy->str = str_replace("\t", $spaces, $stringy->str);

        return $stringy;
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
        $stringy = self::create($this->str, $this->encoding);

        $spaces = str_repeat(' ', $tabLength);
        $stringy->str = str_replace($spaces, "\t", $stringy->str);

        return $stringy;
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
        $stringy = self::create($this->str, $this->encoding);

        $stringy->str = preg_replace('/[^a-zA-Z\d -]/u', '', $stringy->standardize());
        $stringy->str = $stringy->collapseWhitespace()->str;
        $stringy->str = str_replace(' ', '-', strtolower($stringy->str));

        return $stringy;
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
        $stringy = self::create($this->str, $this->encoding);
        $stringy->str = implode('', array($substring, $stringy->str, $substring));

        return $stringy;
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
        $stringy = self::create($this->str, $this->encoding);
        if ($index > $stringy->length())
            return $stringy;

        $start = mb_substr($stringy->str, 0, $index, $stringy->encoding);
        $end = mb_substr($stringy->str, $index, $stringy->length(), $stringy->encoding);

        $stringy->str = $start . $substring . $end;

        return $stringy;
    }

    /**
     * Truncates $str to a given length. If $substring is provided, and
     * truncating occurs, the string is further truncated so that the substring
     * may be appended without exceeding the desired length.
     *
     * @param   int      $length       Desired length of the truncated string
     * @param   string   $substring    The substring to append if it can fit
     * @return  Stringy  Object with the resulting $str after truncating
     */
    public function truncate($length, $substring = '')
    {
        $stringy = self::create($this->str, $this->encoding);
        if ($length >= $stringy->length())
            return $stringy;

        // Need to further trim the string so we can append the substring
        $substringLength = mb_strlen($substring, $stringy->encoding);
        $length = $length - $substringLength;

        $truncated = mb_substr($stringy->str, 0, $length, $stringy->encoding);
        $stringy->str = $truncated . $substring;

        return $stringy;
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
        $stringy = self::create($this->str, $this->encoding);
        if ($length >= $stringy->length())
            return $stringy;

        // Need to further trim the string so we can append the substring
        $substringLength = mb_strlen($substring, $stringy->encoding);
        $length = $length - $substringLength;

        $truncated = mb_substr($stringy->str, 0, $length, $stringy->encoding);

        // If the last word was truncated
        if (mb_strpos($stringy->str, ' ', $length - 1, $stringy->encoding) != $length) {
            // Find pos of the last occurence of a space, and get everything up until
            $lastPos = mb_strrpos($truncated, ' ', 0, $stringy->encoding);
            $truncated = mb_substr($truncated, 0, $lastPos, $stringy->encoding);
        }

        $stringy->str = $truncated . $substring;

        return $stringy;
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

        return self::create($reversed, $this->encoding);
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

        return self::create($shuffledStr, $this->encoding);
    }

    /**
     * Trims $str. An alias for PHP's trim() function.
     *
     * @return  Stringy  Object with a trimmed $str
     */
    public function trim()
    {
        return self::create(trim($this->str), $this->encoding);
    }

    /**
     * Finds the longest common prefix between $str and $otherStr.
     *
     * @param   string   $otherStr  Second string for comparison
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

        return self::create($longestCommonPrefix, $this->encoding);
    }

    /**
     * Finds the longest common suffix between $str and $otherStr.
     *
     * @param   string   $otherStr  Second string for comparison
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

        return self::create($longestCommonSuffix, $this->encoding);
    }

    /**
     * Finds the longest common substring between $str and $otherStr. In the
     * case of ties, returns that which occurs first.
     *
     * @param   string   $otherStr  Second string for comparison
     * @return  Stringy  Object with its $str being the longest common substring
     */
    public function longestCommonSubstring($otherStr)
    {
        // Uses dynamic programming to solve
        // http://en.wikipedia.org/wiki/Longest_common_substring_problem
        $stringy = self::create($this->str, $this->encoding);
        $strLength = $stringy->length();
        $otherLength = mb_strlen($otherStr, $stringy->encoding);

        // Return if either string is empty
        if ($strLength == 0 || $otherLength == 0) {
            $stringy->str = '';
            return $stringy;
        }

        $len = 0;
        $end = 0;
        $table = array_fill(0, $strLength + 1, array_fill(0, $otherLength + 1, 0));

        for ($i = 1; $i <= $strLength; $i++){
            for ($j = 1; $j <= $otherLength; $j++){
                $strChar = mb_substr($stringy->str, $i - 1, 1, $stringy->encoding);
                $otherChar = mb_substr($otherStr, $j - 1, 1, $stringy->encoding);

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

        $stringy->str = mb_substr($stringy->str, $end - $len, $len, $stringy->encoding);

        return $stringy;
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

    /**
     * Gets the substring of $str beginning at $start with the specified $length.
     * It differs from the mb_substr() function in that providing a $length of
     * null will return the rest of the string, rather than an empty string.
     *
     * @param   int  $start   Position of the first character to use from str
     * @param   int  $length  Maximum number of characters used
     * @return  Stringy  Object with its $str being the substring
     */
    public function substr($start, $length = null)
    {
        $stringy = self::create($this->str, $this->encoding);

        if ($length === null) {
            $stringy->str = mb_substr($stringy->str, $start,
                $stringy->length() - $start, $this->encoding);
        } else {
            $stringy->str = mb_substr($stringy->str, $start, $length,
                $stringy->encoding);
        }

        return $stringy;
    }

    /**
     * Gets the character of $str at $index, with indexes starting at 0.
     *
     * @param   int  $index  Position of the character
     * @return  Stringy  Object with its $str being the selected character
     */
    public function at($index)
    {
        return $this->substr($index, 1);
    }

    /**
     * Gets the first $n characters of $str.
     *
     * @param   int  $n  Number of characters to retrieve from the start
     * @return  Stringy  Object with its $str being the first $n chars
     */
    public function first($n)
    {
        $stringy = self::create($this->str, $this->encoding);

        if ($n < 0) {
            $stringy->str = '';
        } else {
            return $stringy->substr(0, $n);
        }

        return $stringy;
    }

    /**
     * Gets the last $n characters of $str.
     *
     * @param   int  $n  Number of characters to retrieve from the end
     * @return  Stringy  Object with its $str being the last $n chars
     */
    public function last($n)
    {
        $stringy = self::create($this->str, $this->encoding);

        if ($n <= 0) {
            $stringy->str = '';
        } else {
            return $stringy->substr(-$n);
        }

        return $stringy;
    }

    /**
     * Ensures that $str begins with $substring.
     *
     * @param   string   $substring  The substring to add if not present
     * @return  Stringy  Object with its $str prefixed by the $substring
     */
    public function ensureLeft($substring)
    {
        $stringy = self::create($this->str, $this->encoding);

        if (!$stringy->startsWith($substring))
            $stringy->str = $substring . $stringy->str;

        return $stringy;
    }

    /**
     * Ensures that $str ends with $substring.
     *
     * @param   string   $substring  The substring to add if not present
     * @return  Stringy  Object with its $str suffixed by the $substring
     */
    public function ensureRight($substring)
    {
        $stringy = self::create($this->str, $this->encoding);

        if (!$stringy->endsWith($substring))
            $stringy->str .= $substring;

        return $stringy;
    }

    /**
     * Removes the prefix $substring if present.
     *
     * @param   string   $substring  The prefix to remove
     * @return  Stringy  Object having a $str without the prefix $substring
     */
    public function removeLeft($substring)
    {
        $stringy = self::create($this->str, $this->encoding);

        if ($stringy->startsWith($substring)) {
            $substringLength = mb_strlen($substring, $stringy->encoding);
            return $stringy->substr($substringLength);
        }

        return $stringy;
    }

    /**
     * Removes the suffix $substring if present.
     *
     * @param   string   $substring  The suffix to remove
     * @return  Stringy  Object having a $str without the suffix $substring
     */
    public function removeRight($substring)
    {
        $stringy = self::create($this->str, $this->encoding);

        if ($stringy->endsWith($substring)) {
            $substringLength = mb_strlen($substring, $stringy->encoding);
            return $stringy->substr(0, $stringy->length() - $substringLength);
        }

        return $stringy;
    }

    /**
     * Returns true if $str matches the supplied pattern, false otherwise.
     *
     * @param   string  Regex pattern to match against
     * @return  bool    Whether or not $str matches the pattern
     */
    private function matchesPattern($pattern)
    {
        $regexEncoding = mb_regex_encoding();
        mb_regex_encoding($this->encoding);

        $match = mb_ereg_match($pattern, $this->str);
        mb_regex_encoding($regexEncoding);

        return $match;
    }

    /**
     * Returns true if $str contains only alphabetic chars, false otherwise.
     *
     * @return  bool  Whether or not $str contains only alphabetic chars
     */
    public function isAlpha()
    {
        return $this->matchesPattern('^([[:alpha:]])*$');
    }

    /**
     * Returns true if $str contains only alphabetic and numeric chars, false
     * otherwise.
     *
     * @return  bool  Whether or not $str contains only alphanumeric chars
     */
    public function isAlphanumeric()
    {
        return $this->matchesPattern('^([[:alnum:]])*$');
    }

    /**
     * Returns true if $str contains only whitespace chars, false otherwise.
     *
     * @return  bool  Whether or not $str contains only whitespace characters
     */
    public function isBlank()
    {
        return $this->matchesPattern('^([[:space:]])*$');
    }

    /**
     * Returns true if $str contains only lower case chars, false otherwise.
     *
     * @return  bool  Whether or not $str contains only lower case characters
     */
    public function isLowerCase()
    {
        return $this->matchesPattern('^([[:lower:]])*$');
    }

    /**
     * Returns true if $str contains only lower case chars, false otherwise.
     *
     * @return  bool  Whether or not $str contains only lower case characters
     */
    public function isUpperCase()
    {
        return $this->matchesPattern('^([[:upper:]])*$');
    }

    /**
     * Returns the number of occurences of $substring in $str. An alias for
     * mb_substr_count()
     *
     * @param   string   $substring  The substring to search for
     * @return  int      The number of $substring occurences
     */
    public function count($substring)
    {
        return mb_substr_count($this->str, $substring, $this->encoding);
    }

    /**
     * Replaces all occurrences of $search with $replace in $str.
     *
     * @param   string   $search   The needle to search for
     * @param   string   $replace  The string to replace with
     * @return  Stringy  Object with the resulting $str after the replacements
     */
    public function replace($search, $replace)
    {
        $stringy = self::create($this->str, $this->encoding);

        $regexEncoding = mb_regex_encoding();
        mb_regex_encoding($stringy->encoding);

        // Don't want the args accidentally being parsed as regex
        $quotedSearch = preg_quote($search);
        $quotedReplace = preg_quote($replace);

        $stringy->str = mb_ereg_replace($search, $replace, $stringy->str);
        mb_regex_encoding($regexEncoding);

        return $stringy;
    }
}
