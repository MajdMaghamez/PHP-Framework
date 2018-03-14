<?php namespace main\controllers\authControl;

    use main\gui\guiCreator;
    use main\gui\alerts\alert;
    use main\layouts\bootstrap\main;
    use main\controllers\Controller;
    use main\gui\renderer\bootstrapForm;
    use main\frameworkHelper\cacheManager;
    use main\frameworkHelper\fieldsValidator;
    class LoginController extends Controller
    {
        protected $errors = false;
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
                                    "parent"        => "fields",
                                    "class"         => "honeyPotField",
                                    "label"         => "User Name",
                                    "name"          => "username",
                                    "id"            => "username",
                                    "setTabs"       => $Tabs
                                ]
                        ],
                    3   =>
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
                    4   =>
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

            $cacheManager = new cacheManager ( $folder, $file );
            if ( ! $cacheManager->isCacheExists ( ) ) { $this->errors = ! $cacheManager->write ( $this->preRenderPage ( ) ); }
            if ( ! $this->errors ) { return $cacheManager->read ( $this->arrComponents ); }
            return "";
        }

        public function onGet ( )
        {
            $layoutTemplate = new main( );
            $alert  = new alert ( "Oops!", "Something went wrong, please make a correction and try again", 4 );
            $alert->setTabs ( "\t\t\t\t\t" );

            $html   = "<!DOCTYPE html>\n";
            $html   .= "<html lang=\"en\">\n";
            $html   .= "\t<head>\n";
            $html   .= $layoutTemplate->render_header ( [ "TITLE" => "Login Page" ], ".login { margin-top: 50px; }" );
            $html   .= "\t</head>\n";
            $html   .= "\t<body>\n";
            $html   .= "\t\t<div class=\"container login\">\n";
            $html   .= "\t\t\t<div class=\"row justify-content-center\">\n";
            $html   .= "\t\t\t\t<div class=\"col-md-6 col-lg-6 col-xl-6\">\n";
            if ( $this->errors ) { $html .= $alert->renderBootstrap ( ); }
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

        public function onPost ( )
        {
            $this->errors = ! fieldsValidator::validate ( $this->arrComponents );

            if ( $this->Errors )
            {
                $this->onGet ( );
            }
        }
    }