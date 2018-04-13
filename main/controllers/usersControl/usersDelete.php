<?php namespace main\controllers\usersControl;

    use main\models\User;
    use main\models\Permission;
    use main\controllers\Controller;

    class usersDelete extends Controller
    {
        protected $canAccess = false;
        protected $canEdit   = false;
        protected $canAdd    = false;
        protected $canDelete = false;

        /**
         * usersDelete constructor.
         * @throws \Exception
         */
        public function __construct ( )
        {
            session_auth ( );

            $this->canAccess = Permission::getUserPermission( $_SESSION["USER_ID"], "USER_VIEW" );
            $this->canAdd    = Permission::getUserPermission( $_SESSION["USER_ID"], "USER_ADD" );
            $this->canEdit   = Permission::getUserPermission( $_SESSION["USER_ID"], "USER_EDIT" );
            $this->canDelete = Permission::getUserPermission( $_SESSION["USER_ID"], "USER_DELETE" );

        }

        protected function onGet ( ) { }

        protected function onPost ( )
        {
            if ( $this->canDelete )
            {
                $userID = sanitize_integer( $_POST ["UserId"] );
                http_response_code( 400 );

                $user   = new User( ["ID", $userID ] );
                if ( ! is_null ( $user->getUser() ) )
                    if ( $user->setDeleted( true ) )
                        http_response_code( 200 );
            }

        }
    }