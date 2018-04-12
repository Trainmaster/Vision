<?php
declare(strict_types = 1);

namespace Vision\Authentication\Strategy;

use Vision\Authentication\ResultInterface;

interface StrategyInterface
{
    /**
     * @param array $data
     *
     * @return \Vision\Authentication\ResultInterface
     */
    public function authenticate(array $data): ResultInterface;

    /**
     * @param mixed $identity
     *
     * @return void
     */
    public function invalidate($identity): void;
}
