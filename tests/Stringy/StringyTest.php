<?php

$base = realpath(dirname(__FILE__) . '/../..');
require("$base/src/Stringy/Stringy.php");

use Stringy\Stringy as S;

class StringyTestCase extends CommonTest
{
    /**
     * @dataProvider stringsForUpperCaseFirst
     */
    public function testUpperCaseFirst($expected, $str, $encoding = null)
    {
        $result = S::create($str, $encoding)->upperCaseFirst();
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForLowerCaseFirst
     */
    public function testLowerCaseFirst($expected, $str, $encoding = null)
    {
        $result = S::create($str, $encoding)->lowerCaseFirst();
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForCamelize
     */
    public function testCamelize($expected, $str, $encoding = null)
    {
        $result = S::create($str, $encoding)->camelize();
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForUpperCamelize
     */
    public function testUpperCamelize($expected, $str, $encoding = null)
    {
        $result = S::create($str, $encoding)->upperCamelize();
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForDasherize
     */
    public function testDasherize($expected, $str, $encoding = null)
    {
        $result = S::create($str, $encoding)->dasherize();
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForUnderscored
     */
    public function testUnderscored($expected, $str, $encoding = null)
    {
        $result = S::create($str, $encoding)->underscored();
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForSwapCase
     */
    public function testSwapCase($expected, $str, $encoding = null)
    {
        $result = S::create($str, $encoding)->swapCase();
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForTitleize
     */
    public function testTitleize($expected, $str, $ignore = null,
                                 $encoding = null)
    {
        $result = S::create($str, $encoding)->titleize($ignore);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForHumanize
     */
    public function testHumanize($expected, $str, $encoding = null)
    {
        $result = S::create($str, $encoding)->humanize();
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForTidy
     */
    public function testTidy($expected, $str)
    {
        $result = S::create($str)->tidy();
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForCollapseWhitespace
     */
    public function testCollapseWhitespace($expected, $str)
    {
        $result = S::create($str)->collapseWhitespace();
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForStandardize
     */
    public function testStandardize($expected, $str)
    {
        $result = S::create($str)->standardize();
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForPad
     */
    public function testPad($expected, $str, $length, $padStr = ' ',
                            $padType = 'right', $encoding = null)
    {
        $result = S::create($str, $encoding)->pad($length, $padStr, $padType);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForPadLeft
     */
    public function testPadLeft($expected, $str, $length, $padStr = ' ',
                                $encoding = null)
    {
        $result = S::create($str, $encoding)->padLeft($length, $padStr);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForPadRight
     */
    public function testPadRight($expected, $str, $length, $padStr = ' ',
                                 $encoding = null)
    {
        $result = S::create($str, $encoding)->padRight($length, $padStr);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForPadBoth
     */
    public function testPadBoth($expected, $str, $length, $padStr = ' ',
                                $encoding = null)
    {
        $result = S::create($str, $encoding)->padBoth($length, $padStr);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForStartsWith
     */
    public function testStartsWith($expected, $str, $substring,
                                $caseSensitive = true, $encoding = null)
    {
        $result = S::create($str, $encoding)->startsWith($substring, $caseSensitive);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForEndsWith
     */
    public function testEndsWith($expected, $str, $substring,
                                $caseSensitive = true, $encoding = null)
    {
        $result = S::create($str, $encoding)->endsWith($substring, $caseSensitive);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForToSpaces
     */
    public function testToSpaces($expected, $str, $tabLength = 4)
    {
        $result = S::create($str)->toSpaces($tabLength);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForToTabs
     */
    public function testToTabs($expected, $str, $tabLength = 4)
    {
        $result = S::create($str)->toTabs($tabLength);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForSlugify
     */
    public function testSlugify($expected, $str)
    {
        $result = S::create($str)->slugify();
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForContains
     */
    public function testContains($expected, $haystack, $needle, $encoding = null)
    {
        $result = S::create($haystack, $encoding)->contains($needle);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForSurround
     */
    public function testSurround($expected, $str, $substring)
    {
        $result = S::create($str)->surround($substring);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForInsert
     */
    public function testInsert($expected, $str, $substring, $index,
                               $encoding = null)
    {
        $result = S::create($str, $encoding)->insert($substring, $index);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForSafeTruncate
     */
    public function testSafeTruncate($expected, $str, $length, $substring = '',
                                     $encoding = null)
    {
        $result = S::create($str, $encoding)->safeTruncate($length, $substring);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForReverse
     */
    public function testReverse($expected, $str, $encoding = null)
    {
        $result = S::create($str, $encoding)->reverse();
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForShuffle
     */
    public function testShuffle($str, $encoding = null)
    {
        // We'll just make sure that the chars are present before/after shuffle
        $result = S::create($str, $encoding)->shuffle();
        $this->assertEquals(count_chars($str), count_chars($result));
    }

    /**
     * @dataProvider stringsForTrim
     */
    public function testTrim($expected, $str)
    {
        $result = S::create($str)->trim();
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForLongestCommonPrefix
     */
    public function testLongestCommonPrefix($expected, $str, $otherStr,
                                            $encoding = null)
    {
        $result = S::create($str, $encoding)
                   ->longestCommonPrefix($otherStr);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForLongestCommonSubstring
     */
    public function testLongestCommonSubstring($expected, $str, $otherStr,
                                               $encoding = null)
    {
        $result = S::create($str, $encoding)
                   ->longestCommonSubstring($otherStr);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForLength
     */
    public function testLength($expected, $str, $encoding = null)
    {
        $result = S::create($str, $encoding)->length();
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForSubstr
     */
    public function testSubstr($expected, $str, $start, $length = null,
                               $encoding = null)
    {
        $result = S::create($str, $encoding)->substr($start, $length);
        $this->assertEquals($expected, $result);
    }
}
