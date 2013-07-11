# Stringy

A PHP library with a variety of multibyte string manipulation functions.

## Usage

#### Requiring/Loading

If you're using Composer to manage dependencies, you can include the following in your composer.json file:

    "require": {
        "danielstjules/Stringy": "dev-master"
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

#### Methods

*Note: All methods will throw a InvalidArgumentException if $string is not of type
string. Furthermore, if if $encoding is not given, it defaults to
mb_internal_encoding().*

**upperCaseFirst**

S::upperCaseFirst($string [, $encoding])

Converts the first character of the supplied string to upper case, with
support for multibyte strings.

```php
S::upperCaseFirst('σ test', 'UTF-8');  // 'Σ test'
```

**lowerCaseFirst**

S::lowerCaseFirst($string [, $encoding])

Converts the first character of the supplied string to lower case, with
support for multibyte strings.

```php
S::lowerCaseFirst('Σ test', 'UTF-8');  // 'σ test'
```

**camelize**

S::camelize($string [, $encoding])

Returns a camelCase version of a supplied string, with multibyte support.
Trims surrounding spaces, capitalizes letters following digits, spaces,
dashes and underscores, and removes spaces, dashes, underscores.

```php
S::camelize('Camel-Case');  // 'camelCase'
```

**upperCamelize**

S::upperCamelize($string [, $encoding])

Returns an UpperCamelCase version of a supplied string, with multibyte
support. Trims surrounding spaces, capitalizes letters following digits,
spaces, dashes and underscores, and removes spaces, dashes, underscores.

```php
S::upperCamelize('Upper Camel-Case');  // 'UpperCamelCase'
```

**dasherize**

S::dasherize($string [, $encoding])

Returns a lowercase and trimmed string seperated by dashes, with
multibyte support. Dashes are inserted before uppercase characters
(with the exception of the first character of the string), and in place
of spaces as well as underscores.

```php
S::dasherize('TestDCase');  // 'test-d-case'
```

**underscored**

S::underscored($string [, $encoding])

Returns a lowercase and trimmed string seperated by underscores, with
multibyte support. Underscores are inserted before uppercase characters
(with the exception of the first character of the string), and in place
of spaces as well as dashes.

```php
S::underscored('TestUCase');  // 'test_u_case'
```

**swapCase**

S::swapCase($string [, $encoding])

Returns a case swapped version of a string.

```php
S::swapCase('Ντανιλ', 'UTF-8');  // 'νΤΑΝΙΛ'
```

**titleize**

S::titleize($string [, $encoding [, $ignore]])

Capitalizes the first letter of each word in a string, after trimming.
Ignores the case of other letters, allowing for the use of acronyms.
Also accepts an array, $ignore, allowing you to list words not to be
capitalized.

```php
$ignore = array('at', 'by', 'for', 'in', 'of', 'on', 'out', 'to', 'the');
S::titleize('i like to watch DVDs at home', 'UTF-8', $ignore);
// 'I Like to Watch DVDs at Home'
```

## TODO

**sentence**

**center**

**endsWith**

**beginsWith**

**toSpaces**

**toTabs**

**slugify**

**contains**

**clean**

**between**

**insert**

**nextChar**

**truncateByChars**

**truncateByWords**

**longestCommonPrefix**

**longestCommonSubstring**

**isJson**

**toAnchor**

## Tests

[![Build Status](https://travis-ci.org/danielstjules/Stringy.png)](https://travis-ci.org/danielstjules/Stringy)

From the project directory, tests can be ran using `phpunit`

## License

Released under the MIT License - see `LICENSE.txt` for details.
