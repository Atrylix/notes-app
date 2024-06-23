<?php
// Define a simple router class
class Router {
    private $routes = [];
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getConn() {
        return $this->conn;
    }
    
    public function get($route, $callback)
    {
        $this->routes[$route] = ['method' => 'GET', 'callback' => $callback];
    }

    public function post($route, $callback)
    {
        $this->routes[$route] = ['method' => 'POST', 'callback' => $callback];
    }

    public function render_template($template_name, ...$data_arrays) {
        $data = [];
        foreach ($data_arrays as $array) {
            $data = array_merge($data, $array);
        }
        
        $script_dir = __DIR__ . '/..';
        $template_path = $script_dir. '/templates/'. $template_name;
        
        if (!file_exists($template_path)) {
            throw new Exception("Template '$template_name' not found");
        }
        
        extract($data); // extract variables from $data array
        
        ob_start(); // start output buffering
        include $template_path;
        $html = ob_get_clean(); // get the rendered HTML
        
        return $html;
    }

    public function run()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
    
        // Strip the directory path from the URI
        $uri = substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
    
        foreach ($this->routes as $route => $config) {
            if ($uri === $route && $method === $config['method']) {
                $callback = $config['callback'];
                $callback();
                return;
            }
        }
    
        http_response_code(404);
        echo 'Not Found';
    }
}
