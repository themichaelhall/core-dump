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
        return self::toStringRecursive($var, 0);
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
    private static function toStringRecursive($var, int $indent): string
    {
        if (is_object($var)) {
            return self::objectToString($var, $indent);
        }

        if (is_array($var)) {
            return self::arrayToString($var, $indent);
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

    /**
     * Converts an object to a string.
     *
     * @param mixed $var    The object.
     * @param int   $indent The indent.
     *
     * @return string The object as a string.
     */
    private static function objectToString($var, int $indent): string
    {
        // fixme: infinite recursion.
        $indentString = str_repeat('  ', $indent);
        $result = get_class($var) . "\n" . $indentString . "{\n";

        $reflectionClass = new \ReflectionClass($var);
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $result .= $indentString . '  ' . $property->getName() . ' => ' . self::toStringRecursive($property->getValue($var), $indent + 1) . "\n";
        }

        $result .= $indentString . '}';

        return $result;
    }

    /**
     * Converts an array to a string.
     *
     * @param array $var    The array.
     * @param int   $indent The indent.
     *
     * @return string The array as a string.
     */
    private static function arrayToString(array $var, int $indent): string
    {
        $indentString = str_repeat('  ', $indent);
        $result = 'array[' . count($var) . "]\n" . $indentString . "[\n";

        foreach ($var as $key => $value) {
            $result .= $indentString . '  ' . self::toString($key) . ' => ' . self::toStringRecursive($value, $indent + 1) . "\n";
        }

        $result .= $indentString . ']';

        return $result;
    }
}
