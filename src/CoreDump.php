<?php
/**
 * This file is a part of the core-dump package.
 *
 * Read more at https://github.com/themichaelhall/core-dump
 */
declare(strict_types=1);

namespace MichaelHall\CoreDump;

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
     */
    public function __construct()
    {
        $this->content = [];

        if (isset($_SERVER)) {
            $this->add('$_SERVER global', $_SERVER);
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

            if (is_array($content)) {
                $result[] = print_r($content, true);
            }
        }

        return implode("\n", $result);
    }

    /**
     * @var array My content.
     */
    private $content;
}
