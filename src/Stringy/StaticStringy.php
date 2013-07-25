<?php

namespace Stringy;

class StaticStringy
{
    /**
     * Converts the first character of the supplied string to upper case.
     *
     * @param   string  $str       String to modify
     * @param   string  $encoding  The character encoding
     * @return  string  String with the first character being upper case
     */
    public static function upperCaseFirst($str, $encoding = null)
    {
        return Stringy::create($str, $encoding)->upperCaseFirst();
    }

    /**
     * Converts the first character of the supplied string to lower case.
     *
     * @param   string  $str       String to modify
     * @param   string  $encoding  The character encoding
     * @return  string  String with the first character being lower case
     */
    public static function lowerCaseFirst($str, $encoding = null)
    {
        return Stringy::create($str, $encoding)->lowerCaseFirst();
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
    public static function camelize($str, $encoding = null)
    {
        return Stringy::create($str, $encoding)->camelize();
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
    public static function upperCamelize($str, $encoding = null)
    {
        return Stringy::create($str, $encoding)->upperCamelize();
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
    public static function dasherize($str, $encoding = null)
    {
        return Stringy::create($str, $encoding)->dasherize();
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
    public static function underscored($str, $encoding = null)
    {
        return $result = Stringy::create($str, $encoding)->underscored();
    }

    /**
     * Returns a case swapped version of a string.
     *
     * @param   string  $str       String to swap case
     * @param   string  $encoding  The character encoding
     * @return  string  String with each character's case swapped
     */
    public static function swapCase($str, $encoding = null)
    {
        return $result = Stringy::create($str, $encoding)->swapCase();
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
    public static function titleize($str, $ignore = null, $encoding = null)
    {
        return $result = Stringy::create($str, $encoding)->titleize($ignore);
    }

    /**
     * Capitalizes the first word of a string, replaces underscores with spaces,
     * and strips '_id'.
     *
     * @param   string  $str       String to humanize
     * @param   string  $encoding  The character encoding
     * @return  string  A humanized string
     */
    public static function humanize($str, $encoding = null)
    {
        return $result = Stringy::create($str, $encoding)->humanize();
    }

    /**
     * Replaces smart quotes, ellipsis characters, and dashes from Windows-1252
     * (and commonly used in Word documents) with their ASCII equivalents.
     *
     * @param   string  $str       String to remove special chars
     * @param   string  $encoding  The character encoding
     * @return  string  String with those characters removed
     */
    public static function tidy($str)
    {
        return $result = Stringy::create($str)->tidy();
    }

    /**
     * Trims the string and replaces consecutive whitespace characters with a
     * single space. This inclues tabs and newline characters.
     *
     * @param   string  $str  The string to cleanup whitespace
     * @return  string  The trimmed string with condensed whitespace
     */
    public static function collapseWhitespace($str)
    {
        return $result = Stringy::create($str)->collapseWhitespace();
    }

    /**
     * Converts some non-ASCII characters to their closest ASCII counterparts.
     *
     * @param   string  $str  A string with non-ASCII characters
     * @return  string  The string after the replacements
     */
    public static function standardize($str)
    {
        return $result = Stringy::create($str)->standardize();
    }

    /**
     * Pads a string to a given length with another string. If length is less
     * than or equal to the length of $str, then no padding takes places. The
     * default string used for padding is a space, and the default type (one of
     * 'left', 'right', 'both') is 'right'. Throws an exception if $padType
     * isn't one of those 3 values.
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
                               $encoding = null)
    {
        return $result = Stringy::create($str, $encoding)
                                ->pad($length, $padStr, $padType);
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
    public static function padLeft($str, $length, $padStr = ' ', $encoding = null)
    {
        return Stringy::create($str, $encoding)->padLeft($length, $padStr);
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
    public static function padRight($str, $length, $padStr = ' ', $encoding = null)
    {
        return Stringy::create($str, $encoding)->padRight($length, $padStr);
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
    public static function padBoth($str, $length, $padStr = ' ', $encoding = null)
    {
        return Stringy::create($str, $encoding)->padBoth($length, $padStr);
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
                                      $encoding = null)
    {
        return Stringy::create($str, $encoding)->startsWith($substring, $caseSensitive);
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
                                    $encoding = null)
    {
        return Stringy::create($str, $encoding)->endsWith($substring, $caseSensitive);
    }

    /**
     * Converts each tab in a string to some number of spaces, as defined by
     * $tabLength. By default, each tab is converted to 4 consecutive spaces.
     *
     * @param   string  $str        String to convert tabs to spaces
     * @param   int     $tabLength  Number of spaces to replace each tab with
     * @return  string  String with tabs switched to spaces
     */
    public static function toSpaces($str, $tabLength = 4)
    {
        return Stringy::create($str)->toSpaces($tabLength);
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
    public static function toTabs($str, $tabLength = 4)
    {
        return Stringy::create($str)->toTabs($tabLength);
    }

    /**
     * Converts the supplied text into an URL slug. This includes replacing
     * non-ASCII characters with their closest ASCII equivalents, removing
     * non-alphanumeric and non-ASCII characters, and replacing whitespace with
     * dashes. The string is also converted to lowercase.
     *
     * @param   string  $str  Text to transform into an URL slug
     * @return  string  The corresponding URL slug
     */
    public static function slugify($str)
    {
        return Stringy::create($str)->slugify();
    }

    /**
     * Returns true if $haystack contains $needle, false otherwise.
     *
     * @param   string  $haystack  String being checked
     * @param   string  $needle    Substring to look for
     * @param   string  $encoding  The character encoding
     * @return  bool    Whether or not $haystack contains $needle
     */
    public static function contains($haystack, $needle, $encoding = null)
    {
        return Stringy::create($haystack, $encoding)->contains($needle);
    }

    /**
     * Surrounds a string with the given substring.
     *
     * @param   string  $str        The string to surround
     * @param   string  $substring  The substring to add to both sides
     * @return  string  The string with the substring prepended and appended
     */
    public static function surround($str, $substring)
    {
        return Stringy::create($str)->surround($substring);
    }

    /**
     * Inserts $substring into $str at the $index provided.
     *
     * @param   string  $str        String to insert into
     * @param   string  $substring  String to be inserted
     * @param   int     $index      The index at which to insert the substring
     * @param   string  $encoding   The character encoding
     * @return  string  The resulting string after the insertion
     */
    public static function insert($str, $substring, $index, $encoding = null)
    {
        return Stringy::create($str, $encoding)->insert($substring, $index);
    }

    /**
     * Truncates the string to a given length, while ensuring that it does not
     * chop words. If $substring is provided, and truncating occurs, the string
     * is further truncated so that the substring may be appended without
     * exceeding the desired length.
     *
     * @param   string  $str          String to truncate
     * @param   int     $length       Desired length of the truncated string
     * @param   string  $substring    The substring to append if it can fit
     * @param   string  $encoding     The character encoding
     * @return  string  The resulting string after truncating
     */
    public static function safeTruncate($str, $length, $substring = '',
                                    $encoding = null)
    {
        return Stringy::create($str, $encoding)->safeTruncate($length, $substring);
    }

    /**
     * Reverses a string. A multibyte version of strrev.
     *
     * @param   string  $str        String to reverse
     * @param   string  $encoding   The character encoding
     * @return  string  The reversed string
     */
    public static function reverse($str, $encoding = null)
    {
        return Stringy::create($str, $encoding)->reverse();
    }

    /**
     * A multibyte str_shuffle function. It randomizes the order of characters
     * in a string.
     *
     * @param   string  $str       String to shuffle
     * @param   string  $encoding  The character encoding
     * @return  string  The shuffled string
     */
    public static function shuffle($str, $encoding = null)
    {
        return Stringy::create($str, $encoding)->shuffle();
    }

    /**
     * Trims $str. An alias for PHP's trim() function.
     *
     * @return  string  Trimmed $str
     */
    public function trim($str)
    {
        return trim($str);
    }
}
