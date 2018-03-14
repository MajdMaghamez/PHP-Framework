<?php namespace main\controllers\authControl;

    use main\emails\email;
    use main\gui\buttons\formButton;
    use main\gui\fields\emailField;
    use main\gui\fields\passwordField;
    use main\gui\fields\selectField;
    use main\gui\fields\textField;
    use main\gui\alerts\alert;
    use main\gui\links\link;
    use main\storage\database;
    use main\controllers\Controller;
    use main\layouts\bootstrap\main;
    use main\gui\renderer\bootstrapForm;
    use main\frameworkHelper\cacheManager;
    use main\frameworkHelper\fieldsValidator;
    class RegisterController extends Controller
    {
        protected $errors = array ( );
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

            $cacheManager = new cacheManager ($folder, $file);
            if (!$cacheManager->isCacheExists()) { $this->errors = !$cacheManager->write($this->preRenderPage ( ) ); }
            if (!$this->errors) { return $cacheManager->read ( $this->arrComponents ); }
            return "";
        }

        protected function onGet()
        {
            $layoutTemplate = new main();
            $alert = new alert ("Oops!", "Something went wrong, please make a correction and try again", 4);
            $alert->setTabs("\t\t\t\t\t");

            $html = "<!DOCTYPE html>\n";
            $html .= "<html lang=\"en\">\n";
            $html .= "\t<head>\n";
            $html .= $layoutTemplate->render_header(["TITLE" => "Registration Page"], ".register { margin-top: 25px; }");
            $html .= "\t</head>\n";
            $html .= "\t<body>\n";
            $html .= "\t\t<div class=\"container register\">\n";
            $html .= "\t\t\t<div class=\"row justify-content-center\">\n";
            $html .= "\t\t\t\t<div class=\"col-sm-12 col-md-6 col-lg-6 col-xl-6\">\n";

            if ($this->errors) { $html .= $alert->renderBootstrap();}

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
            $errors = !fieldsValidator::validate ( $this->arrComponents );
            if ( $errors == false ) { array_push ( $this->errors, [ "TYPE" => 4, "HEADER" => "Oops", "MESSAGE" => "Something went wrong, please make a correction and try again" ] ); }


            $user ["firstname"] = ucwords($this->arrComponents [0][0]->getValue());
            $user ["lastname"] = ucwords($this->arrComponents [0][1]->getValue());
            $user ["email"] = $this->arrComponents [1][0]->getValue();
            $user ["password"] = password($this->arrComponents [2][0]->getValue());
            $user ["question1"] = $this->arrComponents [3][0]->getValue();
            $user ["answer1"] = encrypt($this->arrComponents [4][0]->getValue());
            $user ["question2"] = $this->arrComponents [5][0]->getValue();
            $user ["answer2"] = encrypt($this->arrComponents [6][0]->getValue());

            $this->errors = $this->registerUser ( $user );

        }

        protected function registerUser( $userData )
        {
            define('stop', 0);
            define('user_exists', 1);
            define('user_store', 2);
            define('send_email', 3);

            $state = user_exists;
            while ($state > stop) {
                switch ($state) {
                    case user_exists: if ( $this->findByEmail ( $userData ["EMAIL"] ) ) { return 2; } else { $state = user_store; } break;
                    case user_store: if ( $this->storePublicUser ( $userData)) { $state = send_email; } else { return 0; } break;
                    case send_email: if ($this->sendEmail( $userData)) { return 1; } else { return 0; } break;
                }
            }
        }

        /**
         * @param string $email
         * @return bool
         */
        private function findByEmail( $email )
        {
            $sql_select = "SELECT `ID` FROM `users` WHERE `EMAIL` = :EMAIL;";
            $sql_params = array(":EMAIL" => ["TYPE" => "STR", "VALUE" => $email]);
            $sql_result = database::runSelectQuery($sql_select, $sql_params);
            if (isset ($sql_result))
                return true;
            return false;
        }

        /**
         * @param array $userData
         * @return bool
         */
        private function storePublicUser( $userData)
        {
            // store the user
            $sql_insert = "INSERT INTO `users` ( `FIRSTNAME`, `LASTNAME`, `EMAIL`, `PASSWORD`, `ACTIVE`, `FAILED`, `VERIFIED`, `CREATED`, `UPDATED` ) ";
            $sql_insert .= "VALUES ( :FIRSTNAME, :LASTNAME, :EMAIL, :PASSWORD, 1, 0, 0, CURRENT_TIMESTAMP ( ), CURRENT_TIMESTAMP ( );";
            $sql_params = array
            (
                ":FIRSTNAME" => ["TYPE" => "STR", "VALUE" => $userData ["FIRSTNAME"]],
                ":LASTNAME" => ["TYPE" => "STR", "VALUE" => $userData ["LASTNAME"]],
                ":EMAIL" => ["TYPE" => "STR", "VALUE" => $userData ["EMAIL"]],
                ":PASSWORD" => ["TYPE" => "STR", "VALUE" => $userData ["PASSWORD"]]
            );

            $userID = database::runInsertQuery($sql_insert, $sql_params, "ID");
            if ($userID == 0) return false;

            // store questions & answers
            $sql_insert = "INSERT INTO `users_password_answers` ( `USERID`, `QUESTIONID1`, `QUESTIONID2`, `ANSWER1`, `ANSWER2` ) ";
            $sql_insert .= "VALUES ( :USERID, :QUESTIONID1, :QUESTIONID2, :ANSWER1, :ANSWER2 );";
            $sql_params = array
            (
                ":USERID" => ["TYPE" => "INT", "VALUE" => $userID],
                ":QUESTIONID1" => ["TYPE" => "INT", "VALUE" => $userData ["QUESTION1"]],
                ":QUESTIONID2" => ["TYPE" => "INT", "VALUE" => $userData ["QUESTION2"]],
                ":ANSWER1" => ["TYPE" => "STR", "VALUE" => $userData ["ANSWER1"]],
                ":ANSWER2" => ["TYPE" => "STR", "VALUE" => $userData ["ANSWER2"]]
            );

            $sql_result = database::runInsertQuery($sql_insert, $sql_params, "ID");
            if ($sql_result == 0) return false;

            return true;
        }

        /**
         * @param $userId
         * @return string
         */
        private function generateVerificationLink ($userId )
        {
            return base64urlEncode ($GLOBALS ["RELATIVE_TO_ROOT"] . "/verify?token=" . $userId );
        }

        /**
         * @param array $userData
         * @return bool
         */
        private function sendEmail ( $userData )
        {
            $template   = $GLOBALS ["RELATIVE_TO_DIRECTORY"] . "/main/emails/templates/registration.html";
            $contents   = file_get_contents ( $template );
            $keys       = array ( "{{ name }}", "{{ href }}", "{{ link }}", "{{ company_name }}" );
            $values     = array
            (
                $userData ["firstname"],
                $GLOBALS ["RELATIVE_TO_ROOT"] . "/verify",
                $this->generateVerificationLink ( ),
                $GLOBALS ["BS_NAME"]
            );

            // email setup
            $subject    = "verify your email";
            $recipients = array ( "to" => [ $userData ["email"] => $userData ["firstname"] . " " . $userData ["lastname"] ] );
            $message    = str_replace ( $keys, $values, $contents );

            ob_start ( );
            email::sendEmail ( $subject, $recipients, $message );
            $results = ob_get_contents ( );
            ob_end_clean ( );

            if ( $results !== 0 )
                return true;
            return false;
        }
    }