<?php

use Stringy\Stringy as S;

class StringyTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Asserts that a variable is of a Stringy instance.
     *
     * @param mixed $actual
     */
    public function assertStringy($actual)
    {
        $this->assertInstanceOf('Stringy\Stringy', $actual);
    }

    public function testConstruct()
    {
        $stringy = new S('foo bar', 'UTF-8');
        $this->assertStringy($stringy);
        $this->assertEquals('foo bar', (string) $stringy);
        $this->assertEquals('UTF-8', $stringy->getEncoding());
    }

    public function testEmptyConstruct()
    {
        $stringy = new S();
        $this->assertStringy($stringy);
        $this->assertEquals('', (string) $stringy);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructWithArray()
    {
        (string) new S(array());
        $this->fail('Expecting exception when the constructor is passed an array');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMissingToString()
    {
        (string) new S(new stdClass());
        $this->fail('Expecting exception when the constructor is passed an ' .
                    'object without a __toString method');
    }

    /**
     * @dataProvider toStringProvider()
     */
    public function testToString($expected, $str)
    {
        $this->assertEquals($expected, (string) new S($str));
    }

    public function toStringProvider()
    {
        return array(
            array('', null),
            array('', false),
            array('1', true),
            array('-9', -9),
            array('1.18', 1.18),
            array(' string  ', ' string  ')
        );
    }

    public function testCreate()
    {
        $stringy = S::create('foo bar', 'UTF-8');
        $this->assertStringy($stringy);
        $this->assertEquals('foo bar', (string) $stringy);
        $this->assertEquals('UTF-8', $stringy->getEncoding());
    }

    public function testChaining()
    {
        $stringy = S::create("Fòô     Bàř", 'UTF-8');
        $this->assertStringy($stringy);
        $result = $stringy->collapseWhitespace()->swapCase()->upperCaseFirst();
        $this->assertEquals('FÒÔ bÀŘ', $result);
    }

    public function testCount()
    {
        $stringy = S::create('Fòô', 'UTF-8');
        $this->assertEquals(3, $stringy->count());
        $this->assertEquals(3, count($stringy));
    }

    public function testGetIterator()
    {
        $stringy = S::create('Fòô Bàř', 'UTF-8');

        $valResult = array();
        foreach ($stringy as $char) {
            $valResult[] = $char;
        }

        $keyValResult = array();
        foreach ($stringy as $pos => $char) {
            $keyValResult[$pos] = $char;
        }

        $this->assertEquals(array('F', 'ò', 'ô', ' ', 'B', 'à', 'ř'), $valResult);
        $this->assertEquals(array('F', 'ò', 'ô', ' ', 'B', 'à', 'ř'), $keyValResult);
    }

    /**
     * @dataProvider offsetExistsProvider()
     */
    public function testOffsetExists($expected, $offset)
    {
        $stringy = S::create('fòô', 'UTF-8');
        $this->assertEquals($expected, $stringy->offsetExists($offset));
        $this->assertEquals($expected, isset($stringy[$offset]));
    }

    public function offsetExistsProvider()
    {
        return array(
            array(true, 0),
            array(true, 2),
            array(false, 3),
            array(true, -1),
            array(true, -3),
            array(false, -4)
        );
    }

    public function testOffsetGet()
    {
        $stringy = S::create('fòô', 'UTF-8');

        $this->assertEquals('f', $stringy->offsetGet(0));
        $this->assertEquals('ô', $stringy->offsetGet(2));

        $this->assertEquals('ô', $stringy[2]);
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testOffsetGetOutOfBounds()
    {
        $stringy = S::create('fòô', 'UTF-8');
        $test = $stringy[3];
    }

    /**
     * @expectedException \Exception
     */
    public function testOffsetSet()
    {
        $stringy = S::create('fòô', 'UTF-8');
        $stringy[1] = 'invalid';
    }

    /**
     * @expectedException \Exception
     */
    public function testOffsetUnset()
    {
        $stringy = S::create('fòô', 'UTF-8');
        unset($stringy[1]);
    }

    /**
     * @dataProvider indexOfProvider()
     */
    public function testIndexOf($expected, $str, $subStr, $offset = 0, $encoding = null)
    {
        $result = S::create($str, $encoding)->indexOf($subStr, $offset);
        $this->assertEquals($expected, $result);
    }

    public function indexOfProvider()
    {
        return array(
            array(6, 'foo & bar', 'bar'),
            array(6, 'foo & bar', 'bar', 0),
            array(false, 'foo & bar', 'baz'),
            array(false, 'foo & bar', 'baz', 0),
            array(0, 'foo & bar & foo', 'foo', 0),
            array(12, 'foo & bar & foo', 'foo', 5),
            array(6, 'fòô & bàř', 'bàř', 0, 'UTF-8'),
            array(false, 'fòô & bàř', 'baz', 0, 'UTF-8'),
            array(0, 'fòô & bàř & fòô', 'fòô', 0, 'UTF-8'),
            array(12, 'fòô & bàř & fòô', 'fòô', 5, 'UTF-8'),
        );
    }

    /**
     * @dataProvider indexOfLastProvider()
     */
    public function testIndexOfLast($expected, $str, $subStr, $offset = 0, $encoding = null)
    {
        $result = S::create($str, $encoding)->indexOfLast($subStr, $offset);
        $this->assertEquals($expected, $result);
    }

    public function indexOfLastProvider()
    {
        return array(
            array(6, 'foo & bar', 'bar'),
            array(6, 'foo & bar', 'bar', 0),
            array(false, 'foo & bar', 'baz'),
            array(false, 'foo & bar', 'baz', 0),
            array(12, 'foo & bar & foo', 'foo', 0),
            array(0, 'foo & bar & foo', 'foo', -5),
            array(6, 'fòô & bàř', 'bàř', 0, 'UTF-8'),
            array(false, 'fòô & bàř', 'baz', 0, 'UTF-8'),
            array(12, 'fòô & bàř & fòô', 'fòô', 0, 'UTF-8'),
            array(0, 'fòô & bàř & fòô', 'fòô', -5, 'UTF-8'),
        );
    }

    /**
     * @dataProvider appendProvider()
     */
    public function testAppend($expected, $str, $string, $encoding = null)
    {
        $result = S::create($str, $encoding)->append($string);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
    }

    public function appendProvider()
    {
        return array(
            array('foobar', 'foo', 'bar'),
            array('fòôbàř', 'fòô', 'bàř', 'UTF-8')
        );
    }

    /**
     * @dataProvider prependProvider()
     */
    public function testPrepend($expected, $str, $string, $encoding = null)
    {
        $result = S::create($str, $encoding)->prepend($string);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
    }

    public function prependProvider()
    {
        return array(
            array('foobar', 'bar', 'foo'),
            array('fòôbàř', 'bàř', 'fòô', 'UTF-8')
        );
    }

    /**
     * @dataProvider charsProvider()
     */
    public function testChars($expected, $str, $encoding = null)
    {
        $result = S::create($str, $encoding)->chars();
        $this->assertInternalType('array', $result);
        foreach ($result as $char) {
            $this->assertInternalType('string', $char);
        }
        $this->assertEquals($expected, $result);
    }

    public function charsProvider()
    {
        return array(
            array(array(), ''),
            array(array('T', 'e', 's', 't'), 'Test'),
            array(array('F', 'ò', 'ô', ' ', 'B', 'à', 'ř'), 'Fòô Bàř', 'UTF-8')
        );
    }

    /**
     * @dataProvider linesProvider()
     */
    public function testLines($expected, $str, $encoding = null)
    {
        $result = S::create($str, $encoding)->lines();

        $this->assertInternalType('array', $result);
        foreach ($result as $line) {
            $this->assertStringy($line);
        }

        for ($i = 0; $i < count($expected); $i++) {
            $this->assertEquals($expected[$i], $result[$i]);
        }
    }

    public function linesProvider()
    {
        return array(
            array(array(), ""),
            array(array(''), "\r\n"),
            array(array('foo', 'bar'), "foo\nbar"),
            array(array('foo', 'bar'), "foo\rbar"),
            array(array('foo', 'bar'), "foo\r\nbar"),
            array(array('foo', '', 'bar'), "foo\r\n\r\nbar"),
            array(array('foo', 'bar', ''), "foo\r\nbar\r\n"),
            array(array('', 'foo', 'bar'), "\r\nfoo\r\nbar"),
            array(array('fòô', 'bàř'), "fòô\nbàř", 'UTF-8'),
            array(array('fòô', 'bàř'), "fòô\rbàř", 'UTF-8'),
            array(array('fòô', 'bàř'), "fòô\n\rbàř", 'UTF-8'),
            array(array('fòô', 'bàř'), "fòô\r\nbàř", 'UTF-8'),
            array(array('fòô', '', 'bàř'), "fòô\r\n\r\nbàř", 'UTF-8'),
            array(array('fòô', 'bàř', ''), "fòô\r\nbàř\r\n", 'UTF-8'),
            array(array('', 'fòô', 'bàř'), "\r\nfòô\r\nbàř", 'UTF-8'),
        );
    }
    /**
     * @dataProvider upperCaseFirstProvider()
     */
    public function testUpperCaseFirst($expected, $str, $encoding = null)
    {
        $result = S::create($str, $encoding)->upperCaseFirst();
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
    }

    public function upperCaseFirstProvider()
    {
        return array(
            array('Test', 'Test'),
            array('Test', 'test'),
            array('1a', '1a'),
            array('Σ test', 'σ test', 'UTF-8'),
            array(' σ test', ' σ test', 'UTF-8')
        );
    }

    /**
     * @dataProvider lowerCaseFirstProvider()
     */
    public function testLowerCaseFirst($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->lowerCaseFirst();
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function lowerCaseFirstProvider()
    {
        return array(
            array('test', 'Test'),
            array('test', 'test'),
            array('1a', '1a'),
            array('σ test', 'Σ test', 'UTF-8'),
            array(' Σ test', ' Σ test', 'UTF-8')
        );
    }

    /**
     * @dataProvider camelizeProvider()
     */
    public function testCamelize($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->camelize();
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function camelizeProvider()
    {
        return array(
            array('camelCase', 'CamelCase'),
            array('camelCase', 'Camel-Case'),
            array('camelCase', 'camel case'),
            array('camelCase', 'camel -case'),
            array('camelCase', 'camel - case'),
            array('camelCase', 'camel_case'),
            array('camelCTest', 'camel c test'),
            array('stringWith1Number', 'string_with1number'),
            array('stringWith22Numbers', 'string-with-2-2 numbers'),
            array('dataRate', 'data_rate'),
            array('backgroundColor', 'background-color'),
            array('yesWeCan', 'yes_we_can'),
            array('mozSomething', '-moz-something'),
            array('carSpeed', '_car_speed_'),
            array('serveHTTP', 'ServeHTTP'),
            array('1Camel2Case', '1camel2case'),
            array('camelΣase', 'camel σase', 'UTF-8'),
            array('στανιλCase', 'Στανιλ case', 'UTF-8'),
            array('σamelCase', 'σamel  Case', 'UTF-8')
        );
    }

    /**
     * @dataProvider upperCamelizeProvider()
     */
    public function testUpperCamelize($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->upperCamelize();
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function upperCamelizeProvider()
    {
        return array(
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
    }

    /**
     * @dataProvider dasherizeProvider()
     */
    public function testDasherize($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->dasherize();
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function dasherizeProvider()
    {
        return array(
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
            array('data-rate', 'dataRate'),
            array('car-speed', 'CarSpeed'),
            array('yes-we-can', 'yesWeCan'),
            array('background-color', 'backgroundColor'),
            array('dash-σase', 'dash Σase', 'UTF-8'),
            array('στανιλ-case', 'Στανιλ case', 'UTF-8'),
            array('σash-case', 'Σash  Case', 'UTF-8')
        );
    }

    /**
     * @dataProvider underscoredProvider()
     */
    public function testUnderscored($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->underscored();
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function underscoredProvider()
    {
        return array(
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
            array('yes_we_can', 'yesWeCan'),
            array('test_σase', 'test Σase', 'UTF-8'),
            array('στανιλ_case', 'Στανιλ case', 'UTF-8'),
            array('σash_case', 'Σash  Case', 'UTF-8')
        );
    }

    /**
     * @dataProvider delimitProvider()
     */
    public function testDelimit($expected, $str, $delimiter, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->delimit($delimiter);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function delimitProvider()
    {
        return array(
            array('test*case', 'testCase', '*'),
            array('test&case', 'Test-Case', '&'),
            array('test#case', 'test case', '#'),
            array('test**case', 'test -case', '**'),
            array('~!~test~!~case', '-test - case', '~!~'),
            array('test*case', 'test_case', '*'),
            array('test%c%test', '  test c test', '%'),
            array('test+u+case', 'TestUCase', '+'),
            array('test=c=c=test', 'TestCCTest', '='),
            array('string#>with1number', 'string_with1number', '#>'),
            array('1test2case', '1test2case', '*'),
            array('test ύα σase', 'test Σase', ' ύα ', 'UTF-8',),
            array('στανιλαcase', 'Στανιλ case', 'α', 'UTF-8',),
            array('σashΘcase', 'Σash  Case', 'Θ', 'UTF-8')
        );
    }

    /**
     * @dataProvider swapCaseProvider()
     */
    public function testSwapCase($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->swapCase();
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function swapCaseProvider()
    {
        return array(
            array('TESTcASE', 'testCase'),
            array('tEST-cASE', 'Test-Case'),
            array(' - σASH  cASE', ' - Σash  Case', 'UTF-8'),
            array('νΤΑΝΙΛ', 'Ντανιλ', 'UTF-8')
        );
    }

    /**
     * @dataProvider titleizeProvider()
     */
    public function testTitleize($expected, $str, $ignore = null,
                                 $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->titleize($ignore);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function titleizeProvider()
    {
        $ignore = array('at', 'by', 'for', 'in', 'of', 'on', 'out', 'to', 'the');

        return array(
            array('Title Case', 'TITLE CASE'),
            array('Testing The Method', 'testing the method'),
            array('Testing the Method', 'testing the method', $ignore),
            array('I Like to Watch Dvds at Home', 'i like to watch DVDs at home',
                $ignore),
            array('Θα Ήθελα Να Φύγει', '  Θα ήθελα να φύγει  ', null, 'UTF-8')
        );
    }

    /**
     * @dataProvider humanizeProvider()
     */
    public function testHumanize($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->humanize();
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function humanizeProvider()
    {
        return array(
            array('Author', 'author_id'),
            array('Test user', ' _test_user_'),
            array('Συγγραφέας', ' συγγραφέας_id ', 'UTF-8')
        );
    }

    /**
     * @dataProvider tidyProvider()
     */
    public function testTidy($expected, $str)
    {
        $stringy = S::create($str);
        $result = $stringy->tidy();
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function tidyProvider()
    {
        return array(
            array('"I see..."', '“I see…”'),
            array("'This too'", "‘This too’"),
            array('test-dash', 'test—dash'),
            array('Ο συγγραφέας είπε...', 'Ο συγγραφέας είπε…')
        );
    }

    /**
     * @dataProvider collapseWhitespaceProvider()
     */
    public function testCollapseWhitespace($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->collapseWhitespace();
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function collapseWhitespaceProvider()
    {
        return array(
            array('foo bar', '  foo   bar  '),
            array('test string', 'test string'),
            array('Ο συγγραφέας', '   Ο     συγγραφέας  '),
            array('123', ' 123 '),
            array('', ' ', 'UTF-8'), // no-break space (U+00A0)
            array('', '           ', 'UTF-8'), // spaces U+2000 to U+200A
            array('', ' ', 'UTF-8'), // narrow no-break space (U+202F)
            array('', ' ', 'UTF-8'), // medium mathematical space (U+205F)
            array('', '　', 'UTF-8'), // ideographic space (U+3000)
            array('1 2 3', '  1  2  3　　', 'UTF-8'),
            array('', ' '),
            array('', ''),
        );
    }

    /**
     * @dataProvider toAsciiProvider()
     */
    public function testToAscii($expected, $str, $removeUnsupported = true)
    {
        $stringy = S::create($str);
        $result = $stringy->toAscii($removeUnsupported);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function toAsciiProvider()
    {
        return array(
            array('foo bar', 'fòô bàř'),
            array(' TEST ', ' ŤÉŚŢ '),
            array('f = z = 3', 'φ = ź = 3'),
            array('perevirka', 'перевірка'),
            array('lysaya gora', 'лысая гора'),
            array('shchuka', 'щука'),
            array('', '漢字'),
            array('xin chao the gioi', 'xin chào thế giới'),
            array('XIN CHAO THE GIOI', 'XIN CHÀO THẾ GIỚI'),
            array('dam phat chet luon', 'đấm phát chết luôn'),
            array(' ', ' '), // no-break space (U+00A0)
            array('           ', '           '), // spaces U+2000 to U+200A
            array(' ', ' '), // narrow no-break space (U+202F)
            array(' ', ' '), // medium mathematical space (U+205F)
            array(' ', '　'), // ideographic space (U+3000)
            array('', '𐍉'), // some uncommon, unsupported character (U+10349)
            array('𐍉', '𐍉', false),
        );
    }

    /**
     * @dataProvider padProvider()
     */
    public function testPad($expected, $str, $length, $padStr = ' ',
                            $padType = 'right', $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->pad($length, $padStr, $padType);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function padProvider()
    {
        return array(
            // length <= str
            array('foo bar', 'foo bar', -1),
            array('foo bar', 'foo bar', 7),
            array('fòô bàř', 'fòô bàř', 7, ' ', 'right', 'UTF-8'),

            // right
            array('foo bar  ', 'foo bar', 9),
            array('foo bar_*', 'foo bar', 9, '_*', 'right'),
            array('fòô bàř¬ø¬', 'fòô bàř', 10, '¬ø', 'right', 'UTF-8'),

            // left
            array('  foo bar', 'foo bar', 9, ' ', 'left'),
            array('_*foo bar', 'foo bar', 9, '_*', 'left'),
            array('¬ø¬fòô bàř', 'fòô bàř', 10, '¬ø', 'left', 'UTF-8'),

            // both
            array('foo bar ', 'foo bar', 8, ' ', 'both'),
            array('¬fòô bàř¬ø', 'fòô bàř', 10, '¬ø', 'both', 'UTF-8'),
            array('¬øfòô bàř¬øÿ', 'fòô bàř', 12, '¬øÿ', 'both', 'UTF-8')
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testPadException()
    {
        $stringy = S::create('foo');
        $result = $stringy->pad(5, 'foo', 'bar');
    }

    /**
     * @dataProvider padLeftProvider()
     */
    public function testPadLeft($expected, $str, $length, $padStr = ' ',
                                $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->padLeft($length, $padStr);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function padLeftProvider()
    {
        return array(
            array('  foo bar', 'foo bar', 9),
            array('_*foo bar', 'foo bar', 9, '_*'),
            array('_*_foo bar', 'foo bar', 10, '_*'),
            array('  fòô bàř', 'fòô bàř', 9, ' ', 'UTF-8'),
            array('¬øfòô bàř', 'fòô bàř', 9, '¬ø', 'UTF-8'),
            array('¬ø¬fòô bàř', 'fòô bàř', 10, '¬ø', 'UTF-8'),
            array('¬ø¬øfòô bàř', 'fòô bàř', 11, '¬ø', 'UTF-8'),
        );
    }

    /**
     * @dataProvider padRightProvider()
     */
    public function testPadRight($expected, $str, $length, $padStr = ' ',
                                 $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->padRight($length, $padStr);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function padRightProvider()
    {
        return array(
            array('foo bar  ', 'foo bar', 9),
            array('foo bar_*', 'foo bar', 9, '_*'),
            array('foo bar_*_', 'foo bar', 10, '_*'),
            array('fòô bàř  ', 'fòô bàř', 9, ' ', 'UTF-8'),
            array('fòô bàř¬ø', 'fòô bàř', 9, '¬ø', 'UTF-8'),
            array('fòô bàř¬ø¬', 'fòô bàř', 10, '¬ø', 'UTF-8'),
            array('fòô bàř¬ø¬ø', 'fòô bàř', 11, '¬ø', 'UTF-8'),
        );
    }

    /**
     * @dataProvider padBothProvider()
     */
    public function testPadBoth($expected, $str, $length, $padStr = ' ',
                                $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->padBoth($length, $padStr);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function padBothProvider()
    {
        return array(
            array('foo bar ', 'foo bar', 8),
            array(' foo bar ', 'foo bar', 9, ' '),
            array('fòô bàř ', 'fòô bàř', 8, ' ', 'UTF-8'),
            array(' fòô bàř ', 'fòô bàř', 9, ' ', 'UTF-8'),
            array('fòô bàř¬', 'fòô bàř', 8, '¬ø', 'UTF-8'),
            array('¬fòô bàř¬', 'fòô bàř', 9, '¬ø', 'UTF-8'),
            array('¬fòô bàř¬ø', 'fòô bàř', 10, '¬ø', 'UTF-8'),
            array('¬øfòô bàř¬ø', 'fòô bàř', 11, '¬ø', 'UTF-8'),
            array('¬fòô bàř¬ø', 'fòô bàř', 10, '¬øÿ', 'UTF-8'),
            array('¬øfòô bàř¬ø', 'fòô bàř', 11, '¬øÿ', 'UTF-8'),
            array('¬øfòô bàř¬øÿ', 'fòô bàř', 12, '¬øÿ', 'UTF-8')
        );
    }

    /**
     * @dataProvider startsWithProvider()
     */
    public function testStartsWith($expected, $str, $substring,
                                   $caseSensitive = true, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->startsWith($substring, $caseSensitive);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function startsWithProvider()
    {
        return array(
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
    }

    /**
     * @dataProvider startsWithProviderAny()
     */
    public function testStartsWithAny($expected, $str, $substrings,
                                      $caseSensitive = true, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->startsWithAny($substrings, $caseSensitive);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function startsWithProviderAny()
    {
        return array(
            array(true, 'foo bars', array('foo bar')),
            array(true, 'FOO bars', array('foo bar'), false),
            array(true, 'FOO bars', array('foo bar', 'foo BAR'), false),
            array(true, 'FÒÔ bàřs', array('foo bar', 'fòô bàř'), false, 'UTF-8'),
            array(true, 'fòô bàřs', array('foo bar', 'fòô BÀŘ'), false, 'UTF-8'),
            array(false, 'foo bar', array('bar')),
            array(false, 'foo bar', array('foo bars')),
            array(false, 'FOO bar', array('foo bars')),
            array(false, 'FOO bars', array('foo BAR')),
            array(false, 'FÒÔ bàřs', array('fòô bàř'), true, 'UTF-8'),
            array(false, 'fòô bàřs', array('fòô BÀŘ'), true, 'UTF-8'),
        );
    }

    /**
     * @dataProvider endsWithProvider()
     */
    public function testEndsWith($expected, $str, $substring,
                                 $caseSensitive = true, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->endsWith($substring, $caseSensitive);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function endsWithProvider()
    {
        return array(
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
    }

    /**
     * @dataProvider endsWithAnyProvider()
     */
    public function testEndsWithAny($expected, $str, $substrings,
                                    $caseSensitive = true, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->endsWithAny($substrings, $caseSensitive);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function endsWithAnyProvider()
    {
        return array(
            array(true, 'foo bars', array('foo', 'o bars')),
            array(true, 'FOO bars', array('foo', 'o bars'), false),
            array(true, 'FOO bars', array('foo', 'o BARs'), false),
            array(true, 'FÒÔ bàřs', array('foo', 'ô bàřs'), false, 'UTF-8'),
            array(true, 'fòô bàřs', array('foo', 'ô BÀŘs'), false, 'UTF-8'),
            array(false, 'foo bar', array('foo')),
            array(false, 'foo bar', array('foo', 'foo bars')),
            array(false, 'FOO bar', array('foo', 'foo bars')),
            array(false, 'FOO bars', array('foo', 'foo BARS')),
            array(false, 'FÒÔ bàřs', array('fòô', 'fòô bàřs'), true, 'UTF-8'),
            array(false, 'fòô bàřs', array('fòô', 'fòô BÀŘS'), true, 'UTF-8'),
        );
    }

    /**
     * @dataProvider toBooleanProvider()
     */
    public function testToBoolean($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->toBoolean();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function toBooleanProvider()
    {
        return array(
            array(true, 'true'),
            array(true, '1'),
            array(true, 'on'),
            array(true, 'ON'),
            array(true, 'yes'),
            array(true, '999'),
            array(false, 'false'),
            array(false, '0'),
            array(false, 'off'),
            array(false, 'OFF'),
            array(false, 'no'),
            array(false, '-999'),
            array(false, ''),
            array(false, ' '),
            array(false, '  ', 'UTF-8') // narrow no-break space (U+202F)
        );
    }

    /**
     * @dataProvider toSpacesProvider()
     */
    public function testToSpaces($expected, $str, $tabLength = 4)
    {
        $stringy = S::create($str);
        $result = $stringy->toSpaces($tabLength);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function toSpacesProvider()
    {
        return array(
            array('    foo    bar    ', '	foo	bar	'),
            array('     foo     bar     ', '	foo	bar	', 5),
            array('    foo  bar  ', '		foo	bar	', 2),
            array('foobar', '	foo	bar	', 0),
            array("    foo\n    bar", "	foo\n	bar"),
            array("    fòô\n    bàř", "	fòô\n	bàř")
        );
    }

    /**
     * @dataProvider toTabsProvider()
     */
    public function testToTabs($expected, $str, $tabLength = 4)
    {
        $stringy = S::create($str);
        $result = $stringy->toTabs($tabLength);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function toTabsProvider()
    {
        return array(
            array('	foo	bar	', '    foo    bar    '),
            array('	foo	bar	', '     foo     bar     ', 5),
            array('		foo	bar	', '    foo  bar  ', 2),
            array("	foo\n	bar", "    foo\n    bar"),
            array("	fòô\n	bàř", "    fòô\n    bàř")
        );
    }

    /**
     * @dataProvider toLowerCaseProvider()
     */
    public function testToLowerCase($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->toLowerCase();
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function toLowerCaseProvider()
    {
        return array(
            array('foo bar', 'FOO BAR'),
            array(' foo_bar ', ' FOO_bar '),
            array('fòô bàř', 'FÒÔ BÀŘ', 'UTF-8'),
            array(' fòô_bàř ', ' FÒÔ_bàř ', 'UTF-8'),
            array('αυτοκίνητο', 'ΑΥΤΟΚΊΝΗΤΟ', 'UTF-8'),
        );
    }

    /**
     * @dataProvider toTitleCaseProvider()
     */
    public function testToTitleCase($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->toTitleCase();
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function toTitleCaseProvider()
    {
        return array(
            array('Foo Bar', 'foo bar'),
            array(' Foo_Bar ', ' foo_bar '),
            array('Fòô Bàř', 'fòô bàř', 'UTF-8'),
            array(' Fòô_Bàř ', ' fòô_bàř ', 'UTF-8'),
            array('Αυτοκίνητο Αυτοκίνητο', 'αυτοκίνητο αυτοκίνητο', 'UTF-8'),
        );
    }

    /**
     * @dataProvider toUpperCaseProvider()
     */
    public function testToUpperCase($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->toUpperCase();
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function toUpperCaseProvider()
    {
        return array(
            array('FOO BAR', 'foo bar'),
            array(' FOO_BAR ', ' FOO_bar '),
            array('FÒÔ BÀŘ', 'fòô bàř', 'UTF-8'),
            array(' FÒÔ_BÀŘ ', ' FÒÔ_bàř ', 'UTF-8'),
            array('ΑΥΤΟΚΊΝΗΤΟ', 'αυτοκίνητο', 'UTF-8'),
        );
    }

    /**
     * @dataProvider slugifyProvider()
     */
    public function testSlugify($expected, $str, $replacement = '-')
    {
        $stringy = S::create($str);
        $result = $stringy->slugify($replacement);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function slugifyProvider()
    {
        return array(
            array('foo-bar', ' foo  bar '),
            array('foo-bar', 'foo -.-"-...bar'),
            array('another-foo-bar', 'another..& foo -.-"-...bar'),
            array('foo-dbar', " Foo d'Bar "),
            array('a-string-with-dashes', 'A string-with-dashes'),
            array('using-strings-like-foo-bar', 'Using strings like fòô bàř'),
            array('numbers-1234', 'numbers 1234'),
            array('perevirka-ryadka', 'перевірка рядка'),
            array('bukvar-s-bukvoy-y', 'букварь с буквой ы'),
            array('podekhal-k-podezdu-moego-doma', 'подъехал к подъезду моего дома'),
            array('foo:bar:baz', 'Foo bar baz', ':'),
            array('a_string_with_underscores', 'A_string with_underscores', '_'),
            array('a_string_with_dashes', 'A string-with-dashes', '_'),
            array('a\string\with\dashes', 'A string-with-dashes', '\\'),
            array('an_odd_string', '--   An odd__   string-_', '_')
        );
    }

    /**
     * @dataProvider betweenProvider()
     */
    public function testBetween($expected, $str, $start, $end, $offset = null,
                                $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->between($start, $end, $offset);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function betweenProvider()
    {
        return array(
            array('', 'foo', '{', '}'),
            array('', '{foo', '{', '}'),
            array('foo', '{foo}', '{', '}'),
            array('{foo', '{{foo}', '{', '}'),
            array('', '{}foo}', '{', '}'),
            array('foo', '}{foo}', '{', '}'),
            array('foo', 'A description of {foo} goes here', '{', '}'),
            array('bar', '{foo} and {bar}', '{', '}', 1),
            array('', 'fòô', '{', '}', 0, 'UTF-8'),
            array('', '{fòô', '{', '}', 0, 'UTF-8'),
            array('fòô', '{fòô}', '{', '}', 0, 'UTF-8'),
            array('{fòô', '{{fòô}', '{', '}', 0, 'UTF-8'),
            array('', '{}fòô}', '{', '}', 0, 'UTF-8'),
            array('fòô', '}{fòô}', '{', '}', 0, 'UTF-8'),
            array('fòô', 'A description of {fòô} goes here', '{', '}', 0, 'UTF-8'),
            array('bàř', '{fòô} and {bàř}', '{', '}', 1, 'UTF-8')
        );
    }

    /**
     * @dataProvider containsProvider()
     */
    public function testContains($expected, $haystack, $needle,
                                 $caseSensitive = true, $encoding = null)
    {
        $stringy = S::create($haystack, $encoding);
        $result = $stringy->contains($needle, $caseSensitive);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($haystack, $stringy);
    }

    public function containsProvider()
    {
        return array(
            array(true, 'Str contains foo bar', 'foo bar'),
            array(true, '12398!@(*%!@# @!%#*&^%',  ' @!%#*&^%'),
            array(true, 'Ο συγγραφέας είπε', 'συγγραφέας', 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', 'å´¥©', true, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', 'å˚ ∆', true, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', 'øœ¬', true, 'UTF-8'),
            array(false, 'Str contains foo bar', 'Foo bar'),
            array(false, 'Str contains foo bar', 'foobar'),
            array(false, 'Str contains foo bar', 'foo bar '),
            array(false, 'Ο συγγραφέας είπε', '  συγγραφέας ', true, 'UTF-8'),
            array(false, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', ' ßå˚', true, 'UTF-8'),
            array(true, 'Str contains foo bar', 'Foo bar', false),
            array(true, '12398!@(*%!@# @!%#*&^%',  ' @!%#*&^%', false),
            array(true, 'Ο συγγραφέας είπε', 'ΣΥΓΓΡΑΦΈΑΣ', false, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', 'Å´¥©', false, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', 'Å˚ ∆', false, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', 'ØŒ¬', false, 'UTF-8'),
            array(false, 'Str contains foo bar', 'foobar', false),
            array(false, 'Str contains foo bar', 'foo bar ', false),
            array(false, 'Ο συγγραφέας είπε', '  συγγραφέας ', false, 'UTF-8'),
            array(false, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', ' ßÅ˚', false, 'UTF-8')
        );
    }

    /**
     * @dataProvider containsAnyProvider()
     */
    public function testcontainsAny($expected, $haystack, $needles,
                                    $caseSensitive = true, $encoding = null)
    {
        $stringy = S::create($haystack, $encoding);
        $result = $stringy->containsAny($needles, $caseSensitive);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($haystack, $stringy);
    }

    public function containsAnyProvider()
    {
        // One needle
        $singleNeedle = array_map(function ($array) {
            $array[2] = array($array[2]);
            return $array;
        }, $this->containsProvider());

        $provider = array(
            // No needles
            array(false, 'Str contains foo bar', array()),
            // Multiple needles
            array(true, 'Str contains foo bar', array('foo', 'bar')),
            array(true, '12398!@(*%!@# @!%#*&^%', array(' @!%#*', '&^%')),
            array(true, 'Ο συγγραφέας είπε', array('συγγρ', 'αφέας'), 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('å´¥', '©'), true, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('å˚ ', '∆'), true, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('øœ', '¬'), true, 'UTF-8'),
            array(false, 'Str contains foo bar', array('Foo', 'Bar')),
            array(false, 'Str contains foo bar', array('foobar', 'bar ')),
            array(false, 'Str contains foo bar', array('foo bar ', '  foo')),
            array(false, 'Ο συγγραφέας είπε', array('  συγγραφέας ', '  συγγραφ '), true, 'UTF-8'),
            array(false, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array(' ßå˚', ' ß '), true, 'UTF-8'),
            array(true, 'Str contains foo bar', array('Foo bar', 'bar'), false),
            array(true, '12398!@(*%!@# @!%#*&^%', array(' @!%#*&^%', '*&^%'), false),
            array(true, 'Ο συγγραφέας είπε', array('ΣΥΓΓΡΑΦΈΑΣ', 'ΑΦΈΑ'), false, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('Å´¥©', '¥©'), false, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('Å˚ ∆', ' ∆'), false, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('ØŒ¬', 'Œ'), false, 'UTF-8'),
            array(false, 'Str contains foo bar', array('foobar', 'none'), false),
            array(false, 'Str contains foo bar', array('foo bar ', ' ba '), false),
            array(false, 'Ο συγγραφέας είπε', array('  συγγραφέας ', ' ραφέ '), false, 'UTF-8'),
            array(false, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array(' ßÅ˚', ' Å˚ '), false, 'UTF-8'),
        );

        return array_merge($singleNeedle, $provider);
    }

    /**
     * @dataProvider containsAllProvider()
     */
    public function testContainsAll($expected, $haystack, $needles,
                                    $caseSensitive = true, $encoding = null)
    {
        $stringy = S::create($haystack, $encoding);
        $result = $stringy->containsAll($needles, $caseSensitive);
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($haystack, $stringy);
    }

    public function containsAllProvider()
    {
        // One needle
        $singleNeedle = array_map(function ($array) {
            $array[2] = array($array[2]);
            return $array;
        }, $this->containsProvider());

        $provider = array(
            // One needle
            array(false, 'Str contains foo bar', array()),
            // Multiple needles
            array(true, 'Str contains foo bar', array('foo', 'bar')),
            array(true, '12398!@(*%!@# @!%#*&^%', array(' @!%#*', '&^%')),
            array(true, 'Ο συγγραφέας είπε', array('συγγρ', 'αφέας'), 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('å´¥', '©'), true, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('å˚ ', '∆'), true, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('øœ', '¬'), true, 'UTF-8'),
            array(false, 'Str contains foo bar', array('Foo', 'bar')),
            array(false, 'Str contains foo bar', array('foobar', 'bar')),
            array(false, 'Str contains foo bar', array('foo bar ', 'bar')),
            array(false, 'Ο συγγραφέας είπε', array('  συγγραφέας ', '  συγγραφ '), true, 'UTF-8'),
            array(false, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array(' ßå˚', ' ß '), true, 'UTF-8'),
            array(true, 'Str contains foo bar', array('Foo bar', 'bar'), false),
            array(true, '12398!@(*%!@# @!%#*&^%', array(' @!%#*&^%', '*&^%'), false),
            array(true, 'Ο συγγραφέας είπε', array('ΣΥΓΓΡΑΦΈΑΣ', 'ΑΦΈΑ'), false, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('Å´¥©', '¥©'), false, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('Å˚ ∆', ' ∆'), false, 'UTF-8'),
            array(true, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array('ØŒ¬', 'Œ'), false, 'UTF-8'),
            array(false, 'Str contains foo bar', array('foobar', 'none'), false),
            array(false, 'Str contains foo bar', array('foo bar ', ' ba'), false),
            array(false, 'Ο συγγραφέας είπε', array('  συγγραφέας ', ' ραφέ '), false, 'UTF-8'),
            array(false, 'å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', array(' ßÅ˚', ' Å˚ '), false, 'UTF-8'),
        );

        return array_merge($singleNeedle, $provider);
    }

    /**
     * @dataProvider surroundProvider()
     */
    public function testSurround($expected, $str, $substring)
    {
        $stringy = S::create($str);
        $result = $stringy->surround($substring);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function surroundProvider()
    {
        return array(
            array('__foobar__', 'foobar', '__'),
            array('test', 'test', ''),
            array('**', '', '*'),
            array('¬fòô bàř¬', 'fòô bàř', '¬'),
            array('ßå∆˚ test ßå∆˚', ' test ', 'ßå∆˚')
        );
    }

    /**
     * @dataProvider insertProvider()
     */
    public function testInsert($expected, $str, $substring, $index,
                               $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->insert($substring, $index);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function insertProvider()
    {
        return array(
            array('foo bar', 'oo bar', 'f', 0),
            array('foo bar', 'f bar', 'oo', 1),
            array('f bar', 'f bar', 'oo', 20),
            array('foo bar', 'foo ba', 'r', 6),
            array('fòôbàř', 'fòôbř', 'à', 4, 'UTF-8'),
            array('fòô bàř', 'òô bàř', 'f', 0, 'UTF-8'),
            array('fòô bàř', 'f bàř', 'òô', 1, 'UTF-8'),
            array('fòô bàř', 'fòô bà', 'ř', 6, 'UTF-8')
        );
    }

    /**
     * @dataProvider truncateProvider()
     */
    public function testTruncate($expected, $str, $length, $substring = '',
                                 $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->truncate($length, $substring);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function truncateProvider()
    {
        return array(
            array('Test foo bar', 'Test foo bar', 12),
            array('Test foo ba', 'Test foo bar', 11),
            array('Test foo', 'Test foo bar', 8),
            array('Test fo', 'Test foo bar', 7),
            array('Test', 'Test foo bar', 4),
            array('Test foo bar', 'Test foo bar', 12, '...'),
            array('Test foo...', 'Test foo bar', 11, '...'),
            array('Test ...', 'Test foo bar', 8, '...'),
            array('Test...', 'Test foo bar', 7, '...'),
            array('T...', 'Test foo bar', 4, '...'),
            array('Test fo....', 'Test foo bar', 11, '....'),
            array('Test fòô bàř', 'Test fòô bàř', 12, '', 'UTF-8'),
            array('Test fòô bà', 'Test fòô bàř', 11, '', 'UTF-8'),
            array('Test fòô', 'Test fòô bàř', 8, '', 'UTF-8'),
            array('Test fò', 'Test fòô bàř', 7, '', 'UTF-8'),
            array('Test', 'Test fòô bàř', 4, '', 'UTF-8'),
            array('Test fòô bàř', 'Test fòô bàř', 12, 'ϰϰ', 'UTF-8'),
            array('Test fòô ϰϰ', 'Test fòô bàř', 11, 'ϰϰ', 'UTF-8'),
            array('Test fϰϰ', 'Test fòô bàř', 8, 'ϰϰ', 'UTF-8'),
            array('Test ϰϰ', 'Test fòô bàř', 7, 'ϰϰ', 'UTF-8'),
            array('Teϰϰ', 'Test fòô bàř', 4, 'ϰϰ', 'UTF-8'),
            array('What are your pl...', 'What are your plans today?', 19, '...')
        );
    }

    /**
     * @dataProvider safeTruncateProvider()
     */
    public function testSafeTruncate($expected, $str, $length, $substring = '',
                                     $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->safeTruncate($length, $substring);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function safeTruncateProvider()
    {
        return array(
            array('Test foo bar', 'Test foo bar', 12),
            array('Test foo', 'Test foo bar', 11),
            array('Test foo', 'Test foo bar', 8),
            array('Test', 'Test foo bar', 7),
            array('Test', 'Test foo bar', 4),
            array('Test foo bar', 'Test foo bar', 12, '...'),
            array('Test foo...', 'Test foo bar', 11, '...'),
            array('Test...', 'Test foo bar', 8, '...'),
            array('Test...', 'Test foo bar', 7, '...'),
            array('T...', 'Test foo bar', 4, '...'),
            array('Test....', 'Test foo bar', 11, '....'),
            array('Tëst fòô bàř', 'Tëst fòô bàř', 12, '', 'UTF-8'),
            array('Tëst fòô', 'Tëst fòô bàř', 11, '', 'UTF-8'),
            array('Tëst fòô', 'Tëst fòô bàř', 8, '', 'UTF-8'),
            array('Tëst', 'Tëst fòô bàř', 7, '', 'UTF-8'),
            array('Tëst', 'Tëst fòô bàř', 4, '', 'UTF-8'),
            array('Tëst fòô bàř', 'Tëst fòô bàř', 12, 'ϰϰ', 'UTF-8'),
            array('Tëst fòôϰϰ', 'Tëst fòô bàř', 11, 'ϰϰ', 'UTF-8'),
            array('Tëstϰϰ', 'Tëst fòô bàř', 8, 'ϰϰ', 'UTF-8'),
            array('Tëstϰϰ', 'Tëst fòô bàř', 7, 'ϰϰ', 'UTF-8'),
            array('Tëϰϰ', 'Tëst fòô bàř', 4, 'ϰϰ', 'UTF-8'),
            array('What are your plans...', 'What are your plans today?', 22, '...')
        );
    }

    /**
     * @dataProvider reverseProvider()
     */
    public function testReverse($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->reverse();
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function reverseProvider()
    {
        return array(
            array('', ''),
            array('raboof', 'foobar'),
            array('řàbôòf', 'fòôbàř', 'UTF-8'),
            array('řàb ôòf', 'fòô bàř', 'UTF-8'),
            array('∂∆ ˚åß', 'ßå˚ ∆∂', 'UTF-8')
        );
    }

    /**
     * @dataProvider repeatProvider()
     */
    public function testRepeat($expected, $str, $multiplier, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->repeat($multiplier);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function repeatProvider()
    {
        return array(
            array('', 'foo', 0),
            array('foo', 'foo', 1),
            array('foofoo', 'foo', 2),
            array('foofoofoo', 'foo', 3),
            array('fòô', 'fòô', 1, 'UTF-8'),
            array('fòôfòô', 'fòô', 2, 'UTF-8'),
            array('fòôfòôfòô', 'fòô', 3, 'UTF-8')
        );
    }

    /**
     * @dataProvider shuffleProvider()
     */
    public function testShuffle($str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $encoding = $encoding ?: mb_internal_encoding();
        $result = $stringy->shuffle();

        $this->assertStringy($result);
        $this->assertEquals($str, $stringy);
        $this->assertEquals(mb_strlen($str, $encoding),
            mb_strlen($result, $encoding));

        // We'll make sure that the chars are present after shuffle
        for ($i = 0; $i < mb_strlen($str, $encoding); $i++) {
            $char = mb_substr($str, $i, 1, $encoding);
            $countBefore = mb_substr_count($str, $char, $encoding);
            $countAfter = mb_substr_count($result, $char, $encoding);
            $this->assertEquals($countBefore, $countAfter);
        }
    }

    public function shuffleProvider()
    {
        return array(
            array('foo bar'),
            array('∂∆ ˚åß', 'UTF-8'),
            array('å´¥©¨ˆßå˚ ∆∂˙©å∑¥øœ¬', 'UTF-8')
        );
    }

    /**
     * @dataProvider trimProvider()
     */
    public function testTrim($expected, $str, $chars = null, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->trim($chars);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function trimProvider()
    {
        return array(
            array('foo   bar', '  foo   bar  '),
            array('foo bar', ' foo bar'),
            array('foo bar', 'foo bar '),
            array('foo bar', "\n\t foo bar \n\t"),
            array('fòô   bàř', '  fòô   bàř  '),
            array('fòô bàř', ' fòô bàř'),
            array('fòô bàř', 'fòô bàř '),
            array(' foo bar ', "\n\t foo bar \n\t", "\n\t"),
            array('fòô bàř', "\n\t fòô bàř \n\t", null, 'UTF-8'),
            array('fòô', ' fòô ', null, 'UTF-8'), // narrow no-break space (U+202F)
            array('fòô', '  fòô  ', null, 'UTF-8'), // medium mathematical space (U+205F)
            array('fòô', '           fòô', null, 'UTF-8') // spaces U+2000 to U+200A
        );
    }

    /**
     * @dataProvider trimLeftProvider()
     */
    public function testTrimLeft($expected, $str, $chars = null,
                                 $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->trimLeft($chars);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function trimLeftProvider()
    {
        return array(
            array('foo   bar  ', '  foo   bar  '),
            array('foo bar', ' foo bar'),
            array('foo bar ', 'foo bar '),
            array("foo bar \n\t", "\n\t foo bar \n\t"),
            array('fòô   bàř  ', '  fòô   bàř  '),
            array('fòô bàř', ' fòô bàř'),
            array('fòô bàř ', 'fòô bàř '),
            array('foo bar', '--foo bar', '-'),
            array('fòô bàř', 'òòfòô bàř', 'ò', 'UTF-8'),
            array("fòô bàř \n\t", "\n\t fòô bàř \n\t", null, 'UTF-8'),
            array('fòô ', ' fòô ', null, 'UTF-8'), // narrow no-break space (U+202F)
            array('fòô  ', '  fòô  ', null, 'UTF-8'), // medium mathematical space (U+205F)
            array('fòô', '           fòô', null, 'UTF-8') // spaces U+2000 to U+200A
        );
    }

    /**
     * @dataProvider trimRightProvider()
     */
    public function testTrimRight($expected, $str, $chars = null,
                                  $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->trimRight($chars);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function trimRightProvider()
    {
        return array(
            array('  foo   bar', '  foo   bar  '),
            array('foo bar', 'foo bar '),
            array(' foo bar', ' foo bar'),
            array("\n\t foo bar", "\n\t foo bar \n\t"),
            array('  fòô   bàř', '  fòô   bàř  '),
            array('fòô bàř', 'fòô bàř '),
            array(' fòô bàř', ' fòô bàř'),
            array('foo bar', 'foo bar--', '-'),
            array('fòô bàř', 'fòô bàřòò', 'ò', 'UTF-8'),
            array("\n\t fòô bàř", "\n\t fòô bàř \n\t", null, 'UTF-8'),
            array(' fòô', ' fòô ', null, 'UTF-8'), // narrow no-break space (U+202F)
            array('  fòô', '  fòô  ', null, 'UTF-8'), // medium mathematical space (U+205F)
            array('fòô', 'fòô           ', null, 'UTF-8') // spaces U+2000 to U+200A
        );
    }

    /**
     * @dataProvider longestCommonPrefixProvider()
     */
    public function testLongestCommonPrefix($expected, $str, $otherStr,
                                            $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->longestCommonPrefix($otherStr);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function longestCommonPrefixProvider()
    {
        return array(
            array('foo', 'foobar', 'foo bar'),
            array('foo bar', 'foo bar', 'foo bar'),
            array('f', 'foo bar', 'far boo'),
            array('', 'toy car', 'foo bar'),
            array('', 'foo bar', ''),
            array('fòô', 'fòôbar', 'fòô bar', 'UTF-8'),
            array('fòô bar', 'fòô bar', 'fòô bar', 'UTF-8'),
            array('fò', 'fòô bar', 'fòr bar', 'UTF-8'),
            array('', 'toy car', 'fòô bar', 'UTF-8'),
            array('', 'fòô bar', '', 'UTF-8'),
        );
    }

    /**
     * @dataProvider longestCommonSuffixProvider()
     */
    public function testLongestCommonSuffix($expected, $str, $otherStr,
                                            $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->longestCommonSuffix($otherStr);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function longestCommonSuffixProvider()
    {
        return array(
            array('bar', 'foobar', 'foo bar'),
            array('foo bar', 'foo bar', 'foo bar'),
            array('ar', 'foo bar', 'boo far'),
            array('', 'foo bad', 'foo bar'),
            array('', 'foo bar', ''),
            array('bàř', 'fòôbàř', 'fòô bàř', 'UTF-8'),
            array('fòô bàř', 'fòô bàř', 'fòô bàř', 'UTF-8'),
            array(' bàř', 'fòô bàř', 'fòr bàř', 'UTF-8'),
            array('', 'toy car', 'fòô bàř', 'UTF-8'),
            array('', 'fòô bàř', '', 'UTF-8'),
        );
    }

    /**
     * @dataProvider longestCommonSubstringProvider()
     */
    public function testLongestCommonSubstring($expected, $str, $otherStr,
                                               $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->longestCommonSubstring($otherStr);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function longestCommonSubstringProvider()
    {
        return array(
            array('foo', 'foobar', 'foo bar'),
            array('foo bar', 'foo bar', 'foo bar'),
            array('oo ', 'foo bar', 'boo far'),
            array('foo ba', 'foo bad', 'foo bar'),
            array('', 'foo bar', ''),
            array('fòô', 'fòôbàř', 'fòô bàř', 'UTF-8'),
            array('fòô bàř', 'fòô bàř', 'fòô bàř', 'UTF-8'),
            array(' bàř', 'fòô bàř', 'fòr bàř', 'UTF-8'),
            array(' ', 'toy car', 'fòô bàř', 'UTF-8'),
            array('', 'fòô bàř', '', 'UTF-8'),
        );
    }

    /**
     * @dataProvider lengthProvider()
     */
    public function testLength($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->length();
        $this->assertInternalType('int', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function lengthProvider()
    {
        return array(
            array(11, '  foo bar  '),
            array(1, 'f'),
            array(0, ''),
            array(7, 'fòô bàř', 'UTF-8')
        );
    }

    /**
     * @dataProvider sliceProvider()
     */
    public function testSlice($expected, $str, $start, $end = null,
                              $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->slice($start, $end);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function sliceProvider()
    {
        return array(
            array('foobar', 'foobar', 0),
            array('foobar', 'foobar', 0, null),
            array('foobar', 'foobar', 0, 6),
            array('fooba', 'foobar', 0, 5),
            array('', 'foobar', 3, 0),
            array('', 'foobar', 3, 2),
            array('ba', 'foobar', 3, 5),
            array('ba', 'foobar', 3, -1),
            array('fòôbàř', 'fòôbàř', 0, null, 'UTF-8'),
            array('fòôbàř', 'fòôbàř', 0, null),
            array('fòôbàř', 'fòôbàř', 0, 6, 'UTF-8'),
            array('fòôbà', 'fòôbàř', 0, 5, 'UTF-8'),
            array('', 'fòôbàř', 3, 0, 'UTF-8'),
            array('', 'fòôbàř', 3, 2, 'UTF-8'),
            array('bà', 'fòôbàř', 3, 5, 'UTF-8'),
            array('bà', 'fòôbàř', 3, -1, 'UTF-8')
        );
    }

    /**
     * @dataProvider splitProvider()
     */
    public function testSplit($expected, $str, $pattern, $limit = null,
                              $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->split($pattern, $limit);

        $this->assertInternalType('array', $result);
        foreach ($result as $string) {
            $this->assertStringy($string);
        }

        for ($i = 0; $i < count($expected); $i++) {
            $this->assertEquals($expected[$i], $result[$i]);
        }
    }

    public function splitProvider()
    {
        return array(
            array(array('foo,bar,baz'), 'foo,bar,baz', ''),
            array(array('foo,bar,baz'), 'foo,bar,baz', '-'),
            array(array('foo', 'bar', 'baz'), 'foo,bar,baz', ','),
            array(array('foo', 'bar', 'baz'), 'foo,bar,baz', ',', null),
            array(array('foo', 'bar', 'baz'), 'foo,bar,baz', ',', -1),
            array(array(), 'foo,bar,baz', ',', 0),
            array(array('foo'), 'foo,bar,baz', ',', 1),
            array(array('foo', 'bar'), 'foo,bar,baz', ',', 2),
            array(array('foo', 'bar', 'baz'), 'foo,bar,baz', ',', 3),
            array(array('foo', 'bar', 'baz'), 'foo,bar,baz', ',', 10),
            array(array('fòô,bàř,baz'), 'fòô,bàř,baz', '-', null, 'UTF-8'),
            array(array('fòô', 'bàř', 'baz'), 'fòô,bàř,baz', ',', null, 'UTF-8'),
            array(array('fòô', 'bàř', 'baz'), 'fòô,bàř,baz', ',', null, 'UTF-8'),
            array(array('fòô', 'bàř', 'baz'), 'fòô,bàř,baz', ',', -1, 'UTF-8'),
            array(array(), 'fòô,bàř,baz', ',', 0, 'UTF-8'),
            array(array('fòô'), 'fòô,bàř,baz', ',', 1, 'UTF-8'),
            array(array('fòô', 'bàř'), 'fòô,bàř,baz', ',', 2, 'UTF-8'),
            array(array('fòô', 'bàř', 'baz'), 'fòô,bàř,baz', ',', 3, 'UTF-8'),
            array(array('fòô', 'bàř', 'baz'), 'fòô,bàř,baz', ',', 10, 'UTF-8')
        );
    }

    /**
     * @dataProvider stripWhitespaceProvider()
     */
    public function testStripWhitespace($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->stripWhitespace();
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function stripWhitespaceProvider()
    {
        return array(
            array('foobar', '  foo   bar  '),
            array('teststring', 'test string'),
            array('Οσυγγραφέας', '   Ο     συγγραφέας  '),
            array('123', ' 123 '),
            array('', ' ', 'UTF-8'), // no-break space (U+00A0)
            array('', '           ', 'UTF-8'), // spaces U+2000 to U+200A
            array('', ' ', 'UTF-8'), // narrow no-break space (U+202F)
            array('', ' ', 'UTF-8'), // medium mathematical space (U+205F)
            array('', '　', 'UTF-8'), // ideographic space (U+3000)
            array('123', '  1  2  3　　', 'UTF-8'),
            array('', ' '),
            array('', ''),
        );
    }

    /**
     * @dataProvider substrProvider()
     */
    public function testSubstr($expected, $str, $start, $length = null,
                               $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->substr($start, $length);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function substrProvider()
    {
        return array(
            array('foo bar', 'foo bar', 0),
            array('bar', 'foo bar', 4),
            array('bar', 'foo bar', 4, null),
            array('o b', 'foo bar', 2, 3),
            array('', 'foo bar', 4, 0),
            array('fòô bàř', 'fòô bàř', 0, null, 'UTF-8'),
            array('bàř', 'fòô bàř', 4, null, 'UTF-8'),
            array('ô b', 'fòô bàř', 2, 3, 'UTF-8'),
            array('', 'fòô bàř', 4, 0, 'UTF-8')
        );
    }

    /**
     * @dataProvider atProvider()
     */
    public function testAt($expected, $str, $index, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->at($index);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function atProvider()
    {
        return array(
            array('f', 'foo bar', 0),
            array('o', 'foo bar', 1),
            array('r', 'foo bar', 6),
            array('', 'foo bar', 7),
            array('f', 'fòô bàř', 0, 'UTF-8'),
            array('ò', 'fòô bàř', 1, 'UTF-8'),
            array('ř', 'fòô bàř', 6, 'UTF-8'),
            array('', 'fòô bàř', 7, 'UTF-8'),
        );
    }

    /**
     * @dataProvider firstProvider()
     */
    public function testFirst($expected, $str, $n, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->first($n);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function firstProvider()
    {
        return array(
            array('', 'foo bar', -5),
            array('', 'foo bar', 0),
            array('f', 'foo bar', 1),
            array('foo', 'foo bar', 3),
            array('foo bar', 'foo bar', 7),
            array('foo bar', 'foo bar', 8),
            array('', 'fòô bàř', -5, 'UTF-8'),
            array('', 'fòô bàř', 0, 'UTF-8'),
            array('f', 'fòô bàř', 1, 'UTF-8'),
            array('fòô', 'fòô bàř', 3, 'UTF-8'),
            array('fòô bàř', 'fòô bàř', 7, 'UTF-8'),
            array('fòô bàř', 'fòô bàř', 8, 'UTF-8'),
        );
    }

    /**
     * @dataProvider lastProvider()
     */
    public function testLast($expected, $str, $n, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->last($n);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function lastProvider()
    {
        return array(
            array('', 'foo bar', -5),
            array('', 'foo bar', 0),
            array('r', 'foo bar', 1),
            array('bar', 'foo bar', 3),
            array('foo bar', 'foo bar', 7),
            array('foo bar', 'foo bar', 8),
            array('', 'fòô bàř', -5, 'UTF-8'),
            array('', 'fòô bàř', 0, 'UTF-8'),
            array('ř', 'fòô bàř', 1, 'UTF-8'),
            array('bàř', 'fòô bàř', 3, 'UTF-8'),
            array('fòô bàř', 'fòô bàř', 7, 'UTF-8'),
            array('fòô bàř', 'fòô bàř', 8, 'UTF-8'),
        );
    }

    /**
     * @dataProvider ensureLeftProvider()
     */
    public function testEnsureLeft($expected, $str, $substring, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->ensureLeft($substring);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function ensureLeftProvider()
    {
        return array(
            array('foobar', 'foobar', 'f'),
            array('foobar', 'foobar', 'foo'),
            array('foo/foobar', 'foobar', 'foo/'),
            array('http://foobar', 'foobar', 'http://'),
            array('http://foobar', 'http://foobar', 'http://'),
            array('fòôbàř', 'fòôbàř', 'f', 'UTF-8'),
            array('fòôbàř', 'fòôbàř', 'fòô', 'UTF-8'),
            array('fòô/fòôbàř', 'fòôbàř', 'fòô/', 'UTF-8'),
            array('http://fòôbàř', 'fòôbàř', 'http://', 'UTF-8'),
            array('http://fòôbàř', 'http://fòôbàř', 'http://', 'UTF-8'),
        );
    }

    /**
     * @dataProvider ensureRightProvider()
     */
    public function testEnsureRight($expected, $str, $substring, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->ensureRight($substring);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function ensureRightProvider()
    {
        return array(
            array('foobar', 'foobar', 'r'),
            array('foobar', 'foobar', 'bar'),
            array('foobar/bar', 'foobar', '/bar'),
            array('foobar.com/', 'foobar', '.com/'),
            array('foobar.com/', 'foobar.com/', '.com/'),
            array('fòôbàř', 'fòôbàř', 'ř', 'UTF-8'),
            array('fòôbàř', 'fòôbàř', 'bàř', 'UTF-8'),
            array('fòôbàř/bàř', 'fòôbàř', '/bàř', 'UTF-8'),
            array('fòôbàř.com/', 'fòôbàř', '.com/', 'UTF-8'),
            array('fòôbàř.com/', 'fòôbàř.com/', '.com/', 'UTF-8'),
        );
    }

    /**
     * @dataProvider removeLeftProvider()
     */
    public function testRemoveLeft($expected, $str, $substring, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->removeLeft($substring);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function removeLeftProvider()
    {
        return array(
            array('foo bar', 'foo bar', ''),
            array('oo bar', 'foo bar', 'f'),
            array('bar', 'foo bar', 'foo '),
            array('foo bar', 'foo bar', 'oo'),
            array('foo bar', 'foo bar', 'oo bar'),
            array('oo bar', 'foo bar', S::create('foo bar')->first(1), 'UTF-8'),
            array('oo bar', 'foo bar', S::create('foo bar')->at(0), 'UTF-8'),
            array('fòô bàř', 'fòô bàř', '', 'UTF-8'),
            array('òô bàř', 'fòô bàř', 'f', 'UTF-8'),
            array('bàř', 'fòô bàř', 'fòô ', 'UTF-8'),
            array('fòô bàř', 'fòô bàř', 'òô', 'UTF-8'),
            array('fòô bàř', 'fòô bàř', 'òô bàř', 'UTF-8')
        );
    }

    /**
     * @dataProvider removeRightProvider()
     */
    public function testRemoveRight($expected, $str, $substring, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->removeRight($substring);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function removeRightProvider()
    {
        return array(
            array('foo bar', 'foo bar', ''),
            array('foo ba', 'foo bar', 'r'),
            array('foo', 'foo bar', ' bar'),
            array('foo bar', 'foo bar', 'ba'),
            array('foo bar', 'foo bar', 'foo ba'),
            array('foo ba', 'foo bar', S::create('foo bar')->last(1), 'UTF-8'),
            array('foo ba', 'foo bar', S::create('foo bar')->at(6), 'UTF-8'),
            array('fòô bàř', 'fòô bàř', '', 'UTF-8'),
            array('fòô bà', 'fòô bàř', 'ř', 'UTF-8'),
            array('fòô', 'fòô bàř', ' bàř', 'UTF-8'),
            array('fòô bàř', 'fòô bàř', 'bà', 'UTF-8'),
            array('fòô bàř', 'fòô bàř', 'fòô bà', 'UTF-8')
        );
    }

    /**
     * @dataProvider isAlphaProvider()
     */
    public function testIsAlpha($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->isAlpha();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function isAlphaProvider()
    {
        return array(
            array(true, ''),
            array(true, 'foobar'),
            array(false, 'foo bar'),
            array(false, 'foobar2'),
            array(true, 'fòôbàř', 'UTF-8'),
            array(false, 'fòô bàř', 'UTF-8'),
            array(false, 'fòôbàř2', 'UTF-8'),
            array(true, 'ҠѨњфгШ', 'UTF-8'),
            array(false, 'ҠѨњ¨ˆфгШ', 'UTF-8'),
            array(true, '丹尼爾', 'UTF-8')
        );
    }

    /**
     * @dataProvider isAlphanumericProvider()
     */
    public function testIsAlphanumeric($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->isAlphanumeric();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function isAlphanumericProvider()
    {
        return array(
            array(true, ''),
            array(true, 'foobar1'),
            array(false, 'foo bar'),
            array(false, 'foobar2"'),
            array(false, "\nfoobar\n"),
            array(true, 'fòôbàř1', 'UTF-8'),
            array(false, 'fòô bàř', 'UTF-8'),
            array(false, 'fòôbàř2"', 'UTF-8'),
            array(true, 'ҠѨњфгШ', 'UTF-8'),
            array(false, 'ҠѨњ¨ˆфгШ', 'UTF-8'),
            array(true, '丹尼爾111', 'UTF-8'),
            array(true, 'دانيال1', 'UTF-8'),
            array(false, 'دانيال1 ', 'UTF-8')
        );
    }

    /**
     * @dataProvider isBlankProvider()
     */
    public function testIsBlank($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->isBlank();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function isBlankProvider()
    {
        return array(
            array(true, ''),
            array(true, ' '),
            array(true, "\n\t "),
            array(true, "\n\t  \v\f"),
            array(false, "\n\t a \v\f"),
            array(false, "\n\t ' \v\f"),
            array(false, "\n\t 2 \v\f"),
            array(true, '', 'UTF-8'),
            array(true, ' ', 'UTF-8'), // no-break space (U+00A0)
            array(true, '           ', 'UTF-8'), // spaces U+2000 to U+200A
            array(true, ' ', 'UTF-8'), // narrow no-break space (U+202F)
            array(true, ' ', 'UTF-8'), // medium mathematical space (U+205F)
            array(true, '　', 'UTF-8'), // ideographic space (U+3000)
            array(false, '　z', 'UTF-8'),
            array(false, '　1', 'UTF-8'),
        );
    }

    /**
     * @dataProvider isJsonProvider()
     */
    public function testIsJson($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->isJson();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function isJsonProvider()
    {
        return array(
            array(false, ''),
            array(false, '  '),
            array(true, 'null'),
            array(true, 'true'),
            array(true, 'false'),
            array(true, '[]'),
            array(true, '{}'),
            array(true, '123'),
            array(true, '{"foo": "bar"}'),
            array(false, '{"foo":"bar",}'),
            array(false, '{"foo"}'),
            array(true, '["foo"]'),
            array(false, '{"foo": "bar"]'),
            array(true, '123', 'UTF-8'),
            array(true, '{"fòô": "bàř"}', 'UTF-8'),
            array(false, '{"fòô":"bàř",}', 'UTF-8'),
            array(false, '{"fòô"}', 'UTF-8'),
            array(false, '["fòô": "bàř"]', 'UTF-8'),
            array(true, '["fòô"]', 'UTF-8'),
            array(false, '{"fòô": "bàř"]', 'UTF-8'),
        );
    }

    /**
     * @dataProvider isLowerCaseProvider()
     */
    public function testIsLowerCase($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->isLowerCase();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function isLowerCaseProvider()
    {
        return array(
            array(true, ''),
            array(true, 'foobar'),
            array(false, 'foo bar'),
            array(false, 'Foobar'),
            array(true, 'fòôbàř', 'UTF-8'),
            array(false, 'fòôbàř2', 'UTF-8'),
            array(false, 'fòô bàř', 'UTF-8'),
            array(false, 'fòôbÀŘ', 'UTF-8'),
        );
    }

    /**
     * @dataProvider hasLowerCaseProvider()
     */
    public function testHasLowerCase($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->hasLowerCase();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function hasLowerCaseProvider()
    {
        return array(
            array(false, ''),
            array(true, 'foobar'),
            array(false, 'FOO BAR'),
            array(true, 'fOO BAR'),
            array(true, 'foO BAR'),
            array(true, 'FOO BAr'),
            array(true, 'Foobar'),
            array(false, 'FÒÔBÀŘ', 'UTF-8'),
            array(true, 'fòôbàř', 'UTF-8'),
            array(true, 'fòôbàř2', 'UTF-8'),
            array(true, 'Fòô bàř', 'UTF-8'),
            array(true, 'fòôbÀŘ', 'UTF-8'),
        );
    }

    /**
     * @dataProvider isSerializedProvider()
     */
    public function testIsSerialized($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->isSerialized();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function isSerializedProvider()
    {
        return array(
            array(false, ''),
            array(true, 'a:1:{s:3:"foo";s:3:"bar";}'),
            array(false, 'a:1:{s:3:"foo";s:3:"bar"}'),
            array(true, serialize(array('foo' => 'bar'))),
            array(true, 'a:1:{s:5:"fòô";s:5:"bàř";}', 'UTF-8'),
            array(false, 'a:1:{s:5:"fòô";s:5:"bàř"}', 'UTF-8'),
            array(true, serialize(array('fòô' => 'bár')), 'UTF-8'),
        );
    }

    /**
     * @dataProvider isBase64Provider()
     */
    public function testIsBase64($expected, $str)
    {
        $stringy = S::create($str);
        $result = $stringy->isBase64();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function isBase64Provider()
    {
        return array(
            array(false, ' '),
            array(true, ''),
            array(true, base64_encode('FooBar') ),
            array(true, base64_encode(' ') ),
            array(true, base64_encode('FÒÔBÀŘ') ),
            array(true, base64_encode('συγγραφέας') ),
            array(false, 'Foobar'),
        );
    }

    /**
     * @dataProvider isUpperCaseProvider()
     */
    public function testIsUpperCase($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->isUpperCase();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function isUpperCaseProvider()
    {
        return array(
            array(true, ''),
            array(true, 'FOOBAR'),
            array(false, 'FOO BAR'),
            array(false, 'fOOBAR'),
            array(true, 'FÒÔBÀŘ', 'UTF-8'),
            array(false, 'FÒÔBÀŘ2', 'UTF-8'),
            array(false, 'FÒÔ BÀŘ', 'UTF-8'),
            array(false, 'FÒÔBàř', 'UTF-8'),
        );
    }

    /**
     * @dataProvider hasUpperCaseProvider()
     */
    public function testHasUpperCase($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->hasUpperCase();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function hasUpperCaseProvider()
    {
        return array(
            array(false, ''),
            array(true, 'FOOBAR'),
            array(false, 'foo bar'),
            array(true, 'Foo bar'),
            array(true, 'FOo bar'),
            array(true, 'foo baR'),
            array(true, 'fOOBAR'),
            array(false, 'fòôbàř', 'UTF-8'),
            array(true, 'FÒÔBÀŘ', 'UTF-8'),
            array(true, 'FÒÔBÀŘ2', 'UTF-8'),
            array(true, 'fÒÔ BÀŘ', 'UTF-8'),
            array(true, 'FÒÔBàř', 'UTF-8'),
        );
    }

    /**
     * @dataProvider isHexadecimalProvider()
     */
    public function testIsHexadecimal($expected, $str, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->isHexadecimal();
        $this->assertInternalType('boolean', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function isHexadecimalProvider()
    {
        return array(
            array(true, ''),
            array(true, 'abcdef'),
            array(true, 'ABCDEF'),
            array(true, '0123456789'),
            array(true, '0123456789AbCdEf'),
            array(false, '0123456789x'),
            array(false, 'ABCDEFx'),
            array(true, 'abcdef', 'UTF-8'),
            array(true, 'ABCDEF', 'UTF-8'),
            array(true, '0123456789', 'UTF-8'),
            array(true, '0123456789AbCdEf', 'UTF-8'),
            array(false, '0123456789x', 'UTF-8'),
            array(false, 'ABCDEFx', 'UTF-8'),
        );
    }

    /**
     * @dataProvider countSubstrProvider()
     */
    public function testCountSubstr($expected, $str, $substring,
                                    $caseSensitive = true, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->countSubstr($substring, $caseSensitive);
        $this->assertInternalType('int', $result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function countSubstrProvider()
    {
        return array(
            array(0, '', 'foo'),
            array(0, 'foo', 'bar'),
            array(1, 'foo bar', 'foo'),
            array(2, 'foo bar', 'o'),
            array(0, '', 'fòô', 'UTF-8'),
            array(0, 'fòô', 'bàř', 'UTF-8'),
            array(1, 'fòô bàř', 'fòô', 'UTF-8'),
            array(2, 'fôòô bàř', 'ô', 'UTF-8'),
            array(0, 'fÔÒÔ bàř', 'ô', 'UTF-8'),
            array(0, 'foo', 'BAR', false),
            array(1, 'foo bar', 'FOo', false),
            array(2, 'foo bar', 'O', false),
            array(1, 'fòô bàř', 'fÒÔ', false, 'UTF-8'),
            array(2, 'fôòô bàř', 'Ô', false, 'UTF-8'),
            array(2, 'συγγραφέας', 'Σ', false, 'UTF-8')
        );
    }

    /**
     * @dataProvider replaceProvider()
     */
    public function testReplace($expected, $str, $search, $replacement,
                                $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->replace($search, $replacement);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function replaceProvider()
    {
        return array(
            array('', '', '', ''),
            array('foo', '', '', 'foo'),
            array('foo', '\s', '\s', 'foo'),
            array('foo bar', 'foo bar', '', ''),
            array('foo bar', 'foo bar', 'f(o)o', '\1'),
            array('\1 bar', 'foo bar', 'foo', '\1'),
            array('bar', 'foo bar', 'foo ', ''),
            array('far bar', 'foo bar', 'foo', 'far'),
            array('bar bar', 'foo bar foo bar', 'foo ', ''),
            array('', '', '', '', 'UTF-8'),
            array('fòô', '', '', 'fòô', 'UTF-8'),
            array('fòô', '\s', '\s', 'fòô', 'UTF-8'),
            array('fòô bàř', 'fòô bàř', '', '', 'UTF-8'),
            array('bàř', 'fòô bàř', 'fòô ', '', 'UTF-8'),
            array('far bàř', 'fòô bàř', 'fòô', 'far', 'UTF-8'),
            array('bàř bàř', 'fòô bàř fòô bàř', 'fòô ', '', 'UTF-8'),
        );
    }

    /**
     * @dataProvider regexReplaceProvider()
     */
    public function testregexReplace($expected, $str, $pattern, $replacement,
                                     $options = 'msr', $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->regexReplace($pattern, $replacement, $options);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function regexReplaceProvider()
    {
        return array(
            array('', '', '', ''),
            array('bar', 'foo', 'f[o]+', 'bar'),
            array('o bar', 'foo bar', 'f(o)o', '\1'),
            array('bar', 'foo bar', 'f[O]+\s', '', 'i'),
            array('foo', 'bar', '[[:alpha:]]{3}', 'foo'),
            array('', '', '', '', 'msr', 'UTF-8'),
            array('bàř', 'fòô ', 'f[òô]+\s', 'bàř', 'msr', 'UTF-8'),
            array('fòô', 'fò', '(ò)', '\\1ô', 'msr', 'UTF-8'),
            array('fòô', 'bàř', '[[:alpha:]]{3}', 'fòô', 'msr', 'UTF-8')
        );
    }

    /**
     * @dataProvider htmlEncodeProvider()
     */
    public function testHtmlEncode($expected, $str, $flags = ENT_COMPAT, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->htmlEncode($flags);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function htmlEncodeProvider()
    {
        return array(
            array('&amp;', '&'),
            array('&quot;', '"'),
            array('&#039;', "'", ENT_QUOTES),
            array('&lt;', '<'),
            array('&gt;', '>'),
        );
    }

    /**
     * @dataProvider htmlDecodeProvider()
     */
    public function testHtmlDecode($expected, $str, $flags = ENT_COMPAT, $encoding = null)
    {
        $stringy = S::create($str, $encoding);
        $result = $stringy->htmlDecode($flags);
        $this->assertStringy($result);
        $this->assertEquals($expected, $result);
        $this->assertEquals($str, $stringy);
    }

    public function htmlDecodeProvider()
    {
        return array(
            array('&', '&amp;'),
            array('"', '&quot;'),
            array("'", '&#039;', ENT_QUOTES),
            array('<', '&lt;'),
            array('>', '&gt;'),
        );
    }
}
