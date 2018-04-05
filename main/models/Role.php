<?php namespace main\models;

    use main\storage\database;
    class Role extends Permission
    {
        protected $role_list;

        /**
         * Role constructor.
         */
        public function __construct ( )
        {
            parent::__construct ( );

            $this->role_list ['Super Admin'] =
            [
                'USER_VIEW'     => 1,
                'USER_ADD'      => 1,
                'USER_EDIT'     => 1,
                'USER_DELETE'   => 1
            ];

            $this->role_list ['Admin'] =
            [

            ];

            $this->role_list ['Data Analyst'] =
            [

            ];

            $this->role_list ['Accountant'] =
            [

            ];

            $this->role_list ['Public'] =
            [

            ];

            foreach ( $this->role_list as $role => $permission )
            {
                $this->role_list [ $role ] = array_merge ( $this->permission_list, $this->role_list [ $role ] );
            }
        }

        /**
         * @return mixed
         */
        public function getRoleList ( )
        {
            return $this->role_list;
        }

        /**
         * @param mixed $role_list
         */
        public function setRoleList ( $role_list )
        {
            $this->role_list = $role_list;
        }

        /**
         * @param integer $id
         * @return bool
         */
        public static function isUserSuperAdmin ( $id )
        {
            $sql_select = "SELECT ( CASE `UG`.`PHPVAR` = 'Super Admin' WHEN 1 THEN 1 ELSE 0 END ) AS `Role` ";
            $sql_select.= "FROM `users` `U` INNER JOIN `users_group` `UG` ON `UG`.`ID` = `U`.`ROLE` AND `UG`.`ROLE` = 1 ";
            $sql_select.= "WHERE `U`.`ID` = :ID AND `U`.`DELETED` = 0 and `UG`.`DELETED` = 0";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $id ] );
            $sql_result = database::runSelectQuery ( $sql_select, $sql_params );
            if ( !empty ( $sql_result ) )
                return boolval( $sql_result[0]["Role"] );
            return false;
        }

        /**
         * @param integer $id
         * @return bool
         */
        public static function isUserAdmin ( $id )
        {
            $sql_select = "SELECT ( CASE `UG`.`PHPVAR` = 'Admin' WHEN 1 THEN 1 ELSE 0 END ) AS `Role` ";
            $sql_select.= "FROM `users` `U` INNER JOIN `users_group` `UG` ON `UG`.`ID` = `U`.`ROLE` AND `UG`.`ROLE` = 1 ";
            $sql_select.= "WHERE `U`.`ID` = :ID AND `U`.`DELETED` = 0 and `UG`.`DELETED` = 0";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $id ] );
            $sql_result = database::runSelectQuery ( $sql_select, $sql_params );
            if ( !empty ( $sql_result ) )
                return boolval( $sql_result[0]["Role"] );
            return false;
        }

        /**
         * @param integer $id
         * @return bool
         */
        public static function isUserDataAnalyst ( $id )
        {
            $sql_select = "SELECT ( CASE `UG`.`PHPVAR` = 'Data Analyst' WHEN 1 THEN 1 ELSE 0 END ) AS `Role` ";
            $sql_select.= "FROM `users` `U` INNER JOIN `users_group` `UG` ON `UG`.`ID` = `U`.`ROLE` AND `UG`.`ROLE` = 1 ";
            $sql_select.= "WHERE `U`.`ID` = :ID AND `U`.`DELETED` = 0 and `UG`.`DELETED` = 0";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $id ] );
            $sql_result = database::runSelectQuery ( $sql_select, $sql_params );
            if ( !empty ( $sql_result ) )
                return boolval( $sql_result[0]["Role"] );
            return false;
        }

        /**
         * @param integer $id
         * @return bool
         */
        public static function isUserAccountant ( $id )
        {
            $sql_select = "SELECT ( CASE `UG`.`PHPVAR` = 'Accountant' WHEN 1 THEN 1 ELSE 0 END ) AS `Role` ";
            $sql_select.= "FROM `users` `U` INNER JOIN `users_group` `UG` ON `UG`.`ID` = `U`.`ROLE` AND `UG`.`ROLE` = 1 ";
            $sql_select.= "WHERE `U`.`ID` = :ID AND `U`.`DELETED` = 0 and `UG`.`DELETED` = 0";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $id ] );
            $sql_result = database::runSelectQuery ( $sql_select, $sql_params );
            if ( !empty ( $sql_result ) )
                return boolval( $sql_result[0]["Role"] );
            return false;
        }

        /**
         * @param integer $id
         * @return bool
         */
        public static function isUserPublic ( $id )
        {
            $sql_select = "SELECT ( CASE `UG`.`PHPVAR` = 'Public' WHEN 1 THEN 1 ELSE 0 END ) AS `Role` ";
            $sql_select.= "FROM `users` `U` INNER JOIN `users_group` `UG` ON `UG`.`ID` = `U`.`ROLE` AND `UG`.`ROLE` = 1 ";
            $sql_select.= "WHERE `U`.`ID` = :ID AND `U`.`DELETED` = 0 and `UG`.`DELETED` = 0";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $id ] );
            $sql_result = database::runSelectQuery ( $sql_select, $sql_params );
            if ( !empty ( $sql_result ) )
                return boolval( $sql_result[0]["Role"] );
            return false;
        }

        /**
         * @param integer $id
         * @return bool
         */
        public function setUserSuperAdmin ( $id )
        {
            // Clear User Permissions
            $sql_delete = "DELETE FROM `users_permission` WHERE `USERID` = :ID";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $id ] );
            $sql_result = database::runDeleteQuery ( $sql_delete, $sql_params );

            // Insert records into table
            $sql_insert = "INSERT INTO `users_permission` ( `USERID`, `PERMISSIONID`, `PERMISSION_VAR`, `PERMISSION_VALUE` ) ";
            $sql_insert.= "SELECT :ID AS `USERID`, `P`.`ID`, `P`.`PHPVAR`, 1 AS `PERMISSION_VALUE` FROM `users_group` `P` ";
            $sql_insert.= "WHERE `P`.`PHPVAR` IN ( '" . implode ( '\',', array_keys ( $this->role_list["Super Admin"], 1, true ) ) . "' )";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $id ] );
            $sql_result = database::runInsertQuery ( $sql_insert, $sql_params, "ID" );
            if ( ! is_null( $sql_result ) )
                return true;
            return false;
        }

        /**
         * @param integer $id
         * @return bool
         */
        public function setUserAdmin ( $id )
        {
            // Clear User Permissions
            $sql_delete = "DELETE FROM `users_permission` WHERE `USERID` = :ID";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $id ] );
            $sql_result = database::runDeleteQuery ( $sql_delete, $sql_params );

            // Insert records into table
            $sql_insert = "INSERT INTO `users_permission` ( `USERID`, `PERMISSIONID`, `PERMISSION_VAR`, `PERMISSION_VALUE` ) ";
            $sql_insert.= "SELECT :ID AS `USERID`, `P`.`ID`, `P`.`PHPVAR`, 1 AS `PERMISSION_VALUE` FROM `users_group` `P` ";
            $sql_insert.= "WHERE `P`.`PHPVAR` IN ( '" . implode ( '\',', array_keys ( $this->role_list["Admin"], 1, true ) ) . "' )";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $id ] );
            $sql_result = database::runInsertQuery ( $sql_insert, $sql_params, "ID" );
            if ( ! is_null( $sql_result ) )
                return true;
            return false;
        }

        /**
         * @param integer $id
         * @return bool
         */
        public function setUserDataAnalyst ( $id )
        {
            // Clear User Permissions
            $sql_delete = "DELETE FROM `users_permission` WHERE `USERID` = :ID";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $id ] );
            $sql_result = database::runDeleteQuery ( $sql_delete, $sql_params );

            // Insert records into table
            $sql_insert = "INSERT INTO `users_permission` ( `USERID`, `PERMISSIONID`, `PERMISSION_VAR`, `PERMISSION_VALUE` ) ";
            $sql_insert.= "SELECT :ID AS `USERID`, `P`.`ID`, `P`.`PHPVAR`, 1 AS `PERMISSION_VALUE` FROM `users_group` `P` ";
            $sql_insert.= "WHERE `P`.`PHPVAR` IN ( '" . implode ( '\',', array_keys ( $this->role_list["Data Analyst"], 1, true ) ) . "' )";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $id ] );
            $sql_result = database::runInsertQuery ( $sql_insert, $sql_params, "ID" );
            if ( ! is_null( $sql_result ) )
                return true;
            return false;
        }

        /**
         * @param integer $id
         * @return bool
         */
        public function setUserAccountant ( $id )
        {
            // Clear User Permissions
            $sql_delete = "DELETE FROM `users_permission` WHERE `USERID` = :ID";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $id ] );
            $sql_result = database::runDeleteQuery ( $sql_delete, $sql_params );

            // Insert records into table
            $sql_insert = "INSERT INTO `users_permission` ( `USERID`, `PERMISSIONID`, `PERMISSION_VAR`, `PERMISSION_VALUE` ) ";
            $sql_insert.= "SELECT :ID AS `USERID`, `P`.`ID`, `P`.`PHPVAR`, 1 AS `PERMISSION_VALUE` FROM `users_group` `P` ";
            $sql_insert.= "WHERE `P`.`PHPVAR` IN ( '" . implode ( '\',', array_keys ( $this->role_list["Accountant"], 1, true ) ) . "' )";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $id ] );
            $sql_result = database::runInsertQuery ( $sql_insert, $sql_params, "ID" );
            if ( ! is_null( $sql_result ) )
                return true;
            return false;
        }

        /**
         * @param integer $id
         * @return bool
         */
        public function setUserPublic ( $id )
        {
            // Clear User Permissions
            $sql_delete = "DELETE FROM `users_permission` WHERE `USERID` = :ID";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $id ] );
            $sql_result = database::runDeleteQuery ( $sql_delete, $sql_params );

            // Insert records into table
            $sql_insert = "INSERT INTO `users_permission` ( `USERID`, `PERMISSIONID`, `PERMISSION_VAR`, `PERMISSION_VALUE` ) ";
            $sql_insert.= "SELECT :ID AS `USERID`, `P`.`ID`, `P`.`PHPVAR`, 1 AS `PERMISSION_VALUE` FROM `users_group` `P` ";
            $sql_insert.= "WHERE `P`.`PHPVAR` IN ( '" . implode ( '\',', array_keys ( $this->role_list["Public"], 1, true ) ) . "' )";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $id ] );
            $sql_result = database::runInsertQuery ( $sql_insert, $sql_params, "ID" );
            if ( ! is_null( $sql_result ) )
                return true;
            return false;
        }

    }