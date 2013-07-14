<?php

$base = realpath(dirname(__FILE__) . '/../..');
require("$base/src/Stringy/Stringy.php");

use Stringy\Stringy as S;

class StringyTestCase extends PHPUnit_Framework_TestCase {

    /**
     * @expectedException BadMethodCallException
     */
    public function testExceptionOnUndefinedMethod() {
        S::doesntExist('test', 'UTF-8');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testExceptionWithInvalidArgument() {
        S::camelize(1, 'UTF-8');
    }

    /**
     * @dataProvider stringsForUpperCaseFirst
     */
    public function testUpperCaseFirst($string, $expected, $encoding = null) {
        $result = S::upperCaseFirst($string, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForUpperCaseFirst() {
        $testData = array(
            array('Test', 'Test'),
            array('test', 'Test'),
            array('1a', '1a'),
            array('σ test', 'Σ test', 'UTF-8'),
            array(' σ test', ' σ test', 'UTF-8')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForLowerCaseFirst
     */
    public function testLowerCaseFirst($string, $expected, $encoding = null) {
        $result = S::lowerCaseFirst($string, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForLowerCaseFirst() {
        $testData = array(
            array('Test', 'test'),
            array('test', 'test'),
            array('1a', '1a'),
            array('Σ test', 'σ test', 'UTF-8'),
            array(' Σ test', ' Σ test', 'UTF-8')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForCamelize
     */
    public function testCamelize($string, $expected, $encoding = null) {
        $result = S::camelize($string, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForCamelize() {
        $testData = array(
            array('CamelCase', 'camelCase'),
            array('Camel-Case', 'camelCase'),
            array('camel case', 'camelCase'),
            array('camel -case', 'camelCase'),
            array('camel - case', 'camelCase'),
            array('camel_case', 'camelCase'),
            array('camel c test', 'camelCTest'),
            array('string_with1number', 'stringWith1Number'),
            array('string-with-2-2 numbers', 'stringWith22Numbers'),
            array('1camel2case', '1Camel2Case'),
            array('camel σase', 'camelΣase', 'UTF-8'),
            array('Στανιλ case', 'στανιλCase', 'UTF-8'),
            array('σamel  Case', 'σamelCase', 'UTF-8')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForUpperCamelize
     */
    public function testUpperCamelize($string, $expected, $encoding = null) {
        $result = S::upperCamelize($string, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForUpperCamelize() {
        $testData = array(
            array('camelCase', 'CamelCase'),
            array('Camel-Case', 'CamelCase'),
            array('camel case', 'CamelCase'),
            array('camel -case', 'CamelCase'),
            array('camel - case', 'CamelCase'),
            array('camel_case', 'CamelCase'),
            array('camel c test', 'CamelCTest'),
            array('string_with1number', 'StringWith1Number'),
            array('string-with-2-2 numbers', 'StringWith22Numbers'),
            array('1camel2case', '1Camel2Case'),
            array('camel σase', 'CamelΣase', 'UTF-8'),
            array('στανιλ case', 'ΣτανιλCase', 'UTF-8'),
            array('Σamel  Case', 'ΣamelCase', 'UTF-8')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForDasherize
     */
    public function testDasherize($string, $expected, $encoding = null) {
        $result = S::dasherize($string, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForDasherize() {
        $testData = array(
            array('testCase', 'test-case'),
            array('Test-Case', 'test-case'),
            array('test case', 'test-case'),
            array('-test -case', '-test-case'),
            array('test - case', 'test-case'),
            array('test_case', 'test-case'),
            array('test c test', 'test-c-test'),
            array('TestDCase', 'test-d-case'),
            array('TestCCTest', 'test-c-c-test'),
            array('string_with1number', 'string-with1number'),
            array('String-with_2_2 numbers', 'string-with-2-2-numbers'),
            array('1test2case', '1test2case'),
            array('dash Σase', 'dash-σase', 'UTF-8'),
            array('Στανιλ case', 'στανιλ-case', 'UTF-8'),
            array('Σash  Case', 'σash-case', 'UTF-8')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForUnderscored
     */
    public function testUnderscored($string, $expected, $encoding = null) {
        $result = S::underscored($string, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForUnderscored() {
        $testData = array(
            array('testCase', 'test_case'),
            array('Test-Case', 'test_case'),
            array('test case', 'test_case'),
            array('test -case', 'test_case'),
            array('-test - case', '_test_case'),
            array('test_case', 'test_case'),
            array('  test c test', 'test_c_test'),
            array('TestUCase', 'test_u_case'),
            array('TestCCTest', 'test_c_c_test'),
            array('string_with1number', 'string_with1number'),
            array('String-with_2_2 numbers', 'string_with_2_2_numbers'),
            array('1test2case', '1test2case'),
            array('test Σase', 'test_σase', 'UTF-8'),
            array('Στανιλ case', 'στανιλ_case', 'UTF-8'),
            array('Σash  Case', 'σash_case', 'UTF-8')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForSwapCase
     */
    public function testSwapCase($string, $expected, $encoding = null) {
        $result = S::swapCase($string, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForSwapCase() {
        $testData = array(
            array('testCase', 'TESTcASE'),
            array('Test-Case', 'tEST-cASE'),
            array(' - Σash  Case', ' - σASH  cASE', 'UTF-8'),
            array('Ντανιλ', 'νΤΑΝΙΛ', 'UTF-8')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForTitleize
     */
    public function testTitleize($string, $expected, $encoding = null, $ignore = null) {
        $result = S::titleize($string, $encoding, $ignore);
        $this->assertEquals($expected, $result);
    }

    public function stringsForTitleize() {
        $ignore = array('at', 'by', 'for', 'in', 'of', 'on', 'out', 'to', 'the');

        $testData = array(
            array('testing the method', 'Testing The Method'),
            array('testing the method', 'Testing the Method', 'UTF-8', $ignore),
            array('i like to watch DVDs at home', 'I Like to Watch DVDs at Home',
                'UTF-8', $ignore),
            array('  Θα ήθελα να φύγει  ', 'Θα Ήθελα Να Φύγει', 'UTF-8')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForHumanize
     */
    public function testHumanize($string, $expected, $encoding = null) {
        $result = S::humanize($string, $encoding);
        $this->assertEquals($expected, $result);
    }

    public function stringsForHumanize() {
        $testData = array(
            array('author_id', 'Author'),
            array(' _test_user_', 'Test user'),
            array(' συγγραφέας_id ', 'Συγγραφέας', 'UTF-8')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForTidy
     */
    public function testTidy($string, $expected) {
        $result = S::tidy($string);
        $this->assertEquals($expected, $result);
    }

    public function stringsForTidy() {
        $testData = array(
            array('“I see…”', '"I see..."'),
            array("‘This too’", "'This too'"),
            array('test—dash', 'test-dash'),
            array('Ο συγγραφέας είπε…', 'Ο συγγραφέας είπε...')
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForClean
     */
    public function testClean($string, $expected) {
        $result = S::clean($string);
        $this->assertEquals($expected, $result);
    }

    public function stringsForClean() {
        $testData = array(
            array('  foo   bar  ', 'foo bar'),
            array('test string', 'test string'),
            array('   Ο     συγγραφέας  ', 'Ο συγγραφέας'),
            array(' 123 ', '123'),
            array(' ', ''),
            array('', ''),
        );

        return $testData;
    }

    /**
     * @dataProvider stringsForStandardize
     */
    public function testStandardize($string, $expected) {
        $result = S::standardize($string);
        $this->assertEquals($expected, $result);
    }

    public function stringsForStandardize() {
        $testData = array(
            array('fòô bàř', 'foo bar'),
            array(' ŤÉŚŢ ', ' TEST '),
            array('φ = ź = 3', 'φ = z = 3')
        );

        return $testData;
    }

}

?>
