# Stringy

A PHP library with a variety of string manipulation functions with multibyte support. Inspired by underscore.string.js.

* [Requiring/Loading](#requiringloading)
* [Methods](#methods)
    * [upperCaseFirst](#uppercasefirst)
    * [lowerCaseFirst](#lowercasefirst)
    * [camelize](#camelize)
    * [upperCamelize](#uppercamelize)
    * [dasherize](#dasherize)
    * [underscored](#underscored)
    * [swapCase](#swapcase)
    * [titleize](#titleize)
    * [humanize](#humanize)
    * [tidy](#tidy)
    * [clean](#clean)
    * [standardize](#standardize)
    * [pad](#pad)
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
```

And in either case, I'd suggest using an alias.

```php
use Stringy\Stringy as S;
```

## Methods

*Note: If $encoding is not given, it defaults to mb_internal_encoding().*

##### upperCaseFirst

S::upperCaseFirst(string $str [, string $encoding])

Converts the first character of the supplied string to upper case, with
support for multibyte strings.

```php
S::upperCaseFirst('σ test', 'UTF-8');  // 'Σ test'
```

##### lowerCaseFirst

S::lowerCaseFirst(string $str [, string $encoding])

Converts the first character of the supplied string to lower case, with
support for multibyte strings.

```php
S::lowerCaseFirst('Σ test', 'UTF-8');  // 'σ test'
```

##### camelize

S::camelize(string $str [, string $encoding])

Returns a camelCase version of a supplied string, with multibyte support.
Trims surrounding spaces, capitalizes letters following digits, spaces,
dashes and underscores, and removes spaces, dashes, underscores.

```php
S::camelize('Camel-Case');  // 'camelCase'
```

##### upperCamelize

S::upperCamelize(string $str [, string $encoding])

Returns an UpperCamelCase version of a supplied string, with multibyte
support. Trims surrounding spaces, capitalizes letters following digits,
spaces, dashes and underscores, and removes spaces, dashes, underscores.

```php
S::upperCamelize('Upper Camel-Case');  // 'UpperCamelCase'
```

##### dasherize

S::dasherize(string $str [, string $encoding])

Returns a lowercase and trimmed string seperated by dashes, with
multibyte support. Dashes are inserted before uppercase characters
(with the exception of the first character of the string), and in place
of spaces as well as underscores.

```php
S::dasherize('TestDCase');  // 'test-d-case'
```

##### underscored

S::underscored(string $str [, string $encoding])

Returns a lowercase and trimmed string seperated by underscores, with
multibyte support. Underscores are inserted before uppercase characters
(with the exception of the first character of the string), and in place
of spaces as well as dashes.

```php
S::underscored('TestUCase');  // 'test_u_case'
```

##### swapCase

S::swapCase(string $str [, string $encoding])

Returns a case swapped version of a string.

```php
S::swapCase('Ντανιλ', 'UTF-8');  // 'νΤΑΝΙΛ'
```

##### titleize

S::titleize(string $str [, array $ignore [, string $encoding]])

Capitalizes the first letter of each word in a string, after trimming.
Ignores the case of other letters, allowing for the use of acronyms.
Also accepts an array, $ignore, allowing you to list words not to be
capitalized.

```php
$ignore = array('at', 'by', 'for', 'in', 'of', 'on', 'out', 'to', 'the');
S::titleize('i like to watch DVDs at home', $ignore, 'UTF-8');
// 'I Like to Watch DVDs at Home'
```

##### humanize

S::humanize(string $str [, string $encoding])

Capitalizes the first word of a string, replaces underscores with spaces,
and strips '_id'.

```php
S::humanize('author_id');  // 'Author'
```

##### tidy

S::tidy(string $str)

Replaces smart quotes, ellipsis characters, and dashes from Windows-1252
(and commonly used in Word documents) with their ASCII equivalents.

```php
S::tidy('“I see…”');  // '"I see..."'
```

##### clean

S::clean(string $str)

Trims the string and replaces consecutive whitespace characters with a
single space.

```php
S::clean('   Ο     συγγραφέας  '); // 'Ο συγγραφέας'
```

##### standardize

S::standardize(string $str)

Converts some non-ASCII characters to their closest ASCII counterparts.

```php
S::standardize('fòô bàř'); // 'foo bar'
```

##### pad

S::pad(string $str , int $length [, string $padStr [, string $padType [, string $encoding]]])

Pads a string to a given length with another string. If length is less
than or equal to the length of $str, then no padding takes places. The
default string used for padding is a space, and the default type (one of
'left', 'right', 'both') is 'right'.

```php
S::pad('fòô bàř', 10, '¬ø', 'left', 'UTF-8'); // '¬ø¬fòô bàř'
```

## TODO

**center**

**startsWith**

**endsWith**

**toSpaces**

**toTabs**

**toAnchor**

**slugify**

**contains**

**between**

**insert**

**truncate**

**prune**

**longestCommonPrefix**

**longestCommonSubstring**

**isJson**

## Tests

[![Build Status](https://travis-ci.org/danielstjules/Stringy.png)](https://travis-ci.org/danielstjules/Stringy)

From the project directory, tests can be ran using `phpunit`

## License

Released under the MIT License - see `LICENSE.txt` for details.
