<?php

declare(strict_types=1);

namespace MichaelHall\Debug\Tests\Helpers;

/**
 * A stringable test class.
 */
class StringableTestClass
{
    /**
     * StringableTestClass constructor.
     *
     * @param \DateTimeInterface $dateTime The date time.
     */
    public function __construct(\DateTimeInterface $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * Returns this as a string.
     *
     * @return string This as a string.
     */
    public function __toString()
    {
        return 'This is a StringableTestClass';
    }

    /**
     * @var \DateTimeInterface My date time.
     */
    private $dateTime;
}
