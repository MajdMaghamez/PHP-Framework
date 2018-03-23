<?php namespace main\controllers\authControl;

    use main\gui\guiCreator;
    use main\layouts\bootstrap\main;
    use main\controllers\Controller;
    use main\gui\renderer\bootstrapForm;
    use main\frameworkHelper\cacheManager;
    use main\frameworkHelper\fieldsValidator;

    class ResetController extends controller
    {
        protected $errors;
        protected $arrComponents;

        public function __construct ( )
        {
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
                            "setShowStar"   => true,
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
            $formAction = $GLOBALS ["RELATIVE_TO_ROOT"] . "/Reset";
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
            $file   = $folder . "/reset.html";

            $cacheManager   = new cacheManager ( $folder, $file );
            if ( ! $cacheManager->isCacheExists ( ) ) { $this->errors = ! $cacheManager->write ( $this->preRenderPage ( ) ); }
            if ( ! $this->errors ) { return $cacheManager->read ( $this->arrComponents ); }
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
            $html   .= "<html lang=\en\">\n";
            $html   .= "\t<head>\n";
            $html   .= $layoutTemplate->render_header ( [ "TITLE" => "Reset Password" ], ".reset { margin-top: 50px; }" );
            $html   .= "\t</head>\n";
            $html   .= "\t<body>\n";
            $html   .= "\t\t<div class=\"container reset\">\n";
            $html   .= "\t\t\t<div class=\"row justify-content-center\">\n";
            $html   .= "\t\t\t\t<div class=\"col-md-6 col-lg-6 col-xl-6\">\n";
            $html   .= "\t\t\t\t\t<div class=\"card\">\n";
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
                    setFlashMessage ( "Success", "Check your email for the reset link", 3 );
                }
            }
        }


        protected function resetUser ( )
        {

        }
    }