<?php
namespace Vision\Controller;

interface ExceptionHandlerInterface
{
    public function handle(\Exception $exception);
}
