<?php

use function Stringy\create as s;
use PHPUnit\Framework\TestCase;

class CreateTestCase extends TestCase
{
    public function testCreate()
    {
        $stringy = s('foo bar', 'UTF-8');
        $this->assertInstanceOf('Stringy\Stringy', $stringy);
        $this->assertEquals('foo bar', (string) $stringy);
        $this->assertEquals('UTF-8', $stringy->getEncoding());
    }
}
