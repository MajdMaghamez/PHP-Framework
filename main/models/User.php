<?php namespace main\models;

    use main\emails\email;
    use main\storage\database;
    class User
    {
        protected $object = null;

        /**
         * User constructor.
         * @param array $data
         *
         * @note example data [ 'ID', 1 ] or [ 'email', 'user@example.com' ]
         */
        public function __construct ( $data )
        {
            $sql_select = "SELECT * FROM `users` WHERE `" . $data [0] . "` = :" . $data [0] . " AND `DELETED` = 0";
            $sql_params = array ( ":" . $data[0] => ["TYPE" => "STR", "VALUE" => $data [1] ] );
            $sql_result = database::runSelectQuery ( $sql_select, $sql_params );

            if ( isset ( $sql_result ) )
                $this->object = $sql_result [0];
        }

        /**
         * @return object|null
         */
        public function getUser ( )
        {
            return $this->object;
        }

        /**
         * @return integer
         */
        public function getID ( )
        {
            return $this->object ["ID"];
        }

        /**
         * @return string
         */
        public function getFirst ( )
        {
            return $this->object ["FIRSTNAME"];
        }

        /**
         * @return string
         */
        public function getLast ( )
        {
            return $this->object ["LASTNAME"];
        }

        /**
         * @return string
         */
        public function getName ( )
        {
            return $this->object ["FIRSTNAME"] . " " . $this->object ["LASTNAME"];
        }

        /**
         * @return string
         */
        public function getEmail ( )
        {
            return $this->object ["EMAIL"];
        }

        /**
         * @return integer
         */
        public function isActive ( )
        {
            return $this->object ["ACTIVE"];
        }

        /**
         * @return integer
         */
        public function isVerified ( )
        {
            return $this->object ["VERIFIED"];
        }

        /**
         * @return integer
         */
        public function isDeleted ( )
        {
            return $this->object ["DELETED"];
        }

        /**
         * @return false|string
         */
        public function getCreated ( )
        {
            return date ( 'm/d/Y h:i:s A', $this->object ["CREATED"] );
        }

        /**
         * @return false|string
         */
        public function getUpdated ( )
        {
            return date ( "m/d/Y h:i:s A", $this->object ["UPDATED"] );
        }

        /**
         * @return integer
         */
        public function mustChangePassword ( )
        {
            return $this->object ["CHANGE_PASSWORD"];
        }

        /**
         * @return integer
         */
        public function getRole ( )
        {
            return $this->object ["ROLE"];
        }

        /**
         * @return string
         */
        public function getHomePage ( )
        {
            return $this->object ["HOME_DIR"];
        }

        /**
         * @param $password
         * @return bool
         */
        public function isAuth ( $password )
        {
            if ( password_verify ( $password, $this->object ["PASSWORD"] ) )
                return true;
            return false;
        }


        /**
         * @param integer $id
         * @return bool
         */
        public static function disable ($id )
        {
            $sql_update = "UPDATE `users` SET `ACTIVE` = 0, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID AND `DELETED` = 0";
            $sql_params = array ( "ID" => ["TYPE" => "INT", "VALUE" => $id] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
                return true;
            return false;
        }

        /**
         * @param integer $id
         * @return bool
         */
        public static function enable ($id )
        {
            $sql_update = "UPDATE `users` SET `ACTIVE` = 1, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID AND `DELETED` = 0";
            $sql_params = array ( "ID" => ["TYPE" => "INT", "VALUE" => $id] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
                return true;
            return false;
        }

        /**
         * @param integer $id
         * @return bool
         */
        public static function setLastLogin ($id )
        {
            $sql_update = "UPDATE `users` SET `LAST_LOGGED_IP` = :IP, `FAILED` = 0, `LAST_LOGGED_IN` = CURRENT_TIMESTAMP (), `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID AND `DELETED` = 0";
            $sql_params = array ( ":IP" => ["TYPE" => "STR", "VALUE" => get_ip() ], ":ID" => ["TYPE" => "STR", "VALUE" => $id ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
                return true;
            return false;
        }

        /**
         * @param integer $id
         * @return mixed
         */
        public static function getFailed ( $id )
        {
            $sql_select = "SELECT `FAILED` FROM `users` WHERE `ID` = :ID AND `DELETED` = 0";
            $sql_params = array ( ":ID" => ["TYPE" => "INT", "VALUE" => $id ] );
            $sql_result = database::runSelectQuery ( $sql_select, $sql_params );
            return isset ( $sql_result ) ? $sql_result [0]["FAILED"] : null;
        }

        /**
         * @param integer $id
         * @return mixed|null
         */
        public static function incrementFailed ( $id )
        {
            $sql_update = "UPDATE `users` SET `FAILED` = `FAILED` + 1, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID AND `DELETED` = 0";
            $sql_params = array ( ":ID" => ["TYPE" => "INT", "VALUE" => $id ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
                return self::getFailed ( $id );
            return null;
        }


        /**
         * @param $user
         * @return integer UserID
         *
         * @note storing users from public registration
         */
        public static function store_public ( $user )
        {
            $sql_insert = "INSERT INTO `users` ( `FIRSTNAME`, `LASTNAME`, `EMAIL`, `PASSWORD`, `QUESTIONID1`, `QUESTIONID2`, `ANSWER1`, `ANSWER2`, `CREATED`, `HOME_DIR` ) ";
            $sql_insert .= "VALUES ( :FIRSTNAME, :LASTNAME, :EMAIL, :PASSWORD, :QUESTIONID1, :QUESTIONID2, :ANSWER1, :ANSWER2, CURRENT_TIMESTAMP ( ), '/Home' );";

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
         * @param $data
         * @return bool
         *
         * @note ex. $data = array ( 'ID', 1 ) or array ( 'EMAIL' => 'user@example.com' )
         */
        public static function isExists ( $data )
        {
            $sql_select = "SELECT `ID` FROM `users` WHERE `" . $data [0] . "` = :" . $data [0] . " AND `DELETED` = 0";
            $sql_params = array ( ":" . $data[0] => ["TYPE" => "STR", "VALUE" => $data [1] ] );
            $sql_result = database::runSelectQuery ( $sql_select, $sql_params );

            if ( isset ( $sql_result ) )
                return true;
            return false;
        }

        /**
         * @param $token
         * @return string
         */
        private static function generateVerificationLink ( $token )
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