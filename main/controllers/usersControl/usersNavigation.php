<?php namespace main\controllers\usersControl;

    use main\storage\database;
    trait usersNavigation
    {
        /**
         * @return string
         */
        public static function renderNavigationLinks ( )
        {
            $tabs = "\t\t\t\t";
            $path = explode ( '\\', __CLASS__ );
            $path = array_pop ( $path );

            $navigation =
            [
                0 =>
                [
                    "label" => "Users List",
                    "href"  => $GLOBALS ["RELATIVE_TO_ROOT"] . "/Users/List",
                    "class" => ( $path == 'usersList' ) ? " active" : ""
                ],
                1 =>
                [
                    "label" => "Add Users",
                    "href"  => $GLOBALS ["RELATIVE_TO_ROOT"] . "/Users/Add",
                    "class" => ( $path == 'usersCreate' ) ? " active" : ""
                ]
            ];

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

        public static function renderListTableJS ( )
        {
            $url        = $GLOBALS ["RELATIVE_TO_ROOT"] . "/Users/List/";
            $JavaScript = <<<EOT

            \$('#users').dataTable ({
                'processing'    : true,
                'serverSide'    : true,
                'responsive'    : true,
                'lengthMenu'    : [ 5, 10, 25 ],
                'ajax'          :
                {
                    url     : '$url',
                    type    : 'POST'
                },
                'columns'       :
                [
                    {
                        'data'          : 0,
                        'render'        : function ( data, type, row ) { return data + ' '  + row [1]; },
                        'searchable'    : true,
                        'orderable'     : true
                    },
                    {
                        'data'          : 2,
                        'searchable'    : true,
                        'orderable'     : true
                    },
                    {
                        'data'          : 3,
                        'searchable'    : false,
                        'orderable'     : true
                    },
                    {
                        'data'          : 4,
                        'searchable'    : false,
                        'ordable'       : true
                    },
                    {
                        'data'          : 5,
                        'render'        : function ( data, type, row )
                        {
                            return  "<a href='" + data + "' class='margin-right-5'><i class='far fa-edit'></i></a>" +
                                    "<a href='" + row[6] + "'><i class='far fa-trash-alt'></i></a>";
                        },
                        'searchable'    : false,
                        'orderable'     : false
                    }
                ],
                'order'         : [[ 0, 'asc' ]]
            });
            
EOT;
            return $JavaScript;
        }

        /**
         * @return array
         */
        public static function getRoleList ( )
        {
            $sql_select = "SELECT `ID`, `PHPVAR` FROM `users_group` WHERE `ROLE` = 1 AND `DELETED` = 0";
            $sql_result = database::runSelectQuery ( $sql_select );
            return $sql_result;
        }
    }