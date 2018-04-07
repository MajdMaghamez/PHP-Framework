<?php namespace main\controllers\usersControl;

    use main\models\Role;
    use main\storage\database;
    use main\controllers\Controller;
    use main\layouts\bootstrap\datatables;
    use main\frameworkHelper\datatableHelper;

    class usersList extends Controller
    {
        use usersNavigation;
        protected $canAccess = false;
        protected $userRoles = array ( );

        /**
         * usersList constructor.
         * @throws \Exception
         */
        public function __construct ( )
        {
            session_auth ( );

            if ( Role::isUserAdmin ( $_SESSION ["USER_ID"] ) || Role::isUserSuperAdmin ( $_SESSION ["USER_ID"] ) )
            {
                $this->canAccess = true;
            }
            else
            {
                setFlashMessage ( "Access Denied!", "You do not have permission to access this page", 4 );
            }
        }

        protected function renderPage ( )
        {
            $html    = "\t\t\t<div class=\"row\">\n";
            $html   .= "\t\t\t\t<div class=\"col-md-3 col-lg-3 col-xl-3\">\n";
            $html   .= self::renderNavigationLinks();
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t<div class=\"col-md-9 col-lg-9 col-xl-9\">\n";
            $html   .= "\t\t\t\t\t<div class=\"box\">\n";
            $html   .= "\t\t\t\t\t<h4><i class=\"fas fa-chevron-circle-right\"></i> Users List</h4><hr/>\n";
            $html   .= "\t\t\t\t\t\t<table id=\"users\" class=\"table table-striped table-sm\" width=\"100%\">\n";
            $html   .= "\t\t\t\t\t\t\t<thead class='thead-dark'>\n";
            $html   .= "\t\t\t\t\t\t\t\t<tr>\n";
            $html   .= "\t\t\t\t\t\t\t\t\t<th class=\"all\">Name</th>\n";
            $html   .= "\t\t\t\t\t\t\t\t\t<th class=\"none\">Email</th>\n";
            $html   .= "\t\t\t\t\t\t\t\t\t<th class=\"desktop\">Role</th>\n";
            $html   .= "\t\t\t\t\t\t\t\t\t<th class=\"desktop\">Last Logged in</th>\n";
            $html   .= "\t\t\t\t\t\t\t\t\t<th class=\"desktop\">Action</th>\n";
            $html   .= "\t\t\t\t\t\t\t\t</tr>\n";
            $html   .= "\t\t\t\t\t\t\t</thead>\n";
            $html   .= "\t\t\t\t\t\t\t<tbody>\n";
            $html   .= "\t\t\t\t\t\t\t</tbody>\n";
            $html   .= "\t\t\t\t\t\t</table>\n";
            $html   .= "\t\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t</div>\n";

            return $html;
        }

        protected function onGet ( )
        {
            $layoutTemplate = new datatables ( trim ( basename (__DIR__ ) ), trim ( basename ( __DIR__ ) ) );

            $html   = "<!DOCTYPE html>\n";
            $html   .= "<html lang=\"en\">\n";
            $html   .= "\t<head>\n";
            $html   .= $layoutTemplate->render_header ( [ "TITLE" => "Users List" ], ".page { margin-top: 15px; }" );
            $html   .= "\t</head>\n";
            $html   .= "\t<body>\n";
            $html   .= $layoutTemplate->render_navbar ( );
            $html   .= "\t\t<div class=\"container page\">\n";
            ( $this->canAccess ) ? $html .= $this->renderPage ( ) : $html .= flash_message( "\t\t\t" );
            $html   .= "\t\t</div>\n";
            $html   .= $layoutTemplate->render_footer ( array ( ), self::renderListTableJS() );
            $html   .= "\t</body>\n";
            $html   .= "</html>\n";

            echo $html;
        }

        protected function onPost ( )
        {
            $table      = 'users';
            $primary    = 'ID';
            $this->userRoles = $this->getRoleList();

            http_response_code( 404 );

            $table_columns = array
            (
                array ( 'db' => 'FIRSTNAME', 'dt' => 0 ),
                array ( 'db' => 'LASTNAME', 'dt' => 1 ),
                array ( 'db' => 'EMAIL', 'dt' => 2 ),

                array
                (
                    'db'    => 'ROLE',
                    'dt'    => 3,
                    'formatter' => function ( $d, $row )
                    {
                        return $this->userRoles[$d -1]["PHPVAR"];
                    }
                ),

                array
                (
                    'db'    => 'LAST_LOGGED_IN',
                    'dt'    => 4,
                    'formatter' => function ( $d, $row )
                    {
                        if ( isset ( $d ) )
                            return date ( 'm/d/Y | h:i:s A', strtotime( $d ) );
                        return '';
                    }
                ),

                array
                (
                    'db'    => 'ID',
                    'dt'    => 5,
                    'formatter' => function ( $d, $row )
                    {
                        return $GLOBALS ["RELATIVE_TO_ROOT"] . "/Users/Edit/" . $d;
                    }
                ),

                array
                (
                    'db'    => 'ID',
                    'dt'    => 6,
                    'formatter' => function ( $d, $row )
                    {
                        return $GLOBALS ["RELATIVE_TO_ROOT"] . "/Users/Delete/" . $d;
                    }
                )
            );

            if ( $this->canAccess )
            {
                http_response_code( 200 );
                die ( json_encode ( datatableHelper::complex( $_POST, $table, $primary, $table_columns, null, '`DELETED` = 0' ) ) );
            }

            die ( json_encode( array( ) ) );
        }

        /**
         * @return array
         */
        protected function getRoleList ( )
        {
            $sql_select = "SELECT `PHPVAR` FROM `users_group` WHERE `ROLE` = 1 AND `DELETED` = 0";
            $sql_result = database::runSelectQuery ( $sql_select );
            return $sql_result;
        }
    }