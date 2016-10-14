<?php

namespace Slim3\Annotation;


use Slim\App;

class Slim3Annotation
{

    public static function create(App $application, string $pathController, string $pathCache) {

        $collector = new CollectorRoute();
        $arrayRoute = $collector->getControllers($pathController);

        $arrayRouteObject = $collector->convertModelRoute($arrayRoute);
        self::injectRoute($application, $arrayRouteObject);
    }

    private static function injectRoute(App $application, array $arrayRouteObject) {

        foreach ($arrayRouteObject as $routeModel) {
            if (is_null($routeModel->getAlias())) {
                $application->map([$routeModel->getVerb()], $routeModel->getRoute(), $routeModel->getClassName() . ':' . $routeModel->getMethodName());
            } else {
                $application->map([$routeModel->getVerb()], $routeModel->getRoute(), $routeModel->getClassName() . ':' . $routeModel->getMethodName())
                ->setName($routeModel->getAlias());
            }
        }
    }

}