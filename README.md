![Stringy](http://danielstjules.com/github/stringy-logo.png)

A PHP string manipulation library with multibyte support. Compatible with PHP
5.3+, PHP 7, and HHVM. Refer to the [1.x branch](https://github.com/danielstjules/Stringy/tree/1.x)
for older documentation.

``` php
s('string')->toTitleCase()->ensureRight('y') == 'Stringy'
```

[![Build Status](https://api.travis-ci.org/danielstjules/Stringy.svg?branch=master)](https://travis-ci.org/danielstjules/Stringy)
[![Total Downloads](https://poser.pugx.org/danielstjules/stringy/downloads)](https://packagist.org/packages/danielstjules/stringy)
[![License](https://poser.pugx.org/danielstjules/stringy/license)](https://packagist.org/packages/danielstjules/stringy)

* [Why?](#why)
* [Installation](#installation)
* [OO and Chaining](#oo-and-chaining)
* [Implemented Interfaces](#implemented-interfaces)
* [PHP 5.6 Creation](#php-56-creation)
* [StaticStringy](#staticstringy)
* [Class methods](#class-methods)
    * [create](#createmixed-str--encoding-)
* [Instance methods](#instance-methods)
    * [append](#appendstring-string)
    * [at](#atint-index)
    * [between](#betweenstring-start-string-end--int-offset)
    * [camelize](#camelize)
    * [chars](#chars)
    * [collapseWhitespace](#collapsewhitespace)
    * [contains](#containsstring-needle--boolean-casesensitive--true-)
    * [containsAll](#containsallarray-needles--boolean-casesensitive--true-)
    * [containsAny](#containsanyarray-needles--boolean-casesensitive--true-)
    * [countSubstr](#countsubstrstring-substring--boolean-casesensitive--true-)
    * [dasherize](#dasherize)
    * [delimit](#delimitint-delimiter)
    * [endsWith](#endswithstring-substring--boolean-casesensitive--true-)
    * [ensureLeft](#ensureleftstring-substring)
    * [ensureRight](#ensurerightstring-substring)
    * [first](#firstint-n)
    * [getEncoding](#getencoding)
    * [hasLowerCase](#haslowercase)
    * [hasUpperCase](#hasuppercase)
    * [htmlDecode](#htmldecode)
    * [htmlEncode](#htmlencode)
    * [humanize](#humanize)
    * [indexOf](#indexofstring-needle--offset--0-)
    * [indexOfLast](#indexoflaststring-needle--offset--0-)
    * [insert](#insertint-index-string-substring)
    * [isAlpha](#isalpha)
    * [isAlphanumeric](#isalphanumeric)
    * [isBase64](#isbase64)
    * [isBlank](#isblank)
    * [isHexadecimal](#ishexadecimal)
    * [isJson](#isjson)
    * [isLowerCase](#islowercase)
    * [isSerialized](#isserialized)
    * [isUpperCase](#isuppercase)
    * [last](#last)
    * [length](#length)
    * [lines](#lines)
    * [longestCommonPrefix](#longestcommonprefixstring-otherstr)
    * [longestCommonSuffix](#longestcommonsuffixstring-otherstr)
    * [longestCommonSubstring](#longestcommonsubstringstring-otherstr)
    * [lowerCaseFirst](#lowercasefirst)
    * [pad](#padint-length--string-padstr-----string-padtype--right-)
    * [padBoth](#padbothint-length--string-padstr----)
    * [padLeft](#padleftint-length--string-padstr----)
    * [padRight](#padrightint-length--string-padstr----)
    * [prepend](#prependstring-string)
    * [regexReplace](#regexreplacestring-pattern-string-replacement--string-options--msr)
    * [removeLeft](#removeleftstring-substring)
    * [removeRight](#removerightstring-substring)
    * [repeat](#repeatmultiplier)
    * [replace](#replacestring-search-string-replacement)
    * [reverse](#reverse)
    * [safeTruncate](#safetruncateint-length--string-substring---)
    * [shuffle](#shuffle)
    * [slugify](#slugify-string-replacement----)
    * [startsWith](#startswithstring-substring--boolean-casesensitive--true-)
    * [slice](#sliceint-start--int-end-)
    * [split](#splitstring-pattern--int-limit-)
    * [substr](#substrint-start--int-length-)
    * [surround](#surroundstring-substring)
    * [swapCase](#swapcase)
    * [tidy](#tidy)
    * [titleize](#titleize-array-ignore)
    * [toAscii](#toascii)
    * [toBoolean](#toboolean)
    * [toLowerCase](#tolowercase)
    * [toSpaces](#tospaces-tablength--4-)
    * [toTabs](#totabs-tablength--4-)
    * [toTitleCase](#totitlecase)
    * [toUpperCase](#touppercase)
    * [trim](#trim-string-chars)
    * [trimLeft](#trimleft-string-chars)
    * [trimRight](#trimright-string-chars)
    * [truncate](#truncateint-length--string-substring---)
    * [underscored](#underscored)
    * [upperCamelize](#uppercamelize)
    * [upperCaseFirst](#uppercasefirst)
* [Extensions](#extensions)
* [Tests](#tests)
* [License](#license)

## Why?

In part due to a lack of multibyte support (including UTF-8) across many of
PHP's standard string functions. But also to offer an OO wrapper around the
`mbstring` module's multibyte-compatible functions. Stringy handles some quirks,
provides additional functionality, and hopefully makes strings a little easier
to work with!

```php
// Standard library
strtoupper('fòôbàř');       // 'FòôBàř'
strlen('fòôbàř');           // 10

// mbstring
mb_strtoupper('fòôbàř');    // 'FÒÔBÀŘ'
mb_strlen('fòôbàř');        // '6'

// Stringy
s('fòôbàř')->toUpperCase(); // 'FÒÔBÀŘ'
s('fòôbàř')->length();      // '6'
```

## Installation

If you're using Composer to manage dependencies, you can include the following
in your composer.json file:

```json
"require": {
    "danielstjules/stringy": "~2.3"
}
```

Then, after running `composer update` or `php composer.phar update`, you can
load the class using Composer's autoloading:

```php
require 'vendor/autoload.php';
```

Otherwise, you can simply require the file directly:

```php
require_once 'path/to/Stringy/src/Stringy.php';
```

And in either case, I'd suggest using an alias.

```php
use Stringy\Stringy as S;
```

Please note that Stringy relies on the `mbstring` module for its underlying
multibyte support. If the module is not found, Stringy will use
[symfony/polyfill-mbstring](https://github.com/symfony/polyfill-mbstring).
ex-mbstring is a non-default, but very common module. For example, with debian
and ubuntu, it's included in libapache2-mod-php5, php5-cli, and php5-fpm. For
OSX users, it's a default for any version of PHP installed with homebrew.
If compiling PHP from scratch, it can be included with the
`--enable-mbstring` flag.

## OO and Chaining

The library offers OO method chaining, as seen below:

```php
use Stringy\Stringy as S;
echo S::create('fòô     bàř')->collapseWhitespace()->swapCase(); // 'FÒÔ BÀŘ'
```

`Stringy\Stringy` has a __toString() method, which returns the current string
when the object is used in a string context, ie:
`(string) S::create('foo')  // 'foo'`

## Implemented Interfaces

`Stringy\Stringy` implements the `IteratorAggregate` interface, meaning that
`foreach` can be used with an instance of the class:

``` php
$stringy = S::create('fòôbàř');
foreach ($stringy as $char) {
    echo $char;
}
// 'fòôbàř'
```

It implements the `Countable` interface, enabling the use of `count()` to
retrieve the number of characters in the string:

``` php
$stringy = S::create('fòô');
count($stringy);  // 3
```

Furthermore, the `ArrayAccess` interface has been implemented. As a result,
`isset()` can be used to check if a character at a specific index exists. And
since `Stringy\Stringy` is immutable, any call to `offsetSet` or `offsetUnset`
will throw an exception. `offsetGet` has been implemented, however, and accepts
both positive and negative indexes. Invalid indexes result in an
`OutOfBoundsException`.

``` php
$stringy = S::create('bàř');
echo $stringy[2];     // 'ř'
echo $stringy[-2];    // 'à'
isset($stringy[-4]);  // false

$stringy[3];          // OutOfBoundsException
$stringy[2] = 'a';    // Exception
```

## PHP 5.6 Creation

As of PHP 5.6, [`use function`](https://wiki.php.net/rfc/use_function) is
available for importing functions. Stringy exposes a namespaced function,
`Stringy\create`, which emits the same behaviour as `Stringy\Stringy::create()`.
If running PHP 5.6, or another runtime that supports the `use function` syntax,
you can take advantage of an even simpler API as seen below:

``` php
use function Stringy\create as s;

// Instead of: S::create('fòô     bàř')
s('fòô     bàř')->collapseWhitespace()->swapCase();
```

## StaticStringy

All methods listed under "Instance methods" are available as part of a static
wrapper. For StaticStringy methods, the optional encoding is expected to be the
last argument. The return value is not cast, and may thus be of type Stringy,
integer, boolean, etc.

```php
use Stringy\StaticStringy as S;

// Translates to Stringy::create('fòôbàř')->slice(0, 3);
// Returns a Stringy object with the string "fòô"
S::slice('fòôbàř', 0, 3);
```

## Class methods

##### create(mixed $str [, $encoding ])

Creates a Stringy object and assigns both str and encoding properties
the supplied values. $str is cast to a string prior to assignment, and if
$encoding is not specified, it defaults to mb_internal_encoding(). It
then returns the initialized object. Throws an InvalidArgumentException
if the first argument is an array or object without a __toString method.

```php
$stringy = S::create('fòôbàř'); // 'fòôbàř'
```

## Instance Methods

Stringy objects are immutable. All examples below make use of PHP 5.6
function importing, and PHP 5.4 short array syntax. They also assume the
encoding returned by mb_internal_encoding() is UTF-8. For further details,
see the documentation for the create method above, as well as the notes
on PHP 5.6 creation.

##### append(string $string)

Returns a new string with $string appended.

```php
s('fòô')->append('bàř'); // 'fòôbàř'
```

##### at(int $index)

Returns the character at $index, with indexes starting at 0.

```php
s('fòôbàř')->at(3); // 'b'
```

##### between(string $start, string $end [, int $offset])

Returns the substring between $start and $end, if found, or an empty
string. An optional offset may be supplied from which to begin the
search for the start string.

```php
s('{foo} and {bar}')->between('{', '}'); // 'foo'
```

##### camelize()

Returns a camelCase version of the string. Trims surrounding spaces,
capitalizes letters following digits, spaces, dashes and underscores,
and removes spaces, dashes, as well as underscores.

```php
s('Camel-Case')->camelize(); // 'camelCase'
```

##### chars()

Returns an array consisting of the characters in the string.

```php
s('fòôbàř')->chars(); // ['f', 'ò', 'ô', 'b', 'à', 'ř']
```

##### collapseWhitespace()

Trims the string and replaces consecutive whitespace characters with a
single space. This includes tabs and newline characters, as well as
multibyte whitespace such as the thin space and ideographic space.

```php
s('   Ο     συγγραφέας  ')->collapseWhitespace(); // 'Ο συγγραφέας'
```

##### contains(string $needle [, boolean $caseSensitive = true ])

Returns true if the string contains $needle, false otherwise. By default,
the comparison is case-sensitive, but can be made insensitive
by setting $caseSensitive to false.

```php
s('Ο συγγραφέας είπε')->contains('συγγραφέας'); // true
```

##### containsAll(array $needles [, boolean $caseSensitive = true ])

Returns true if the string contains all $needles, false otherwise. By
default the comparison is case-sensitive, but can be made insensitive by
setting $caseSensitive to false.

```php
s('foo & bar')->containsAll(['foo', 'bar']); // true
```

##### containsAny(array $needles [, boolean $caseSensitive = true ])

Returns true if the string contains any $needles, false otherwise. By
default the comparison is case-sensitive, but can be made insensitive by
setting $caseSensitive to false.

```php
s('str contains foo')->containsAny(['foo', 'bar']); // true
```

##### countSubstr(string $substring [, boolean $caseSensitive = true ])

Returns the number of occurrences of $substring in the given string.
By default, the comparison is case-sensitive, but can be made insensitive
by setting $caseSensitive to false.

```php
s('Ο συγγραφέας είπε')->countSubstr('α'); // 2
```

##### dasherize()

Returns a lowercase and trimmed string separated by dashes. Dashes are
inserted before uppercase characters (with the exception of the first
character of the string), and in place of spaces as well as underscores.

```php
s('fooBar')->dasherize(); // 'foo-bar'
```

##### delimit(int $delimiter)

Returns a lowercase and trimmed string separated by the given delimiter.
Delimiters are inserted before uppercase characters (with the exception
of the first character of the string), and in place of spaces, dashes,
and underscores. Alpha delimiters are not converted to lowercase.

```php
s('fooBar')->delimit('::'); // 'foo::bar'
```

##### endsWith(string $substring [, boolean $caseSensitive = true ])

Returns true if the string ends with $substring, false otherwise. By
default, the comparison is case-sensitive, but can be made insensitive by
setting $caseSensitive to false.

```php
s('fòôbàř')->endsWith('bàř', true); // true
```

##### ensureLeft(string $substring)

Ensures that the string begins with $substring. If it doesn't, it's prepended.

```php
s('foobar')->ensureLeft('http://'); // 'http://foobar'
```

##### ensureRight(string $substring)

Ensures that the string ends with $substring. If it doesn't, it's appended.

```php
s('foobar')->ensureRight('.com'); // 'foobar.com'
```

##### first(int $n)

Returns the first $n characters of the string.

```php
s('fòôbàř')->first(3); // 'fòô'
```

##### getEncoding()

Returns the encoding used by the Stringy object.

```php
s('fòôbàř')->getEncoding(); // 'UTF-8'
```

##### hasLowerCase()

Returns true if the string contains a lower case char, false otherwise.

```php
s('fòôbàř')->hasLowerCase(); // true
```

##### hasUpperCase()

Returns true if the string contains an upper case char, false otherwise.

```php
s('fòôbàř')->hasUpperCase(); // false
```

##### htmlDecode()

Convert all HTML entities to their applicable characters. An alias of
html_entity_decode. For a list of flags, refer to
http://php.net/manual/en/function.html-entity-decode.php

```php
s('&amp;')->htmlDecode(); // '&'
```

##### htmlEncode()

Convert all applicable characters to HTML entities. An alias of
htmlentities. Refer to http://php.net/manual/en/function.htmlentities.php
for a list of flags.

```php
s('&')->htmlEncode(); // '&amp;'
```

##### humanize()

Capitalizes the first word of the string, replaces underscores with
spaces, and strips '_id'.

```php
s('author_id')->humanize(); // 'Author'
```

##### indexOf(string $needle [, $offset = 0 ]);

Returns the index of the first occurrence of $needle in the string,
and false if not found. Accepts an optional offset from which to begin
the search. A negative index searches from the end

```php
s('string')->indexOf('ing'); // 3
```

##### indexOfLast(string $needle [, $offset = 0 ]);

Returns the index of the last occurrence of $needle in the string,
and false if not found. Accepts an optional offset from which to begin
the search. Offsets may be negative to count from the last character
in the string.

```php
s('foobarfoo')->indexOfLast('foo'); // 10
```

##### insert(int $index, string $substring)

Inserts $substring into the string at the $index provided.

```php
s('fòôbř')->insert('à', 4); // 'fòôbàř'
```

##### isAlpha()

Returns true if the string contains only alphabetic chars, false otherwise.

```php
s('丹尼爾')->isAlpha(); // true
```

##### isAlphanumeric()

Returns true if the string contains only alphabetic and numeric chars, false
otherwise.

```php
s('دانيال1')->isAlphanumeric(); // true
```

##### isBase64()

Returns true if the string is base64 encoded, false otherwise.

```php
s('Zm9vYmFy')->isBase64(); // true
```

##### isBlank()

Returns true if the string contains only whitespace chars, false otherwise.

```php
s("\n\t  \v\f")->isBlank(); // true
```

##### isHexadecimal()

Returns true if the string contains only hexadecimal chars, false otherwise.

```php
s('A102F')->isHexadecimal(); // true
```

##### isJson()

Returns true if the string is JSON, false otherwise. Unlike json_decode
in PHP 5.x, this method is consistent with PHP 7 and other JSON parsers,
in that an empty string is not considered valid JSON.

```php
s('{"foo":"bar"}')->isJson(); // true
```

##### isLowerCase()

Returns true if the string contains only lower case chars, false otherwise.

```php
s('fòôbàř')->isLowerCase(); // true
```

##### isSerialized()

Returns true if the string is serialized, false otherwise.

```php
s('a:1:{s:3:"foo";s:3:"bar";}')->isSerialized(); // true
```

##### isUpperCase()

Returns true if the string contains only upper case chars, false otherwise.

```php
s('FÒÔBÀŘ')->isUpperCase(); // true
```

##### last(int $n)

Returns the last $n characters of the string.

```php
s('fòôbàř')->last(3); // 'bàř'
```

##### length()

Returns the length of the string. An alias for PHP's mb_strlen() function.

```php
s('fòôbàř')->length(); // 6
```

##### lines()

Splits on newlines and carriage returns, returning an array of Stringy
objects corresponding to the lines in the string.

```php
s("fòô\r\nbàř\n")->lines(); // ['fòô', 'bàř', '']
```

##### longestCommonPrefix(string $otherStr)

Returns the longest common prefix between the string and $otherStr.

```php
s('foobar')->longestCommonPrefix('foobaz'); // 'fooba'
```

##### longestCommonSuffix(string $otherStr)

Returns the longest common suffix between the string and $otherStr.

```php
s('fòôbàř')->longestCommonSuffix('fòrbàř'); // 'bàř'
```

##### longestCommonSubstring(string $otherStr)

Returns the longest common substring between the string and $otherStr. In the
case of ties, it returns that which occurs first.

```php
s('foobar')->longestCommonSubstring('boofar'); // 'oo'
```

##### lowerCaseFirst()

Converts the first character of the supplied string to lower case.

```php
s('Σ foo')->lowerCaseFirst(); // 'σ foo'
```

##### pad(int $length [, string $padStr = ' ' [, string $padType = 'right' ]])

Pads the string to a given length with $padStr. If length is less than
or equal to the length of the string, no padding takes places. The default
string used for padding is a space, and the default type (one of 'left',
'right', 'both') is 'right'. Throws an InvalidArgumentException if
$padType isn't one of those 3 values.

```php
s('fòôbàř')->pad(9, '-/', 'left'); // '-/-fòôbàř'
```

##### padBoth(int $length [, string $padStr = ' ' ])

Returns a new string of a given length such that both sides of the string
string are padded. Alias for pad() with a $padType of 'both'.

```php
s('foo bar')->padBoth(9, ' '); // ' foo bar '
```

##### padLeft(int $length [, string $padStr = ' ' ])

Returns a new string of a given length such that the beginning of the
string is padded. Alias for pad() with a $padType of 'left'.

```php
s('foo bar')->padLeft(9, ' '); // '  foo bar'
```

##### padRight(int $length [, string $padStr = ' ' ])

Returns a new string of a given length such that the end of the string is
padded. Alias for pad() with a $padType of 'right'.

```php
s('foo bar')->padRight(10, '_*'); // 'foo bar_*_'
```

##### prepend(string $string)

Returns a new string starting with $string.

```php
s('bàř')->prepend('fòô'); // 'fòôbàř'
```

##### regexReplace(string $pattern, string $replacement [, string $options = 'msr'])

Replaces all occurrences of $pattern in $str by $replacement. An alias
for mb_ereg_replace(). Note that the 'i' option with multibyte patterns
in mb_ereg_replace() requires PHP 5.6+ for correct results. This is due
to a lack of support in the bundled version of Oniguruma in PHP < 5.6,
and current versions of HHVM (3.8 and below).

```php
s('fòô ')->regexReplace('f[òô]+\s', 'bàř'); // 'bàř'
s('fò')->regexReplace('(ò)', '\\1ô'); // 'fòô'
```

##### removeLeft(string $substring)

Returns a new string with the prefix $substring removed, if present.

```php
s('fòôbàř')->removeLeft('fòô'); // 'bàř'
```

##### removeRight(string $substring)

Returns a new string with the suffix $substring removed, if present.

```php
s('fòôbàř')->removeRight('bàř'); // 'fòô'
```

##### repeat(int $multiplier)

Returns a repeated string given a multiplier. An alias for str_repeat.

```php
s('α')->repeat(3); // 'ααα'
```

##### replace(string $search, string $replacement)

Replaces all occurrences of $search in $str by $replacement.

```php
s('fòô bàř fòô bàř')->replace('fòô ', ''); // 'bàř bàř'
```

##### reverse()

Returns a reversed string. A multibyte version of strrev().

```php
s('fòôbàř')->reverse(); // 'řàbôòf'
```

##### safeTruncate(int $length [, string $substring = '' ])

Truncates the string to a given length, while ensuring that it does not
split words. If $substring is provided, and truncating occurs, the
string is further truncated so that the substring may be appended without
exceeding the desired length.

```php
s('What are your plans today?')->safeTruncate(22, '...');
// 'What are your plans...'
```

##### shuffle()

A multibyte str_shuffle() function. It returns a string with its characters in
random order.

```php
s('fòôbàř')->shuffle(); // 'àôřbòf'
```

##### slugify([, string $replacement = '-' ])

Converts the string into an URL slug. This includes replacing non-ASCII
characters with their closest ASCII equivalents, removing remaining
non-ASCII and non-alphanumeric characters, and replacing whitespace with
$replacement. The replacement defaults to a single dash, and the string
is also converted to lowercase.

```php
s('Using strings like fòô bàř')->slugify(); // 'using-strings-like-foo-bar'
```

##### startsWith(string $substring [, boolean $caseSensitive = true ])

Returns true if the string begins with $substring, false otherwise.
By default, the comparison is case-sensitive, but can be made insensitive
by setting $caseSensitive to false.

```php
s('FÒÔbàřbaz')->startsWith('fòôbàř', false); // true
```

##### slice(int $start [, int $end ])

Returns the substring beginning at $start, and up to, but not including
the index specified by $end. If $end is omitted, the function extracts
the remaining string. If $end is negative, it is computed from the end
of the string.

```php
s('fòôbàř')->slice(3, -1); // 'bà'
```

##### split(string $pattern [, int $limit ])

Splits the string with the provided regular expression, returning an
array of Stringy objects. An optional integer $limit will truncate the
results.

```php
s('foo,bar,baz')->split(',', 2); // ['foo', 'bar']
```

##### substr(int $start [, int $length ])

Returns the substring beginning at $start with the specified $length.
It differs from the mb_substr() function in that providing a $length of
null will return the rest of the string, rather than an empty string.

```php
s('fòôbàř')->substr(2, 3); // 'ôbà'
```

##### surround(string $substring)

Surrounds a string with the given substring.

```php
s(' ͜ ')->surround('ʘ'); // 'ʘ ͜ ʘ'
```

##### swapCase()

Returns a case swapped version of the string.

```php
s('Ντανιλ')->swapCase(); // 'νΤΑΝΙΛ'
```

##### tidy()

Returns a string with smart quotes, ellipsis characters, and dashes from
Windows-1252 (commonly used in Word documents) replaced by their ASCII equivalents.

```php
s('“I see…”')->tidy(); // '"I see..."'
```

##### titleize([, array $ignore])

Returns a trimmed string with the first letter of each word capitalized.
Also accepts an array, $ignore, allowing you to list words not to be
capitalized.

```php
$ignore = ['at', 'by', 'for', 'in', 'of', 'on', 'out', 'to', 'the'];
s('i like to watch television')->titleize($ignore);
// 'I Like to Watch Television'
```

##### toAscii()

Returns an ASCII version of the string. A set of non-ASCII characters are
replaced with their closest ASCII counterparts, and the rest are removed
unless instructed otherwise.

```php
s('fòôbàř')->toAscii(); // 'foobar'
```

##### toBoolean()

Returns a boolean representation of the given logical string value.
For example, 'true', '1', 'on' and 'yes' will return true. 'false', '0',
'off', and 'no' will return false. In all instances, case is ignored.
For other numeric strings, their sign will determine the return value.
In addition, blank strings consisting of only whitespace will return
false. For all other strings, the return value is a result of a
boolean cast.

```php
s('OFF')->toBoolean(); // false
```

##### toLowerCase()

Converts all characters in the string to lowercase. An alias for PHP's
mb_strtolower().

```php
s('FÒÔBÀŘ')->toLowerCase(); // 'fòôbàř'
```

##### toSpaces([, tabLength = 4 ])

Converts each tab in the string to some number of spaces, as defined by
$tabLength. By default, each tab is converted to 4 consecutive spaces.

```php
s(' String speech = "Hi"')->toSpaces(); // '    String speech = "Hi"'
```

##### toTabs([, tabLength = 4 ])

Converts each occurrence of some consecutive number of spaces, as defined
by $tabLength, to a tab. By default, each 4 consecutive spaces are
converted to a tab.

```php
s('    fòô    bàř')->toTabs();
// '   fòô bàř'
```

##### toTitleCase()

Converts the first character of each word in the string to uppercase.

```php
s('fòô bàř')->toTitleCase(); // 'Fòô Bàř'
```

##### toUpperCase()

Converts all characters in the string to uppercase. An alias for PHP's
mb_strtoupper().

```php
s('fòôbàř')->toUpperCase(); // 'FÒÔBÀŘ'
```

##### trim([, string $chars])

Returns a string with whitespace removed from the start and end of the
string. Supports the removal of unicode whitespace. Accepts an optional
string of characters to strip instead of the defaults.

```php
s('  fòôbàř  ')->trim(); // 'fòôbàř'
```

##### trimLeft([, string $chars])

Returns a string with whitespace removed from the start of the string.
Supports the removal of unicode whitespace. Accepts an optional
string of characters to strip instead of the defaults.

```php
s('  fòôbàř  ')->trimLeft(); // 'fòôbàř  '
```

##### trimRight([, string $chars])

Returns a string with whitespace removed from the end of the string.
Supports the removal of unicode whitespace. Accepts an optional
string of characters to strip instead of the defaults.

```php
s('  fòôbàř  ')->trimRight(); // '  fòôbàř'
```

##### truncate(int $length [, string $substring = '' ])

Truncates the string to a given length. If $substring is provided, and
truncating occurs, the string is further truncated so that the substring
may be appended without exceeding the desired length.

```php
s('What are your plans today?')->truncate(19, '...'); // 'What are your pl...'
```

##### underscored()

Returns a lowercase and trimmed string separated by underscores.
Underscores are inserted before uppercase characters (with the exception
of the first character of the string), and in place of spaces as well as dashes.

```php
s('TestUCase')->underscored(); // 'test_u_case'
```

##### upperCamelize()

Returns an UpperCamelCase version of the supplied string. It trims
surrounding spaces, capitalizes letters following digits, spaces, dashes
and underscores, and removes spaces, dashes, underscores.

```php
s('Upper Camel-Case')->upperCamelize(); // 'UpperCamelCase'
```

##### upperCaseFirst()

Converts the first character of the supplied string to upper case.

```php
s('σ foo')->upperCaseFirst(); // 'Σ foo'
```

## Extensions

The following is a list of libraries that extend Stringy:

 * [SliceableStringy](https://github.com/danielstjules/SliceableStringy):
Python-like string slices in PHP
 * [SubStringy](https://github.com/TCB13/SubStringy):
Advanced substring methods

## Tests

From the project directory, tests can be ran using `phpunit`

## License

Released under the MIT License - see `LICENSE.txt` for details.
