<?php namespace main\models;

    use main\emails\email;
    use main\storage\database;
    class User
    {
        public function __construct ( ) {}

        /**
         * @param $user
         * @return integer UserID
         */
        public static function store_public ( $user )
        {
            $sql_insert = "INSERT INTO `users` ( `FIRSTNAME`, `LASTNAME`, `EMAIL`, `PASSWORD`, `QUESTIONID1`, `QUESTIONID2`, `ANSWER1`, `ANSWER2`, `CREATED` ) ";
            $sql_insert .= "VALUES ( :FIRSTNAME, :LASTNAME, :EMAIL, :PASSWORD, :QUESTIONID1, :QUESTIONID2, :ANSWER1, :ANSWER2, CURRENT_TIMESTAMP ( ) );";

            $sql_params = array
            (
                ":FIRSTNAME" => ["TYPE" => "STR", "VALUE" => $user ['firstname']],
                ":LASTNAME" => ["TYPE" => "STR", "VALUE" => $user ['lastname']],
                ":EMAIL" => ["TYPE" => "STR", "VALUE" => $user ['email']],
                ":PASSWORD" => ["TYPE" => "STR", "VALUE" => $user ['password']],
                ":QUESTIONID1" => ["TYPE" => "INT", "VALUE" => $user ['question1']],
                ":QUESTIONID2" => ["TYPE" => "INT", "VALUE" => $user ['question2']],
                ":ANSWER1" => ["TYPE" => "STR", "VALUE" => $user ['answer1']],
                ":ANSWER2" => ["TYPE" => "STR", "VALUE" => $user ['answer2']]
            );

            return database::runInsertQuery($sql_insert, $sql_params, "ID");
        }

        /**
         * @param $email
         * @return bool
         */
        public static function is_emailExists ( $email )
        {
            $sql_select = "SELECT `ID` FROM `users` WHERE `EMAIL` = :EMAIL;";
            $sql_params = array(":EMAIL" => ["TYPE" => "STR", "VALUE" => $email]);
            $sql_result = database::runSelectQuery($sql_select, $sql_params);
            if (isset ($sql_result))
                return true;
            return false;
        }

        /**
         * @param $id
         * @return bool
         */
        public static function is_idExists ( $id )
        {
            $sql_select = "SELECT `ID` FROM `users` WHERE `ID` = :ID;";
            $sql_params = array(":EMAIL" => ["TYPE" => "STR", "VALUE" => $id]);
            $sql_result = database::runSelectQuery($sql_select, $sql_params);
            if (isset ($sql_result))
                return true;
            return false;
        }

        /**
         * @param $token
         * @return string
         */
        private static function generateVerificationLink ($token )
        {
            return base64urlEncode ($GLOBALS ["RELATIVE_TO_ROOT"] . "/verify?token=" . $token );
        }

        public static function sendVerificationEmail ( $user )
        {
//            $template   = $GLOBALS ["RELATIVE_TO_DIRECTORY"] . "/main/emails/templates/registration.html";
//            $contents   = file_get_contents ( $template );
//            $keys       = array ( "{{ name }}", "{{ href }}", "{{ link }}", "{{ company_name }}" );
//            $values     = array
//            (
//                $user ['firstname'],
//                self::generateVerificationLink ( $user ['id'] ),
//                "Verify my email",
//                $GLOBALS ["BS_NAME"]
//            );
//
//            // email setup
//            $subject    = "Verify my email";
//            $recipients = array ( "to" => [ $user ['email'] => $user ['firstname'] . " " . $user ['lastname'] ] );
//            $message    = str_replace ( $keys, $values, $contents );
//
//            email::sendEmail( $subject, $recipients, $message );

            return true;
        }
    }