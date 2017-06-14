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

        self::assertContains("------------------------------------------------------------\n \$_SERVER global\n------------------------------------------------------------\n", $coreDump->__toString());
        self::assertNotContains('[_SERVER_TEST_VAR] => 1', $coreDump->__toString());
    }

    /**
     * Test a core dump with globals set.
     */
    public function testWithGlobals()
    {
        $_SERVER['_SERVER_TEST_VAR'] = '1';

        $coreDump = new CoreDump();

        self::assertContains("------------------------------------------------------------\n \$_SERVER global\n------------------------------------------------------------\n", $coreDump->__toString());
        self::assertContains('[_SERVER_TEST_VAR] => 1', $coreDump->__toString());
    }

    /**
     * Set up.
     */
    public function setUp()
    {
        if (!isset($_SERVER)) {
            $_SERVER = [];
        }
    }

    /**
     * Tear down.
     */
    public function tearDown()
    {
        if (isset($_SERVER['_SERVER_TEST_VAR'])) {
            unset($_SERVER['_SERVER_TEST_VAR']);
        }
    }
}
