<?php namespace main\userControl;

    use main\models\User;
    use main\gui\fields\textField;
    use main\layouts\bootstrap\main;
    use main\controllers\Controller;
    use main\gui\fields\selectField;
    use main\gui\buttons\formButton;
    use main\gui\renderer\bootstrapForm;
    use main\frameworkHelper\cacheManager;
    use main\frameworkHelper\fieldsValidator;

    class userQuestions extends Controller
    {
        use userNavigation;

        protected $arrComponents;

        /**
         * userQuestions constructor.
         * @throws \Exception
         */
        public function __construct ( )
        {
            session_auth ( );

            $Tabs   = "\t\t\t\t\t\t\t\t";

            $components ["question1"]   = new selectField ( "Security Question", "question1", "question1", 1 );
            $components ["question1"]->setRequired ( true );
            $components ["question1"]->setTabs ( $Tabs );

            $components ["answer1"]     = new textField ( "Answer", "answer1", "answer1" );
            $components ["answer1"]->setRequired ( true );
            $components ["answer1"]->setTabs ( $Tabs );

            $components ["question2"]   = new selectField ( "Security Question", "question2", "question2", 2 );
            $components ["question2"]->setRequired ( true );
            $components ["question2"]->setTabs ( $Tabs );

            $components ["answer2"]     = new textField ( "Answer", "answer2", "answer2" );
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
            $html      .= self::renderProfilePicModal ( );
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

        protected function onGet ( )
        {
            $layoutTemplate = new main ( trim ( basename(__DIR__) ), trim ( basename (__DIR__) ), true );

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
            $html   .= $layoutTemplate->render_footer ( array ( ), self::renderProfilePicJS( $GLOBALS ["RELATIVE_TO_ROOT"] . '/User/Questions/' ) );
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
                $errors = ! $this->updateQuestions ( );
                if ( ! $errors )
                {
                    setFlashMessage( '', 'Your information has been successfully updated.', 3 );
                }
            }
            $this->onGet();
        }

        /**
         * @return bool
         */
        protected function updateQuestions ( )
        {
            $question1  = $this->arrComponents[0][0]->getValue ( );
            $question2  = $this->arrComponents[2][0]->getValue ( );

            $answer1    = $this->arrComponents[1][0]->getValue ( );
            $answer2    = $this->arrComponents[3][0]->getValue ( );

            // update information
            $user   = new User( ["ID", $_SESSION ["USER_ID"] ] );

            return $user->setQuestionsAnswers($question1, $question2, $answer1, $answer2);
        }
    }