<?php namespace main\userControl;

    use main\models\User;
    use main\gui\guiCreator;
    use main\layouts\bootstrap\main;
    use main\controllers\Controller;
    use main\gui\renderer\bootstrapForm;
    use main\frameworkHelper\cacheManager;
    use main\frameworkHelper\fieldsValidator;

    class userPassword extends Controller
    {
        use userNavigation;

        protected $arrComponents;

        /**
         * userPassword constructor.
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
                                    "class"         => "passwordField",
                                    "label"         => "Current Password",
                                    "name"          => "currentPassword",
                                    "id"            => "currentPassword",
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
                                    "label"         => "New Password",
                                    "name"          => "password",
                                    "id"            => "password",
                                    "setRequired"   => true,
                                    "setTabs"       => $Tabs
                                ]
                        ],
                    2 =>
                        [
                            0 =>
                                [
                                    "parent"        => "fields",
                                    "class"         => "passwordField",
                                    "label"         => "Confirm Password",
                                    "name"          => "confPassword",
                                    "id"            => "confPassword",
                                    "setRequired"   => true,
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
            $formAction = $GLOBALS ["RELATIVE_TO_ROOT"] . "/User/Password";
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
            $file   = $folder . "/userPassword.html";
            $errors = false;

            $cacheManager = new cacheManager( $folder, $file );
            if ( ! $cacheManager->isCacheExists ( ) ) { $errors = ! $cacheManager->write ( $this->preRenderPage ( ) ); }
            if ( ! $errors ) { return $cacheManager->read_values ( $this->arrComponents ); }
            return "";
        }

        protected function onGet ( )
        {
            $layoutTemplate = new main ( trim ( basename(__DIR__) ), trim ( basename (__DIR__) ), true );
            $JavaScript     = array ( "LIBRARIES" => [ "AFTER" => [ $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/js/userControl/userProfile.js" ] ] );

            $user   = new User ( [ "ID", $_SESSION ["USER_ID"] ] );

            $html   = "<!DOCTYPE html>\n";
            $html   .= "<html lang=\"en\">\n";
            $html   .= "\t<head>\n";
            $html   .= $layoutTemplate->render_header ( [ "TITLE" => "User Password" ], ".page { margin-top: 15px; }" );
            $html   .= "\t</head>\n";
            $html   .= "\t<body>\n";
            $html   .= $layoutTemplate->render_navbar ( );
            $html   .= "\t\t<div class=\"container page\">\n";
            $html   .= "\t\t\t<div class=\"row\">\n";
            $html   .= "\t\t\t\t<div class=\"col-md-3 col-lg-3 col-xl-3\">\n";
            $html   .= $this->renderNavigationLinks ( $user->getProfilePicture() );
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t<div class=\"col-md-9 col-lg-9 col-xl-9\">\n";
            $html   .= flash_message ( "\t\t\t\t\t" );
            $html   .= "\t\t\t\t\t<div class=\"box\">\n";
            $html   .= "\t\t\t\t\t<h4><i class=\"fas fa-chevron-circle-right\"></i> Update Your Password</h4><hr/>\n";
            $html   .= $this->renderPage();
            $html   .= "\t\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t</div>\n";
            $html   .= "\t\t</div>\n";
            $html   .= $layoutTemplate->render_footer ( $JavaScript );
            $html   .= "\t</body>\n";
            $html   .= "</html>\n";

            echo $html;
        }

        protected function onPost( )
        {
            $errors = ! fieldsValidator::validate ( $this->arrComponents );

            if ( $errors )
            {
                setFlashMessage( '', 'Something went wrong, please make a correction and try again', 4 );
            }
            else
            {
                $errors = ! $this->updatePassword ( );
                if ( ! $errors )
                {
                    setFlashMessage( '', 'Your password has been successfully updated.', 3 );
                }
            }

            // clear the password fields
            $this->arrComponents[0][0]->setValue ( '' );
            $this->arrComponents[1][0]->setValue ( '' );
            $this->arrComponents[2][0]->setValue ( '' );

            $this->onGet();
        }

        /**
         * @return bool
         */
        protected function updatePassword ( )
        {
            $currentPassword= $this->arrComponents[0][0]->getValue ( );
            $password       = $this->arrComponents[1][0]->getValue ( );
            $confPassword   = $this->arrComponents[2][0]->getValue ( );

            $user   = new User( ["ID", $_SESSION ["USER_ID"] ] );

            // check if current password equal to the password in database
            if( ! $user->isAuth ( $currentPassword ) )
            {
                $Attempt = $user->incrementFailed();
                // check for failed attempts
                if ( $Attempt >= $GLOBALS ["MAX_FAILED"] )
                {
                    // disable user account
                    $user->setActive( false );
                    redirect( '/Logout' );
                }
                setFlashMessage( 'Incorrect Password!', 'Current Password is incorrect, attempt ' . $Attempt . ' out of ' . $GLOBALS ["MAX_FAILED"], 4 );
                return false;
            }

            // check if password and confirm password are equal
            if ( $password != $confPassword )
            {
                setFlashMessage( 'Error!', 'Your password and password confirmation must be the same', 4 );
                return false;
            }

            // update password

            return $user->setPassword( $password );
        }
    }