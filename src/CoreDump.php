<?php
/**
 * This file is a part of the debug package.
 *
 * Read more at https://github.com/themichaelhall/debug
 */
declare(strict_types=1);

namespace MichaelHall\Debug;

/**
 * Class CoreDump.
 *
 * @since 1.0.0
 */
class CoreDump
{
    /**
     * Constructs a core dump object.
     *
     * @since 1.0.0
     *
     * @param \Throwable |null $exception The exception or null if no exception.
     */
    public function __construct(\Throwable $exception = null)
    {
        $this->content = [];

        if ($exception !== null) {
            $this->add('Exception', $exception);
        }

        if (isset($_SERVER)) {
            $this->add('$_SERVER global', $_SERVER);
        }

        if (isset($_GET)) {
            $this->add('$_GET global', $_GET);
        }
    }

    /**
     * Adds content to the core dump.
     *
     * @since 1.0.0
     *
     * @param string $header  The header.
     * @param mixed  $content The content.
     */
    public function add(string $header, $content): void
    {
        $this->content[] = [$header, $content];
    }

    /**
     * Saves content to a file.
     *
     * @since 1.0.0
     *
     * @param string $path The path to save file to.
     *
     * @return string The full path to the file.
     */
    public function save(string $path = ''): string
    {
        if ($path === '') {
            $path = getcwd() . DIRECTORY_SEPARATOR . '#.coredump';
        } elseif (is_dir($path)) {
            $path = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '#.coredump';
        }

        $path = str_replace('#', sha1(mt_rand() . microtime()), $path);

        file_put_contents($path, $this->__toString());

        return $path;
    }

    /**
     * Returns the core dump content as a string.
     *
     * @since 1.0.0
     *
     * @return string The core dump content as a string.
     */
    public function __toString(): string
    {
        $result = [];
        foreach ($this->content as list($header, $content)) {
            $result[] = str_repeat('-', 60) . "\n $header\n" . str_repeat('-', 60) . "\n";

            if (is_a($content, '\Throwable', true)) {
                $result[] = self::formatException($content) . "\n";
            } else {
                $result[] = print_r($content, true) . "\n";
            }
        }

        return implode("\n", $result);
    }

    /**
     * Formats an exception.
     *
     * @param \Throwable $exception The exception.
     *
     * @return string The result.
     */
    private static function formatException(\Throwable $exception)
    {
        return
            'Class    : ' . get_class($exception) . "\n" .
            'Message  : ' . $exception->getMessage() . "\n" .
            'Code     : ' . $exception->getCode() . "\n" .
            'Location : ' . $exception->getFile() . '(' . $exception->getLine() . ")\n" .
            "\n" .
            $exception->getTraceAsString();
    }

    /**
     * @var array My content.
     */
    private $content;
}
