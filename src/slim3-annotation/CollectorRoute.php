<?php

namespace Slim3\Annotation;


use Slim3\Annotation\Model\EnumVerb;
use Slim3\Annotation\Model\RouteModel;

class CollectorRoute
{

    /**
     * @param string $pathControllers
     * @return array
     */
    public function getControllers(string $pathControllers) : array {

        $directory = new \RecursiveDirectoryIterator($pathControllers);
        $regexDirectory = new \RecursiveRegexIterator($directory, '/[\w]+Controller\.php$/', \RecursiveRegexIterator::GET_MATCH);

        $arrayReturn = [];

        foreach ($regexDirectory as $item) {
            $arrayReturn[] = [
                $pathControllers . DIRECTORY_SEPARATOR . $item[0],
                filemtime($pathControllers . DIRECTORY_SEPARATOR . $item[0])
            ];
        }

        return $arrayReturn;
    }

    /**
     * @param array $arrayController
     * @return array
     * @throws \Exception
     */
    public function castRoute(array $arrayController) : array {

        $arrayReturn = [];
        foreach($arrayController as $itemController) {

            $fileInclude = file_get_contents($itemController[0]);

            preg_match('/namespace\s+([\w\\\_-]+)\s*;/', $fileInclude, $arrayNamespace);
            preg_match('/class\s+([\w-]+Controller)\s*/', $fileInclude, $arrayNameClass);

            $classFullName = $arrayNamespace[1] . '\\' . $arrayNameClass[1];

            $reflactionClass = new \ReflectionClass($classFullName);

            preg_match('/@[ˆcC]ontroller/', $reflactionClass->getDocComment(), $arrayMatch);
            preg_match('/@Route\s*\(\s*["\']([^\'"]*)["\']\s*\)/', $reflactionClass->getDocComment(), $arrayRouteController);

            $routePrefix = "";
            if (count($arrayRouteController) > 0) {
                $routePrefix = $arrayRouteController[1];
            }

            if (count($arrayMatch) > 0) {

                foreach ($reflactionClass->getMethods() as $methods) {
                    preg_match('/@([a-zA-Z]*)\s*\(([^)]+)\)/', $methods->getDocComment(), $arrayRoute);

                    if (count($arrayRoute) == 0)
                        continue 1;

                    //parameter name
                    preg_match('/name\s{0,}=\s{0,}["\']([^\'"]*)["\']/', $arrayRoute[2], $arrayParameterName);

                    //parameter alias
                    preg_match('/alias\s{0,}=\s{0,}["\']([^\'"]*)["\']/', $arrayRoute[2], $arrayParameterAlias);

                    //parameter middleware
                    preg_match('/middleware\s{0,}=\s{0,}\{(.*?)\}/', $arrayRoute[2], $arrayParameterMiddleware);

                    if (count($arrayParameterMiddleware) > 0) {
                        preg_match_all('/\"(.*?)\"/', $arrayParameterMiddleware[1], $arrayMiddleware);
                        $arrayParameterMiddleware = [];
                        foreach ($arrayMiddleware[1] as $item) {
                            if (trim($item) == "" || !class_exists(trim($item)))
                                throw new \Exception('Annotation of poorly written middleware. Class: ' . $reflactionClass->getName());

                            $arrayParameterMiddleware[] = trim($item);
                        }
                    }

                    if (count($arrayParameterName) == 0)
                        continue 1;

                    try {
                        $verbName = $this->validateVerbRoute($arrayRoute[1]);
                    } catch(\Exception $ex) {
                        continue 1;
                    }

                    $routeFullName = $routePrefix  . $arrayParameterName[1];

                    $classFullName = $reflactionClass->getName();
                    $methodName = $methods->getName();
                    $aliasName = (count($arrayParameterAlias) > 0 ? $arrayParameterAlias[1] : null);
                    $classMiddleWare = (count($arrayParameterMiddleware) > 0 ? $arrayParameterMiddleware : []);

                    $arrayReturn[] = new RouteModel($verbName, $routeFullName, $classFullName, $methodName, $aliasName, $classMiddleWare);
                }

            }
            ob_clean();
        }
        return $arrayReturn;
    }

    private function validateVerbRoute(string $verb) {
        $arrayVerb = ['GET', 'POST', 'OPTIONS', 'DELETE', 'PATCH', 'ANY', 'PUT'];
        $verb = strtoupper($verb);

        if (!in_array($verb, $arrayVerb))
            throw new \Exception('Parameter verb is not defined in the HTTP verbs');

        return $verb;
    }

}