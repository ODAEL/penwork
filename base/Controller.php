<?php

namespace Penwork\base;

use Penwork\Router;

abstract class Controller {

    public $route;
    public $layout;
    public $view;
    public $params = [];

    private $_viewObject;

    public function __construct($route = null)
    {
        $this->route = $route ?? Router::getRoute();
        $this->view = $this->route['action'];
    }

    public function renderView(): void
    {
        $this->beforeRenderView();
        if ($this->_viewObject instanceof View) {
            $this->_viewObject->render($this->params);
        }
    }

    protected function beforeRenderView(): void
    {
        $this->_viewObject = new View($this->route, $this->layout, $this->view);
    }

    public function addParams($params): void
    {
        $this->params = array_merge($this->params, $params);
    }

    public function goSuccess(array $data = []): bool
    {
        return $this->goWithStatus('OK', $data);
    }

    public function goError($message = []): bool
    {
        $data = is_array($message) ? ['errors' => $message] : ['error' => $message];
        return $this->goWithStatus('ERROR', $data);
    }

    public function redirect(string $url): bool
    {
        header('Location: ' . $url);
        return true;
    }

    protected function goWithStatus(string $status, array $data): bool
    {
        $this->addParams(array_merge([
            'status' => $status,
        ], $data));
        return true;
    }
}