<?php

class App
{
    private string $controllerName = DEFAULT_CONTROLLER;
    private object $controller;
    private string $method = DEFAULT_METHOD;
    private array $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        if (!empty($url) && file_exists(__DIR__ . '/../Controllers/' . ucfirst($url[0]) . 'Controller.php')) {
            $this->controllerName = ucfirst($url[0]);
            unset($url[0]);
        }

        require_once __DIR__ . '/../Controllers/' . $this->controllerName . 'Controller.php';
        $controllerClass = $this->controllerName . 'Controller';
        $this->controller = new $controllerClass();

        if (!empty($url) && isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        $this->params = $url ? array_values($url) : [];
    }

    public function run(): void
    {
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl(): array
    {
        if (isset($_GET['url'])) {
            $url = filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}
