<?php

namespace Penwork\Base;

use Penwork\Router;

class View
{
    public $route;
    public $view;
    public $layout;

    public function __construct($route = null, $layout = null, $view = null)
    {
        $this->route = $route ?? Router::getRoute();
        $this->layout = $layout ?? DEFAULT_LAYOUT;
        $this->view = $view ?? $route['action'];
    }

    public function render($params): void
    {
        if ($this->view === false) {
            echo json_encode($params);
            return;
        }

        $fileView = APP . "/views/{$this->route['controller']}/{$this->view}.php";

        if (\is_array($params)) {
            extract($params, EXTR_SKIP);
        }

        $route = $this->route;

        ob_start();

        if (is_file($fileView)) {
            require $fileView;
        } else {
            echo 'NOT FOUND VIEW ' . $fileView;
        }

        $content = ob_get_clean();

        if ($this->layout === false) {
            echo $content;
            return;
        }

        $fileLayout = APP . "/views/layouts/{$this->layout}.php";

        if (is_file($fileLayout)) {
            require $fileLayout;
        } else {
            echo 'NOT FOUND LAYOUT ' . $fileLayout;
        }
    }
}