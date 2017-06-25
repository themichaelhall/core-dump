<?php

declare(strict_types=1);

namespace MichaelHall\Debug\Tests\Helpers;

/**
 * A derived test class.
 */
class DerivedTestClass extends SimpleTestClass
{
    /**
     * DerivedTestClass constructor.
     *
     * @param int    $publicVar    The public variable.
     * @param bool   $protectedVar The protected variable.
     * @param float  $privateVar   The private variable.
     * @param string $staticVar    The static variable.
     */
    public function __construct(int $publicVar, bool $protectedVar, float $privateVar, string $staticVar)
    {
        parent::__construct($publicVar, $protectedVar, $privateVar);

        self::$staticVar = $staticVar;
    }

    /**
     * @var string My static variable.
     */
    public static $staticVar;
}
