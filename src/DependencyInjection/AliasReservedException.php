<?php

namespace Vision\DependencyInjection;

use Psr\Container\ContainerExceptionInterface;
use LogicException;

class AliasReservedException extends LogicException implements ContainerExceptionInterface
{
}
