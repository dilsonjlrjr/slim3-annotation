<?php
/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 19/10/16
 * Time: 13:34
 */

namespace Test\Middleware;


class ExampleMiddleware
{

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     *
     * @return ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $response->getBody()->write("AFTER");
        $response = $next($request, $response);
        $response->getBody()->write("BEFORE");

        return $response;
    }

}