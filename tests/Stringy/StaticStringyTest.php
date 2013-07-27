<?php

$base = realpath(dirname(__FILE__) . '/../..');
require("$base/src/Stringy/StaticStringy.php");

use Stringy\StaticStringy as S;

class StaticStringyTestCase extends CommonTest
{
    /**
     * @dataProvider stringsForUpperCaseFirst
     */
    public function testUpperCaseFirst($expected, $str, $encoding = null)
    {
        $result = S::upperCaseFirst($str, $encoding);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForLowerCaseFirst
     */
    public function testLowerCaseFirst($expected, $str, $encoding = null)
    {
        $result = S::lowerCaseFirst($str, $encoding);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForCamelize
     */
    public function testCamelize($expected, $str, $encoding = null)
    {
        $result = S::camelize($str, $encoding);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForUpperCamelize
     */
    public function testUpperCamelize($expected, $str, $encoding = null)
    {
        $result = S::upperCamelize($str, $encoding);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForDasherize
     */
    public function testDasherize($expected, $str, $encoding = null)
    {
        $result = S::dasherize($str, $encoding);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForUnderscored
     */
    public function testUnderscored($expected, $str, $encoding = null)
    {
        $result = S::underscored($str, $encoding);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForSwapCase
     */
    public function testSwapCase($expected, $str, $encoding = null)
    {
        $result = S::swapCase($str, $encoding);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForTitleize
     */
    public function testTitleize($expected, $str, $ignore = null,
                                 $encoding = null)
    {
        $result = S::titleize($str, $ignore, $encoding);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForHumanize
     */
    public function testHumanize($expected, $str, $encoding = null)
    {
        $result = S::humanize($str, $encoding);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForTidy
     */
    public function testTidy($expected, $str)
    {
        $result = S::tidy($str);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForCollapseWhitespace
     */
    public function testCollapseWhitespace($expected, $str)
    {
        $result = S::collapseWhitespace($str);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForStandardize
     */
    public function testStandardize($expected, $str)
    {
        $result = S::standardize($str);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForPad
     */
    public function testPad($expected, $str, $length, $padStr = ' ',
                            $padType = 'right', $encoding = null)
    {
        $result = S::pad($str, $length, $padStr, $padType, $encoding);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForPadLeft
     */
    public function testPadLeft($expected, $str, $length, $padStr = ' ',
                                $encoding = null)
    {
        $result = S::padLeft($str, $length, $padStr, $encoding);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForPadRight
     */
    public function testPadRight($expected, $str, $length, $padStr = ' ',
                                 $encoding = null)
    {
        $result = S::padRight($str, $length, $padStr, $encoding);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForPadBoth
     */
    public function testPadBoth($expected, $str, $length, $padStr = ' ',
                                $encoding = null)
    {
        $result = S::padBoth($str, $length, $padStr, $encoding);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForStartsWith
     */
    public function testStartsWith($expected, $str, $substring,
                                $caseSensitive = true, $encoding = null)
    {
        $result = S::startsWith($str, $substring, $caseSensitive, $encoding);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForEndsWith
     */
    public function testEndsWith($expected, $str, $substring,
                                $caseSensitive = true, $encoding = null)
    {
        $result = S::endsWith($str, $substring, $caseSensitive, $encoding);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForToSpaces
     */
    public function testToSpaces($expected, $str, $tabLength = 4)
    {
        $result = S::toSpaces($str, $tabLength);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForToTabs
     */
    public function testToTabs($expected, $str, $tabLength = 4)
    {
        $result = S::toTabs($str, $tabLength);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForSlugify
     */
    public function testSlugify($expected, $str)
    {
        $result = S::slugify($str);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForContains
     */
    public function testContains($expected, $haystack, $needle, $encoding = null)
    {
        $result = S::contains($haystack, $needle, $encoding);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForSurround
     */
    public function testSurround($expected, $str, $substring)
    {
        $result = S::surround($str, $substring);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForInsert
     */
    public function testInsert($expected, $str, $substring, $index,
                               $encoding = null)
    {
        $result = S::insert($str, $substring, $index, $encoding);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForSafeTruncate
     */
    public function testSafeTruncate($expected, $str, $length, $substring = '',
                                 $encoding = null)
    {
        $result = S::safeTruncate($str, $length, $substring, $encoding);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForReverse
     */
    public function testReverse($expected, $str, $encoding = null)
    {
        $result = S::reverse($str, $encoding);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForShuffle
     */
    public function testShuffle($str, $encoding = null)
    {
        // We'll just make sure that the chars are present before/after shuffle
        $result = S::shuffle($str, $encoding);
        $this->assertEquals(count_chars($str), count_chars($result));
    }

    /**
     * @dataProvider stringsForTrim
     */
    public function testTrim($expected, $str)
    {
        $result = S::trim($str);
        $this->assertEquals($expected, $result);
    }
}
