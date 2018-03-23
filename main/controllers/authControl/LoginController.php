<?php namespace main\controllers\authControl;

    use main\models\User;
    use main\gui\guiCreator;
    use main\layouts\bootstrap\main;
    use main\controllers\Controller;
    use main\gui\renderer\bootstrapForm;
    use main\frameworkHelper\cacheManager;
    use main\frameworkHelper\fieldsValidator;

    class LoginController extends Controller
    {
        protected $arrComponents;

        /**
         * LoginController constructor.
         */
        public function __construct ( )
        {
            $Tabs   = "\t\t\t\t\t\t\t\t\t";
            $components =
                [
                    0    =>
                        [
                            0 =>
                                [
                                    "parent"        => "fields",
                                    "class"         => "emailField",
                                    "label"         => "Email Address",
                                    "name"          => "email",
                                    "id"            => "email",
                                    "setRequired"   => true,
                                    "setShowStar"   => false,
                                    "setIcon"       => "<i class=\"fas fa-envelope\"></i>",
                                    "setTabs"       => $Tabs
                                ]
                        ],
                    1   =>
                        [
                            0 =>
                                [
                                    "parent"        => "fields",
                                    "class"         => "passwordField",
                                    "label"         => "Password",
                                    "name"          => "password",
                                    "id"            => "password",
                                    "setRequired"   => true,
                                    "setShowStar"   => false,
                                    "setIcon"       => "<i class=\"fas fa-key\"></i>",
                                    "setTabs"       => $Tabs
                                ],
                        ],
                    2   =>
                        [
                            0 =>
                                [
                                    "parent"        => "links",
                                    "class"         => "link",
                                    "href"          => $GLOBALS ["RELATIVE_TO_ROOT"] . "/Reset",
                                    "label"         => "Having trouble logging in?",
                                    "setformItem"   => true,
                                    "setTabs"       => $Tabs
                                ]
                        ],
                    3   =>
                        [
                            0 =>
                                [
                                    "parent"        => "buttons",
                                    "class"         => "formButton",
                                    "label"         => "Login",
                                    "id"            => "login",
                                    "type"          => 1,
                                    "setTabs"       => $Tabs
                                ],
                            1 =>
                                [
                                    "parent"        => "links",
                                    "class"         => "link",
                                    "href"          => $GLOBALS ["RELATIVE_TO_ROOT"] . "/Register",
                                    "label"         => "Register",
                                    "setClass"      => "right",
                                    "setOutLine"    => true,
                                    "setformItem"   => true,
                                    "setLikeBtn"    => true,
                                    "setTabs"       => $Tabs
                                ]
                        ]
                ];

            $arrComponents  = new guiCreator ( $components );
            $this->arrComponents = $arrComponents->getContainer ( );

            if ( findInURL( '1' ) )
            {
                $_REQUEST ["ALERT_HEAD"] = "Timed out";
                $_REQUEST ["ALERT_TYPE"] = 5;
                $_REQUEST ["ALERT_MSG"] = "You have not been active for a while so we logged you out.";
            }
        }

        /**
         * @return string
         */
        private function preRenderPage ( )
        {
            $formId     = "form-parsley";
            $formMethod = "post";
            $formAction = $GLOBALS ["RELATIVE_TO_ROOT"] . "/Login";
            $formTabs   = "\t\t\t\t\t\t";
            $html       = bootstrapForm::renderStatic ( $this->arrComponents, $formTabs, $formId, $formMethod, $formAction );
            return $html;
        }

        /**
         * @param array $values
         * @return string
         */
        private function renderPage ( )
        {
            $folder = $GLOBALS ["CACHE_FOLDER"] . "/" . basename ( __DIR__ );
            $file   = $folder . "/login.html";
            $errors = false;

            $cacheManager = new cacheManager ( $folder, $file );
            if ( ! $cacheManager->isCacheExists ( ) ) { $errors = ! $cacheManager->write ( $this->preRenderPage ( ) ); }
            if ( ! $errors ) { return $cacheManager->read ( $this->arrComponents ); }
            return "";
        }

        /**
         * @throws \Exception
         */
        protected function onGet ( )
        {
            session_auth ( true );
            $layoutTemplate = new main( );

            $html   = "<!DOCTYPE html>\n";
            $html   .= "<html lang=\"en\">\n";
            $html   .= "\t<head>\n";
            $html   .= $layoutTemplate->render_header ( [ "TITLE" => "Login Page" ], ".login { margin-top: 50px; }" );
            $html   .= "\t</head>\n";
            $html   .= "\t<body>\n";
            $html   .= "\t\t<div class=\"container login\">\n";
            $html   .= "\t\t\t<div class=\"row justify-content-center\">\n";
            $html   .= "\t\t\t\t<div class=\"col-md-6 col-lg-6 col-xl-6\">\n";
            $html   .= flash_message ( "\t\t\t\t\t" );
            $html   .= "\t\t\t\t\t<div class=\"card\">\n";
            $html   .= "\t\t\t\t\t<h4 class=\"center\">" . $GLOBALS ["BS_NAME"] . "</h4><hr/>\n";
            $html   .= $this->renderPage ( );
            $html   .= "\t\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t</div>\n";
            $html   .= "\t\t</div>\n";
            $html   .= $layoutTemplate->render_footer ( array ( ) );
            $html   .= "\t</body>\n";
            $html   .= "</html>\n";

            echo $html;
        }

        /**
         * @throws \Exception
         */
        protected function onPost ( )
        {
            $errors = ! fieldsValidator::validate ( $this->arrComponents );

            if ( $errors )
            {
                $_REQUEST ["ALERT_MSG"] = "Something went wrong, please make a correction and try again";
                $_REQUEST ["ALERT_TYPE"]= 4;
            }
            else
            {
                $errors = ! $this->authenticateUser ( );
                if ( ! $errors )
                {
                    redirect ( $GLOBALS ["RELATIVE_TO_ROOT"] . $_SESSION ["USER_HOME"] );
                }
            }
            $this->onGet();
        }

        /**
         * @return bool
         */
        protected function authenticateUser ( )
        {
            $data ["email"]     = $this->arrComponents [0][0]->getValue ( );
            $data ["password"]  = $this->arrComponents [1][0]->getValue ( );

            $user = new User( ["EMAIL", $data ["email"] ] );

            if ( is_null ( $user->getUser ( ) ) )
            {
                $_REQUEST ["ALERT_HEAD"] = "User Not Found!";
                $_REQUEST ["ALERT_TYPE"] = 5;
                $_REQUEST ["ALERT_MSG"]  = "This email address is unassociated with any account.";
                return false;
            }

            define ( 'stop'         , 0 );
            define ( 'user_active'  , 1 );
            define ( 'user_verified', 2 );
            define ( 'user_auth'    , 3 );
            define ( 'user_failed'  , 4 );
            define ( 'user_login'   , 5 );

            $state = user_active;
            while ( $state > stop )
            {
                switch ( $state )
                {
                    case user_active:
                        if ( $user->isActive ( ) )
                        {
                            $state = user_verified;
                        }
                        else
                        {
                            $_REQUEST ["ALERT_HEAD"] = "Disabled Account!";
                            $_REQUEST ["ALERT_TYPE"] = 4;
                            $_REQUEST ["ALERT_MSG"]  = "Contact support to re-enable this account";
                            return false;
                        }
                    break;

                    case user_verified:
                        if ( $user->isVerified ( ) )
                        {
                            $state = user_auth;
                        }
                        else
                        {
                            $_REQUEST ["ALERT_HEAD"] = "Unverified Account!";
                            $_REQUEST ["ALERT_TYPE"] = 5;
                            $_REQUEST ["ALERT_MSG"]  = "Verify your account in order to be able to login, a verification email is sent right after a successful registration";
                            return false;
                        }
                    break;

                    case user_auth:
                        if ( ! $user->isAuth ( $data ["password"] ) )
                            $state = user_failed;
                        else
                            $state = user_login;
                    break;

                    case user_failed:
                        $attempts = User::incrementFailed ( $user->getID ( ) );
                        $_REQUEST ["ALERT_HEAD"] = "Incorrect Password!";
                        $_REQUEST ["ALERT_TYPE"] = 4;
                        $_REQUEST ["ALERT_MSG"]  = "You have entered an incorrect password " . isset ( $attempts ) ? " attempt " . $attempts . " out of " . $GLOBALS ["MAX_FAILED"] : "";

                        if ( isset ( $attempts ) )
                        {
                            if ( $attempts >= $GLOBALS ["MAX_FAILED"] )
                                User::disable ( $user->getID ( ) );
                        }
                        return false;
                    break;

                    case user_login:

                        $logoutTime = new \datetime ( 'now', new \DateTimeZone( $GLOBALS ["TIME_ZONE"] ) );
                        try
                        {
                            $logoutTime->add ( new \DateInterval ( 'PT' . $GLOBALS ["S_TIMEOUT"] . 'M' ) );
                        }
                        catch ( \Exception $E )
                        {
                            error_log ( 'Setting Session Time Error ' . $E->getMessage(), 0 );
                            return false;
                        }

                        session_start ( );
                        $_SESSION ["USER_ID"] = $user->getID ( );
                        $_SESSION ["USER_NAME"] = $user->getName ( );
                        $_SESSION ["USER_EMAIL"] = $user->getEmail ( );
                        $_SESSION ["USER_ROLE"] = $user->getRole ( );
                        $_SESSION ["USER_HOME"] = $user->getHomePage ( );
                        $_SESSION ["CSRF_TOKEN"] = CSRFToken ( );
                        $_SESSION ["TIMEOUT"] = $logoutTime->format ( 'm/d/Y H:i:s' );
                        $_SESSION ["CHANGE_PASS"] = $user->mustChangePassword ( );

                        return User::setLastLogin( $user->getID ( ) );
                    break;
                }
            }
        }
    }