<?php


namespace ExampleApp;

use ExampleApp\Handler\GetHandler;
use ExampleApp\Handler\PostHandler;
use ExampleApp\Handler\TokenHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
class RouterMiddleware implements MiddlewareInterface
{
    private $ConnectionConfig;
    private $ActionConfig;
    private $pathUri;
    private $method;
    private $request;
    public function __construct(string $path, bool $fromfile = true)
    {
        if ($fromfile) {
            if (file_exists($path)) {
                $string = file_get_contents($path);
            }
        } else {
            $string = $path;
        }
        $json_a = json_decode($string, true);
        $this->ActionConfig = $json_a['ActionConfiguration'];
        $this->ConnectionConfig = $json_a['ConnectionStrings'];
    }

    private $attribute = 'request-handler';
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->pathUri=$request->getUri()->getPath();
        $this->request=$request;
        $this->method=$request->getMethod();
        if($this->pathUri === '/token')
        {
            $request= $request->withAttribute($this->attribute, TokenHandler::class);
            return $handler->handle($request);
        }
        switch ($this->method) {
            case 'GET':
                $request= $request->withAttribute($this->attribute, GetHandler::class);
                break;
            case 'POST':
                $request= $request->withAttribute($this->attribute, PostHandler::class);
                break;
            default:
                $request= $request->withAttribute($this->attribute, HelloWorld::class);

                break;
        }
        $filtered_array=array_filter( $this->ActionConfig[$this->method], function($item){
            return $item['Path'] === trim( $this->pathUri,'/');
        });
        $request= $request->withAttribute('Connection',$this->ConnectionConfig[$filtered_array[0]['Connection']]);
        $request= $request->withAttribute('Procedure',$filtered_array[0]['Procedure']);
        $request= $request->withAttribute('XSD',$filtered_array[0]['SchemaXSD']);
        return $handler->handle($request);
    }
}
