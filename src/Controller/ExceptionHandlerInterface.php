<?php
declare(strict_types = 1);

namespace Vision\Controller;

interface ExceptionHandlerInterface
{
    public function handle(\Exception $exception): string;
}
