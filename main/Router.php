<?php namespace main;

    use main\controllers\init;
    use main\controllers\notFound;
    use main\controllers\homeControl\homeController;
    use main\controllers\authControl\LoginController;
    use main\controllers\authControl\LogoutController;
    use main\controllers\authControl\ResetController;
    use main\controllers\authControl\VerifyController;
    use main\controllers\authControl\RegisterController;

    Class Router {

        private $routes = [];
        private static $instance = null;

        private function __construct ( ) {
            $this->routes["Init"]       = init::class;

            $this->routes["Login"]      = LoginController::class;
            $this->routes["Logout"]     = LogoutController::class;
            $this->routes["Register"]   = RegisterController::class;
            $this->routes["Reset"]      = ResetController::class;
            $this->routes["Verify"]     = VerifyController::class;

            $this->routes["Home"]       = homeController::class;
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
            $route = explode( '/', $route );

            $this->routeTo($route[0]);
        }

        public function routeTo( $route ) {
            if ( array_key_exists( $route, $this->routes) )
            {
                $controllerClass = $this->routes[$route];
                ( new $controllerClass ( ) )->onRequestStart ( );
            }
            else
            {
                ( new notFound ( ) )->onRequestStart ( );
            }
        }
    }