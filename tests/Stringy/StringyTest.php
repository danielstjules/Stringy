<?php

$base = realpath(dirname(__FILE__) . '/../..');
require("$base/src/Stringy/Stringy.php");

use Stringy\Stringy as S;

class StringyTestCase extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider stringsForUpperCaseFirst
     */
    public function testUpperCaseFirst($expected, $string, $encoding = null) {
        $result = S::upperCaseFirst($string, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForUpperCaseFirst() {
        $testData = array(
            array('Test', 'Test'),
            array('Test', 'test'),
            array('1a', '1a'),
            array('Σ test', 'σ test', 'UTF-8'),
            array(' σ test', ' σ test', 'UTF-8')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForLowerCaseFirst
     */
    public function testLowerCaseFirst($expected, $string, $encoding = null) {
        $result = S::lowerCaseFirst($string, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForLowerCaseFirst() {
        $testData = array(
            array('test', 'Test'),
            array('test', 'test'),
            array('1a', '1a'),
            array('σ test', 'Σ test', 'UTF-8'),
            array(' Σ test', ' Σ test', 'UTF-8')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForCamelize
     */
    public function testCamelize($expected, $string, $encoding = null) {
        $result = S::camelize($string, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForCamelize() {
        $testData = array(
            array('camelCase', 'CamelCase'),
            array('camelCase', 'Camel-Case'),
            array('camelCase', 'camel case'),
            array('camelCase', 'camel -case'),
            array('camelCase', 'camel - case'),
            array('camelCase', 'camel_case'),
            array('camelCTest', 'camel c test'),
            array('stringWith1Number', 'string_with1number'),
            array('stringWith22Numbers', 'string-with-2-2 numbers'),
            array('1Camel2Case', '1camel2case'),
            array('camelΣase', 'camel σase', 'UTF-8'),
            array('στανιλCase', 'Στανιλ case', 'UTF-8'),
            array('σamelCase', 'σamel  Case', 'UTF-8')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForUpperCamelize
     */
    public function testUpperCamelize($expected, $string, $encoding = null) {
        $result = S::upperCamelize($string, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForUpperCamelize() {
        $testData = array(
            array('CamelCase', 'camelCase'),
            array('CamelCase', 'Camel-Case'),
            array('CamelCase', 'camel case'),
            array('CamelCase', 'camel -case'),
            array('CamelCase', 'camel - case'),
            array('CamelCase', 'camel_case'),
            array('CamelCTest', 'camel c test'),
            array('StringWith1Number', 'string_with1number'),
            array('StringWith22Numbers', 'string-with-2-2 numbers'),
            array('1Camel2Case', '1camel2case'),
            array('CamelΣase', 'camel σase', 'UTF-8'),
            array('ΣτανιλCase', 'στανιλ case', 'UTF-8'),
            array('ΣamelCase', 'Σamel  Case', 'UTF-8')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForDasherize
     */
    public function testDasherize($expected, $string, $encoding = null) {
        $result = S::dasherize($string, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForDasherize() {
        $testData = array(
            array('test-case', 'testCase'),
            array('test-case', 'Test-Case'),
            array('test-case', 'test case'),
            array('-test-case', '-test -case'),
            array('test-case', 'test - case'),
            array('test-case', 'test_case'),
            array('test-c-test', 'test c test'),
            array('test-d-case', 'TestDCase'),
            array('test-c-c-test', 'TestCCTest'),
            array('string-with1number', 'string_with1number'),
            array('string-with-2-2-numbers', 'String-with_2_2 numbers'),
            array('1test2case', '1test2case'),
            array('dash-σase', 'dash Σase', 'UTF-8'),
            array('στανιλ-case', 'Στανιλ case', 'UTF-8'),
            array('σash-case', 'Σash  Case', 'UTF-8')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForUnderscored
     */
    public function testUnderscored($expected, $string, $encoding = null) {
        $result = S::underscored($string, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForUnderscored() {
        $testData = array(
            array('test_case', 'testCase'),
            array('test_case', 'Test-Case'),
            array('test_case', 'test case'),
            array('test_case', 'test -case'),
            array('_test_case', '-test - case'),
            array('test_case', 'test_case'),
            array('test_c_test', '  test c test'),
            array('test_u_case', 'TestUCase'),
            array('test_c_c_test', 'TestCCTest'),
            array('string_with1number', 'string_with1number'),
            array('string_with_2_2_numbers', 'String-with_2_2 numbers'),
            array('1test2case', '1test2case'),
            array('test_σase', 'test Σase', 'UTF-8'),
            array('στανιλ_case', 'Στανιλ case', 'UTF-8'),
            array('σash_case', 'Σash  Case', 'UTF-8')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForSwapCase
     */
    public function testSwapCase($expected, $string, $encoding = null) {
        $result = S::swapCase($string, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForSwapCase() {
        $testData = array(
            array('TESTcASE', 'testCase'),
            array('tEST-cASE', 'Test-Case'),
            array(' - σASH  cASE', ' - Σash  Case', 'UTF-8'),
            array('νΤΑΝΙΛ', 'Ντανιλ', 'UTF-8')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForTitleize
     */
    public function testTitleize($expected, $string, $ignore = null,
                                 $encoding = null) {
        $result = S::titleize($string, $ignore, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForTitleize() {
        $ignore = array('at', 'by', 'for', 'in', 'of', 'on', 'out', 'to', 'the');

        $testData = array(
            array('Testing The Method', 'testing the method'),
            array('Testing the Method', 'testing the method', $ignore, 'UTF-8'),
            array('I Like to Watch DVDs at Home', 'i like to watch DVDs at home',
                $ignore, 'UTF-8'),
            array('Θα Ήθελα Να Φύγει', '  Θα ήθελα να φύγει  ', null, 'UTF-8')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForHumanize
     */
    public function testHumanize($expected, $string, $encoding = null) {
        $result = S::humanize($string, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForHumanize() {
        $testData = array(
            array('Author', 'author_id'),
            array('Test user', ' _test_user_'),
            array('Συγγραφέας', ' συγγραφέας_id ', 'UTF-8')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForTidy
     */
    public function testTidy($expected, $string) {
        $result = S::tidy($string);
        $this->assertEquals($expected, $result);
    }

    public function stringsForTidy() {
        $testData = array(
            array('"I see..."', '“I see…”'),
            array("'This too'", "‘This too’"),
            array('test-dash', 'test—dash'),
            array('Ο συγγραφέας είπε...', 'Ο συγγραφέας είπε…')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForClean
     */
    public function testClean($expected, $string) {
        $result = S::clean($string);
        $this->assertEquals($expected, $result);
    }

    public function stringsForClean() {
        $testData = array(
            array('foo bar', '  foo   bar  '),
            array('test string', 'test string'),
            array('Ο συγγραφέας', '   Ο     συγγραφέας  '),
            array('123', ' 123 '),
            array('', ' '),
            array('', ''),
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForStandardize
     */
    public function testStandardize($expected, $string) {
        $result = S::standardize($string);
        $this->assertEquals($expected, $result);
    }

    public function stringsForStandardize() {
        $testData = array(
            array('foo bar', 'fòô bàř'),
            array(' TEST ', ' ŤÉŚŢ '),
            array('φ = z = 3', 'φ = ź = 3')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForPad
     */
    public function testPad($expected, $string, $length, $padStr = ' ',
                            $padType = 'right', $encoding = null) {
        $result = S::pad($string, $length, $padStr, $padType, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForPad() {
        $testData = array(
            // $length <= $str
            array('foo bar', 'foo bar', -1),
            array('foo bar', 'foo bar', 7),
            array('fòô bàř', 'fòô bàř', 7, ' ', 'right', 'UTF-8'),

            // right
            array('foo bar  ', 'foo bar', 9),
            array('foo bar_*', 'foo bar', 9, '_*', 'right'),
            array('foo bar_*_', 'foo bar', 10, '_*', 'right'),
            array('fòô bàř  ', 'fòô bàř', 9, ' ', 'right', 'UTF-8'),
            array('fòô bàř¬ø', 'fòô bàř', 9, '¬ø', 'right', 'UTF-8'),
            array('fòô bàř¬ø¬', 'fòô bàř', 10, '¬ø', 'right', 'UTF-8'),
            array('fòô bàř¬ø¬ø', 'fòô bàř', 11, '¬ø', 'right', 'UTF-8'),

            // left
            array('  foo bar', 'foo bar', 9, ' ', 'left'),
            array('_*foo bar', 'foo bar', 9, '_*', 'left'),
            array('_*_foo bar', 'foo bar', 10, '_*', 'left'),
            array('  fòô bàř', 'fòô bàř', 9, ' ', 'left', 'UTF-8'),
            array('¬øfòô bàř', 'fòô bàř', 9, '¬ø', 'left', 'UTF-8'),
            array('¬ø¬fòô bàř', 'fòô bàř', 10, '¬ø', 'left', 'UTF-8'),
            array('¬ø¬øfòô bàř', 'fòô bàř', 11, '¬ø', 'left', 'UTF-8'),

            // both
            array('foo bar ', 'foo bar', 8, ' ', 'both'),
            array(' foo bar ', 'foo bar', 9, ' ', 'both'),
            array('fòô bàř ', 'fòô bàř', 8, ' ', 'both', 'UTF-8'),
            array(' fòô bàř ', 'fòô bàř', 9, ' ', 'both', 'UTF-8'),
            array('fòô bàř¬', 'fòô bàř', 8, '¬ø', 'both', 'UTF-8'),
            array('¬fòô bàř¬', 'fòô bàř', 9, '¬ø', 'both', 'UTF-8'),
            array('¬fòô bàř¬ø', 'fòô bàř', 10, '¬ø', 'both', 'UTF-8'),
            array('¬øfòô bàř¬ø', 'fòô bàř', 11, '¬ø', 'both', 'UTF-8'),
            array('¬fòô bàř¬ø', 'fòô bàř', 10, '¬øÿ', 'both', 'UTF-8'),
            array('¬øfòô bàř¬ø', 'fòô bàř', 11, '¬øÿ', 'both', 'UTF-8'),
            array('¬øfòô bàř¬øÿ', 'fòô bàř', 12, '¬øÿ', 'both', 'UTF-8')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForPadLeft
     */
    public function testPadLeft($expected, $string, $length, $padStr = ' ',
                                $encoding = null) {
        $result = S::padLeft($string, $length, $padStr, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForPadLeft() {
        $testData = array(
            array('  foo bar', 'foo bar', 9),
            array('_*_foo bar', 'foo bar', 10, '_*'),
            array('¬ø¬øfòô bàř', 'fòô bàř', 11, '¬ø', 'UTF-8'),
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForPadRight
     */
    public function testPadRight($expected, $string, $length, $padStr = ' ',
                                 $encoding = null) {
        $result = S::padRight($string, $length, $padStr, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForPadRight() {
        $testData = array(
            array('foo bar  ', 'foo bar', 9),
            array('foo bar_*_', 'foo bar', 10, '_*'),
            array('fòô bàř¬ø¬ø', 'fòô bàř', 11, '¬ø', 'UTF-8'),
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForPadBoth
     */
    public function testPadBoth($expected, $string, $length, $padStr = ' ',
                                $encoding = null) {
        $result = S::padBoth($string, $length, $padStr, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForPadBoth() {
        $testData = array(
            array('foo bar ', 'foo bar', 8),
            array(' foo bar ', 'foo bar', 9, ' '),
            array('¬fòô bàř¬ø', 'fòô bàř', 10, '¬øÿ', 'UTF-8'),
            array('¬øfòô bàř¬øÿ', 'fòô bàř', 12, '¬øÿ', 'UTF-8')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForStartsWith
     */
    public function testStartsWith($expected, $string, $substring,
                                $caseSensitive = true, $encoding = null) {
        $result = S::startsWith($string, $substring, $caseSensitive, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForStartsWith() {
        $testData = array(
            array(true, 'foo bars', 'foo bar'),
            array(true, 'FOO bars', 'foo bar', false),
            array(true, 'FOO bars', 'foo BAR', false),
            array(true, 'FÒÔ bàřs', 'fòô bàř', false, 'UTF-8'),
            array(true, 'fòô bàřs', 'fòô BÀŘ', false, 'UTF-8'),
            array(false, 'foo bar', 'bar'),
            array(false, 'foo bar', 'foo bars'),
            array(false, 'FOO bar', 'foo bars'),
            array(false, 'FOO bars', 'foo BAR'),
            array(false, 'FÒÔ bàřs', 'fòô bàř', true, 'UTF-8'),
            array(false, 'fòô bàřs', 'fòô BÀŘ', true, 'UTF-8'),
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForEndsWith
     */
    public function testEndsWith($expected, $string, $substring,
                                $caseSensitive = true, $encoding = null) {
        $result = S::endsWith($string, $substring, $caseSensitive, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForEndsWith() {
        $testData = array(
            array(true, 'foo bars', 'o bars'),
            array(true, 'FOO bars', 'o bars', false),
            array(true, 'FOO bars', 'o BARs', false),
            array(true, 'FÒÔ bàřs', 'ô bàřs', false, 'UTF-8'),
            array(true, 'fòô bàřs', 'ô BÀŘs', false, 'UTF-8'),
            array(false, 'foo bar', 'foo'),
            array(false, 'foo bar', 'foo bars'),
            array(false, 'FOO bar', 'foo bars'),
            array(false, 'FOO bars', 'foo BARS'),
            array(false, 'FÒÔ bàřs', 'fòô bàřs', true, 'UTF-8'),
            array(false, 'fòô bàřs', 'fòô BÀŘS', true, 'UTF-8'),
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForToSpaces
     */
    public function testToSpaces($expected, $string, $tabLength = 4) {
        $result = S::toSpaces($string, $tabLength);
        $this->assertEquals($expected, $result);
    }

    public function stringsForToSpaces() {
        $testData = array(
            array('    foo    bar    ', '	foo	bar	'),
            array('     foo     bar     ', '	foo	bar	', 5),
            array('    foo  bar  ', '		foo	bar	', 2),
            array('foobar', '	foo	bar	', 0),
            array("    foo\n    bar", "	foo\n	bar"),
            array("    fòô\n    bàř", "	fòô\n	bàř")
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForToTabs
     */
    public function testToTabs($expected, $string, $tabLength = 4) {
        $result = S::toTabs($string, $tabLength);
        $this->assertEquals($expected, $result);
    }

    public function stringsForToTabs() {
        $testData = array(
            array('	foo	bar	', '    foo    bar    '),
            array('	foo	bar	', '     foo     bar     ', 5),
            array('		foo	bar	', '    foo  bar  ', 2),
            array("	foo\n	bar", "    foo\n    bar"),
            array("	fòô\n	bàř", "    fòô\n    bàř")
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForSlugify
     */
    public function testSlugify($expected, $string) {
        $result = S::slugify($string);
        $this->assertEquals($expected, $result);
    }

    public function stringsForSlugify() {
        $testData = array(
            array('foo-bar', ' foo  bar '),
            array('foo-dbar', " Foo d'Bar "),
            array('a-string-with-dashes', 'A string-with-dashes'),
            array('using-strings-like-foo-bar', 'Using strings like fòô bàř'),
            array('unrecognized-chars-like', 'unrecognized chars like συγγρ'),
            array('numbers-1234', 'numbers 1234')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForContains
     */
    public function testContains($expected, $haystack, $needle, $encoding = null) {
        $result = S::contains($haystack, $needle, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForContains() {
        $testData = array(
            array(true, 'This string contains foo bar', 'foo bar'),
            array(true, '12398!@(*%!@# @!%#*&^%',  ' @!%#*&^%'),
            array(true, 'Ο συγγραφέας είπε', 'συγγραφέας', 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', 'å´¥©', 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', 'å˚ ∆', 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', 'øœ¬', 'UTF-8'),
            array(false, 'This string contains foo bar', 'Foo bar'),
            array(false, 'This string contains foo bar', 'foobar'),
            array(false, 'This string contains foo bar', 'foo bar '),
            array(false, 'Ο συγγραφέας είπε', '  συγγραφέας ', 'UTF-8'),
            array(false, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', ' ßå˚', 'UTF-8')
        );

        return $testData;
    }

}

?>
