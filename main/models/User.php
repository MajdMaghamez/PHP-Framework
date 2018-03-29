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
         * @param string $first
         * @return bool
         */
        public function setFirst ( $first )
        {
            $sql_update = "UPDATE `users` SET `FIRSTNAME` = :FIRSTNAME, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":FIRSTNAME" => [ "TYPE" => "STR", "VALUE" => $first ], ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
            {
                $this->object ["FIRSTNAME"] = $first;
                return true;
            }
            return false;
        }

        /**
         * @return string
         */
        public function getLast ( )
        {
            return $this->object ["LASTNAME"];
        }

        /**
         * @param string $last
         * @return bool
         */
        public function setLast ( $last )
        {
            $sql_update = "UPDATE `users` SET `LASTNAME` = :LASTNAME, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":LASTNAME" => [ "TYPE" => "STR", "VALUE" => $last ], ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID ( ) ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
            {
                $this->object ["LASTNAME"] = $last;
                return true;
            }
            return false;
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
         * @param string $email
         * @return bool
         */
        public function setEmail ( $email )
        {
            $sql_update = "UPDATE `users` SET `EMAIL` = :EMAIL, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":EMAIL" => [ "TYPE" => "STR", "VALUE" => $email ], ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );

            if ( $sql_result > 0 )
            {
                $this->object ["EMAIL"] = $email;
                return true;
            }

            return false;
        }


        /**
         * @return integer
         */
        public function isActive ( )
        {
            return $this->object ["ACTIVE"];
        }

        /**
         * @param boolean $active
         * @return bool
         */
        public function setActive ( $active )
        {
            $sql_update = "UPDATE `users` SET `ACTIVE` = :ACTIVE, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":ACTIVE" => [ "TYPE" => "INT", "VALUE" => intval ($active) ], ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
            {
                $this->object ["ACTIVE"] = intval ($active);
                return true;
            }

            return false;
        }

        /**
         * @return mixed
         */
        public function getFailed ( )
        {
            $sql_select = "SELECT `FAILED` FROM `users` WHERE `ID` = :ID AND `DELETED` = 0";
            $sql_params = array ( ":ID" => ["TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runSelectQuery ( $sql_select, $sql_params );
            return isset ( $sql_result ) ? $sql_result [0]["FAILED"] : null;
        }

        /**
         * @param boolean $failed
         * @return bool
         */
        public function setFailed ( $failed )
        {
            $sql_update = "UPDATE `users` SET `FAILED` = :FAILED, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":FAILED" => [ "TYPE" => "INT", "VALUE" => intval ($failed) ], ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
            {
                $this->object ["FAILED"] = intval ($failed);
                return true;
            }

            return false;
        }

        /**
         * @return mixed|null
         */
        public function incrementFailed ( )
        {
            $sql_update = "UPDATE `users` SET `FAILED` = `FAILED` + 1, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID AND `DELETED` = 0";
            $sql_params = array ( ":ID" => ["TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
                return $this->getFailed ( );
            return null;
        }

        /**
         * @return integer
         */
        public function isVerified ( )
        {
            return $this->object ["VERIFIED"];
        }

        /**
         * @param boolean $verified
         * @return bool
         */
        public function setVerified ( $verified )
        {
            $sql_update = "UPDATE `users` SET `VERIFIED` = :VERIFIED, `VERIFY_TOKEN` = NULL, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":VERIFIED" => [ "TYPE" => "INT", "VALUE" => intval ($verified) ], ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
            {
                $this->object ["VERIFIED"] = intval ($verified);
                return true;
            }

            return false;
        }

        /**
         * @return string
         */
        public function getVerifiedToken ( )
        {
            return $this->object ["VERIFY_TOKEN"];
        }

        /**
         * @return integer
         */
        public function isDeleted ( )
        {
            return $this->object ["DELETED"];
        }

        /**
         * @param boolean $deleted
         * @return bool
         */
        public function setDeleted ( $deleted )
        {
            $sql_update = "UPDATE `users` SET `DELETED` = :DELETED, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":DELETED" => [ "TYPE" => "INT", "VALUE" => intval ($deleted) ], ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
            {
                $this->object ["DELETED"] = intval ($deleted);
                return true;
            }

            return false;
        }


        /**
         * @return string
         */
        public function getPassword ( )
        {
            return $this->object ["PASSWORD"];
        }

        /**
         * @param string $password
         * @return bool
         */
        public function setPassword ( $password )
        {
            $sql_update = "UPDATE `users` SET `PASSWORD` = :PASSWORD, `FAILED` = 0, `ACTIVE` = 1, `PASSWORD_TOKEN` = NULL, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":PASSWORD" => [ "TYPE" => "STR", "VALUE" => password ( $password ) ], ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );

            if ( $sql_result > 0 )
            {
                $this->object ["PASSWORD"] = password ( $password );
                return true;
            }

            return false;
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
         * @return integer
         */
        public function getChangePassword ( )
        {
            return $this->object ["CHANGE_PASSWORD"];
        }

        /**
         * @param boolean $changePassword
         * @return bool
         */
        public function setChangePassword ( $changePassword )
        {
            $sql_update = "UPDATE `users` SET `CHANGE_PASSWORD` = :CHANGE_PASSWORD, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":CHANGE_PASSWORD" => [ "TYPE" => "INT", "VALUE" => intval($changePassword) ], ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery( $sql_update, $sql_params );
            if ( $sql_result > 0 )
            {
                $this->object ["CHANGE_PASSWORD"] = intval($changePassword);
                return true;
            }

            return false;
        }

        /**
         * @return string
         */
        public function getPasswordToken ( )
        {
            return $this->object ["PASSWORD_TOKEN"];
        }

        /**
         * @param string $token
         * @return bool
         */
        public function setPasswordToken ( $token )
        {
            $sql_update = "UPDATE `users` SET `PASSWORD_TOKEN` = :PASSWORD_TOKEN, `UPDATED` = CURRENT_TIMESTAMP (), `TOKEN_CREATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":PASSWORD_TOKEN" => [ "TYPE" => "STR", "VALUE" => $token ], ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
            {
                $this->object ["PASSWORD_TOKEN"] = $token;
                return true;
            }

            return false;
        }

        /**
         * @return false|string
         */
        public function getTokenCreated ( )
        {
            return date ( 'm/d/Y h:i:s A', $this->object ["TOKEN_CREATED"] );
        }

        /**
         * @param $date
         * @return bool
         */
        public function setTokenCreated ( $date )
        {
            $sql_update = "UPDATE `users` SET `TOKEN_CREATED` = :CREATED, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":CREATED" => [ "TYPE" => "STR", "VALUE" => date ( 'Y-m-d H:i:s', $date ) ], ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
            {
                $this->object ["TOKEN_CREATED"] = date ( 'Y-m-d H:i:s', $date );
                return true;
            }

            return false;
        }

        /**
         * @return bool
         */
        public function isTokenExpired ( )
        {
            // last created password reset token
            $token = new \DateTime ( $this->object ["TOKEN_CREATED"], new \DateTimeZone( $GLOBALS ["TIME_ZONE"] ) );
            $current = new \DateTime ( 'now', new \DateTimeZone( $GLOBALS ["TIME_ZONE"] ) );

            try
            {
                $token = $token->add ( new \DateInterval( 'PT' . $GLOBALS ["TOKEN_EXPIRY"] . 'M' ) );
                if ( $token < $current )
                    return true;
            }
            catch ( \Exception $E )
            {
                error_log ( 'error: could not add time to password reset token ' . $E->getMessage() );
            }

            return false;
        }


        /**
         * @return integer
         */
        public function getQuestion1 ( )
        {
            return $this->object ["QUESTIONID1"];
        }

        /**
         * @param integer $question1
         * @return bool
         */
        public function setQuestion1 ( $question1 )
        {
            $sql_update = "UPDATE `users` SET `QUESTIONID1` = :QUESTIONID1, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":QUESTIONID1" => [ "TYPE" => "INT", "VALUE" => $question1 ], ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
            {
                $this->object ["QUESTIONID1"] = $question1;
                return true;
            }

            return false;
        }

        /**
         * @return integer
         */
        public function getQuestion2 ( )
        {
            return $this->object ["QUESTIONID2"];
        }

        /**
         * @param integer $question2
         * @return bool
         */
        public function setQuestion2 ( $question2 )
        {
            $sql_update = "UPDATE `users` SET `QUESTIONID2` = :QUESTIONID2, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":QUESTIONID2" => [ "TYPE" => "INT", "VALUE" => $question2 ], ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
            {
                $this->object ["QUESTIONID2"] = $question2;
                return true;
            }

            return false;
        }

        /**
         * @return string
         */
        public function getAnswer1 ( )
        {
            return decrypt ( $this->object ["ANSWER1"] );
        }

        /**
         * @param string $answer1
         * @return bool
         */
        public function setAnswer1 ( $answer1 )
        {
            $sql_update = "UPDATE `users` SET `ANSWER1` = :ANSWER1, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":ANSWER1" => [ "TYPE" => "STR", "VALUE" => encrypt( $answer1 ) ], ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
            {
                $this->object ["ANSWER1"] = $answer1;
                return true;
            }

            return false;
        }

        /**
         * @return string
         */
        public function getAnswer2 ( )
        {
            return decrypt ( $this->object ["ANSWER2"] );
        }

        /**
         * @param string $answer2
         * @return bool
         */
        public function setAnswer2 ( $answer2 )
        {
            $sql_update = "UPDATE `users` SET `ANSWER2` = :ANSWER2, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":ANSWER2" => [ "TYPE" => "STR", "VALUE" => encrypt( $answer2 ) ], ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
            {
                $this->object ["ANSWER2"] = $answer2;
                return true;
            }

            return false;
        }

        /**
         * @param integer $Q1
         * @param integer $Q2
         * @param string $A1
         * @param string $A2
         * @return bool
         */
        public function setQuestionsAnswers ($Q1, $Q2, $A1, $A2 )
        {
            $sql_update = "UPDATE `users` SET `QUESTIONID1` = :QUESTIONID1, `QUESTIONID2` = :QUESTIONID2, `ANSWER1` = :ANSWER1, `ANSWER2` = :ANSWER2, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array
            (
                ":QUESTIONID1" => [ "TYPE" => "INT", "VALUE" => $Q1 ],
                ":QUESTIONID2" => [ "TYPE" => "INT", "VALUE" => $Q2 ],
                ":ANSWER1" => [ "TYPE" => "STR", "VALUE" => encrypt( $A1 ) ],
                ":ANSWER2" => [ "TYPE" => "STR", "VALUE" => encrypt( $A2 ) ],
                ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID() ]
            );

            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
            {
                $this->object ["QUESTIONID1"] = $Q1;
                $this->object ["QUESTIONID2"] = $Q2;

                $this->object ["ANSWER1"] = $A1;
                $this->object ["ANSWER2"] = $A2;
                return true;
            }

            return false;
        }


        /**
         * @return string
         */
        public function getLastLoggedIP ( )
        {
            return $this->object ["LAST_LOGGED_IP"];
        }

        /**
         * @param string $ip
         * @return bool
         */
        public function setLastLoggedIP ( $ip )
        {
            $sql_update = "UPDATE `users` SET `LAST_LOGGED_IP` = :IP, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":IP" => [ "TYPE" => "STR", "VALUE" => $ip ], ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
            {
                $this->object ["LAST_LOGGED_IP"] = $ip;
                return true;
            }

            return false;
        }

        /**
         * @return false|string
         */
        public function getLastLoggedIn ( )
        {
            $date = strtotime ( $this->object ["LAST_LOGGED_IN"] );
            return date ( 'm/d/Y h:i:s A', $date );
        }

        /**
         * @return bool
         */
        public function setLastLoggedIn ( )
        {
            $sql_update = "UPDATE `users` SET `LAST_LOGGED_IN` = CURRENT_TIMESTAMP (), `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
            {
                $this->object ["LAST_LOGGED_IN"] = date ( 'm/d/Y h:i:s A' );
                return true;
            }

            return false;
        }


        /**
         * @return integer
         */
        public function getCreatedBy ( )
        {
            return $this->object ["CREATED_BY"];
        }

        /**
         * @param integer $id
         * @return bool
         */
        public function setCreatedBy ( $id )
        {
            $sql_update = "UPDATE `users` SET `CREATED_BY` = :CREATED_BY, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":CREATED_BY" => [ "TYPE" => "INT", "VALUE" => $id ], ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
            {
                $this->object ["CREATED_BY"] = $id;
                return true;
            }

            return false;
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
        public function getRole ( )
        {
            return $this->object ["ROLE"];
        }

        /**
         * @param integer $role
         * @return bool
         */
        public function setRole ( $role )
        {
            $sql_update = "UPDATE `users` SET `ROLE` = :ROLE, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":ROLE" => [ "TYPE" => "INT", "VALUE" => $role ], ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
            {
                $this->object ["ROLE"] = $role;
                return true;
            }

            return false;
        }


        /**
         * @return string
         */
        public function getHomePage ( )
        {
            return $this->object ["HOME_DIR"];
        }

        /**
         * @param string $home
         * @return bool
         */
        public function setHomePage ($home )
        {
            $sql_update = "UPDATE `users` SET `HOME_DIR` = :HOME_DIR, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":HOME_DIR" => [ "TYPE" => "STR", "VALUE" => $home ], ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
            {
                $this->object ["HOME_DIR"] = $home;
                return true;
            }

            return false;
        }

        /**
         * @return string
         */
        public function getProfilePicture ( )
        {
            return $GLOBALS ["RELATIVE_TO_ROOT"] . "/cache/users/" . $this->object ["PICTURE"];
        }

        /**
         * @param string $picture
         * @return bool
         */
        public function setProfilePicture ($picture )
        {
            $sql_update = "UPDATE `users` SET `PICTURE` = :PICTURE, `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID";
            $sql_params = array ( ":PICTURE" => [ "TYPE" => "STR", "VALUE" => $picture ], ":ID" => [ "TYPE" => "INT", "VALUE" => $this->getID ( ) ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );
            if ( $sql_result > 0 )
            {
                $this->object["PICTURE"] = $picture;
                return true;
            }

            return false;
        }


        /**
         * @return bool
         */
        public function setAuthentication ( )
        {
            $sql_update = "UPDATE `users` SET `LAST_LOGGED_IP` = :IP, `FAILED` = 0, `LAST_LOGGED_IN` = CURRENT_TIMESTAMP (), `UPDATED` = CURRENT_TIMESTAMP () WHERE `ID` = :ID AND `DELETED` = 0";
            $sql_params = array ( ":IP" => ["TYPE" => "STR", "VALUE" => get_ip() ], ":ID" => ["TYPE" => "STR", "VALUE" => $this->getID() ] );
            $sql_result = database::runUpdateQuery ( $sql_update, $sql_params );

            if ( $sql_result > 0 )
            {
                $logoutTime = new \datetime ( 'now', new \DateTimeZone( $GLOBALS ["TIME_ZONE"] ) );
                try
                {
                    $logoutTime->add ( new \DateInterval( 'PT' . $GLOBALS ["S_TIMEOUT"] . 'M' ) );
                }
                catch ( \Exception $E )
                {
                    error_log( 'Error Setting Session Timeout ' . $E->getMessage ( ) );
                    return false;
                }

                session_start ( );
                $_SESSION ["USER_ID"] = $this->getID ( );
                $_SESSION ["USER_NAME"] = $this->getName ( );
                $_SESSION ["USER_EMAIL"] = $this->getEmail ( );
                $_SESSION ["USER_ROLE"] = $this->getRole ( );
                $_SESSION ["USER_HOME"] = $this->getHomePage ( );
                $_SESSION ["CSRF_TOKEN"] = randomToken ( );
                $_SESSION ["TIMEOUT"] = $logoutTime->format ( 'm/d/Y H:i:s' );
                $_SESSION ["CHANGE_PASS"] = $this->getChangePassword ( );

                return true;
            }

            return false;
        }


        /**
         * @return bool
         */
        public function sendResetEmail ( )
        {
            return true;
        }

        /**
         * @return bool
         */
        public function sendVerificationEmail ( )
        {
            return true;
        }


        /**
         * @param $user
         * @return integer UserID
         *
         * @note storing users from public registration
         */
        public static function store_public ( $user )
        {
            $sql_insert = <<<EOT
            INSERT INTO `users` ( `FIRSTNAME`, `LASTNAME`, `EMAIL`, `PASSWORD`, `QUESTIONID1`, `QUESTIONID2`, `ANSWER1`, `ANSWER2`, `CREATED`, `VERIFY_TOKEN`, `HOME_DIR`, `PICTURE` ) 
            VALUES ( :FIRSTNAME, :LASTNAME, :EMAIL, :PASSWORD, :QUESTIONID1, :QUESTIONID2, :ANSWER1, :ANSWER2, CURRENT_TIMESTAMP ( ), :VERIFY_TOKEN, '/Home', :PICTURE );
EOT;
            $sql_params = array
            (
                ":FIRSTNAME" => ["TYPE" => "STR", "VALUE" => $user ['firstname']],
                ":LASTNAME" => ["TYPE" => "STR", "VALUE" => $user ['lastname']],
                ":EMAIL" => ["TYPE" => "STR", "VALUE" => $user ['email']],
                ":PASSWORD" => ["TYPE" => "STR", "VALUE" => $user ['password']],
                ":QUESTIONID1" => ["TYPE" => "INT", "VALUE" => $user ['question1']],
                ":QUESTIONID2" => ["TYPE" => "INT", "VALUE" => $user ['question2']],
                ":ANSWER1" => ["TYPE" => "STR", "VALUE" => $user ['answer1']],
                ":ANSWER2" => ["TYPE" => "STR", "VALUE" => $user ['answer2']],
                ":VERIFY_TOKEN" => ["TYPE" => "STR", "VALUE" => randomToken()],
                ":PICTURE" => ["TYPE" => "STR", "VALUE" => base64StringEncode( $user ['email'] ) . ".png" ]
            );

            $default = $GLOBALS ["RELATIVE_TO_DIRECTORY"] . "/assets/img/default.png";
            $destination = $GLOBALS ["CACHE_FOLDER"] . "/users/" . base64StringEncode ( $user ['email'] ) . ".png";

            if ( ! file_exists ( $destination ) ) { copy ( $default, $destination ); }

            return database::runInsertQuery($sql_insert, $sql_params, "ID");
        }

    }