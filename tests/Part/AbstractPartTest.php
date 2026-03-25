<?php

namespace TheIconic\NameParser\Part;

use PHPUnit\Framework\TestCase;

class AbstractPartTest extends TestCase
{
    /**
     * make sure the placeholder normalize() method returns the original value
     */
    public function testNormalize()
    {
        $part = new class('abc') extends AbstractPart {};
        $this->assertEquals('abc', $part->normalize());
    }

    /**
     * make sure we unwrap any parts during setValue() calls
     */
    public function testSetValueUnwraps()
    {
        $part = new class('abc') extends AbstractPart {};
        $this->assertEquals('abc', $part->getValue());

        $part2 = new class($part) extends AbstractPart {};
        $this->assertEquals('abc', $part2->getValue());
    }
}
