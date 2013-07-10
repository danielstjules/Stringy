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
            array('Σamel case', 'σamelCase', 'UTF-8'),
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
            array('σamel case', 'ΣamelCase', 'UTF-8'),
            array('Σamel  Case', 'ΣamelCase', 'UTF-8')
        );

        return $testData;
    }

}

?>
