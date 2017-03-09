<?php

use Stringy\StaticStringy as S;

class StaticStringyTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException BadMethodCallException
     */
    public function testBadMethodCall()
    {
        $result = S::invalidMethod('foo');
    }

    public function testEmptyArgsInvocation()
    {
        $result = S::toLowerCase();
        $this->assertEquals('', $result);
    }

    public function testInvocation()
    {
        $result = S::toLowerCase('FOOBAR');
        $this->assertEquals('foobar', $result);
        $this->assertInternalType('string', $result);
    }

    public function testPartialArgsInvocation()
    {
        $result = S::slice('foobar', 0, 3);
        $this->assertEquals('foo', $result);
        $this->assertInternalType('string', $result);
    }

    public function testFullArgsInvocation()
    {
        $result = S::slice('fòôbàř', 0, 3, 'UTF-8');
        $this->assertEquals('fòô', $result);
        $this->assertInternalType('string', $result);
    }

    public function testArrayReturnValue()
    {
        $result = S::lines("a\nb");
        $this->assertEquals(['a', 'b'], $result);
        $this->assertInternalType('array', $result);
        foreach ($result as $val) {
            $this->assertInternalType('string', $val);
        }
    }

    /**
     * Use reflection to ensure that all argument numbers are correct. Each
     * static method should accept 2 more arguments than their Stringy
     * equivalent.
     */
    public function testArgumentNumbers()
    {
        $staticStringyClass = new ReflectionClass('Stringy\StaticStringy');
        $stringyClass = new ReflectionClass('Stringy\Stringy');

        // getStaticPropertyValue can't access protected properties
        $properties = $staticStringyClass->getStaticProperties();

        foreach ($properties['methodArgs'] as $method => $expected) {
            $num = $stringyClass->getMethod($method)
                ->getNumberOfParameters() + 2;

            $this->assertEquals($expected, $num,
                'Invalid num args for ' . $method);
        }
    }
}
