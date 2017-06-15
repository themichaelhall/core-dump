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
     * Test save method with default path.
     */
    public function testSaveWithDefaultValue()
    {
        $coreDump = new CoreDump();
        $coreDump->add('Test', ['Method' => 'testSaveWithDefaultValue']);
        $filePath = $coreDump->save();
        $fileContent = file_get_contents($filePath);
        unlink($filePath);

        self::assertRegExp('!^' . getcwd() . DIRECTORY_SEPARATOR . '[a-z0-9]{40}\.coredump$!', $filePath);
        self::assertContains('[Method] => testSaveWithDefaultValue', $fileContent);
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
