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
        self::assertSame('(null)', VarDump::toString(null));
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

        self::assertSame('(null)', $value);
    }

    /**
     * Test toString method for true.
     */
    public function testTrueToString()
    {
        self::assertSame('true (bool)', VarDump::toString(true));
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

        self::assertSame('true (bool)', $value);
    }

    /**
     * Test toString method for false.
     */
    public function testFalseToString()
    {
        self::assertSame('false (bool)', VarDump::toString(false));
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

        self::assertSame('false (bool)', $value);
    }
}