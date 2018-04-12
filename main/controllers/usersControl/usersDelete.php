<?php namespace main\controllers\usersControl;

    use main\models\User;
    use main\models\Permission;
    use main\controllers\Controller;

    class usersDelete extends Controller
    {

        protected $canDelete = false;

        /**
         * usersDelete constructor.
         * @throws \Exception
         */
        public function __construct ( )
        {
            session_auth ( );

            if ( Permission::getUserPermission( $_SESSION["USER_ID"], "USER_DELETE") )
                $this->canDelete = true;
        }

        protected function onGet ( ) { }

        protected function onPost ( )
        {
            $userID = sanitize_integer( $_POST ["UserId"] );
            http_response_code( 400 );

            $user   = new User( ["ID", $userID ] );
            if ( ! is_null ( $user ) )
            {
                if ( $user->setDeleted(true) )
                {
                    http_response_code( 200 );
                }
            }

        }
    }