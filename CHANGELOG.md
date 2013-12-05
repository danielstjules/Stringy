### 1.2.2 (2013-12-04)

  * Updated create function to use late static binding
  * Added optional $replacement param to slugify

### 1.2.1 (2013-10-11)

  * Cleaned up tests
  * Added homepage to composer.json

### 1.2.0 (2013-09-15)

  * Fixed pad's use of InvalidArgumentException
  * Fixed replace(). It now correctly treats regex special chars as normal chars
  * Added additional Cyrillic letters to toAscii
  * Added $caseSensitive to contains() and count()
  * Added toLowerCase()
  * Added toUpperCase()
  * Added regexReplace()

### 1.1.0 (2013-08-31)

  * Fix for collapseWhitespace()
  * Added isHexadecimal()
  * Added constructor to Stringy\Stringy
  * Added isSerialized()
  * Added isJson()

### 1.0.0 (2013-08-1)

  * 1.0.0 release
  * Added test coverage for Stringy::create and method chaining
  * Added tests for returned type
  * Fixed StaticStringy::replace(). It was returning a Stringy object instead of string
  * Renamed standardize() to the more appropriate toAscii()
  * Cleaned up comments and README

### 1.0.0-rc.1 (2013-07-28)

  * Release candidate
