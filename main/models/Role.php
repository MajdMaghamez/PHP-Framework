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

            $this->role_list ['SUPER_ADMIN'] =
            [
                'USER_VIEW'     => 1,
                'USER_ADD'      => 1,
                'USER_EDIT'     => 1,
                'USER_DELETE'   => 1
            ];

            $this->role_list ['ADMIN'] =
            [
                'USER_VIEW'     => 1,
                'USER_ADD'      => 1,
                'USER_EDIT'     => 1,
                'USER_DELETE'   => 1
            ];

            $this->role_list ['DATA_ANALYST'] =
            [
                'USER_VIEW'     => 1
            ];

            $this->role_list ['USER'] =
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
            return array_keys ( $this->role_list );
        }

        /**
         * @param mixed $role_list
         */
        public function setRoleList ( $role_list )
        {
            $this->role_list = $role_list;
        }

        /**
         * @return array
         */
        public static function getRoleListNames ( )
        {
            $sql_select = "SELECT `NAME` FROM `users_group` WHERE `ROLE` = 1 AND `DELETED` = 0";
            $sql_result = database::runSelectQuery($sql_select);
            if ( ! empty ( $sql_result ) )
                return $sql_result;
            return array ( );
        }

        /**
         * @param integer $roleId
         * @return string
         */
        public static function getRoleName ( $roleId )
        {
            $sql_select = "SELECT `NAME` FROM `users_group` WHERE `ID` = :ID AND `ROLE` = 1 AND `DELETED` = 0";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $roleId ] );
            $sql_result = database::runSelectQuery ( $sql_select, $sql_params );
            if ( ! empty ( $sql_result ) )
                return $sql_result[0]["NAME"];
            return '';
        }

        /**
         * @param integer $roleId
         * @return array ( name, description, and permissions list )
         */
        public function getRoleDetails ( $roleId )
        {
            $role = array ( );

            $sql_select = "SELECT `PHPVAR`, `NAME`, `DESCRIPTION` FROM `users_group` WHERE `ID` = :ID AND `ROLE` = 1 AND `DELETED` = 0";
            $sql_params = array ( ":ID" => ["TYPE" => "INT", "VALUE" => intval ( $roleId ) ] );
            $sql_result = database::runSelectQuery($sql_select, $sql_params);

            if ( ! empty ( $sql_result ) )
            {
                $role ["NAME"] = $sql_result[0]["NAME"];
                $role ["DESCRIPTION"] = $sql_result[0]["DESCRIPTION"];

                $sql_select = "SELECT `ID`, `NAME`, `DESCRIPTION` FROM `users_group` WHERE `PERMISSION` = 1 AND `DELETED` = 0 ";
                $sql_select.= "AND `PHPVAR` IN ( '" . implode( '\',\'', array_keys( $this->role_list [$sql_result[0]["PHPVAR"]], 1, true ) ) . "' )";
                $sql_result = database::runSelectQuery($sql_select);

                $role ["PERMISSIONS"] = $sql_result;
            }

            return $role;
        }


        /**
         * @param integer $UserId
         * @return bool
         */
        public static function isSuperAdmin ( $UserId )
        {
            $sql_select = "SELECT ( CASE `UG`.`PHPVAR` = 'SUPER_ADMIN' WHEN 1 THEN 1 ELSE 0 END ) AS `Role` ";
            $sql_select.= "FROM `users` `U` INNER JOIN `users_group` `UG` ON `UG`.`ID` = `U`.`ROLE` AND `UG`.`ROLE` = 1 ";
            $sql_select.= "WHERE `U`.`ID` = :ID AND `U`.`DELETED` = 0 and `UG`.`DELETED` = 0";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $UserId ] );
            $sql_result = database::runSelectQuery ( $sql_select, $sql_params );
            if ( !empty ( $sql_result ) )
                return boolval( $sql_result[0]["Role"] );
            return false;
        }

        /**
         * @param integer $UserId
         * @return bool
         */
        public static function isAdmin ( $UserId )
        {
            $sql_select = "SELECT ( CASE `UG`.`PHPVAR` = 'ADMIN' WHEN 1 THEN 1 ELSE 0 END ) AS `Role` ";
            $sql_select.= "FROM `users` `U` INNER JOIN `users_group` `UG` ON `UG`.`ID` = `U`.`ROLE` AND `UG`.`ROLE` = 1 ";
            $sql_select.= "WHERE `U`.`ID` = :ID AND `U`.`DELETED` = 0 and `UG`.`DELETED` = 0";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $UserId ] );
            $sql_result = database::runSelectQuery ( $sql_select, $sql_params );
            if ( !empty ( $sql_result ) )
                return boolval( $sql_result[0]["Role"] );
            return false;
        }

        /**
         * @param integer $UserId
         * @return bool
         */
        public static function isDataAnalyst ( $UserId )
        {
            $sql_select = "SELECT ( CASE `UG`.`PHPVAR` = 'DATA_ANALYST' WHEN 1 THEN 1 ELSE 0 END ) AS `Role` ";
            $sql_select.= "FROM `users` `U` INNER JOIN `users_group` `UG` ON `UG`.`ID` = `U`.`ROLE` AND `UG`.`ROLE` = 1 ";
            $sql_select.= "WHERE `U`.`ID` = :ID AND `U`.`DELETED` = 0 and `UG`.`DELETED` = 0";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $UserId ] );
            $sql_result = database::runSelectQuery ( $sql_select, $sql_params );
            if ( !empty ( $sql_result ) )
                return boolval( $sql_result[0]["Role"] );
            return false;
        }

        /**
         * @param integer $UserId
         * @return bool
         */
        public static function isUser ( $UserId )
        {
            $sql_select = "SELECT ( CASE `UG`.`PHPVAR` = 'USER' WHEN 1 THEN 1 ELSE 0 END ) AS `Role` ";
            $sql_select.= "FROM `users` `U` INNER JOIN `users_group` `UG` ON `UG`.`ID` = `U`.`ROLE` AND `UG`.`ROLE` = 1 ";
            $sql_select.= "WHERE `U`.`ID` = :ID AND `U`.`DELETED` = 0 and `UG`.`DELETED` = 0";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $UserId ] );
            $sql_result = database::runSelectQuery ( $sql_select, $sql_params );
            if ( !empty ( $sql_result ) )
                return boolval( $sql_result[0]["Role"] );
            return false;
        }


        /**
         * @param integer $UserId
         * @return bool
         */
        public function setSuperAdmin ( $UserId )
        {
            // Clear User Permissions
            $sql_delete = "DELETE FROM `users_permission` WHERE `USERID` = :ID";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $UserId ] );
            $sql_result = database::runDeleteQuery ( $sql_delete, $sql_params );

            // Insert records into table
            $sql_insert = "INSERT INTO `users_permission` ( `USERID`, `PERMISSIONID`, `PERMISSION_VAR`, `PERMISSION_VALUE` ) ";
            $sql_insert.= "SELECT :ID AS `USERID`, `P`.`ID`, `P`.`PHPVAR`, 1 AS `PERMISSION_VALUE` FROM `users_group` `P` ";
            $sql_insert.= "WHERE `P`.`PHPVAR` IN ( '" . implode ( '\',\'', array_keys ( $this->role_list["SUPER_ADMIN"], 1, true ) ) . "' )";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $UserId ] );
            $sql_result = database::runInsertQuery ( $sql_insert, $sql_params, "ID" );
            if ( ! is_null( $sql_result ) )
                return true;
            return false;
        }

        /**
         * @param integer $UserId
         * @return bool
         */
        public function setAdmin ( $UserId )
        {
            // Clear User Permissions
            $sql_delete = "DELETE FROM `users_permission` WHERE `USERID` = :ID";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $UserId ] );
            $sql_result = database::runDeleteQuery ( $sql_delete, $sql_params );

            // Insert records into table
            $sql_insert = "INSERT INTO `users_permission` ( `USERID`, `PERMISSIONID`, `PERMISSION_VAR`, `PERMISSION_VALUE` ) ";
            $sql_insert.= "SELECT :ID AS `USERID`, `P`.`ID`, `P`.`PHPVAR`, 1 AS `PERMISSION_VALUE` FROM `users_group` `P` ";
            $sql_insert.= "WHERE `P`.`PHPVAR` IN ( '" . implode ( '\',\'', array_keys ( $this->role_list["ADMIN"], 1, true ) ) . "' )";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $UserId ] );
            $sql_result = database::runInsertQuery ( $sql_insert, $sql_params, "ID" );
            if ( ! is_null( $sql_result ) )
                return true;
            return false;
        }

        /**
         * @param integer $UserId
         * @return bool
         */
        public function setDataAnalyst ( $UserId )
        {
            // Clear User Permissions
            $sql_delete = "DELETE FROM `users_permission` WHERE `USERID` = :ID";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $UserId ] );
            $sql_result = database::runDeleteQuery ( $sql_delete, $sql_params );

            // Insert records into table
            $sql_insert = "INSERT INTO `users_permission` ( `USERID`, `PERMISSIONID`, `PERMISSION_VAR`, `PERMISSION_VALUE` ) ";
            $sql_insert.= "SELECT :ID AS `USERID`, `P`.`ID`, `P`.`PHPVAR`, 1 AS `PERMISSION_VALUE` FROM `users_group` `P` ";
            $sql_insert.= "WHERE `P`.`PHPVAR` IN ( '" . implode ( '\',\'', array_keys ( $this->role_list["DATA_ANALYST"], 1, true ) ) . "' )";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $UserId ] );
            $sql_result = database::runInsertQuery ( $sql_insert, $sql_params, "ID" );
            if ( ! is_null( $sql_result ) )
                return true;
            return false;
        }

        /**
         * @param integer $UserId
         * @return bool
         */
        public function setUser ( $UserId )
        {
            // Clear User Permissions
            $sql_delete = "DELETE FROM `users_permission` WHERE `USERID` = :ID";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $UserId ] );
            $sql_result = database::runDeleteQuery ( $sql_delete, $sql_params );

            // Insert records into table
            $sql_insert = "INSERT INTO `users_permission` ( `USERID`, `PERMISSIONID`, `PERMISSION_VAR`, `PERMISSION_VALUE` ) ";
            $sql_insert.= "SELECT :ID AS `USERID`, `P`.`ID`, `P`.`PHPVAR`, 1 AS `PERMISSION_VALUE` FROM `users_group` `P` ";
            $sql_insert.= "WHERE `P`.`PHPVAR` IN ( '" . implode ( '\',\'', array_keys ( $this->role_list["USER"], 1, true ) ) . "' )";
            $sql_params = array ( ":ID" => [ "TYPE" => "INT", "VALUE" => $UserId ] );
            $sql_result = database::runInsertQuery ( $sql_insert, $sql_params, "ID" );
            if ( ! is_null( $sql_result ) )
                return true;
            return false;
        }

    }