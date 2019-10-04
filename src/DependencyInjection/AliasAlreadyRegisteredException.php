<?php

namespace Vision\DependencyInjection;

use Psr\Container\ContainerExceptionInterface;
use LogicException;

class AliasAlreadyRegisteredException extends LogicException implements ContainerExceptionInterface
{
}
