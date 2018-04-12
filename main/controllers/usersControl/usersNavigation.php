<?php namespace main\controllers\usersControl;

    use main\storage\database;
    trait usersNavigation
    {

        /**
         * @param bool $canAccess
         * @param bool $canAdd
         * @param bool $canEdit
         * @return string
         */
        public static function renderNavigationLinks ( $canAccess, $canAdd, $canEdit )
        {
            $tabs = "\t\t\t\t";
            $path = explode ( '\\', __CLASS__ );
            $path = array_pop ( $path );

            $navigation = array ();

            if ( $canAccess )
                array_push ( $navigation, self::getViewButton ( $path ) );
            if ( $canAdd )
                array_push ( $navigation, self::getAddButton ( $path ) );
            if ( $canEdit && findInURL( 'Edit' ) )
                array_push ( $navigation, self::getEditButton ( $path ) );

            $html    = $tabs . "\t<div class=\"box\">\n";

            $html   .= $tabs . "\t\t<div class=\"nav flex-column nav-pills\" role=\"tablist\" aria-orientation=\"vertical\">\n";

            foreach ( $navigation as $link => $page )
            {
                $html .= $tabs . "\t\t\t<a class=\"nav-link" . $page ["class"] . "\" href=\"" . $page["href"] . "\">" . $page ["label"] . "</a>\n";
            }

            $html   .= $tabs . "\t\t</div>\n";

            $html   .= $tabs . "\t</div>\n";

            return $html;
        }

        /**
         * @param string $path
         * @return array
         */
        public static function getViewButton ( $path )
        {
            return
                [
                "label" => "Users List",
                "href"  => $GLOBALS ["RELATIVE_TO_ROOT"] . "/Users/List",
                "class" => ( $path == 'usersList' ) ? " active" : ""
                ];
        }

        /**
         * @param string $path
         * @return array
         */
        public static function getAddButton ( $path )
        {
            return
                [
                "label" => "Add Users",
                "href"  => $GLOBALS ["RELATIVE_TO_ROOT"] . "/Users/Add",
                "class" => ( $path == 'usersCreate' ) ? " active" : ""
                ];
        }

        /**
         * @param string $path
         * @return array
         */
        public static function getEditButton ( $path )
        {
            return
                [
                    "label" => "Edit Users",
                    "href"  => $GLOBALS ["RELATIVE_TO_ROOT"] . "/Users/Edit",
                    "class" => ( $path == 'usersEdit' ) ? " active" : ""
                ];
        }


        /**
         * @return string
         */
        public static function renderUsersDeleteModal ( )
        {
            $tabs   = "\t\t";

            $html    = $tabs . "\t<div class=\"modal fade\" id=\"DeleteUser\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"UserDeleteWindow\" aria-hidden=\"true\">\n";
            $html   .= $tabs . "\t\t<div class=\"modal-dialog\" role=\"document\">\n";
            $html   .= $tabs . "\t\t\t<div class=\"modal-content\">\n";
            $html   .= $tabs . "\t\t\t\t<div class=\"modal-header\">\n";
            $html   .= $tabs . "\t\t\t\t\t<h5 class=\"modal-title\" id=\"UserDeleteWindow\">Deleting User</h5>\n";
            $html   .= $tabs . "\t\t\t\t\t<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">\n";
            $html   .= $tabs . "\t\t\t\t\t\t<span aria-hidden=\"true\">&times;</span>\n";
            $html   .= $tabs . "\t\t\t\t\t</button>\n";
            $html   .= $tabs . "\t\t\t\t</div>\n";
            $html   .= $tabs . "\t\t\t\t<div class=\"modal-body\">\n";
            $html   .= $tabs . "\t\t\t\t\t<h5 class='center'>Are you sure you want to delete this user?</h5>\n";
            $html   .= $tabs . "\t\t\t\t</div>\n";
            $html   .= $tabs . "\t\t\t\t<div class=\"modal-footer\">\n";
            $html   .= $tabs . "\t\t\t\t\t<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancel</button>\n";
            $html   .= $tabs . "\t\t\t\t\t<button type=\"button\" id=\"delete\" class=\"btn btn-outline-danger btn-danger\">Yes, Delete</button>\n";
            $html   .= $tabs . "\t\t\t\t</div>\n";
            $html   .= $tabs . "\t\t\t</div>\n";
            $html   .= $tabs . "\t\t</div>\n";
            $html   .= $tabs . "\t</div>\n";

            return $html;
        }

        /**
         * @return array
         */
        public static function getRoleList ( )
        {
            $sql_select = "SELECT `ID`, `NAME` FROM `users_group` WHERE `ROLE` = 1 AND `DELETED` = 0";
            $sql_result = database::runSelectQuery ( $sql_select );
            return $sql_result;
        }

    }