<?php

class Router
{
    private array $routes = [];
   
    //Método para registrar rutas
    public function add(string $method, string $path, string $controller, string $action): void
    {
        $this->routes[] = [
            'method'     => strtoupper($method),
            'path'       => $path,
            'controller' => $controller,
            'action'     => $action
        ];
    }

    //Función para leer las rutas
    private function getCurrentPath(): string
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Ruta del script actual (ej: /dashboard/Portafolio/Apartado-Salas/public/index.php)
        $scriptName = $_SERVER['SCRIPT_NAME'];

        // Directorio base del proyecto (ej: /dashboard/Portafolio/Apartado-Salas/public)
        $basePath = rtrim(str_replace('/index.php', '', $scriptName), '/');

        // Quitar el base path de la URI
        if (strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        // Normalizar la ruta final
        $uri = '/' . trim($uri, '/');

        return $uri === '/' ? '/' : $uri;
    }

    //Función para leer el método HTTP
    private function getRequestMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }


    public function dispatch(): void
    {
        $currentPath   = $this->getCurrentPath();
        $requestMethod = $this->getRequestMethod();

        foreach ($this->routes as $route) {
            if (
                $route['path'] === $currentPath &&
                $route['method'] === $requestMethod
            ) {
                $this->callAction($route['controller'], $route['action']);
                return;
            }
        }

        $this->handleNotFound();
    }

    private function callAction(string $controllerName, string $action): void
    {
        $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            die('Controlador no encontrado');
        }

        require_once $controllerFile;

        $controller = new $controllerName();

        if (!method_exists($controller, $action)) {
            die('Método no encontrado en el controlador');
        }

        $controller->$action();
    }

    //Manejo para la ruta no encontrada: error 404 not found
    private function handleNotFound(): void
    {
        http_response_code(404);
        echo '404 - Página no encontrada';
    }

}
