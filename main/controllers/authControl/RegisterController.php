<?php namespace main\controllers\authControl;

    use main\models\User;
    use main\emails\email;
    use main\gui\links\link;
    use main\gui\fields\textField;
    use main\gui\fields\emailField;
    use main\controllers\Controller;
    use main\layouts\bootstrap\main;
    use main\gui\buttons\formButton;
    use main\gui\fields\selectField;
    use main\gui\fields\passwordField;
    use main\gui\renderer\bootstrapForm;
    use main\frameworkHelper\cacheManager;
    use main\frameworkHelper\fieldsValidator;

    class RegisterController extends Controller
    {
        protected $arrComponents;

        /**
         * RegisterController constructor.
         */
        public function __construct()
        {
            $Tabs = "\t\t\t\t\t\t\t\t\t";

            $components ["firstname"]   = new textField ( "First Name", "firstname", "firstname" );
            $components ["firstname"]->setFieldsize ( 1 );
            $components ["firstname"]->setRequired ( true );
            $components ["firstname"]->setTabs ( $Tabs );

            $components ["lastname"]    = new textField ( "Last Name", "lastname", "lastname" );
            $components ["lastname"]->setFieldsize ( 1 );
            $components ["lastname"]->setRequired ( true );
            $components ["lastname"]->setTabs ( $Tabs );

            $components ["email"]       = new emailField ( "Email Address", "email", "email" );
            $components ["email"]->setFieldsize ( 1 );
            $components ["email"]->setRequired ( true );
            $components ["email"]->setTabs ( $Tabs );

            $components ["password"]    = new passwordField ( "Password", "password", "password" );
            $components ["password"]->setFieldsize ( 1 );
            $components ["password"]->setRequired ( true );
            $components ["password"]->setTabs ( $Tabs );

            $components ["confPassword"]= new passwordField ( "Confirm Password", "confPassword", "confPassword" );
            $components ["confPassword"]->setFieldsize ( 1 );
            $components ["confPassword"]->setRequired ( true );
            $components ["confPassword"]->setTabs ( $Tabs );

            $components ["question1"]   = new selectField ( "Security Question", "question1", "question1" );
            $components ["question1"]->setOptions ( 1, "What was the name of your elementary school?" );
            $components ["question1"]->setOptions ( 2, "In What city were you born?" );
            $components ["question1"]->setOptions ( 3, "What is your pet name?" );
            $components ["question1"]->setOptions ( 4, "In What month did you get married?" );
            $components ["question1"]->setOptions ( 5, "What is the name of your favorite teacher?" );
            $components ["question1"]->setFieldsize ( 1 );
            $components ["question1"]->setRequired ( true );
            $components ["question1"]->setTabs ( $Tabs );

            $components ["answer1"]     = new textField ( "Answer", "answer1", "answer1" );
            $components ["answer1"]->setFieldsize ( 1 );
            $components ["answer1"]->setRequired ( true );
            $components ["answer1"]->setTabs ( $Tabs );

            $components ["question2"]   = new selectField ( "Security Question", "question2", "question2" );
            $components ["question2"]->setOptions ( 1, "What is your favorite ice cream flavor?" );
            $components ["question2"]->setOptions ( 2, "In What city was your high school?" );
            $components ["question2"]->setOptions ( 3, "What is your mother middle name?" );
            $components ["question2"]->setOptions ( 4, "Who is your favorite cousin?" );
            $components ["question2"]->setOptions ( 5, "What is your favorite fruit?" );
            $components ["question2"]->setFieldsize ( 1 );
            $components ["question2"]->setRequired ( true );
            $components ["question2"]->setTabs ( $Tabs );

            $components ["answer2"]     = new textField ( "Answer", "answer2", "answer2" );
            $components ["answer2"]->setFieldsize ( 1 );
            $components ["answer2"]->setRequired ( true );
            $components ["answer2"]->setTabs ( $Tabs );

            $components ["LNK_login"]   = new link ( $GLOBALS ["RELATIVE_TO_ROOT"] . "/Login", "Login" );
            $components ["LNK_login"]->setOutLine ( true );
            $components ["LNK_login"]->setformItem ( true );
            $components ["LNK_login"]->setLikeBtn ( true );
            $components ["LNK_login"]->setTabs ( $Tabs );

            $components ["BTN_register"]= new formButton ( "Register", "register", 1 );
            $components ["BTN_register"]->setClass ( "right" );
            $components ["BTN_register"]->setTabs ( $Tabs );

            $this->arrComponents =
            [
                0 =>
                [
                    0 => $components ["firstname"],
                    1 => $components ["lastname"]
                ],
                1 =>
                [
                    0 => $components ["email"]
                ],
                2 =>
                [
                    0 => $components ["password"],
                    1 => $components ["confPassword"]
                ],
                3 =>
                [
                    0 => $components ["question1"]
                ],
                4 =>
                [
                    0 => $components ["answer1"]
                ],
                5 =>
                [
                    0 => $components ["question2"]
                ],
                6 =>
                [
                    0 => $components ["answer2"]
                ],
                7 =>
                [
                    0 => $components ["LNK_login"],
                    1 => $components ["BTN_register"]
                ]
            ];
        }

        /**
         * @return string
         */
        private function preRenderPage()
        {
            $formId = "form-parsley";
            $formMethod = "post";
            $formAction = $GLOBALS ["RELATIVE_TO_ROOT"] . "/Register";
            $formTabs = "\t\t\t\t\t\t";
            $html = bootstrapForm::renderStatic($this->arrComponents, $formTabs, $formId, $formMethod, $formAction);
            return $html;
        }

        /**
         * @return string
         */
        private function renderPage()
        {
            $folder = $GLOBALS ["CACHE_FOLDER"] . "/" . basename(__DIR__);
            $file = $folder . "/register.html";
            $errors = false;

            $cacheManager = new cacheManager ($folder, $file);
            if (!$cacheManager->isCacheExists()) { $errors = !$cacheManager->write($this->preRenderPage ( ) ); }
            if (! $errors ) { return $cacheManager->read ( $this->arrComponents ); }
            return "";
        }

        protected function onGet()
        {
            $layoutTemplate = new main();

            $html = "<!DOCTYPE html>\n";
            $html .= "<html lang=\"en\">\n";
            $html .= "\t<head>\n";
            $html .= $layoutTemplate->render_header(["TITLE" => "Registration Page"], ".register { margin-top: 25px; }");
            $html .= "\t</head>\n";
            $html .= "\t<body>\n";
            $html .= "\t\t<div class=\"container register\">\n";
            $html .= "\t\t\t<div class=\"row justify-content-center\">\n";
            $html .= "\t\t\t\t<div class=\"col-sm-12 col-md-6 col-lg-6 col-xl-6\">\n";
            $html .= flash_message ( "\t\t\t\t\t" );
            $html .= "\t\t\t\t\t<div class=\"card\">\n";
            $html .= "\t\t\t\t\t<h5 class=\"center\">Registration</h5><hr/>\n";
            $html .= $this->renderPage();
            $html .= "\t\t\t\t\t</div>\n";
            $html .= "\t\t\t\t</div>\n";
            $html .= "\t\t\t</div>\n";
            $html .= "\t\t</div>\n";
            $html .= $layoutTemplate->render_footer(array());
            $html .= "\t</body>\n";
            $html .= "</html>\n";

            echo $html;
        }

        protected function onPost()
        {
            $errors = ! fieldsValidator::validate ( $this->arrComponents );

            if ( $errors )
            {
                $_REQUEST ["ALERT_MSG"] = "Something went wrong, please make a correction and try again";
                $_REQUEST ["ALERT_TYPE"]= 4;
            }
            else
            {
                $errors = ! $this->registerUser ( );
                if ( $errors )
                {
                    $_REQUEST ["ALERT_HEAD"] = "Oops!";
                    $_REQUEST ["ALERT_MSG"] = "We weren't able to create your account, try again later.";
                    $_REQUEST ["ALERT_TYPE"]= 4;
                }
                $_REQUEST ["ALERT_HEAD"] = "Success!";
                $_REQUEST ["ALERT_MSG"] = "A verification email has been sent! Please verify your email before logging in.";
                $_REQUEST ["ALERT_TYPE"]= 3;
            }
            $this->onGet();
        }

        protected function registerUser( )
        {
            $data ['firstname']     = ucwords ( $this->arrComponents [0][0]->getValue ( ) );
            $data ['lastname']      = ucwords ( $this->arrComponents [0][1]->getValue ( ) );
            $data ['email']         = $this->arrComponents [1][0]->getValue ( );
            $data ['password']      = password ( $this->arrComponents [2][0]->getValue ( ) );

            $data ['question1']     = $this->arrComponents [3][0]->getValue ( );
            $data ['question2']     = $this->arrComponents [5][0]->getValue ( );
            $data ['answer1']       = encrypt ( $this->arrComponents [4][0]->getValue ( ) );
            $data ['answer2']       = encrypt ( $this->arrComponents [6][0]->getValue ( ) );

            define('stop'       , 0);
            define('user_exists', 1);
            define('user_store' , 2);
            define('send_email' , 3);

            $state = user_exists;
            while ($state > stop)
            {
                switch ($state)
                {
                    case user_exists:
                        if ( User::is_emailExists ( $data ["email"] ) )
                        {
                            $_REQUEST ["ALERT_TYPE"] = 5;
                            $_REQUEST ["ALERT_MSG"] = "This email address is already associated with an account.";
                            return false;
                        }
                        $state = user_store;
                    break;

                    case user_store:
                        $data ['id'] = User::store_public ( $data );

                        if ( $data ['id'] > 0 )
                        {
                            $state = send_email;
                        }
                        else
                        {
                            $_REQUEST ["ALERT_HEAD"] = "Error!";
                            $_REQUEST ["ALERT_TYPE"] = 4;
                            $_REQUEST ["ALERT_MSG"] = "We were unable to create your account, try again later.";
                            return false;
                        }
                    break;

                    case send_email:
                        User::sendVerificationEmail ( $data );
                        return true;
                    break;
                }
            }
        }
    }