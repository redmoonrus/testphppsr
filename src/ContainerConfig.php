<?php
namespace ExampleApp;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\WebProcessor;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use DI;
use Zend\Diactoros\Response;

return array(
    ResponseInterface::class => DI\autowire(Response::class),
    LoggerInterface ::class => DI\factory(function(){
        $logger=new Logger('mylog');
        $logger->pushProcessor( new IntrospectionProcessor());
        $logger->pushProcessor(new WebProcessor());
        $handler= new StreamHandler('php://stdout',Logger::DEBUG);
        $logger->pushHandler($handler);
        return $logger;
    })
);
