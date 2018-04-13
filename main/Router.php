<?php namespace main;

    use main\controllers\init;
    use main\userControl\userProfile;
    use main\userControl\userAccount;
    use main\userControl\userPassword;
    use main\userControl\userQuestions;
    use main\controllers\devControl\main;
    use main\controllers\usersControl\usersList;
    use main\controllers\usersControl\usersCreate;
    use main\controllers\usersControl\usersDelete;
    use main\controllers\usersControl\usersEditRole;
    use main\controllers\homeControl\homeController;
    use main\controllers\usersControl\usersEditName;
    use main\controllers\usersControl\usersEditEmail;
    use main\controllers\authControl\LoginController;
    use main\controllers\authControl\LogoutController;
    use main\controllers\authControl\VerifyController;
    use main\controllers\usersControl\usersRoleDetails;
    use main\controllers\usersControl\usersEditPassword;
    use main\controllers\authControl\RegisterController;
    use main\controllers\authControl\ResetPassController;
    use main\controllers\authControl\ResetEmailController;
    use main\controllers\devControl\databaseControl\system;
    use main\controllers\devControl\databaseControl\application;

    Class Router {

        private $routes = [];
        private static $instance = null;

        private function __construct ( ) {
            $this->routes["Init"]                       = init::class;

            // Dev route
            $this->routes["Dev"]                        = main::class;
            $this->routes["Dev/Database/System"]        = system::class;
            $this->routes["Dev/Database/Application"]   = application::class;

            // Auth route
            $this->routes["Login"]                      = LoginController::class;
            $this->routes["Logout"]                     = LogoutController::class;
            $this->routes["Register"]                   = RegisterController::class;
            $this->routes["Reset/Email"]                = ResetEmailController::class;
            $this->routes["Reset/Password"]             = ResetPassController::class;
            $this->routes["Verify"]                     = VerifyController::class;

            // User route
            $this->routes["User/Account"]               = userAccount::class;
            $this->routes["User/Password"]              = userPassword::class;
            $this->routes["User/Questions"]             = userQuestions::class;
            $this->routes["User/Profile"]               = userProfile::class;

            // Users route
            $this->routes["Users/List"]                 = usersList::class;
            $this->routes["Users/Add"]                  = usersCreate::class;
            $this->routes["Users/Role/Details"]         = usersRoleDetails::class;
            $this->routes["Users/Delete"]               = usersDelete::class;
            $this->routes["Users/Edit"]                 = usersEditName::class;
            $this->routes["Users/Edit/Email"]           = usersEditEmail::class;
            $this->routes["Users/Edit/Password"]        = usersEditPassword::class;
            $this->routes["Users/Edit/Role"]            = usersEditRole::class;

            // Home route
            $this->routes["Home"]                       = homeController::class;
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
                $router = null;
                $route = explode( '/', $route );

                foreach ( $route as $index => $item )
                {
                    array_pop ( $route );
                    $controller = implode( '/', $route );
                    if ( array_key_exists( $controller, $this->routes ) )
                    {
                        $router = $controller;
                        break;
                    }
                }

                ( ! is_null ( $router ) ) ? $this->routeTo( $router ) : redirect( '/404.html' );
            }
        }

        /**
         * @param string $route
         */
        public function routeTo( $route ) {
            if ( array_key_exists( $route, $this->routes) )
            {
                $controllerClass = $this->routes[$route];
                ( new $controllerClass ( ) )->onRequestStart ( );
            }
            else
            {
                http_response_code (404 );
                redirect( '/404.html' );
            }
        }
    }