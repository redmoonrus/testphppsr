<?php
declare(strict_types=1);
use ExampleApp\RouterMiddleware;
use Middlewares\RequestHandler;
use Narrowspark\HttpEmitter\SapiEmitter;
use Relay\Relay;
use Zend\Diactoros\ServerRequestFactory;

require_once './vendor/autoload.php';

$builder = new DI\ContainerBuilder();
$builder->addDefinitions('./src/ContainerConfig.php');
$container = $builder->build();

//$middlewareQueue[] =new \ExampleApp\AuthMiddleware();
$middlewareQueue[] = new RouterMiddleware('./config.json');
$middlewareQueue[] = new RequestHandler($container);

$requestHandler = new Relay($middlewareQueue);

$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());
$emitter = new SapiEmitter();
$emitter->emit($response);



