<?php

declare(strict_types=1);

namespace MichaelHall\CoreDump\Tests;

use MichaelHall\CoreDump\CoreDump;
use PHPUnit\Framework\TestCase;

/**
 * Test CoreDump class.
 */
class CoreDumpTest extends TestCase
{
    /**
     * Tests an empty core dump.
     */
    public function testEmptyCoreDump()
    {
        $coreDump = new CoreDump();

        self::assertSame('', $coreDump->__toString());
    }
}
