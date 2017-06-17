<?php

declare(strict_types=1);

namespace MichaelHall\Debug\Tests;

use MichaelHall\Debug\CoreDump;
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
        self::assertNotContains('[_SERVER_TEST_VAR]', $coreDump->__toString());
    }

    /**
     * Test a core dump with globals set.
     */
    public function testWithGlobals()
    {
        $_SERVER['_SERVER_TEST_VAR'] = '1';
        $_GET['_GET_TEST_VAR'] = '2';
        $_POST['_POST_TEST_VAR'] = '3';
        $_FILES['_FILES_TEST_VAR'] = '4';
        $_COOKIE['_COOKIE_TEST_VAR'] = '5';
        $_SESSION['_SESSION_TEST_VAR'] = '6';

        $coreDump = new CoreDump();

        self::assertContains("------------------------------------------------------------\n \$_SERVER global\n------------------------------------------------------------\n", $coreDump->__toString());
        self::assertContains('[_SERVER_TEST_VAR] => 1', $coreDump->__toString());
        self::assertContains("------------------------------------------------------------\n \$_GET global\n------------------------------------------------------------\n", $coreDump->__toString());
        self::assertContains('[_GET_TEST_VAR] => 2', $coreDump->__toString());
        self::assertContains("------------------------------------------------------------\n \$_POST global\n------------------------------------------------------------\n", $coreDump->__toString());
        self::assertContains('[_POST_TEST_VAR] => 3', $coreDump->__toString());
        self::assertContains("------------------------------------------------------------\n \$_FILES global\n------------------------------------------------------------\n", $coreDump->__toString());
        self::assertContains('[_FILES_TEST_VAR] => 4', $coreDump->__toString());
        self::assertContains("------------------------------------------------------------\n \$_COOKIE global\n------------------------------------------------------------\n", $coreDump->__toString());
        self::assertContains('[_COOKIE_TEST_VAR] => 5', $coreDump->__toString());
        self::assertContains("------------------------------------------------------------\n \$_SESSION global\n------------------------------------------------------------\n", $coreDump->__toString());
        self::assertContains('[_SESSION_TEST_VAR] => 6', $coreDump->__toString());
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

        if (!isset($_GET)) {
            $_GET = [];
        }

        if (!isset($_POST)) {
            $_POST = [];
        }

        if (!isset($_FILES)) {
            $_FILES = [];
        }

        if (!isset($_COOKIE)) {
            $_COOKIE = [];
        }

        if (!isset($_SESSION)) {
            $_SESSION = [];
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

        if (isset($_GET['_GET_TEST_VAR'])) {
            unset($_GET['_GET_TEST_VAR']);
        }

        if (isset($_POST['_POST_TEST_VAR'])) {
            unset($_POST['_POST_TEST_VAR']);
        }

        if (isset($_FILES['_FILES_TEST_VAR'])) {
            unset($_FILES['_FILES_TEST_VAR']);
        }

        if (isset($_COOKIE['_COOKIE_TEST_VAR'])) {
            unset($_COOKIE['_COOKIE_TEST_VAR']);
        }

        if (isset($_SESSION['_SESSION_TEST_VAR'])) {
            unset($_SESSION['_SESSION_TEST_VAR']);
        }
    }
}
