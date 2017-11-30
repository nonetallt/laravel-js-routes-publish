<?php

namespace Nonetallt\Jsroute;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Illuminate\Support\Facades\Route as Routes;

class Jsroutes
{
    function __construct()
    {

    }

    function generate(array $routes)
    {
        $output = '';
        foreach($routes as $route)
        {
            $output .= config('jsroute.js_reference', 'Route');
            $output .= '.';
            $output .= strtolower($route->methods()[0]);

            $controller = null;

            try
            {
                $controller = $route->getController();
            }
            catch(\Exception $e)
            {
                // errors out on parsing in source code when trying to parse
                // callback
            }

            if(is_null($controller))
            {
                $output .= "('{$route->uri()}')";
            }
            else
            {
                $controller = class_basename($controller);
                $output .= "('{$route->uri()}', '$controller@{$route->getActionMethod()}')";
            }
            if($route->getActionName() !== 'Closure')
            {
                $output .= ".name('{$route->getName()}')";
            }
            $output .= ';';
            $output .= PHP_EOL;
        }
        return $output;
    }

    function routes()
    {
        // Get the route collection
        $routes = Routes::getRoutes();
        
        // Get the routes in the route collection
        $routes = $routes->getRoutes();

        return $routes;
    }

    function filterRoutes(array $routes, array $middleware = null, array $names = null)
    {
        $nonFilteredRoutes = [];
        if(is_null($middleware)) $middleware = config('jsroute.exclude_middleware');
        if(is_null($names)) $names = config('jsroute.exclude_by_name');

        foreach($routes as $route)
        {
            $filteredMiddleware = array_intersect($route->gatherMiddleware(), $middleware);
            if(count($filteredMiddleware) > 0) continue;

            $nameInFilters = array_search($route->getName(), $names);
            if($nameInFilters !== false) continue;

            $nonFilteredRoutes[] = $route;
        }
        return $nonFilteredRoutes;
    }

    function sort(array $routes, string $sortBy = null, $sortOrder = null)
    {
        if(is_null($sortBy)) $sortBy = config('jsroute.sort_by');
        if(is_null($sortOrder)) $sortOrder = config('jsroute.sort_order');
        
        $callback = null;
        
        // Check if option is descending
        $desc = false;
        if($sortOrder === 'desc') $desc = true;

        switch($sortBy)
        {
        case 'uri':
            $callback = function($route) { return $route->uri(); };
            break;
        case 'verb':
            $callback = function($route) { return $route->methods()[0]; };
            break;
        case 'name':
            $callback = function($route) { return $route->getName(); };
            break;
        default:
            // Sort by default given by laravel
            return $routes;
        }

        usort($routes, function($a, $b) use ($callback, $desc)
        {
            // Use callback to get the desired values for comparison
            $result = strcmp($callback($a), $callback($b));
            if($desc) return $this->rev($result);
            return $result;
        });

        return $routes;
    }

    // Reverse the sign of a number
    private function rev($value)
    {
        if($value > 0) return -$value;
        if($value < 0) return abs($value);
        return 0;
    }
}
