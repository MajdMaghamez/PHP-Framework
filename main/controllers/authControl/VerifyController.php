<?php namespace main\controllers\authControl;

    use main\models\User;
    use main\gui\guiCreator;
    use main\controllers\Controller;
    use main\layouts\bootstrap\main;
    use main\gui\renderer\bootstrapForm;
    use main\frameworkHelper\cacheManager;
    use main\frameworkHelper\fieldsValidator;

    class VerifyController extends Controller
    {
        protected $arrComponents;

        /**
         * VerifyController constructor.
         */
        public function __construct ( )
        {
            $Tabs       = "\t\t\t\t\t\t\t\t\t";
            $components =
            [
                0 =>
                [
                    0 =>
                    [
                        "parent"        => "fields",
                        "class"         => "passwordField",
                        "label"         => "New Password",
                        "name"          => "password",
                        "id"            => "password",
                        "setRequired"   => true,
                        "setIcon"       => "<i class=\"fas fa-key\"></i>",
                        "setTabs"       => $Tabs
                    ]
                ],
                1 =>
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
                        "setIcon"       => "<i class=\"fas fa-key\"></i>",
                        "setTabs"       => $Tabs
                    ]
                ],
                2 =>
                [
                    0 =>
                    [
                        "parent"        => "links",
                        "class"         => "link",
                        "href"          => $GLOBALS ["RELATIVE_TO_ROOT"] . "/Login",
                        "label"         => "Back To Login",
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

            $arrComponent = new guiCreator ( $components );
            $this->arrComponents = $arrComponent->getContainer ( );
        }

        /**
         * @return string
         */
        private function preRenderPage ( )
        {
            $formId     = "form-parsley";
            $formMethod = "post";
            $formAction = $GLOBALS ["RELATIVE_TO_ROOT"] . "/Verify/token/{TokenValue}";
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
            $file   = $folder . "/verify.html";
            $errors = false;

            // insert token into the form url
            $TOKEN  = findInURL( 'token' );
            $TOKEN > 0 ? $TOKEN++ : $TOKEN = 0;
            $URL    = getURLParams();
            $TOKEN_VAL = sanitize_string( $URL[$TOKEN], '/^[a-z0-9]+$/' );

            $cacheManager   = new cacheManager ( $folder, $file );
            if ( ! $cacheManager->isCacheExists ( ) ) { $errors = ! $cacheManager->write ( $this->preRenderPage ( ) ); }
            if ( ! $errors ) { return $cacheManager->read ( $this->arrComponents, [ '{TokenValue}' ], [ $TOKEN_VAL ] ); }
            return "";
        }

        /**
         * @throws \Exception
         */
        protected function onGet()
        {
            session_auth ( true );
            $layoutTemplate = new main ( );

            $html   = "<!DOCTYPE html>\n";
            $html   .= "<html lang=\"en\">\n";
            $html   .= "\t<head>\n";
            $html   .= $layoutTemplate->render_header ( [ "TITLE" => "Change Password" ], ".reset { margin-top: 50px; }" );
            $html   .= "\t</head>\n";
            $html   .= "\t<body>\n";
            $html   .= "\t\t<div class=\"container reset\">\n";
            $html   .= "\t\t\t<div class=\"row justify-content-center\">\n";
            $html   .= "\t\t\t\t<div class=\"col-md-6 col-lg-6 col-xl-6\">\n";
            $html   .= flash_message( "\t\t\t\t\t" );
            $html   .= "\t\t\t\t\t<div class=\"card\">\n";
            $html   .= "\t\t\t\t\t\t<h4 class=\"center\">Choose a new Password</h4><hr/>\n";
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

        /**
         * @throws \Exception
         */
        protected function onPost()
        {
            $errors = ! fieldsValidator::validate ( $this->arrComponents );

            if ( $errors )
            {
                setFlashMessage ( "", "Something went wrong, please make a correction and try again", 4 );
            }
            else
            {
                $errors = ! $this->updatePassword ( );
                if ( ! $errors )
                {
                    setFlashMessage ( "Completed!", "Your password has been changed.", 3 );
                }
            }
            $this->onGet();
        }

        /**
         * @return bool
         */
        protected function updatePassword ( )
        {
            $TOKEN  = findInURL( 'token' );
            $TOKEN > 0 ? $TOKEN++ : $TOKEN = 0;
            $URL    = getURLParams();
            $TOKEN_VAL = sanitize_string( $URL[$TOKEN], '/^[a-z0-9]+$/' );

            // validate the token
            if ( empty ( $TOKEN_VAL ) )
            {
                setFlashMessage ( "Invalid Token!", "You do not have a valid token to locate your account.", 4 );
                return false;
            }

            $data ['token'] = $TOKEN_VAL;
            $user = new user ( [ 'PASSWORD_TOKEN', $data ['token'] ] );

            // check if the user exists
            if ( is_null ( $user->getUser ( ) ) )
            {
                setFlashMessage( "Request Not Found!", "System was unable to locate your request, if you have already used this link before to update your password, please request another.", 5 );
                return false;
            }

            // check if the token has expired
            if ( $user->isTokenExpired ( ) )
            {
                setFlashMessage( 'Expired Request!', "Your request has exceeded the max allowed time of " . $GLOBALS ["TOKEN_EXPIRY"] . " minutes. <br/>Try resetting your password again.", 4 );
                return false;
            }

            // update user password
            $data ["password"] = $this->arrComponents [0][0]->getValue();
            if ( ! $user->setPassword( $data ["password"] ) )
            {
                setFlashMessage( "Error!", "We were unable to process your request, please try again.", 4 );
                return false;
            }

            return true;
        }
    }