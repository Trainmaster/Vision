<?php
declare(strict_types = 1);

namespace Vision\Controller;

use Vision\Http\ResponseInterface;

interface ControllerInterface
{
    /**
     * @return ResponseInterface
     */
    public function __invoke();

    public function preFilter();

    public function postFilter();
}
