<?php namespace main\controllers\usersControl;

    use main\models\Role;
    use main\models\Permission;
    use main\controllers\Controller;

    class usersRoleDetails extends Controller
    {

        protected $canAccess = false;

        /**
         * usersRoleDetails constructor.
         * @throws \Exception
         */
        public function __construct ( )
        {
            session_auth ( );
            if ( Permission::getUserPermission( $_SESSION ["USER_ID"], "USER_ADD" ) )
                $this->canAccess = true;
        }

        protected function onGet ( )
        {
            $index = findInURL('Details' );
            $role = getURLParams()[$index+1];

            http_response_code(404 );

            $Role = new Role();
            if ( is_numeric($role) && $this->canAccess )
            {
                http_response_code( 200 );
                exit ( json_encode( $Role->getRoleDetails($role) ) );
            }

            exit ( json_encode(array ( ) ) );
        }

        protected function onPost ( )
        {
            $this->onGet();
        }

    }