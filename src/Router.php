<?php
declare(strict_types=1);

namespace Penwork;

use CaseConverter\CaseConverter;
use CaseConverter\ConcreteConverter\LowerCamelCaseConverter;

class Router extends BaseObject
{

    /** @var array $routes */
    protected static $routes = [];

    /** @var array $route */
    protected static $route = [];

    public static function add(string $regexp, array $route = []): void
    {
        self::$routes[$regexp] = $route;
    }

    public static function getRoutes(): array
    {
        return self::$routes;
    }

    public static function getRoute(): array
    {
        return self::$route;
    }

    protected static function matchRoute($url): bool
    {
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#$pattern#", $url, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        switch ($key) {

                            case 'controller':
                                $route[$key] = self::matchControllerName($value);
                                break;

                            case 'action':
                                $route[$key] = self::matchActionName($value);
                                break;

                            case 'item_id':
                            case 'event_id':
                                $route[$key] = $value;
                                break;

                        }
                    }
                }
                $route['action'] = $route['action'] ?? 'index';
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    protected static function matchControllerName($name): string
    {
        return CaseConverter::convertToUpperCamel($name);
    }

    protected static function matchActionName($name): string
    {
        return CaseConverter::convertToLowerCamel($name);
    }

    public static function dispatch($url): void
    {
        $url = self::removeQueryString($url);
        if (self::matchRoute($url)) {

            $controllerName = self::getConfigRequiredParams('namespace', 'controller') . '\\' . self::$route['controller'] . 'Controller';

            $converter = new CaseConverter(self::$route['action']);
            $converter->getPhraseHolder()->prependWord('action');
            $actionName = $converter->convert(new LowerCamelCaseConverter());

            if (!class_exists($controllerName)) {
                self::notFound();
            }

            $controllerObject = new $controllerName(self::$route);

            if (!method_exists($controllerObject, $actionName)) {
                self::notFound();
            }

            /** @var AbstractController $controllerObject */
            $controllerObject->$actionName();
            $controllerObject->renderView();
        } else {
            self::notFound();
        }
    }

    public static function notFound(): void
    {
        http_response_code(404);
        /** @noinspection PhpIncludeInspection */
        include self::getConfigParams('error_page', '404') ?? __DIR__ . '../assets/404.html';
        die;
    }

    protected static function removeQueryString($url)
    {
        if ($url === '') {
            return $url;
        }

        $params = explode('?', $url, 2);
        if (strpos('=', $params[0]) === false) {
            return rtrim($params[0], '/');
        }

        return '';
    }
}
