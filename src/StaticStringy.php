<?php

namespace Stringy;

/**
 * Class StaticStringy
 *
 * INFO: "Method Parameter Information" via PhpStorm | https://www.jetbrains.com/phpstorm/help/viewing-method-parameter-information.html
 *
 * @method static string append(string $stringInput, string $stringAppend, string $encoding = null)
 * @method static string at(string $stringInput, int $index, string $encoding = null)
 * @method static string between(string $stringInput, string $start, string $end, int $offset = 0, string $encoding = null)
 * @method static string camelize(string $stringInput, string $encoding = null)
 * @method static string chars(string $stringInput, string $encoding = null)
 * @method static string collapseWhitespace(string $stringInput, string $encoding = null)
 * @method static string contains(string $stringInput, string $needle, bool $caseSensitive = true, string $encoding = null)
 * @method static string containsAll(string $stringInput, string $needle, bool $caseSensitive = true, string $encoding = null)
 * @method static string containsAny(string $stringInput, string $needle, bool $caseSensitive = true, string $encoding = null)
 * @method static string count(string $stringInput, string $encoding = null)
 * @method static string countSubstr(string $stringInput, string $substring, bool $caseSensitive = true, string $encoding = null)
 * @method static string dasherize(string $stringInput, string $encoding = null)
 * @method static string delimit(string $stringInput, string  $delimiter, string $encoding = null)
 * @method static string endsWith(string $stringInput, string $substring, bool $caseSensitive = true, string $encoding = null)
 * @method static string ensureLeft(string $stringInput, string $substring, string $encoding = null)
 * @method static string ensureRight(string $stringInput, string $substring, string $encoding = null)
 * @method static string first(string $stringInput, int $n, string $encoding = null)
 * @method static string hasLowerCase(string $stringInput, string $encoding = null)
 * @method static string hasUpperCase(string $stringInput, string $encoding = null)
 * @method static string htmlDecode(string $stringInput, int $flags = ENT_COMPAT, string $encoding = null)
 * @method static string htmlEncode(string $stringInput, int $flags = ENT_COMPAT, string $encoding = null)
 * @method static string humanize(string $stringInput, string $encoding = null)
 * @method static string indexOf(string $stringInput, string $needle, int $offset = 0, string $encoding = null)
 * @method static string indexOfLast(string $stringInput, string $needle, int $offset = 0, string $encoding = null)
 * @method static string insert(string $stringInput, string $substring, int $index = 0, string $encoding = null)
 * @method static string isAlpha(string $stringInput, string $encoding = null)
 * @method static string isAlphanumeric(string $stringInput, string $encoding = null)
 * @method static string isBlank(string $stringInput, string $encoding = null)
 * @method static string isHexadecimal(string $stringInput, string $encoding = null)
 * @method static string isJson(string $stringInput, string $encoding = null)
 * @method static string isLowerCase(string $stringInput, string $encoding = null)
 * @method static string isSerialized(string $stringInput, string $encoding = null)
 * @method static string isUpperCase(string $stringInput, string $encoding = null)
 * @method static string last(string $stringInput, string $encoding = null)
 * @method static string length(string $stringInput, string $encoding = null)
 * @method static string lines(string $stringInput, string $encoding = null)
 * @method static string longestCommonPrefix(string $stringInput, string $otherStr, string $encoding = null)
 * @method static string longestCommonSuffix(string $stringInput, string $otherStr, string $encoding = null)
 * @method static string longestCommonSubstring(string $stringInput, string $otherStr, string $encoding = null)
 * @method static string lowerCaseFirst(string $stringInput, string $encoding = null)
 * @method static string offsetExists(string $stringInput, mixed $offset, string $encoding = null)
 * @method static string offsetGet(string $stringInput, mixed $offset, string $encoding = null)
 * @method static string offsetSet(string $stringInput, mixed $offset, mixed $value, string $encoding = null)
 * @method static string offsetUnset(string $stringInput, mixed $offset, string $encoding = null)
 * @method static string pad(string $stringInput, int $length, string $padStr = ' ', string $padType = 'right', string $encoding = null)
 * @method static string padBoth(string $stringInput, int $length, string $padStr = ' ', string $encoding = null)
 * @method static string padLeft(string $stringInput, int $length, string $padStr = ' ', string $encoding = null)
 * @method static string padRight(string $stringInput, int $length, string $padStr = ' ', string $encoding = null)
 * @method static string prepend(string $stringInput, string $string, string $encoding = null)
 * @method static string regexReplace(string $stringInput, string $pattern, string $replacement, string $options = 'msr', string $encoding = null)
 * @method static string removeLeft(string $stringInput, string $substring, string $encoding = null)
 * @method static string removeRight(string $stringInput, string $substring, string $encoding = null)
 * @method static string repeat(string $stringInput, int $multiplier, string $encoding = null)
 * @method static string replace(string $stringInput, string $search, string $replacement, string $encoding = null)
 * @method static string reverse(string $stringInput, string $encoding = null)
 * @method static string safeTruncate(string $stringInput, int $length, string $substring = '', string $encoding = null)
 * @method static string shuffle(string $stringInput, string $encoding = null)
 * @method static string slugify(string $stringInput, string $replacement = '-', string $encoding = null)
 * @method static string startsWith(string $stringInput, string $substring, bool $caseSensitive = true, string $encoding = null)
 * @method static string slice(string $stringInput, int $start, int $end = null, string $encoding = null)
 * @method static string split(string $stringInput, string $pattern, int $limit = null, string $encoding = null)
 * @method static string substr(string $stringInput, int $start, int $length = null, string $encoding = null)
 * @method static string surround(string $stringInput, string $substring, string $encoding = null)
 * @method static string swapCase(string $stringInput, string $encoding = null)
 * @method static string tidy(string $stringInput, string $encoding = null)
 * @method static string titleize(string $stringInput, string $encoding = null)
 * @method static string toAscii(string $stringInput, bool $removeUnsupported = true, string $encoding = null)
 * @method static string toBoolean(string $stringInput, string $encoding = null)
 * @method static string toLowerCase(string $stringInput, string $encoding = null)
 * @method static string toSpaces(string $stringInput, int $tabLength = 4, string $encoding = null)
 * @method static string toTabs(string $stringInput, int $tabLength = 4, string $encoding = null)
 * @method static string toTitleCase(string $stringInput, string $encoding = null)
 * @method static string toUpperCase(string $stringInput, string $encoding = null)
 * @method static string trim(string $stringInput, string $chars = null, string $encoding = null)
 * @method static string trimLeft(string $stringInput, string $chars = null, string $encoding = null)
 * @method static string trimRight(string $stringInput, string $chars = null, string $encoding = null)
 * @method static string truncate(string $stringInput, int $length, string $substring = '', string $encoding = null)
 * @method static string underscored(string $stringInput, string $encoding = null)
 * @method static string upperCamelize(string $stringInput, string $encoding = null)
 * @method static string upperCaseFirst(string $stringInput, string $encoding = null)
 *
 * @package Stringy
 */
class StaticStringy
{
    /**
     * A mapping of method names to the numbers of arguments it accepts. Each
     * should be two more than the equivalent Stringy method. Necessary as
     * static methods place the optional $encoding as the last parameter.
     *
     * @var string[]
     */
    protected static $methodArgs = null;

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
     *
     * @return Stringy
     */
    public static function __callStatic($name, $arguments)
    {
        if (!static::$methodArgs) {
            $stringyClass = new \ReflectionClass('Stringy\Stringy');
            $methods = $stringyClass->getMethods(\ReflectionMethod::IS_PUBLIC);

            foreach ($methods as $method) {
                $params = $method->getNumberOfParameters() + 2;
                static::$methodArgs[$method->name] = $params;
            }
        }

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
