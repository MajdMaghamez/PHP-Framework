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

            if ( findInURL( 'TimedOut' ) )
            {
                setFlashMessage( "Timed out", "You havn&#39;t been active for a while so we logged you out.", 5 );
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
                setFlashMessage("", "Something went wrong, please make a correction and try again", 4 );
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
            $email      = $this->arrComponents [0][0]->getValue ( );
            $password   = $this->arrComponents [1][0]->getValue ( );

            $user = new User( [ "EMAIL", $email ] );

            // check if the user exists
            if ( is_null ( $user->getUser ( ) ) )
            {
                setFlashMessage( "User Not Found!", "This email address isn&#39;t associated with any account.", 5 );
                return false;
            }

            // check if the user has an active account
            if ( ! $user->isActive ( ) )
            {
                setFlashMessage( "Disabled Account!", "This account is disabled due to excessive failed login attempts. You may enable it again by resetting your password.", 4 );
                return false;
            }

            // check if the user account was verified
            if ( ! $user->isVerified ( ) )
            {
                setFlashMessage( "Unverified Account!", "This account hasn&#39;t been verified yet. A verification email was sent upon your registration.", 5 );
                return false;
            }

            // check if the user entered the correct password
            if ( ! $user->isAuth ( $password ) )
            {
                // increment failed login attempts and the return the total number of failed attempts
                $attempts = $user->incrementFailed ( );

                // check if the user reached the maximum allowed login attempts
                if ( $attempts >= $GLOBALS ["MAX_FAILED"] )
                    // disable user account
                    $user->setActive ( false );

                setFlashMessage( "Incorrect Password!", "You&#39;ve entered an incorrect password attempt " . $attempts . " out of " . $GLOBALS ["MAX_FAILED"], 4 );
                return false;
            }

            // Authenticate the user
            return $user->setAuthentication ( );
        }
    }