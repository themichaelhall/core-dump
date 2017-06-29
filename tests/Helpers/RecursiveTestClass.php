<?php

declare(strict_types=1);

namespace MichaelHall\Debug\Tests\Helpers;

/**
 * A recursive test class.
 */
class RecursiveTestClass
{
    /**
     * RecursiveTestClass constructor.
     *
     * @param string $text   The text
     * @param int    $number The number.
     */
    public function __construct(string $text, int $number)
    {
        $this->text = $text;
        $this->recursiveTestClass = null;
        $this->number = $number;
    }

    /**
     * Returns this object as a string.
     *
     * @return string This object as a string.
     */
    public function __toString(): string
    {
        return $this->text . ' ' . $this->number;
    }

    /**
     * @var string My text.
     */
    public $text;

    /**
     * @var RecursiveTestClass|null My recursive test class.
     */
    public $recursiveTestClass;

    /**
     * @var int My number.
     */
    public $number;
}
