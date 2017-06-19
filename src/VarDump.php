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
        return self::toStringRecursive($var);
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

    /**
     * Dumps a variable as a readable string.
     *
     * @param mixed $var    The variable.
     * @param int   $indent The indent.
     *
     * @return string The variable as a readable string.
     */
    private static function toStringRecursive($var, int $indent = 0): string
    {
        $indentString = str_repeat('  ', $indent);

        if (is_array($var)) {
            // fixme: infinite recursion.
            $result = 'array[' . count($var) . "]\n" . $indentString . "[\n";

            foreach ($var as $key => $value) {
                $result .= $indentString . '  ' . self::toString($key) . ' => ' . self::toStringRecursive($value, $indent + 1) . "\n";
            }

            $result .= $indentString . ']';

            return $result;
        }

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
}
