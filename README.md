Stringy
=======

A PHP library with a variety of multibyte string manipulation functions.

Usage
-----

```php
use Stringy\Stringy as S;
```

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

TODO
----

**dasherize**

**underscored**

**swapCase**

**dashes**

**underscores**

**title**

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
