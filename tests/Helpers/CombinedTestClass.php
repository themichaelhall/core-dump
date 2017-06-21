<?php

declare(strict_types=1);

namespace MichaelHall\Debug\Tests\Helpers;

/**
 * A combined test class.
 */
class CombinedTestClass
{
    /**
     * CombinedTestClass constructor.
     *
     * @param SimpleTestClass $simpleTestClass The simple test class.
     * @param array           $array           And array.
     * @param string          $text            A text.
     */
    public function __construct(SimpleTestClass $simpleTestClass, array $array, string $text)
    {
        $this->simpleTestClass = $simpleTestClass;
        $this->array = $array;
        $this->text = $text;
    }

    /**
     * @var SimpleTestClass My simple text class.
     */
    public $simpleTestClass;

    /**
     * @var array My array.
     */
    protected $array;

    /**
     * @var string My text.
     */
    private $text;
}
