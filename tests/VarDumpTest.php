<?php

declare(strict_types=1);

namespace MichaelHall\Debug\Tests;

use MichaelHall\Debug\Tests\Helpers\CombinedTestClass;
use MichaelHall\Debug\Tests\Helpers\DerivedTestClass;
use MichaelHall\Debug\Tests\Helpers\SimpleTestClass;
use MichaelHall\Debug\Tests\Helpers\StringableTestClass;
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

    /**
     * Test toString method for a simple object.
     */
    public function testSimpleObjectToString()
    {
        $simpleTestClass = new SimpleTestClass(1234, true, 12.5);

        self::assertSame("MichaelHall\Debug\Tests\Helpers\SimpleTestClass\n{\n  publicVar => 1234 int\n  protectedVar => true bool\n  privateVar => 12.5 float\n}", VarDump::toString($simpleTestClass));
    }

    /**
     * Test write method for a simple object.
     */
    public function testWriteSimpleObject()
    {
        $simpleTestClass = new SimpleTestClass(1234, true, 12.5);

        ob_start();
        VarDump::write($simpleTestClass);
        $value = ob_get_contents();
        ob_end_clean();

        self::assertSame("MichaelHall\Debug\Tests\Helpers\SimpleTestClass\n{\n  publicVar => 1234 int\n  protectedVar => true bool\n  privateVar => 12.5 float\n}", $value);
    }

    /**
     * Test toString method for a nested object.
     */
    public function testNestedObjectToString()
    {
        $combinedTestClass = new CombinedTestClass(
            new SimpleTestClass(123, false, 10.0),
            ['Foo' => 1, 'Bar' => 2, 'Baz' => [true, false]],
            'xxx'
        );

        self::assertSame("MichaelHall\Debug\Tests\Helpers\CombinedTestClass\n{\n  simpleTestClass => MichaelHall\Debug\Tests\Helpers\SimpleTestClass\n  {\n    publicVar => 123 int\n    protectedVar => false bool\n    privateVar => 10 float\n  }\n  array => array[3]\n  [\n    \"Foo\" string[3] => 1 int\n    \"Bar\" string[3] => 2 int\n    \"Baz\" string[3] => array[2]\n    [\n      0 int => true bool\n      1 int => false bool\n    ]\n  ]\n  text => \"xxx\" string[3]\n}", VarDump::toString($combinedTestClass));
    }

    /**
     * Test write method for nested object.
     */
    public function testWriteNestedObject()
    {
        $combinedTestClass = new CombinedTestClass(
            new SimpleTestClass(123, false, 10.0),
            ['Foo' => 1, 'Bar' => 2, 'Baz' => [true, false]],
            'xxx'
        );

        ob_start();
        VarDump::write($combinedTestClass);
        $value = ob_get_contents();
        ob_end_clean();

        self::assertSame("MichaelHall\Debug\Tests\Helpers\CombinedTestClass\n{\n  simpleTestClass => MichaelHall\Debug\Tests\Helpers\SimpleTestClass\n  {\n    publicVar => 123 int\n    protectedVar => false bool\n    privateVar => 10 float\n  }\n  array => array[3]\n  [\n    \"Foo\" string[3] => 1 int\n    \"Bar\" string[3] => 2 int\n    \"Baz\" string[3] => array[2]\n    [\n      0 int => true bool\n      1 int => false bool\n    ]\n  ]\n  text => \"xxx\" string[3]\n}", $value);
    }

    /**
     * Test toString method for a derived object.
     */
    public function testDerivedObjectToString()
    {
        $derivedTestClass = new DerivedTestClass(10, false, 20.0, 'FooBar');

        self::assertSame("MichaelHall\Debug\Tests\Helpers\DerivedTestClass\n{\n  staticVar => \"FooBar\" string[6]\n  publicVar => 10 int\n  protectedVar => false bool\n  privateVar => 20 float\n}", VarDump::toString($derivedTestClass));
    }

    /**
     * Test write method for derived object.
     */
    public function testWriteDerivedObject()
    {
        $derivedTestClass = new DerivedTestClass(10, false, 20.0, 'FooBar');

        ob_start();
        VarDump::write($derivedTestClass);
        $value = ob_get_contents();
        ob_end_clean();

        self::assertSame("MichaelHall\Debug\Tests\Helpers\DerivedTestClass\n{\n  staticVar => \"FooBar\" string[6]\n  publicVar => 10 int\n  protectedVar => false bool\n  privateVar => 20 float\n}", $value);
    }

    /**
     * Test toString method for a stringable object.
     */
    public function testStringableObjectToString()
    {
        $stringableTestClass = new StringableTestClass(new \DateTimeImmutable('2010-11-12 13:14:15.161718', new \DateTimeZone('Europe/Stockholm')));

        self::assertSame("\"This is a StringableTestClass\" MichaelHall\Debug\Tests\Helpers\StringableTestClass\n{\n  dateTime => \"2010-11-12 13:14:15.161718 CET\" DateTimeImmutable\n  {\n  }\n}", VarDump::toString($stringableTestClass));
    }

    /**
     * Test write method for a stringable object.
     */
    public function testWriteStringableObject()
    {
        $stringableTestClass = new StringableTestClass(new \DateTimeImmutable('2010-11-12 13:14:15.161718', new \DateTimeZone('Europe/Stockholm')));

        ob_start();
        VarDump::write($stringableTestClass);
        $value = ob_get_contents();
        ob_end_clean();

        self::assertSame("\"This is a StringableTestClass\" MichaelHall\Debug\Tests\Helpers\StringableTestClass\n{\n  dateTime => \"2010-11-12 13:14:15.161718 CET\" DateTimeImmutable\n  {\n  }\n}", $value);
    }
}
