# Routing

The `Vision\Routing\Router` sits on top of the well-known routing library [FastRoute](https://github.com/nikic/FastRoute).
So it's almost the same API except for some improvements.

## Getting started

### Define routes
First of all routes must be defined in one or more configurations files. These files are simple PHP files returning an anonymous function. The anonymous function will receive an instance of `Vision\Routing\RouteCollector`.

```php
use Vision\Routing\RouteCollector;

return function(RouteCollector $routeCollector) {
    $routeCollector->get('/foo', 'someHandler');
};
```

### Create the router 
In a second step a `Vision\Routing\Router` must be created. 

The first argument must be an instance of `Vision\Routing\DispatcherFactory`. Using this factory ensures that FastRoute uses the route collector provided by `Vision\Routing\RouteCollector`.

The second argument must implement `Vision/Routing/DefinitionLoaderInterface`. With `Vision\Routing\DefinitionLoader` and `Vision\Routing\CachedDefinitionLoader` there are two implementations already shipped. Former is recommended for developement and latter for production environment.

```php
$router = (new Router(
    new DispatcherFactory(),
    new DefinitionLoader(new IncludeFileLoader()))
);
```

### Configure the router

Now the routes configured in the first step must be introduced to the router created in the previous step. This is done by calling `addResource()` providing the path of the route file(s).

```php
$router->addResource(__DIR__ . '/routes.php');
```

### Resolve a request

Finally the router can be used to resolve a request in the form of a HTTP method and URI. If working with `Vision\Http\Request` the methods `getMethod()` and `getPathInfo()` return the corresponding data.

```php
$result = $router->resolve('GET', '/foo');
```
