<?php


namespace ExampleApp;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HelloWorld
{
    private $response;
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface{
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()->write("<html><head></head><body>Hello world!</body></html>");
        var_dump($request);
        return $response;
    }
}
