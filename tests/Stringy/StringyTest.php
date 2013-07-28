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
        $stringy = S::create($str, $encoding);
        $result = $stringy->lowerCaseFirst();
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForCamelize
     */
    public function testCamelize($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->camelize();
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForUpperCamelize
     */
    public function testUpperCamelize($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->upperCamelize();
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForDasherize
     */
    public function testDasherize($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->dasherize();
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForUnderscored
     */
    public function testUnderscored($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->underscored();
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForSwapCase
     */
    public function testSwapCase($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->swapCase();
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForTitleize
     */
    public function testTitleize($expected, $str, $ignore = null,
                                 $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->titleize($ignore);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForHumanize
     */
    public function testHumanize($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->humanize();
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForTidy
     */
    public function testTidy($expected, $str)
    {
        $stringy = S::create($str);
        $result = $stringy->tidy();
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForCollapseWhitespace
     */
    public function testCollapseWhitespace($expected, $str)
    {
        $stringy = S::create($str);
        $result = $stringy->collapseWhitespace();
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForStandardize
     */
    public function testStandardize($expected, $str)
    {
        $stringy = S::create($str);
        $result = $stringy->standardize();
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForPad
     */
    public function testPad($expected, $str, $length, $padStr = ' ',
                            $padType = 'right', $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->pad($length, $padStr, $padType);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForPadLeft
     */
    public function testPadLeft($expected, $str, $length, $padStr = ' ',
                                $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->padLeft($length, $padStr);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForPadRight
     */
    public function testPadRight($expected, $str, $length, $padStr = ' ',
                                 $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->padRight($length, $padStr);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForPadBoth
     */
    public function testPadBoth($expected, $str, $length, $padStr = ' ',
                                $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->padBoth($length, $padStr);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForStartsWith
     */
    public function testStartsWith($expected, $str, $substring,
                                $caseSensitive = true, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->startsWith($substring, $caseSensitive);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForEndsWith
     */
    public function testEndsWith($expected, $str, $substring,
                                $caseSensitive = true, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->endsWith($substring, $caseSensitive);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForToSpaces
     */
    public function testToSpaces($expected, $str, $tabLength = 4)
    {
        $stringy = S::create($str);
        $result = $stringy->toSpaces($tabLength);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForToTabs
     */
    public function testToTabs($expected, $str, $tabLength = 4)
    {
        $stringy = S::create($str);
        $result = $stringy->toTabs($tabLength);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForSlugify
     */
    public function testSlugify($expected, $str)
    {
        $stringy = S::create($str);
        $result = $stringy->slugify();
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForContains
     */
    public function testContains($expected, $haystack, $needle, $encoding = null)
    {
        $stringy = S::create($haystack, $encoding);
        $result = $stringy->contains($needle);
        $this->assertEquals($expected, $result);
        $this->assertEquals($haystack, $stringy);
    }

    /**
     * @dataProvider stringsForSurround
     */
    public function testSurround($expected, $str, $substring)
    {
        $stringy = S::create($str);
        $result = $stringy->surround($substring);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForInsert
     */
    public function testInsert($expected, $str, $substring, $index,
                               $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->insert($substring, $index);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForTruncate
     */
    public function testTruncate($expected, $str, $length, $substring = '',
                                 $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->truncate($length, $substring);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForReverse
     */
    public function testReverse($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->reverse();
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForShuffle
     */
    public function testShuffle($str, $encoding = null)
    {
        // We'll just make sure that the chars are present before/after shuffle
        $stringy = S::create($str, $encoding);
        $result = $stringy->shuffle();
        $this->assertEquals(count_chars($str), count_chars($result));
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForTrim
     */
    public function testTrim($expected, $str)
    {
        $stringy = S::create($str);
        $result = $stringy->trim();
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForLongestCommonPrefix
     */
    public function testLongestCommonPrefix($expected, $str, $otherStr,
                                            $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->longestCommonPrefix($otherStr);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForLongestCommonSubstring
     */
    public function testLongestCommonSubstring($expected, $str, $otherStr,
                                               $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->longestCommonSubstring($otherStr);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForLength
     */
    public function testLength($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->length();
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForSubstr
     */
    public function testSubstr($expected, $str, $start, $length = null,
                               $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->substr($start, $length);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForAt
     */
    public function testAt($expected, $str, $index, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->at($index);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForFirst
     */
    public function testFirst($expected, $str, $n, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->first($n);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForLast
     */
    public function testLast($expected, $str, $n, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->last($n);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForEnsureLeft
     */
    public function testEnsureLeft($expected, $str, $substring, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->ensureLeft($substring);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForEnsureRight
     */
    public function testEnsureRight($expected, $str, $substring, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->ensureRight($substring);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForRemoveLeft
     */
    public function testRemoveLeft($expected, $str, $substring, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->removeLeft($substring);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForRemoveRight
     */
    public function testRemoveRight($expected, $str, $substring, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->removeRight($substring);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForIsAlpha
     */
    public function testIsAlpha($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->isAlpha();
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForIsAlphanumeric
     */
    public function testIsAlphanumeric($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->isAlphanumeric();
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForIsBlank
     */
    public function testIsBlank($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->isBlank();
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForIsLowerCase
     */
    public function testIsLowerCase($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->isLowerCase();
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    /**
     * @dataProvider stringsForIsUpperCase
     */
    public function testIsUpperCase($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->isUpperCase();
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }
}
