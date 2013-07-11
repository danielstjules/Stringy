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
            array('σ test', 'Σ test', 'UTF-8')
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
            array('Σ test', 'σ test', 'UTF-8')
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
            array('dash Σase', 'dash_σase', 'UTF-8'),
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

}

?>
