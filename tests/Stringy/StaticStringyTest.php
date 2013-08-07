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
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForLowerCaseFirst
     */
    public function testLowerCaseFirst($expected, $str, $encoding = null)
    {
        $result = S::lowerCaseFirst($str, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForCamelize
     */
    public function testCamelize($expected, $str, $encoding = null)
    {
        $result = S::camelize($str, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForUpperCamelize
     */
    public function testUpperCamelize($expected, $str, $encoding = null)
    {
        $result = S::upperCamelize($str, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForDasherize
     */
    public function testDasherize($expected, $str, $encoding = null)
    {
        $result = S::dasherize($str, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForUnderscored
     */
    public function testUnderscored($expected, $str, $encoding = null)
    {
        $result = S::underscored($str, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForSwapCase
     */
    public function testSwapCase($expected, $str, $encoding = null)
    {
        $result = S::swapCase($str, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForTitleize
     */
    public function testTitleize($expected, $str, $ignore = null,
                                 $encoding = null)
    {
        $result = S::titleize($str, $ignore, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForHumanize
     */
    public function testHumanize($expected, $str, $encoding = null)
    {
        $result = S::humanize($str, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForTidy
     */
    public function testTidy($expected, $str)
    {
        $result = S::tidy($str);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForCollapseWhitespace
     */
    public function testCollapseWhitespace($expected, $str, $encoding = null)
    {
        $result = S::collapseWhitespace($str, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForToAscii
     */
    public function testToAscii($expected, $str)
    {
        $result = S::toAscii($str);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForPad
     */
    public function testPad($expected, $str, $length, $padStr = ' ',
                            $padType = 'right', $encoding = null)
    {
        $result = S::pad($str, $length, $padStr, $padType, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForPadLeft
     */
    public function testPadLeft($expected, $str, $length, $padStr = ' ',
                                $encoding = null)
    {
        $result = S::padLeft($str, $length, $padStr, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForPadRight
     */
    public function testPadRight($expected, $str, $length, $padStr = ' ',
                                 $encoding = null)
    {
        $result = S::padRight($str, $length, $padStr, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForPadBoth
     */
    public function testPadBoth($expected, $str, $length, $padStr = ' ',
                                $encoding = null)
    {
        $result = S::padBoth($str, $length, $padStr, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForStartsWith
     */
    public function testStartsWith($expected, $str, $substring,
                                $caseSensitive = true, $encoding = null)
    {
        $result = S::startsWith($str, $substring, $caseSensitive, $encoding);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForEndsWith
     */
    public function testEndsWith($expected, $str, $substring,
                                $caseSensitive = true, $encoding = null)
    {
        $result = S::endsWith($str, $substring, $caseSensitive, $encoding);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForToSpaces
     */
    public function testToSpaces($expected, $str, $tabLength = 4)
    {
        $result = S::toSpaces($str, $tabLength);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForToTabs
     */
    public function testToTabs($expected, $str, $tabLength = 4)
    {
        $result = S::toTabs($str, $tabLength);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForSlugify
     */
    public function testSlugify($expected, $str)
    {
        $result = S::slugify($str);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForContains
     */
    public function testContains($expected, $haystack, $needle, $encoding = null)
    {
        $result = S::contains($haystack, $needle, $encoding);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForSurround
     */
    public function testSurround($expected, $str, $substring)
    {
        $result = S::surround($str, $substring);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForInsert
     */
    public function testInsert($expected, $str, $substring, $index,
                               $encoding = null)
    {
        $result = S::insert($str, $substring, $index, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForTruncate
     */
    public function testTruncate($expected, $str, $length, $substring = '',
                                 $encoding = null)
    {
        $result = S::truncate($str, $length, $substring, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForSafeTruncate
     */
    public function testSafeTruncate($expected, $str, $length, $substring = '',
                                     $encoding = null)
    {
        $result = S::safeTruncate($str, $length, $substring, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForReverse
     */
    public function testReverse($expected, $str, $encoding = null)
    {
        $result = S::reverse($str, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForShuffle
     */
    public function testShuffle($str, $encoding = null)
    {
        // We'll just make sure that the chars are present before/after shuffle
        $result = S::shuffle($str, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals(count_chars($str), count_chars($result));
    }

    /**
     * @dataProvider stringsForTrim
     */
    public function testTrim($expected, $str)
    {
        $result = S::trim($str);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForLongestCommonPrefix
     */
    public function testLongestCommonPrefix($expected, $str, $otherStr,
                                            $encoding = null)
    {
        $result = S::longestCommonPrefix($str, $otherStr, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForLongestCommonSuffix
     */
    public function testLongestCommonSuffix($expected, $str, $otherStr,
                                            $encoding = null)
    {
        $result = S::longestCommonSuffix($str, $otherStr, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForLongestCommonSubstring
     */
    public function testLongestCommonSubstring($expected, $str, $otherStr,
                                               $encoding = null)
    {
        $result = S::longestCommonSubstring($str, $otherStr, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForLength
     */
    public function testLength($expected, $str, $encoding = null)
    {
        $result = S::length($str, $encoding);
        $this->assertEquals($expected, $result);
        $this->assertInternalType('int', $result);
    }

    /**
     * @dataProvider stringsForSubstr
     */
    public function testSubstr($expected, $str, $start, $length = null,
                               $encoding = null)
    {
        $result = S::substr($str, $start, $length, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForAt
     */
    public function testAt($expected, $str, $index, $encoding = null)
    {
        $result = S::at($str, $index, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForFirst
     */
    public function testFirst($expected, $str, $n, $encoding = null)
    {
        $result = S::first($str, $n, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForLast
     */
    public function testLast($expected, $str, $n, $encoding = null)
    {
        $result = S::last($str, $n, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForEnsureLeft
     */
    public function testEnsureLeft($expected, $str, $substring, $encoding = null)
    {
        $result = S::ensureLeft($str, $substring, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForEnsureRight
     */
    public function testEnsureRight($expected, $str, $substring, $encoding = null)
    {
        $result = S::ensureRight($str, $substring, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForRemoveLeft
     */
    public function testRemoveLeft($expected, $str, $substring, $encoding = null)
    {
        $result = S::removeLeft($str, $substring, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForRemoveRight
     */
    public function testRemoveRight($expected, $str, $substring, $encoding = null)
    {
        $result = S::removeRight($str, $substring, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForIsAlpha
     */
    public function testIsAlpha($expected, $str, $encoding = null)
    {
        $result = S::isAlpha($str, $encoding);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForIsAlphanumeric
     */
    public function testIsAlphanumeric($expected, $str, $encoding = null)
    {
        $result = S::isAlphanumeric($str, $encoding);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForIsBlank
     */
    public function testIsBlank($expected, $str, $encoding = null)
    {
        $result = S::isBlank($str, $encoding);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForIsLowerCase
     */
    public function testIsLowerCase($expected, $str, $encoding = null)
    {
        $result = S::isLowerCase($str, $encoding);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForIsUpperCase
     */
    public function testIsUpperCase($expected, $str, $encoding = null)
    {
        $result = S::isUpperCase($str, $encoding);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForCount
     */
    public function testCount($expected, $str, $substring, $encoding = null)
    {
        $result = S::count($str, $substring, $encoding);
        $this->assertInternalType('int', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider stringsForReplace
     */
    public function testReplace($expected, $str, $search, $replace,
                                $encoding = null)
    {
        $result = S::replace($str, $search, $replace, $encoding);
        $this->assertInternalType('string', $result);
        $this->assertEquals($expected, $result);
    }
}
