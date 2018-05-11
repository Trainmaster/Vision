<?php

use Vision\Routing\RouteCollector;

return function (RouteCollector $routeCollector) {
    $routeCollector->get('/foo', 'someHandler');
};
