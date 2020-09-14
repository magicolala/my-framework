<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

require __DIR__ . '/../vendor/autoload.php';

$request = Request::createFromGlobals();

$routes = require __DIR__. '/../src/routes.php';

$context = new RequestContext();
$context->fromRequest($request);

$urlMatcher = new UrlMatcher($routes, $context);

try {
    extract($urlMatcher->match($request->getPathInfo()));

    ob_start();
    include __DIR__ . '/../src/pages/' . $_route . '.php';
    $response = new Response(ob_get_clean());
} catch (ResourceNotFoundException $e) {
    $response = new Response('La page demandée n\'exite pas', 404);
} catch (Exception $e) {
    $response->setContent('Une erreur est survenue sur le serveur');
    $response->setStatusCode(500);
}

$response->send();
