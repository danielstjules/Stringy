<?php

namespace Stringy;

class StaticStringy
{
    /**
     * A mapping of method names to the numbers of arguments it accepts. Each
     * should be two more than the equivalent Stringy method. Necessary as
     * static methods place the optional $encoding as the last parameter.
     *
     * @var string[]
     */
    protected static $methodArgs = array(
        'append'                 => 3,
        'at'                     => 3,
        'between'                => 5,
        'camelize'               => 2,
        'chars'                  => 2,
        'collapseWhitespace'     => 2,
        'contains'               => 4,
        'containsAll'            => 4,
        'containsAny'            => 4,
        'count'                  => 2,
        'countSubstr'            => 4,
        'dasherize'              => 2,
        'delimit'                => 3,
        'endsWith'               => 4,
        'ensureLeft'             => 3,
        'ensureRight'            => 3,
        'first'                  => 3,
        'getEncoding'            => 2,
        'hasLowerCase'           => 2,
        'hasUpperCase'           => 2,
        'htmlDecode'             => 3,
        'htmlEncode'             => 3,
        'humanize'               => 2,
        'indexOf'                => 4,
        'indexOfLast'            => 4,
        'insert'                 => 4,
        'isAlpha'                => 2,
        'isAlphanumeric'         => 2,
        'isBlank'                => 2,
        'isHexadecimal'          => 2,
        'isJson'                 => 2,
        'isLowerCase'            => 2,
        'isSerialized'           => 2,
        'isUpperCase'            => 2,
        'last'                   => 3,
        'length'                 => 2,
        'lines'                  => 2,
        'longestCommonPrefix'    => 3,
        'longestCommonSuffix'    => 3,
        'longestCommonSubstring' => 3,
        'lowerCaseFirst'         => 2,
        'pad'                    => 5,
        'padBoth'                => 4,
        'padLeft'                => 4,
        'padRight'               => 4,
        'prepend'                => 3,
        'regexReplace'           => 5,
        'removeLeft'             => 3,
        'removeRight'            => 3,
        'repeat'                 => 3,
        'replace'                => 4,
        'reverse'                => 2,
        'safeTruncate'           => 4,
        'shuffle'                => 2,
        'slugify'                => 3,
        'startsWith'             => 4,
        'slice'                  => 4,
        'split'                  => 4,
        'substr'                 => 4,
        'surround'               => 3,
        'swapCase'               => 2,
        'tidy'                   => 2,
        'titleize'               => 3,
        'toAscii'                => 3,
        'toBoolean'              => 2,
        'toLowerCase'            => 2,
        'toSpaces'               => 3,
        'toTabs'                 => 3,
        'toTitleCase'            => 2,
        'toUpperCase'            => 2,
        'trim'                   => 3,
        'trimLeft'               => 3,
        'trimRight'              => 3,
        'truncate'               => 4,
        'underscored'            => 2,
        'upperCamelize'          => 2,
        'upperCaseFirst'         => 2
    );

    /**
     * Creates an instance of Stringy and invokes the given method with the
     * rest of the passed arguments. The optional encoding is expected to be
     * the last argument. For example, the following:
     * StaticStringy::slice('fòôbàř', 0, 3, 'UTF-8'); translates to
     * Stringy::create('fòôbàř', 'UTF-8')->slice(0, 3);
     * The result is not cast, so the return value may be of type Stringy,
     * integer, boolean, etc.
     *
     * @param string  $name
     * @param mixed[] $arguments
     */
    public static function __callStatic($name, $arguments)
    {
        if (!isset(static::$methodArgs[$name])) {
            throw new \BadMethodCallException($name . ' is not a valid method');
        }

        $numArgs = count($arguments);
        $str = ($numArgs) ? $arguments[0] : '';

        if ($numArgs === static::$methodArgs[$name]) {
            $args = array_slice($arguments, 1, -1);
            $encoding = $arguments[$numArgs - 1];
        } else {
            $args = array_slice($arguments, 1);
            $encoding = null;
        }

        $stringy = Stringy::create($str, $encoding);

        return call_user_func_array(array($stringy, $name), $args);
    }
}
