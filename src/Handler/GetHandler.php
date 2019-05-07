<?php

namespace ExampleApp\Handler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
class GetHandler
{


    private $response;
    private $logger;

    public function __construct(ResponseInterface $response, LoggerInterface $logger)
    {
        $this->response = $response;
        $this->logger = $logger;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface{
        $this->logger->log(LogLevel::INFO,"get handler");
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()->write('<html><head></head><body>Get Handler</body></html>');
        var_dump($request);
        return $response;
    }
}
