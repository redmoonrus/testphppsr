<?php


namespace ExampleApp;

use FastRoute\RouteCollector;
class RouteMapper
{
    private $map;
    private $routes;

    public function __construct($map) {
        $this->map = $map;
    }

    public function __invoke(RouteCollector $collector)
    {
        $this->map($collector);
    }

    public function map(RouteCollector $collector)
    {
        foreach ($this->getRoutes() as $row) {
            $collector->addRoute($row[0], $row[1], $row[2]);
        }
    }
}
