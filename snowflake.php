<?php
class Snowflake {
    public $request = array();
    private $route = array(
        'found' => false 
    );
    private $config = array(
        'debug' => false
    );
    
    public function __construct() {
        $this->request['path'] = $_SERVER['PATH_INFO'];
        $this->request['method'] = $_SERVER['REQUEST_METHOD'];
    }
    
    public function run() {
        if ($this->route['found']) call_user_func($this->route['callback'], $this->route['matches']);
        else call_user_func($this->route['404_callback']);
    }
    
    public function get($route, $callback) {
        if ($this->route['found'] == false && $this->request['method'] == 'GET') {
            $regex = '`' . preg_replace('`:(\w+)`', '(?P<\1>\w+)', $route) . '`';
            if (($route == "_root_" || $route == "/" || $route == "") && ($this->request['path'] == "" || $this->request['path'] == "/")) {
                $this->route['found'] = true;
                $this->route['callback'] = $callback;
                $this->route['matches'] = $matches;
            }
            elseif (preg_match($regex, $this->request['path'], $matches)) {
                $this->route['found'] = true;
                $this->route['callback'] = $callback;
                $this->route['matches'] = $matches;
            }
            elseif ($route == "_404_") $this->route['404_callback'] = $callback;
        }
    }
    
    public function post($route, $callback) {
        if ($this->route['found'] == false && $this->request['method'] == "POST") {
            $regex = '~' . preg_replace('~:(\w+)~', '(?P<\1>\w+)', $route) . '~';
            if ($route == "_root_" && ($this->request['path'] == "" || $this->request['path'] == "/")) {
                $this->route['found'] = true;
                $this->route['callback'] = $callback;
                $this->route['matches'] = $matches;
            }
            elseif (preg_match($regex, $this->request['path'], $matches)) {
                $this->route['found'] = true;
                $this->route['callback'] = $callback;
                $this->route['matches'] = $matches;
            }
            elseif ($this->route == "_404_") $this->route['404_callback'] = $callback;
        }
    }
    
    public function match($route, $callback) {
        switch($request['method']) {
            case "GET":
                $this->get($route, $callback);
            case "POST":
                $this->post($route, $callback);
        }
    }
    
    public function render($view, $vars=array()) {
        if (file_exists($view)) {
            extract($vars);
            try {
                include($view);
            }
            catch (\Exception $e) {
                return false;
            }
            return true;
        }
        else throw new Exception('File to render not found!');
    }
    
    public function config($var, $new=false) {
        if ($new == false) return $this->config[$var];
        else $this->config[$var] = $new;
    }
}
?>