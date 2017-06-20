<?php

declare(strict_types=1);

namespace MichaelHall\Debug\Tests\Helpers;

/**
 * A simple test class.
 */
class SimpleTestClass
{
    /**
     * SimpleTestClass constructor.
     *
     * @param int   $publicVar    The public variable.
     * @param bool  $protectedVar The protected variable.
     * @param float $privateVar   The private variable.
     */
    public function __construct(int $publicVar, bool $protectedVar, float $privateVar)
    {
        $this->publicVar = $publicVar;
        $this->protectedVar = $protectedVar;
        $this->privateVar = $privateVar;
    }

    /**
     * @var int My public variable.
     */
    public $publicVar;

    /**
     * @var bool My protected variable.
     */
    protected $protectedVar;

    /**
     * @var float My private variable.
     */
    private $privateVar;
}
