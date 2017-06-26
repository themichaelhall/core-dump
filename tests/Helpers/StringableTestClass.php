<?php

declare(strict_types=1);

namespace MichaelHall\Debug\Tests\Helpers;

/**
 * A stringable test class.
 */
class StringableTestClass
{
    /**
     * Returns this as a string.
     *
     * @return string This as a string.
     */
    public function __toString()
    {
        return 'This is a StringableTestClass';
    }
}
