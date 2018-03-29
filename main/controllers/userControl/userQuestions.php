<?php namespace main\userControl;

    use main\models\User;
    use main\gui\fields\textField;
    use main\layouts\bootstrap\main;
    use main\controllers\Controller;
    use main\gui\fields\selectField;
    use main\gui\buttons\formButton;
    use main\gui\renderer\bootstrapForm;
    use main\frameworkHelper\cacheManager;

    class userQuestions extends Controller
    {
        use userNavigation;

        protected $arrComponents;

        public function __construct ( )
        {
            $Tabs   = "\t\t\t\t\t\t\t\t";

            $components ["question1"]   = new selectField ( "Security Question", "question1", "question1", 1 );
            $components ["question1"]->setFieldsize ( 1 );
            $components ["question1"]->setRequired ( true );
            $components ["question1"]->setTabs ( $Tabs );

            $components ["answer1"]     = new textField ( "Answer", "answer1", "answer1" );
            $components ["answer1"]->setFieldsize ( 1 );
            $components ["answer1"]->setRequired ( true );
            $components ["answer1"]->setTabs ( $Tabs );

            $components ["question2"]   = new selectField ( "Security Question", "question2", "question2", 2 );
            $components ["question2"]->setFieldsize ( 1 );
            $components ["question2"]->setRequired ( true );
            $components ["question2"]->setTabs ( $Tabs );

            $components ["answer2"]     = new textField ( "Answer", "answer2", "answer2" );
            $components ["answer2"]->setFieldsize ( 1 );
            $components ["answer2"]->setRequired ( true );
            $components ["answer2"]->setTabs ( $Tabs );

            $components ["BTN_update"]= new formButton ( "UPDATE", "update", 1 );
            $components ["BTN_update"]->setClass ( "right" );
            $components ["BTN_update"]->setOutLine( true );
            $components ["BTN_update"]->setTabs ( $Tabs );

            $this->arrComponents =
                [
                    0 =>
                    [
                        0 => $components ["question1"]
                    ],
                    1 =>
                    [
                        0 => $components ["answer1"]
                    ],
                    2 =>
                    [
                        0 => $components ["question2"]
                    ],
                    3 =>
                    [
                        0 => $components ["answer2"]
                    ],
                    4 =>
                    [
                        0 => $components ["BTN_update"]
                    ]
                ];
        }

        /**
         * @return string
         */
        private function preRenderPage ( )
        {
            $formId     = "form-parsley";
            $formMethod = "post";
            $formAction = $GLOBALS ["RELATIVE_TO_ROOT"] . "/User/Questions";
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
            $file   = $folder . "/userQuestions.html";
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
            $this->arrComponents[0][0]->setValue( $user->getQuestion1() );
            $this->arrComponents[1][0]->setValue( $user->getAnswer1() );
            $this->arrComponents[2][0]->setValue( $user->getQuestion2() );
            $this->arrComponents[3][0]->setValue( $user->getAnswer2() );

            $html   = "<!DOCTYPE html>\n";
            $html   .= "<html lang=\"en\">\n";
            $html   .= "\t<head>\n";
            $html   .= $layoutTemplate->render_header ( [ "TITLE" => "Personal Questions" ], ".box { margin-top: 15px; }" );
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
            $html   .= "\t\t\t\t\t<h4><i class=\"fas fa-chevron-circle-right\"></i> Update Your Personal Questions</h4><hr/>\n";
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