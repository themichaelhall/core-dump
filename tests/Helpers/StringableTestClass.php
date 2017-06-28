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
     * @param \DateTimeInterface $dateTime     The date time.
     * @param \DateInterval      $dateInterval The date interval.
     */
    public function __construct(\DateTimeInterface $dateTime, \DateInterval $dateInterval)
    {
        $this->dateTime = $dateTime;
        $this->dateInterval = $dateInterval;
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

    /**
     * @var \DateInterval My date interval.
     */
    private $dateInterval;
}
