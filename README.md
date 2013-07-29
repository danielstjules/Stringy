# Stringy

A PHP library with a variety of string manipulation functions with multibyte support. Offers both OO method chaining and a procedural-style static wrapper. Compatible with PHP 5.3+. Inspired by underscore.string.js.

[![Build Status](https://travis-ci.org/danielstjules/Stringy.png)](https://travis-ci.org/danielstjules/Stringy)
[![Total Downloads](https://poser.pugx.org/danielstjules/Stringy/downloads.png)](https://packagist.org/packages/danielstjules/stringy)
[![Latest Stable Version](https://poser.pugx.org/danielstjules/Stringy/v/stable.png)](https://packagist.org/packages/danielstjules/stringy)

* [Requiring/Loading](#requiringloading)
* [OO and Procedural](#oo-and-procedural)
* [Methods](#methods)
    * [at](#at)
    * [camelize](#camelize)
    * [collapseWhitespace](#collapsewhitespace)
    * [contains](#contains)
    * [count](#count)
    * [create](#create)
    * [dasherize](#dasherize)
    * [endsWith](#endswith)
    * [ensureLeft](#ensureleft)
    * [ensureRight](#ensureright)
    * [first](#first)
    * [humanize](#humanize)
    * [insert](#insert)
    * [isAlpha](#isalpha)
    * [isAlphanumeric](#isalphanumeric)
    * [isBlank](#isblank)
    * [isLowerCase](#islowercase)
    * [isUpperCase](#isuppercase)
    * [last](#last)
    * [length](#length)
    * [longestCommonPrefix](#longestcommonprefix)
    * [longestCommonSuffix](#longestcommonsuffix)
    * [longestCommonSubstring](#longestcommonsubstring)
    * [lowerCaseFirst](#lowercasefirst)
    * [pad](#pad)
    * [padBoth](#padboth)
    * [padLeft](#padleft)
    * [padRight](#padright)
    * [removeLeft](#removeleft)
    * [removeRight](#removeright)
    * [replace](#replace)
    * [reverse](#reverse)
    * [safeTruncate](#safetruncate)
    * [shuffle](#shuffle)
    * [slugify](#slugify)
    * [standardize](#standardize)
    * [startsWith](#startswith)
    * [substr](#substr)
    * [surround](#surround)
    * [swapCase](#swapcase)
    * [tidy](#tidy)
    * [titleize](#titleize)
    * [toSpaces](#tospaces)
    * [toTabs](#totabs)
    * [trim](#trim)
    * [truncate](#truncate)
    * [underscored](#underscored)
    * [upperCamelize](#uppercamelize)
    * [upperCaseFirst](#uppercasefirst)
* [Tests](#tests)
* [License](#license)

## Requiring/Loading

If you're using Composer to manage dependencies, you can include the following in your composer.json file:

    "require": {
        "danielstjules/stringy": "dev-master"
    }

Then, after running `composer update` or `php composer.phar update`, you can load the class using Composer's autoloading:

```php
require 'vendor/autoload.php';
```

Otherwise, you can simply require the file directly:

```php
require_once 'path/to/Stringy/src/Stringy/Stringy.php';
// or
require_once 'path/to/Stringy/src/Stringy/StaticStringy.php';
```

And in either case, I'd suggest using an alias.

```php
use Stringy\Stringy as S;
// or
use Stringy\StaticStringy as S;
```

## OO and Procedural

The library offers both OO method chaining with `Stringy\Stringy`, as well as
procedural-style static method calls with `Stringy\StaticStringy`. An example
of the former is the following:

```php
use Stringy\Stringy as S;
echo S::create("Fòô     Bàř", 'UTF-8')->collapseWhitespace()->swapCase();  // 'fÒÔ bÀŘ'
```

`Stringy\Stringy` contains a __toString() method, which returns the current
string when the object is used in a string context. Its $str property is also
public, and can be accessed directly if required, ie: `S::create('foo')->str  // 'foo'`

Using the static wrapper, an alternative is the following:

```php
use Stringy\StaticStringy as S;
$string = S::collapseWhitespace("Fòô     Bàř", 'UTF-8');
echo S::swapCase($string, 'UTF-8');  // 'fÒÔ bÀŘ''
```

## Methods

In the list below, any static method other than S::create refers to a
method in Stringy\StaticStringy. For all others, they're found in Stringy\Stringy. Furthermore, all methods that return an object of type Stringy return a new object, and do not modify the original.

*Note: If $encoding is not given, it defaults to mb_internal_encoding().*

#### at

$stringy->at(int $index)

S::substr(int $index [, string $encoding ])

Gets the character of $str at $index, with indexes starting at 0.

```php
S::create('fòô bàř', 'UTF-8')->at(6);
S::at('fòô bàř', 6, 'UTF-8');  // 'ř'
```

#### camelize

$stringy->camelize();

S::camelize(string $str [, string $encoding ])

Returns a camelCase version of a supplied string, with multibyte support.
Trims surrounding spaces, capitalizes letters following digits, spaces,
dashes and underscores, and removes spaces, dashes, underscores.

```php
S::create('Camel-Case')->camelize();
S::camelize('Camel-Case');  // 'camelCase'
```

#### collapseWhitespace

$stringy->collapseWhitespace()

S::collapseWhitespace(string $str)

Trims the string and replaces consecutive whitespace characters with a
single space. This inclues tabs and newline characters.

```php
S::create('   Ο     συγγραφέας  ')->collapseWhitespace();
S::collapseWhitespace('   Ο     συγγραφέας  ');  // 'Ο συγγραφέας'
```

#### contains

$stringy->contains(string $needle)

S::contains(string $haystack, string $needle [, string $encoding ])

Returns true if $haystack contains $needle, false otherwise.

```php
S::create('Ο συγγραφέας είπε', 'UTF-8')->contains('συγγραφέας');
S::contains('Ο συγγραφέας είπε', 'συγγραφέας', 'UTF-8');  // true
```

#### count

$stringy->count(string $substring)

S::count(string $str, string $substring [, string $encoding ])

Returns the number of occurences of $substring in $str. An alias for
mb_substr_count()

```php
S::create('Ο συγγραφέας είπε', 'UTF-8')->count('α');
S::count('Ο συγγραφέας είπε', 'α', 'UTF-8');  // 2
```

#### create

$stringy = S::create(string $str, [, $encoding ])

Creates a Stringy object and assigns both str and encoding properties
the supplied values. If $encoding is not specified, it defaults to
mb_internal_encoding(). It then returns the instantiated object.

```php
S::create('fòô bàř', 'UTF-8');  // 'fòô bàř'
```

#### dasherize

$stringy->dasherize();

S::dasherize(string $str [, string $encoding ])

Returns a lowercase and trimmed string seperated by dashes, with
multibyte support. Dashes are inserted before uppercase characters
(with the exception of the first character of the string), and in place
of spaces as well as underscores.

```php
S::create('TestDCase')->dasherize();
S::dasherize('TestDCase');  // 'test-d-case'
```

#### endsWith

$stringy->endsWith(string $substring [, boolean $caseSensitive = true ])

S::endsWith(string $str, string $substring [, boolean $caseSensitive = true [, string $encoding ]])

Returns true if the string $str ends with $substring, false otherwise.
By default, the comparison is case-sensitive, but can be made insensitive
by setting $caseSensitive to false.

```php
S::create('FÒÔ bàřs', 'UTF-8')->endsWith('àřs', true);
S::endsWith('FÒÔ bàřs', 'àřs', true, 'UTF-8');  // true
```

#### ensureLeft

$stringy->ensureLeft(string $substring)

S::ensureLeft(string $substring [, string $encoding ])

Ensures that $str begins with $substring.

```php
S::create('foobar')->ensureLeft('http://');
S::ensureLeft('foobar', 'http://');  // 'http://foobar'
```

#### ensureRight

$stringy->ensureRight(string $substring)

S::ensureRight(string $substring [, string $encoding ])

Ensures that $str ends with $substring.

```php
S::create('foobar')->ensureRight('.com');
S::ensureRight('foobar', '.com');  // 'foobar.com'
```

#### first

$stringy->first(int $n)

S::first(int $n [, string $encoding ])

Gets the first $n characters of $str.

```php
S::create('fòô bàř', 'UTF-8')->first(3);
S::first('fòô bàř', 3, 'UTF-8');  // 'fòô'
```

#### humanize

$stringy->humanize()

S::humanize(string $str [, string $encoding ])

Capitalizes the first word of a string, replaces underscores with spaces,
and strips '_id'.

```php
S::create('author_id')->humanize();
S::humanize('author_id');  // 'Author'
```

#### insert

$stringy->insert(int $index, string $substring)

S::insert(string $str, int $index, string $substring [, string $encoding ])

Inserts $substring into $str at the $index provided.

```php
S::create('fòô bà', 'UTF-8')->insert('ř', 6);
S::insert('fòô bà', 'ř', 6, 'UTF-8');  // 'fòô bàř'
```

#### isAlpha

$stringy->isAlpha()

S::isAlpha(string $str [, string $encoding ])

Returns true if $str contains only alphabetic chars, false otherwise.

```php
S::create('丹尼爾', 'UTF-8')->isAlpha();
S::isAlpha('丹尼爾', 'UTF-8');  // true
```

#### isAlphanumeric

$stringy->isAlphanumeric()

S::isAlphanumeric(string $str [, string $encoding ])

Returns true if $str contains only alphabetic and numeric chars, false
otherwise.

```php
S::create('دانيال1', 'UTF-8')->isAlphanumeric();
S::isAlphanumeric('دانيال1', 'UTF-8');  // true
```

#### isBlank

$stringy->isBlank()

S::isBlank(string $str [, string $encoding ])

Returns true if $str contains only whitespace chars, false otherwise.

```php
S::create("\n\t  \v\f")->isBlank();
S::isBlank("\n\t  \v\f");  // true
```

#### isLowerCase

$stringy->isLowerCase()

S::isLowerCase(string $str [, string $encoding ])

Returns true if $str contains only lower case chars, false otherwise.

```php
S::create('fòô bàř', 'UTF-8')->isLowerCase();
S::isLowerCase('fòô bàř', 'UTF-8');  // true
```

#### isUpperCase

$stringy->isUpperCase()

S::isUpperCase(string $str [, string $encoding ])

Returns true if $str contains only upper case chars, false otherwise.

```php
S::create('FÒÔBÀŘ',, 'UTF-8')->isUpperCase();
S::isUpperCase('FÒÔBÀŘ',, 'UTF-8');  // true
```

#### last

$stringy->last(int $n)

S::last(int $n [, string $encoding ])

Gets the last $n characters of $str.

```php
S::create('fòô bàř', 'UTF-8')->last(3);
S::last('fòô bàř', 3, 'UTF-8');  // 'bàř'
```

#### length

$stringy->length()

S::length(string $str [, string $encoding ])

Returns the length of $str. An alias for PHP's mb_strlen() function.

```php
S::create('fòô bàř', 'UTF-8')->length();
S::length('fòô bàř', 'UTF-8');  // 7
```

#### longestCommonPrefix

$stringy->longestCommonPrefix(string $otherStr)

S::longestCommonPrefix(string $str, string $otherStr [, $encoding ])

Finds the longest common prefix between $str and $otherStr.

```php
S::create('fòô bar', 'UTF-8')->longestCommonPrefix('fòr bar');
S::longestCommonPrefix('fòô bar', 'fòr bar', 'UTF-8');  // 'fò'
```

#### longestCommonSuffix

$stringy->longestCommonSuffix(string $otherStr)

S::longestCommonSuffix(string $str, string $otherStr [, $encoding ])

Finds the longest common suffix between $str and $otherStr.

```php
S::create('fòô bàř', 'UTF-8')->longestCommonSuffix('fòr bàř');
S::longestCommonSuffix('fòô bàř', 'fòr bàř', 'UTF-8');  // ' bàř'
```

#### longestCommonSubstring

$stringy->longestCommonSubstring(string $otherStr)

S::longestCommonSubstring(string $str, string $otherStr [, $encoding ])

Finds the longest common substring between $str and $otherStr. In the
case of ties, returns that which occurs first.

```php
S::create('foo bar')->longestCommonSubstring('boo far');
S::longestCommonSubstring('foo bar', 'boo far');  // 'oo '
```

#### lowerCaseFirst

$stringy->lowerCaseFirst();

S::lowerCaseFirst(string $str [, string $encoding ])

Converts the first character of the supplied string to lower case, with
support for multibyte strings.

```php
S::create('Σ test', 'UTF-8')->lowerCaseFirst();
S::lowerCaseFirst('Σ test', 'UTF-8');  // 'σ test'
```

#### pad

$stringy->pad(int $length [, string $padStr = ' ' [, string $padType = 'right' ]])

S::pad(string $str , int $length [, string $padStr = ' ' [, string $padType = 'right' [, string $encoding ]]])

Pads a string to a given length with another string. If length is less
than or equal to the length of $str, then no padding takes places. The
default string used for padding is a space, and the default type (one of
'left', 'right', 'both') is 'right'. Throws an exception if $padType
isn't one of those 3 values.

```php
S::create('fòô bàř', 'UTF-8')->pad( 10, '¬ø', 'left',);
S::pad('fòô bàř', 10, '¬ø', 'left', 'UTF-8');  // '¬ø¬fòô bàř'
```

#### padBoth

$stringy->padBoth(int $length [, string $padStr = ' ' ])

S::padBoth(string $str , int $length [, string $padStr = ' ' [, string $encoding ]])

Returns a new string of a given length such that both sides of the string
string are padded. Alias for pad($str, $length, $padStr, 'both', $encoding)

```php
S::create('foo bar')->padBoth(9, ' ');
S::padBoth('foo bar', 9, ' ');  // ' foo bar '
```

#### padLeft

$stringy->padLeft(int $length [, string $padStr = ' ' ])

S::padLeft(string $str , int $length [, string $padStr = ' ' [, string $encoding ]])

Returns a new string of a given length such that the beginning of the
string is padded. Alias for pad($str, $length, $padStr, 'left', $encoding)

```php
S::create($str, $encoding)->padLeft($length, $padStr);
S::padLeft('foo bar', 9, ' ');  // '  foo bar'
```

#### padRight

$stringy->padRight(int $length [, string $padStr = ' ' ])

S::padRight(string $str , int $length [, string $padStr = ' ' [, string $encoding ]])

Returns a new string of a given length such that the end of the string is
padded. Alias for pad($str, $length, $padStr, 'right', $encoding)

```php
S::create('foo bar')->padRight(10, '_*');
S::padRight('foo bar', 10, '_*');  // 'foo bar_*_'
```

#### removeLeft

$stringy->removeLeft(string $substring)

S::removeLeft(string $str, string $substring [, string $encoding ])

Removes the prefix $substring if present.

```php
S::create('fòô bàř', 'UTF-8')->removeLeft('fòô ');
S::removeLeft('fòô bàř', 'fòô ', 'UTF-8');  // 'bàř'
```

#### removeRight

$stringy->removeRight(string $substring)

S::removeRight(string $str, string $substring [, string $encoding ])

Removes the suffix $substring if present.

```php
S::create('fòô bàř', 'UTF-8')->removeRight(' bàř');
S::removeRight('fòô bàř', ' bàř', 'UTF-8');  // 'fòô'
```

#### replace

$stringy->replace(string $search, string $replace)

S::replace(string $str, string $search, string $replace [, string $encoding ])

Replaces all occurrences of $search with $replace in $str.

```php
S::create('fòô bàř fòô bàř', 'UTF-8')->replace('fòô ', '');
S::replace('fòô bàř fòô bàř', 'fòô ', '', 'UTF-8');  // 'bàř bàř'
```

#### reverse

$stringy->reverse()

S::reverse(string $str, [, string $encoding ])

Reverses a string. A multibyte version of strrev.

```php
S::create('fòô bàř', 'UTF-8')->reverse();
S::reverse('fòô bàř', 'UTF-8');  // 'řàb ôòf'
```

#### safeTruncate

$stringy->safeTruncate(int $length, [, string $substring = '' ])

S::safeTruncate(string $str, int $length, [, string $substring = '' [, string $encoding ]])

Truncates the string to a given length, while ensuring that it does not
chop words. If $substring is provided, and truncating occurs, the string
is further truncated so that the substring may be appended without
exceeding the desired length.

```php
S::create('What are your plans today?')->safeTruncate(22, '...');
S::safeTruncate('What are your plans today?', 22, '...');  // 'What are your plans...'
```

#### shuffle

$stringy->shuffle()

S::shuffle(string $str [, string $encoding ])

A multibyte str_shuffle function. It randomizes the order of characters
in a string.

```php
S::create('fòô bàř', 'UTF-8')->shuffle();
S::shuffle('fòô bàř', 'UTF-8');  // 'àôřb òf'
```

#### slugify

$stringy->slugify()

S::slugify(string $str)

Converts the supplied text into an URL slug. This includes replacing
non-ASCII characters with their closest ASCII equivalents, removing
non-alphanumeric and non-ASCII characters, and replacing whitespace with
dashes. The string is also converted to lowercase.

```php
S::create('Using strings like fòô bàř')->slugify();
S::slugify('Using strings like fòô bàř');  // 'using-strings-like-foo-bar'
```

#### standardize

$stringy->standardize()

S::standardize(string $str)

Converts some non-ASCII characters to their closest ASCII counterparts.

```php
S::create('fòô bàř')->standardize();
S::standardize('fòô bàř');  // 'foo bar'
```

#### startsWith

$stringy->startsWith(string $substring [, boolean $caseSensitive = true ])

S::startsWith(string $str, string $substring [, boolean $caseSensitive = true [, string $encoding ]])

Returns true if the string $str begins with $substring, false otherwise.
By default, the comparison is case-sensitive, but can be made insensitive
by setting $caseSensitive to false.

```php
S::create('FÒÔ bàřs', 'UTF-8')->startsWith('fòô bàř', false);
S::startsWith('FÒÔ bàřs', 'fòô bàř', false, 'UTF-8');  // true
```

#### substr

$stringy->substr(int $start [, int $length ])

S::substr(string $str, int $start [, int $length [, string $encoding ]])

Gets the substring of $str beginning at $start with the specified $length.
It differs from the mb_substr() function in that providing a $length of
null will return the rest of the string, rather than an empty string.

```php
S::create('fòô bàř', 'UTF-8')->substr(2, 3);
S::substr('fòô bàř', 2, 3, 'UTF-8');  // 'ô b'
```

#### surround

$stringy->surround(string $substring)

S::surround(string $str, string $substring)

Surrounds a string with the given substring.

```php
S::create(' ͜ ')->surround('ʘ');
S::surround(' ͜ ', 'ʘ');  // 'ʘ ͜ ʘ'
```

#### swapCase

$stringy->swapCase();

S::swapCase(string $str [, string $encoding ])

Returns a case swapped version of a string.

```php
S::create('Ντανιλ', 'UTF-8')->swapCase();
S::swapCase('Ντανιλ', 'UTF-8');  // 'νΤΑΝΙΛ'
```

#### tidy

$stringy->tidy()

S::tidy(string $str)

Replaces smart quotes, ellipsis characters, and dashes from Windows-1252
(and commonly used in Word documents) with their ASCII equivalents.

```php
S::create('“I see…”')->tidy();
S::tidy('“I see…”');  // '"I see..."'
```

#### titleize

$stringy->titleize([ string $encoding ])

S::titleize(string $str [, array $ignore [, string $encoding ]])

Capitalizes the first letter of each word in a string, after trimming.
Ignores the case of other letters, allowing for the use of acronyms.
Also accepts an array, $ignore, allowing you to list words not to be
capitalized.

```php
$ignore = array('at', 'by', 'for', 'in', 'of', 'on', 'out', 'to', 'the');
S::create('i like to watch DVDs at home', 'UTF-8')->titleize($ignore);
S::titleize('i like to watch DVDs at home', $ignore, 'UTF-8');
// 'I Like to Watch DVDs at Home'
```

#### toSpaces

$stringy->toSpaces([ tabLength = 4 ])

S::toSpaces(string $str, [, int $tabLength = 4 ])

Converts each tab in a string to some number of spaces, as defined by
$tabLength. By default, each tab is converted to 4 consecutive spaces.

```php
S::create(' String speech = "Hi"')->toSpaces();
S::toSpaces('   String speech = "Hi"');  // '    String speech = "Hi"'
```

#### toTabs

$stringy->toTabs([ tabLength = 4 ])

S::toTabs(string $str, [, int $tabLength = 4 ])

Converts each occurence of some consecutive number of spaces, as defined
by $tabLength, to a tab. By default, each 4 consecutive spaces are
converted to a tab.

```php
S::create('    fòô    bàř')->toTabs();
S::toTabs('    fòô    bàř');  // '   fòô bàř'
```

#### trim

$stringy->trim()

S::trim(string $str)

Trims $str. An alias for PHP's trim() function.

```php
S::create('fòô bàř', 'UTF-8')->trim();
S::trim(' fòô bàř ');  // 'fòô bàř'
```

#### truncate

$stringy->truncate(int $length, [, string $substring = '' ])

S::truncate(string $str, int $length, [, string $substring = '' [, string $encoding ]])

Truncates $str to a given length. If $substring is provided, and
truncating occurs, the string is further truncated so that the substring
may be appended without exceeding the desired length.

```php
S::create('What are your plans today?')->safeTruncate(19, '...');
S::safeTruncate('What are your plans today?', 19, '...');  // 'What are your pl...'
```

#### underscored

$stringy->underscored();

S::underscored(string $str [, string $encoding ])

Returns a lowercase and trimmed string seperated by underscores, with
multibyte support. Underscores are inserted before uppercase characters
(with the exception of the first character of the string), and in place
of spaces as well as dashes.

```php
S::create('TestUCase')->underscored();
S::underscored('TestUCase');  // 'test_u_case'
```

#### upperCamelize

$stringy->upperCamelize();

S::upperCamelize(string $str [, string $encoding ])

Returns an UpperCamelCase version of a supplied string, with multibyte
support. Trims surrounding spaces, capitalizes letters following digits,
spaces, dashes and underscores, and removes spaces, dashes, underscores.

```php
S::create('Upper Camel-Case')->upperCamelize();
S::upperCamelize('Upper Camel-Case');  // 'UpperCamelCase'
```

#### upperCaseFirst

$stringy->upperCaseFirst();

S::upperCaseFirst(string $str [, string $encoding ])

Converts the first character of the supplied string to upper case, with
support for multibyte strings.

```php
S::create('σ test', 'UTF-8')->upperCaseFirst();
S::upperCaseFirst('σ test', 'UTF-8');  // 'Σ test'
```

## Tests

From the project directory, tests can be ran using `phpunit`

## License

Released under the MIT License - see `LICENSE.txt` for details.
