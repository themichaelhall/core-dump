<?php
/**
 * This file is a part of the debug package.
 *
 * Read more at https://github.com/themichaelhall/debug
 */
declare(strict_types=1);

namespace MichaelHall\Debug;

/**
 * Class VarDump.
 *
 * @since 1.0.0
 */
class VarDump
{
    /**
     * Dumps a variable as a readable string.
     *
     * @since 1.0.0
     *
     * @param mixed $var The variable.
     *
     * @return string The variable as a readable string.
     */
    public static function toString($var): string
    {
        if (is_string($var)) {
            return '"' . $var . '" string[' . mb_strlen($var) . ']';
        }

        if (is_float($var)) {
            return $var . ' float';
        }

        if (is_int($var)) {
            return $var . ' int';
        }

        if (is_bool($var)) {
            return ($var ? 'true' : 'false') . ' bool';
        }

        return 'null';
    }

    /**
     * Writes a variable as a readable string.
     *
     * @since 1.0.0
     *
     * @param mixed $var The variable.
     */
    public static function write($var): void
    {
        echo self::toString($var);
    }
}
