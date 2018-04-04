<?php namespace main\userControl;

    use main\models\User;
    use main\gui\guiCreator;
    use main\layouts\bootstrap\main;
    use main\controllers\Controller;
    use main\gui\renderer\bootstrapForm;
    use main\frameworkHelper\cacheManager;
    use main\frameworkHelper\fieldsValidator;

    class userAccount extends Controller
    {
        use userNavigation;

        protected $arrComponents;

        /**
         * userAccount constructor.
         * @throws \Exception
         */
        public function __construct ( )
        {
            session_auth ( );

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
                            "setRequired"   => true,
                            "setTabs"       => $Tabs
                        ]
                    ],
                    1 =>
                    [
                        0 =>
                        [
                            "parent"        => "buttons",
                            "class"         => "formButton",
                            "label"         => "UPDATE",
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
            $html      .= self::renderProfilePicModal ( );
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

        protected function onGet ( )
        {
            $layoutTemplate = new main ( trim ( basename(__DIR__) ), trim ( basename (__DIR__) ), true );
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
            $html   .= self::renderNavigationLinks ( $user->getProfilePicture() );
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t<div class=\"col-md-9 col-lg-9 col-xl-9\">\n";
            $html   .= flash_message ( "\t\t\t\t\t" );
            $html   .= "\t\t\t\t\t<div class=\"card\">\n";
            $html   .= "\t\t\t\t\t<h4><i class=\"fas fa-chevron-circle-right\"></i> Update Your Account Email</h4><hr/>\n";
            $html   .= $this->renderPage();
            $html   .= "\t\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t</div>\n";
            $html   .= "\t\t</div>\n";
            $html   .= $layoutTemplate->render_footer ( array ( ), self::renderProfilePicJS( ) );
            $html   .= "\t</body>\n";
            $html   .= "</html>\n";

            echo $html;
        }

        protected function onPost()
        {
            $errors = ! fieldsValidator::validate ( $this->arrComponents );
            if ( $errors )
            {
                setFlashMessage( '', 'Something went wrong, please make a correction and try again', 4 );
            }
            else
            {
                $errors = ! $this->updateEmail ( );
                if ( ! $errors )
                {
                    setFlashMessage( '', 'Your email has been successfully updated.', 3 );
                }
            }
            $this->onGet();
        }

        /**
         * @return bool
         */
        protected function updateEmail ( )
        {
            $email  = $this->arrComponents[0][0]->getValue ( );

            // check if the user email is the same as the enter email
            if ( $email == $_SESSION ["USER_EMAIL"] )
            {
                return true;
            }

            // check if the email does not exists
            $user   = new User( ["EMAIL", $email ] );
            if ( ! is_null ( $user->getUser ( ) ) )
            {
                setFlashMessage("Failed!", "This email address is associated with another user", 4 );
                return false;
            }

            $user   = new User( ["ID", $_SESSION ["USER_ID"] ] );
            // update user email
            return $user->setEmail ( $email );
        }
    }