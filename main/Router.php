<?php namespace main;

    use main\controllers\init;
    use main\controllers\notFound;
    use main\controllers\homeControl\homeController;
    use main\controllers\authControl\LoginController;
    use main\controllers\authControl\LogoutController;
    use main\controllers\authControl\VerifyController;
    use main\controllers\authControl\RegisterController;
    use main\controllers\authControl\ResetPassController;
    use main\controllers\authControl\ResetEmailController;

    Class Router {

        private $routes = [];
        private static $instance = null;

        private function __construct ( ) {
            $this->routes["Init"]           = init::class;

            $this->routes["Login"]          = LoginController::class;
            $this->routes["Logout"]         = LogoutController::class;
            $this->routes["Register"]       = RegisterController::class;
            $this->routes["Reset/Email"]    = ResetEmailController::class;
            $this->routes["Reset/Password"] = ResetPassController::class;
            $this->routes["Verify"]         = VerifyController::class;

            $this->routes["Home"]           = homeController::class;
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

            // checking if the route already exists in the queue ?
            // otherwise try again by looping through
            // if none exists forward to 404 page not found in the routeTo function

            if ( array_key_exists ( $route, $this->routes ) )
            {
                $this->routeTo($route);
            }
            else
            {
                $route = explode( '/', $route );
                $controller = $route[0];

                for ( $i = 1; $i < sizeof($route); $i++ )
                {
                    $controller .= '/' . $route[$i];
                    if ( array_key_exists ( $controller, $this->routes ) )
                        $this->routeTo($controller);
                }

                $this->routeTo($route[0]);
            }
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