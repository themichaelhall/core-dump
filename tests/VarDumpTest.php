<?php

declare(strict_types=1);

namespace MichaelHall\Debug\Tests;

use MichaelHall\Debug\VarDump;
use PHPUnit\Framework\TestCase;

/**
 * Test VarDump class.
 */
class VarDumpTest extends TestCase
{
    /**
     * Test toString method for null.
     */
    public function testNullToString()
    {
        self::assertSame('null', VarDump::toString(null));
    }

    /**
     * Test write method for null.
     */
    public function testWriteNull()
    {
        ob_start();
        VarDump::write(null);
        $value = ob_get_contents();
        ob_end_clean();

        self::assertSame('null', $value);
    }

    /**
     * Test toString method for true.
     */
    public function testTrueToString()
    {
        self::assertSame('true bool', VarDump::toString(true));
    }

    /**
     * Test write method for true.
     */
    public function testWriteTrue()
    {
        ob_start();
        VarDump::write(true);
        $value = ob_get_contents();
        ob_end_clean();

        self::assertSame('true bool', $value);
    }

    /**
     * Test toString method for false.
     */
    public function testFalseToString()
    {
        self::assertSame('false bool', VarDump::toString(false));
    }

    /**
     * Test write method for false.
     */
    public function testWriteFalse()
    {
        ob_start();
        VarDump::write(false);
        $value = ob_get_contents();
        ob_end_clean();

        self::assertSame('false bool', $value);
    }

    /**
     * Test toString method for int.
     */
    public function testIntToString()
    {
        self::assertSame('1234 int', VarDump::toString(1234));
    }

    /**
     * Test write method for int.
     */
    public function testWriteInt()
    {
        ob_start();
        VarDump::write(-5678);
        $value = ob_get_contents();
        ob_end_clean();

        self::assertSame('-5678 int', $value);
    }

    /**
     * Test toString method for float.
     */
    public function testFloatToString()
    {
        self::assertSame('3.25 float', VarDump::toString(3.25));
    }

    /**
     * Test write method for float.
     */
    public function testWriteFloat()
    {
        ob_start();
        VarDump::write(-1.5);
        $value = ob_get_contents();
        ob_end_clean();

        self::assertSame('-1.5 float', $value);
    }

    /**
     * Test toString method for string.
     */
    public function testStringToString()
    {
        self::assertSame('"Foo Bar È" string[9]', VarDump::toString('Foo Bar È'));
    }

    /**
     * Test write method for string.
     */
    public function testWriteString()
    {
        ob_start();
        VarDump::write('Baz');
        $value = ob_get_contents();
        ob_end_clean();

        self::assertSame('"Baz" string[3]', $value);
    }

    /**
     * Test toString method for a simple array.
     */
    public function testSimpleArrayToString()
    {
        self::assertSame("array[2]\n[\n  10 int => \"Foo\" string[3]\n  \"Bar\" string[3] => \"Baz\" string[3]\n]", VarDump::toString([10 => 'Foo', 'Bar' => 'Baz']));
    }

    /**
     * Test write method for a simple array.
     */
    public function testWriteSimpleArray()
    {
        ob_start();
        VarDump::write([10 => 'Foo', 'Bar' => 'Baz']);
        $value = ob_get_contents();
        ob_end_clean();

        self::assertSame("array[2]\n[\n  10 int => \"Foo\" string[3]\n  \"Bar\" string[3] => \"Baz\" string[3]\n]", $value);
    }

    /**
     * Test toString method for a nested array.
     */
    public function testNestedArrayToString()
    {
        self::assertSame("array[2]\n[\n  10 int => \"Foo\" string[3]\n  \"Bar\" string[3] => array[2]\n  [\n    \"Baz\" string[3] => true bool\n    10 int => array[2]\n    [\n      0 int => 11 int\n      1 int => 12 int\n    ]\n  ]\n]", VarDump::toString([10 => 'Foo', 'Bar' => ['Baz' => true, 10 => [11, 12]]]));
    }

    /**
     * Test write method for nested array.
     */
    public function testWriteNestedArray()
    {
        ob_start();
        VarDump::write([10 => 'Foo', 'Bar' => ['Baz' => true, 10 => [11, 12]]]);
        $value = ob_get_contents();
        ob_end_clean();

        self::assertSame("array[2]\n[\n  10 int => \"Foo\" string[3]\n  \"Bar\" string[3] => array[2]\n  [\n    \"Baz\" string[3] => true bool\n    10 int => array[2]\n    [\n      0 int => 11 int\n      1 int => 12 int\n    ]\n  ]\n]", $value);
    }
}
