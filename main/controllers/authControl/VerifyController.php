<?php namespace main\controllers\authControl;

    use main\models\User;
    use main\controllers\Controller;

    class VerifyController extends Controller
    {
        /**
         * VerifyController constructor.
         */
        public function __construct ( ){}

        /**
         * @throws \Exception
         */
        protected function onGet()
        {
            session_auth ( true );
            $TOKEN = findInURL( 'token' );
            $TOKEN > 0 ? $TOKEN++ : $TOKEN = 0;
            $URL = getURLParams();
            $TOKEN_VAL = sanitize_string( $URL[$TOKEN], '/^[a-z0-9]+$/' );

            if ( ! empty( $TOKEN_VAL ) )
            {
                $user = new User ( [ 'VERIFY_TOKEN', $TOKEN_VAL ] );

                if ( ! is_null ( $user->getUser() ) )
                {
                    if ( $user->getVerifiedToken() == $TOKEN_VAL )
                    {
                        $user->setVerified( true );
                        redirect( $GLOBALS ["RELATIVE_TO_ROOT"] . "/Login/Verified" );
                    }
                }
            }

            redirect( $GLOBALS ["RELATIVE_TO_ROOT"] . "/Login" );
        }

        /**
         * @throws \Exception
         */
        protected function onPost()
        {
            $this->onGet();
        }

    }