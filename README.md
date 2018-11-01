# slim3-annotation
Define routes and controllers with annotations for Slim 3

## Installation

Via [Composer](https://getcomposer.org/)

```
composer require dilsonjlrjr/slim3-annotation
```

## Initialization

In file public/index.php add:

```php
<?php
$pathController = __DIR__ . '/../Controller';

\Slim3\Annotation\Slim3Annotation::create($app, $pathController, '');
```


The attribute **$app** is an instance of _\Slim\App_.

The attribute **$pathController** is the location of the controllers in the application.

## Annotations Route

### Defining Controller - Example

```php
<?php
/**
 * @Route("/prefix")
 */
class ClassController {

    /**
     * @Get(name="/rota2/{id}", alias="rote.id")
     */
    public function method() {
    }
}
```

In creating a controller you can define grouping of routes, verbs, routes, aliases and middlewares.

### Routes
#### Get - Example

```php
<?php
/**
 * @Get(name="/rota2", alias="rote.id")
 */
public function method() {
}
```

#### Post - Example

```php
<?php
/**
 * @Post(name="/rota2/{id}", alias="rote.id")
 */
public function method() {
}
```

#### Put - Example

```php
<?php
/**
 * @Put(name="/rota2/{id}", alias="rote.id")
 */
public function method() {
}
```

#### Delete - Example

```php
<?php
/**
 * @Put(name="/rota2/{id}", alias="rote.id")
 */
public function method() {
}
```

The alias use is optional.


Regular expressions can be used in the creation of routes. All route controls can be seen in the [Slim framework documentation: Router](http://www.slimframework.com/docs/objects/router.html).

#### Route Groups

```php
<?php
/**
 * @Route("/prefix")
 */
class ClassController {

    /**
     * @Get(name="/rota2/{id}", alias="rote.id")
     */
    public function method() {
    }
}
```

Route groups only work on the controller header.

In the example above the route will be created as below:

```
http://localhost/prefix/rota2/1
```

#### Middleware

```php
<?php
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


A route can incorporate several middlewares. How to create a middleware is available in the [Slim framework documentation: Middleware](http://www.slimframework.com/docs/objects/router.html#route-middleware).
