<?php namespace main\userControl;

    use main\models\User;
    use main\gui\guiCreator;
    use main\layouts\bootstrap\main;
    use main\controllers\Controller;
    use main\gui\renderer\bootstrapForm;
    use main\frameworkHelper\cacheManager;

    class userAccount extends Controller
    {
        use userNavigation;

        protected $arrComponents;

        public function __construct ( )
        {
            $Tabs   = "\t\t\t\t\t\t\t\t";
            $components =
                [
                    0 =>
                    [
                        0 =>
                        [
                            "parent"        => "fields",
                            "class"         => "emailField",
                            "label"         => "Email Address",
                            "name"          => "email",
                            "id"            => "email",
                            "setIcon"       => "",
                            "setFieldSize"  => 1,
                            "setRequired"   => true,
                            "setTabs"       => $Tabs
                        ]
                    ],
                    1 =>
                    [
                        0 =>
                        [
                            "parent"        => "fields",
                            "class"         => "passwordField",
                            "label"         => "Password",
                            "name"          => "password",
                            "id"            => "password",
                            "setIcon"       => "",
                            "setFieldSize"  => 1,
                            "setTabs"       => $Tabs
                        ]
                    ],
                    2 =>
                    [
                        0 =>
                        [
                            "parent"        => "fields",
                            "class"         => "passwordField",
                            "label"         => "Password Confirmation",
                            "name"          => "confPassword",
                            "id"            => "confPassword",
                            "setIcon"       => "",
                            "setFieldSize"  => 1,
                            "setEqualTo"    => "password",
                            "setTabs"       => $Tabs
                        ]
                    ],
                    3 =>
                    [
                        0 =>
                        [
                            "parent"        => "buttons",
                            "class"         => "formButton",
                            "label"         => "UPDATE PROFILE",
                            "id"            => "update",
                            "type"          => 1,
                            "setClass"      => "right",
                            "setOutLine"    => true,
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
            $formAction = $GLOBALS ["RELATIVE_TO_ROOT"] . "/User/Account";
            $formTabs   = "\t\t\t\t\t\t";
            $html       = bootstrapForm::renderInline( $this->arrComponents, $formTabs, $formId, $formMethod, $formAction );
            return $html;
        }

        /**
         * @return mixed|string
         */
        private function renderPage ( )
        {
            $folder = $GLOBALS ["CACHE_FOLDER"] . "/" .basename ( __DIR__ );
            $file   = $folder . "/userAccount.html";
            $errors = false;

            $cacheManager = new cacheManager( $folder, $file );
            if ( ! $cacheManager->isCacheExists ( ) ) { $errors = ! $cacheManager->write ( $this->preRenderPage ( ) ); }
            if ( ! $errors ) { return $cacheManager->read_values ( $this->arrComponents ); }
            return "";
        }

        /**
         * @throws \Exception
         */
        protected function onGet ( )
        {
            session_auth ( );
            $layoutTemplate = new main ( trim ( basename(__DIR__) ), trim ( basename (__DIR__) ) );
            $user   = new User ( [ "ID", $_SESSION ["USER_ID"] ] );
            $this->arrComponents[0][0]->setValue ( $user->getEmail() );

            $html   = "<!DOCTYPE html>\n";
            $html   .= "<html lang=\"en\">\n";
            $html   .= "\t<head>\n";
            $html   .= $layoutTemplate->render_header ( [ "TITLE" => "User Account" ], ".box { margin-top: 15px; }" );
            $html   .= "\t</head>\n";
            $html   .= "\t<body>\n";
            $html   .= $layoutTemplate->render_navbar ( );
            $html   .= "\t\t<div class=\"container box\">\n";
            $html   .= "\t\t\t<div class=\"row\">\n";
            $html   .= "\t\t\t\t<div class=\"col-md-3 col-lg-3 col-xl-3\">\n";
            $html   .= $this->renderNavigationLinks ( $user->getProfilePicture() );
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t<div class=\"col-md-9 col-lg-9 col-xl-9\">\n";
            $html   .= flash_message ( "\t\t\t\t\t" );
            $html   .= "\t\t\t\t\t<div class=\"card\">\n";
            $html   .= "\t\t\t\t\t<h4><i class=\"fas fa-chevron-circle-right\"></i> Update Your Account</h4><hr/>\n";
            $html   .= $this->renderPage();
            $html   .= $this->renderProfilePicModal ( );
            $html   .= "\t\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t</div>\n";
            $html   .= "\t\t</div>\n";
            $html   .= $layoutTemplate->render_footer ( array ( ) );
            $html   .= "\t</body>\n";
            $html   .= "</html>\n";

            echo $html;
        }

        protected function onPost()
        {
            // TODO: Implement onPost() method.
        }
    }