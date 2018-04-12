<?php
declare(strict_types = 1);

namespace Vision\Authentication;

interface ResultInterface
{
    /**
     * @return bool
     */
    public function isSuccess(): bool;

    /**
     * @return mixed
     */
    public function getIdentity();
}
