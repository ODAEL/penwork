<?php
declare(strict_types=1);

namespace Penwork;

class View extends BaseObject
{
    public $route;
    public $view;
    public $layout;

    public function __construct($route = null, $layout = null, $view = null)
    {
        $this->route = $route ?? Router::getRoute();
        $this->layout = $layout ?? self::getConfigRequiredParams('layout', 'default');
        $this->view = $view ?? $route['action'];
    }

    public function render($params): void
    {
        if ($this->view === false) {
            echo json_encode($params);
            return;
        }

        $fileView = self::getConfigRequiredParams('path', 'view') . "/{$this->route['controller']}/{$this->view}.php";

        if (is_array($params)) {
            extract($params, EXTR_SKIP);
        }

        ob_start();

        if (is_file($fileView)) {
            /** @noinspection PhpIncludeInspection */
            require $fileView;
        } else {
            echo 'NOT FOUND VIEW ' . $fileView;
        }

        $content = ob_get_clean();

        if ($this->layout === false) {
            echo $content;
            return;
        }

        $fileLayout = self::getConfigRequiredParams('path', 'layout') . "/{$this->layout}.php";

        if (is_file($fileLayout)) {
            /** @noinspection PhpIncludeInspection */
            require $fileLayout;
        } else {
            echo 'NOT FOUND LAYOUT ' . $fileLayout;
        }
    }
}