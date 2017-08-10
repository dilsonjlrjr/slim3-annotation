<?php

namespace Slim3\Annotation;


use Slim\App;

class Slim3Annotation
{

    public static function create(App $application, string $pathController, string $pathCache) {

        $collector = new CollectorRoute();
        $arrayRoute = $collector->getControllers($pathController);

        $arrayRouteObject = $collector->castRoute($arrayRoute);
        self::injectRoute($application, $arrayRouteObject, $arrayRoute, $pathCache);
    }

    private static function injectRoute(App $application, array $arrayRouteObject, array $arrayRoute, string $pathCache) {

        $validate = new CacheAnnotation($pathCache, $application);

        if ($validate->updatedCache($arrayRoute)) {
            $validate->loadLastCache();
        } else {
            foreach ($arrayRouteObject as $routeModel) {
                $route = $application->map([$routeModel->getVerb()], $routeModel->getRoute(), $routeModel->getClassName() . ':' . $routeModel->getMethodName());

                if ($routeModel->getAlias() != null) {
                    $route->setName($routeModel->getAlias());
                }

                if ($routeModel->getClassMiddleware() != null) {
                    $classMiddleware = $routeModel->getClassMiddleware();
                    foreach ($classMiddleware as $middleware) {
                        $route->add(new $middleware());
                    }
                }
            }

            $validate->write($arrayRouteObject);
        }
    }

}