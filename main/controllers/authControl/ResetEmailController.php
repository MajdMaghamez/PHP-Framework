<?php namespace main\controllers\authControl;

    use main\models\User;
    use main\gui\guiCreator;
    use main\layouts\bootstrap\main;
    use main\controllers\Controller;
    use main\gui\renderer\bootstrapForm;
    use main\frameworkHelper\cacheManager;
    use main\frameworkHelper\fieldsValidator;

    class ResetEmailController extends Controller
    {
        protected $arrComponents;

        /**
         * ResetEmailController constructor.
         * @throws \Exception
         */
        public function __construct ( )
        {
            session_auth ( true );

            $Tabs   = "\t\t\t\t\t\t\t\t\t";
            $components =
                [
                    0   =>
                        [
                            0 =>
                                [
                                    "parent"        => "fields",
                                    "class"         => "emailField",
                                    "label"         => "Email Address",
                                    "name"          => "email",
                                    "id"            => "email",
                                    "setRequired"   => true,
                                    "setIcon"       => "<i class=\"fas fa-envelope\"></i>",
                                    "setTabs"       => $Tabs
                                ]
                        ],
                    1   =>
                        [
                            0 =>
                                [
                                    "parent"        => "links",
                                    "class"         => "link",
                                    "href"          => $GLOBALS ["RELATIVE_TO_ROOT"] . "/Login",
                                    "label"         => "Login",
                                    "setFormItem"   => true,
                                    "setOutLine"    => true,
                                    "setLikeBtn"    => true,
                                    "setTabs"       => $Tabs
                                ],
                            1 =>
                                [
                                    "parent"        => "buttons",
                                    "class"         => "formButton",
                                    "label"         => "Submit",
                                    "id"            => "reset",
                                    "type"          => 1,
                                    "setClass"      => "right",
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
            $formAction = $GLOBALS ["RELATIVE_TO_ROOT"] . "/Reset/Email";
            $formTabs   = "\t\t\t\t\t\t";
            $html       = bootstrapForm::renderStatic ( $this->arrComponents, $formTabs, $formId, $formMethod, $formAction );
            return $html;
        }

        /**
         * @return string
         */
        private function renderPage ( )
        {
            $folder = $GLOBALS ["CACHE_FOLDER"] . "/" .basename ( __DIR__ );
            $file   = $folder . "/resetEmail.html";
            $errors = false;

            $cacheManager   = new cacheManager ( $folder, $file );
            if ( ! $cacheManager->isCacheExists ( ) ) { $errors = ! $cacheManager->write ( $this->preRenderPage ( ) ); }
            if ( ! $errors ) { return $cacheManager->read ( $this->arrComponents ); }
            return "";
        }

        protected function onGet()
        {
            $layoutTemplate = new main ( );

            $html   = "<!DOCTYPE html>\n";
            $html   .= "<html lang=\"en\">\n";
            $html   .= "\t<head>\n";
            $html   .= $layoutTemplate->render_header ( [ "TITLE" => "Reset Password" ], ".reset { margin-top: 50px; }" );
            $html   .= "\t</head>\n";
            $html   .= "\t<body>\n";
            $html   .= "\t\t<div class=\"container reset\">\n";
            $html   .= "\t\t\t<div class=\"row justify-content-center\">\n";
            $html   .= "\t\t\t\t<div class=\"col-md-6 col-lg-6 col-xl-6\">\n";
            $html   .= flash_message( "\t\t\t\t\t" );
            $html   .= "\t\t\t\t\t<div class=\"box\">\n";
            $html   .= "\t\t\t\t\t\t<h4 class=\"center\">Password Reset</h4><hr/>\n";
            $html   .= $this->renderPage ( );
            $html   .= "\t\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t</div>\n";
            $html   .= "\t\t</div>\n";
            $html   .= $layoutTemplate->render_footer ( array ( ) );
            $html   .= "\t</body>\n";
            $html   .= "\t</html>\n";

            echo $html;
        }

        protected function onPost()
        {
            $errors = ! fieldsValidator::validate ( $this->arrComponents );

            if ( $errors )
            {
                setFlashMessage ( "", "Something went wrong, please make a correction and try again", 4 );
            }
            else
            {
                $errors = ! $this->resetUser ( );
                if ( ! $errors )
                {
                    setFlashMessage ( "Done!", "A reset link has been sent to this email.", 3 );
                }
            }
            $this->onGet();
        }

        /**
         * @return bool
         */
        protected function resetUser ( )
        {
            $data ["email"] = $this->arrComponents [0][0]->getValue ( );

            $user = new User( ["EMAIL", $data ["email"] ] );

            // check if the user exists
            if ( is_null ( $user->getUser ( ) ) )
            {
                setFlashMessage( "User Not Found!", "This email address isn&#39;t associated with any account.", 5 );
                return false;
            }

            // check if user is deleted.
            if ( $user->isDeleted() )
            {
                setFlashMessage( "Deleted User!", "Failed to Reset!", 4 );
                return false;
            }

            // generate reset token
            if ( ! $user->setPasswordToken ( randomToken ( ) ) )
            {
                setFlashMessage( "Error!", "An error has occurred please try again later.", 4 );
                return false;
            }

            // email the reset token
            if ( ! $user->sendResetEmail ( ) )
            {
                setFlashMessage( "Error!", "An error has occurred please try again later.", 4 );
                return false;
            }

            return true;
        }

    }