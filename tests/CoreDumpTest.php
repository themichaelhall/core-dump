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

        self::assertNotContains("------------------------------------------------------------\n Exception\n------------------------------------------------------------\n", $coreDump->__toString());
        self::assertContains("------------------------------------------------------------\n \$_SERVER global\n------------------------------------------------------------\n", $coreDump->__toString());
        self::assertNotContains('[_SERVER_TEST_VAR] => 1', $coreDump->__toString());
    }

    /**
     * Tests a core dump with exception.
     */
    public function testCoreDumpWithException()
    {
        $exception = new \InvalidArgumentException('This is an exception', 42);
        $coreDump = new CoreDump($exception);

        self::assertContains("------------------------------------------------------------\n Exception\n------------------------------------------------------------\n", $coreDump->__toString());
        self::assertContains('Class    : InvalidArgumentException', $coreDump->__toString());
        self::assertContains('Location : ' . __FILE__, $coreDump->__toString());
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
     * Test save method with directory path.
     */
    public function testSaveWithDirectoryPath()
    {
        $coreDump = new CoreDump();
        $coreDump->add('Test', ['Method' => 'testSaveWithDirectoryPath']);
        $filePath = $coreDump->save(sys_get_temp_dir());
        $fileContent = file_get_contents($filePath);
        unlink($filePath);

        self::assertRegExp('!^' . sys_get_temp_dir() . DIRECTORY_SEPARATOR . '[a-z0-9]{40}\.coredump$!', $filePath);
        self::assertContains('[Method] => testSaveWithDirectoryPath', $fileContent);
    }

    /**
     * Test save method with file path.
     */
    public function testSaveWithFilePath()
    {
        $coreDump = new CoreDump();
        $coreDump->add('Test', ['Method' => 'testSaveWithFilePath']);
        $filePath = $coreDump->save(sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'core.dump');
        $fileContent = file_get_contents($filePath);
        unlink($filePath);

        self::assertSame(sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'core.dump', $filePath);
        self::assertContains('[Method] => testSaveWithFilePath', $fileContent);
    }

    /**
     * Test save method with file path with replacement character.
     */
    public function testSaveWithFilePathWithReplacementCharacter()
    {
        $coreDump = new CoreDump();
        $coreDump->add('Test', ['Method' => 'testSaveWithFilePathWithReplacementCharacter']);
        $filePath = $coreDump->save(sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'core.#.dump');
        $fileContent = file_get_contents($filePath);
        unlink($filePath);

        self::assertRegExp('!^' . sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'core\.[a-z0-9]{40}\.dump$!', $filePath);
        self::assertContains('[Method] => testSaveWithFilePathWithReplacementCharacter', $fileContent);
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
