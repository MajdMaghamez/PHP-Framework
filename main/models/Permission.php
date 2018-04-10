<?php namespace main\models;

    use main\storage\database;
    class Permission
    {
        protected $permission_list;

        /**
         * Permission constructor.
         */
        public function __construct ( )
        {
            $this->permission_list =
            [
                'USER_VIEW'     => 0,
                'USER_ADD'      => 0,
                'USER_EDIT'     => 0,
                'USER_DELETE'   => 0
            ];
        }

        /**
         * @return array
         */
        public function getPermissionList ( )
        {
            return $this->permission_list;
        }

        /**
         * @param array $permission_list
         */
        public function setPermissionList( $permission_list )
        {
            $this->permission_list = $permission_list;
        }

        /**
         * @param integer $id
         * @param string $perm_name
         * @param boolean $perm_value
         * @return boolean
         */
        public static function setUserPermission ( $id, $perm_name, $perm_value )
        {
            // Delete record
            $sql_delete = "DELETE FROM `users_permission` WHERE `USERID` = :ID AND `PERMISSION_VAR` = :PERMISSION_NAME";
            $sql_params = array
            (
                ":PERMISSION_NAME"  => [ "TYPE" => "STR", "VALUE" => $perm_name ],
                ":ID"               => [ "TYPE" => "INT", "VALUE" => $id ]
            );
            $sql_result = database::runDeleteQuery ( $sql_delete, $sql_params );

            // Insert record into table
            $sql_insert = "INSERT INTO `users_permission` ( `USERID`, `PERMISSIONID`, `PERMISSION_VAR`, `PERMISSION_VALUE` ) ";
            $sql_insert.= "SELECT :ID AS `USERID`, `P`.`ID`, `P`.`PHPVAR`, :PERMISSION_VALUE AS `PERMISSION_VALUE` FROM `users_group` `P` ";
            $sql_insert.= "WHERE `P`.`PHPVAR` = :PERMISSION_NAME AND `P`.`PERMISSION` = 1 AND `DELETED` = 0";
            $sql_params = array
            (
                ":PERMISSION_VALUE" => [ "TYPE" => "INT", "VALUE" => intval($perm_value) ],
                ":PERMISSION_NAME"  => [ "TYPE" => "STR", "VALUE" => $perm_name ],
                ":ID"               => [ "TYPE" => "INT", "VALUE" => $id ]
            );
            $sql_result = database::runInsertQuery ( $sql_insert, $sql_params, "ID" );

            if ( ! is_null ( $sql_result ) )
                return true;
            return false;
        }

        /**
         * @param integer $id
         * @param string $perm_name
         * @return boolean
         */
        public static function getUserPermission ( $id, $perm_name )
        {
            $sql_select = "SELECT `PERMISSION_VALUE` FROM `users_permission` WHERE `USERID` = :ID AND `PERMISSION_VAR` = :PERMISSION_NAME";
            $sql_params = array
            (
                ":PERMISSION_NAME"  => [ "TYPE" => "STR", "VALUE" => $perm_name ],
                ":ID"               => [ "TYPE" => "INT", "VALUE" => $id ]
            );
            $sql_result = database::runSelectQuery ( $sql_select, $sql_params );
            if ( !empty ( $sql_result ) )
                return boolval( $sql_result [0]["PERMISSION_VALUE"] );
            return false;
        }
    }

