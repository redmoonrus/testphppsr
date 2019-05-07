<?php


namespace ExampleApp;


use Middlewares\Utils\Factory;
use Middlewares\Utils\Traits\HasResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class AuthMiddleware  implements MiddlewareInterface
{
    use HasResponseFactory;
    public function __construct(ResponseFactoryInterface $responseFactory = null)
    {
        $this->responseFactory = $responseFactory ?: Factory::getResponseFactory();
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path=$request->getUri()->getPath();
        if($path === '/token') {
            return $handler->handle($request);
        }

        return $this->createResponse(401, 'auth error');

    }
}
