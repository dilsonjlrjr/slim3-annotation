<?php
/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 13/10/16
 * Time: 14:21
 */

namespace Slim3\Annotation\Model;


class RouteModel
{
    /**
     * @var string
     */
    private $verb;

    /**
     * @var string
     */
    private $route;

    /**
     * @var string
     */
    private $className;

    /**
     * @var string
     */
    private $methodName;

    /**
     * @var string
     */
    private $alias;

    /**
     * RouteModel constructor.
     * @param string $verb
     * @param string $route
     * @param string $className
     * @param string $methodName
     * @param string $alias
     */
    public function __construct($verb, $route, $className, $methodName, $alias = null)
    {
        $this->verb = $verb;
        $this->route = $route;
        $this->className = $className;
        $this->methodName = $methodName;
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function getVerb()
    {
        return $this->verb;
    }

    /**
     * @param string $verb
     */
    public function setVerb(string $verb)
    {
        $this->verb = $verb;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $route
     */
    public function setRoute(string $route)
    {
        $this->route = $route;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param string $className
     */
    public function setClassName(string $className)
    {
        $this->className = $className;
    }

    /**
     * @return string
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * @param string $methodName
     */
    public function setMethodName(string $methodName)
    {
        $this->methodName = $methodName;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     */
    public function setAlias(string $alias)
    {
        $this->alias = $alias;
    }

    public function __toArray() {
        $arrayReturn = [
            $this->verb,
            $this->route,
            $this->className,
            $this->methodName,
            ];

        if (!is_null($this->alias)) {
            $arrayReturn[] = $this->alias;
        }

        return $arrayReturn;
    }

}