# slim3-annotation
Define Route and Controller with annotation for Slim 3

## Instalation

Via [Composer](https://getcomposer.org/)

```
composer require dilsonjlrjr/slim3-annotation
```

##Initialization

In file public/index.php add:

```
$pathController = __DIR__ . '/../Controller';

\Slim3\Annotation\Slim3Annotation::create($app, $pathController, '');
```


The attribute **$app** is an instance of _\Slim\App_.

The attribute **$pathController** is the location of the Controllers in the application.

##Annotations Route

###Defining Controller - Example
```
/**
 * @Route("/prefix")
 */
class ClassController
{

    /**
     * @Get(name="/rota2/{id}", alias="rote.id")
     */
    public function method() {
    }
}
```

In creating a controller you can define grouping of routes, verbs, routes, aliases and middlewares.

###Routes
####Get - Example
```
/**
 * @Get(name="/rota2", alias="rote.id")
 */
public function method() {
}
```

####Post - Example
```
/**
 * @Post(name="/rota2/{id}", alias="rote.id")
 */
public function method() {
}
```

####Put - Example
```
/**
 * @Put(name="/rota2/{id}", alias="rote.id")
 */
public function method() {
}
```

####Delete - Example
```
/**
 * @Put(name="/rota2/{id}", alias="rote.id")
 */
public function method() {
}
```

The alias use is optional.


Regular expression can be used in the formation of routes. All route control 
can be seen in the Slim framework documentation. [Router Slim](http://www.slimframework.com/docs/objects/router.html)

####Route Groups
```
/**
 * @Route("/prefix")
 */
class ClassController
{

    /**
     * @Get(name="/rota2/{id}", alias="rote.id")
     */
    public function method() {
    }
}
```
Route Groups only works on the Controller header.

In the example above the route will be created as below:

```
http://localhost/prefix/rota2/1
```

####Middleware
```
/*
 * @Get(name="/rota2", alias="rote.id", middleware={"Test\Middleware\ExampleMiddleware"})
 */
public function method() {
}

/**
 * @Get(name="/rota3", alias="rote.id", middleware={"Test\Middleware\ValidateMiddleware", "Test\Middleware\ExampleMiddleware"})
 */
public function method() {
}
```


A route can incorporate several middlewares. 
How to create a middleware is available in the Slim framework documentation. [Middleware](http://www.slimframework.com/docs/objects/router.html#route-middleware)