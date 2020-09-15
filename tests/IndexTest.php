<?php

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

class IndexTest extends TestCase
{
    /**
     * @return void
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function testHello()
    {

        require __DIR__ . '/../vendor/autoload.php';

        $request = Request::create(
            '/hello/Cédric',
            'GET'
        );

        $routes = require __DIR__. '/../src/routes.php';

        $context = new RequestContext();
        $context->fromRequest($request);

        $urlMatcher = new UrlMatcher($routes, $context);

        try {
            $resultat = ($urlMatcher->match($request->getPathInfo()));

            $request->attributes->add($resultat);

            $response = call_user_func($request->attributes->get('_controller'), $request);
        } catch (ResourceNotFoundException $e) {
            $response = new Response('La page demandée n\'exite pas', 404);
        } catch (Exception $e) {
            $response = new Response('Une erreur est survenue', 500);
        }

        $this->assertEquals('Hello Cédric', $response->getContent());
    }
}
