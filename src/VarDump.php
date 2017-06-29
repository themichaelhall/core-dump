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
        return self::toStringRecursive($var, 0, []);
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
     * @param mixed $var             The variable.
     * @param int   $indent          The indent.
     * @param array $previousObjects The objects previously handled.
     *
     * @return string The variable as a readable string.
     */
    private static function toStringRecursive($var, int $indent, array $previousObjects): string
    {
        if (is_object($var)) {
            return self::objectToString($var, $indent, $previousObjects);
        }

        if (is_array($var)) {
            return self::arrayToString($var, $indent, $previousObjects);
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
     * @param mixed $var             The object.
     * @param int   $indent          The indent.
     * @param array $previousObjects The objects previously handled.
     *
     * @return string The object as a string.
     */
    private static function objectToString($var, int $indent, array $previousObjects): string
    {
        $indentString = str_repeat('  ', $indent);
        $stringLabel = self::getStringLabel($var);

        $result = ($stringLabel !== null ? '"' . $stringLabel . '" ' : '') . get_class($var);

        foreach ($previousObjects as $previousObject) {
            if ($previousObject === $var) {
                $result .= ' *RECURSION*';

                return $result;
            }
        }

        $result .= "\n" . $indentString . "{\n";

        $reflectionClass = new \ReflectionClass($var);
        foreach (self::getReflectionClassProperties($reflectionClass) as $property) {
            $property->setAccessible(true);
            $result .= $indentString . '  ' . $property->getName() . ' => ' . self::toStringRecursive($property->getValue($var), $indent + 1, array_merge($previousObjects, [$var])) . "\n";
        }

        $result .= $indentString . '}';

        return $result;
    }

    /**
     * Converts an array to a string.
     *
     * @param array $var             The array.
     * @param int   $indent          The indent.
     * @param array $previousObjects The objects previously handled.
     *
     * @return string The array as a string.
     */
    private static function arrayToString(array $var, int $indent, array $previousObjects): string
    {
        $indentString = str_repeat('  ', $indent);
        $result = 'array[' . count($var) . "]\n" . $indentString . "[\n";

        foreach ($var as $key => $value) {
            $result .= $indentString . '  ' . self::toString($key) . ' => ' . self::toStringRecursive($value, $indent + 1, $previousObjects) . "\n";
        }

        $result .= $indentString . ']';

        return $result;
    }

    /**
     * Returns the properties for a reflection class and its base classes.
     *
     * @param \ReflectionClass $reflectionClass The reflection class.
     *
     * @return \ReflectionProperty[] The reflection properties.
     */
    private static function getReflectionClassProperties(\ReflectionClass $reflectionClass): array
    {
        $properties = [];

        do {
            foreach ($reflectionClass->getProperties() as $property) {
                if (!in_array($property, $properties)) {
                    $properties[] = $property;
                }
            }

            $reflectionClass = $reflectionClass->getParentClass();
        } while ($reflectionClass !== false);

        return $properties;
    }

    /**
     * Returns a string label for an object or null if no string label could be created.
     *
     * @param mixed $var The object.
     *
     * @return null|string The string label for an object or null if no string label could be created.
     */
    private static function getStringLabel($var): ?string
    {
        if (method_exists($var, '__toString')) {
            return $var->__toString();
        }

        if ($var instanceof \DateTimeInterface) {
            return $var->format('Y-m-d H:i:s.u T');
        }

        if ($var instanceof \DateInterval) {
            return $var->format('%R%yy %mm %dd %hh %im %ss');
        }

        return null;
    }
}
