<?php namespace main;

    use main\controllers\authControl\LoginController;
    use main\controllers\authControl\RegisterController;
    use main\controllers\authControl\ResetController;

    Class Router {

        private $routes = [];
        private static $instance = null;

        private function __construct ( ) {
            $this->routes["Login"]      = LoginController::class;
            $this->routes["Register"]   = RegisterController::class;
            $this->routes["Reset"]      = ResetController::class;
        }

        public static function getApplicationRouter ( ) {
            if ( ! isset ( self::$instance ) )
            {
                self::$instance = new Router ( );
            }

            return self::$instance;
        }

        public function handleRequest ( ) {
            $uri = $_SERVER["REQUEST_URI"];
            $route = preg_replace ("/\..+$/","", $uri );
            $route = trim ( $route,"/" );

            $this->routeTo($route);
        }

        public function routeTo( $route ) {
            if ( array_key_exists( $route, $this->routes) )
            {
                $controllerClass = $this->routes[$route];
                ( new $controllerClass ( ) )->onRequestStart ( );
            }
        }
    }