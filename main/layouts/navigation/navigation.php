<?php namespace main\layouts\navigation;


    trait navigation
    {
        /**
         * @param string $active
         * @return array
         */
        public static function Home ( $active = '' )
        {
            return
            [
                "id"        => "Home",
                "title"		=> "Home",
                "active"	=> ( $active == 'homeControl' ) ? " active" : "",
                "icon"		=> "<i class=\"fas fa-home\" aria-hidden=\"true\"></i>",
                "link"		=> $GLOBALS ["RELATIVE_TO_ROOT"] . "/Home",
                "children"	=> array ( )
            ];
        }

        /**
         * @param string $active
         * @return array
         */
        public static function Reports ( $active = '' )
        {
            return
            [
                "id"        => "Reports",
                "title"     => "Reports",
                "active"    => ( $active == 'reportsControl' ) ? " active" : "",
                "icon"      => "<i class=\"fas fa-chart-bar\" aria-hidden=\"true\"></i>",
                "link"      => $GLOBALS ["RELATIVE_TO_ROOT"] . "/Reports",
                "children"  => array ( )
            ];
        }

        /**
         * @param string $active
         * @return array
         */
        public static function Statistics ( $active = '' )
        {
            return
            [
                "id"        => "Statistics",
                "title"     => "Statistics",
                "active"    => ( $active == 'statisticsControl' ) ? " active" : "",
                "icon"      => "<i class=\"fas fa-chart-pie\" aria-hidden=\"true\"></i>",
                "link"      => $GLOBALS ["RELATIVE_TO_ROOT"] . "/Statistics",
                "children"  => array ( )
            ];
        }

        /**
         * @param string $active
         * @return array
         */
        public static function Help ( $active = '' )
        {
            return
            [
                "id"        => "Help",
                "title"     => "Help",
                "active"    => ( $active == 'helpControl' ) ? " active" : "",
                "icon"      => "<i class=\"fa fa-question-circle\" aria-hidden=\"true\"></i>",
                "link"      => $GLOBALS ["RELATIVE_TO_ROOT"] . "/Help",
                "children"  => array ( )
            ];
        }

        /**
         * @param string $name
         * @param string $active
         * @return array
         */
        public static function User ( $name = '', $active = '' )
        {
            return
            [
                "id"        => "User",
                "title"     => $name,
                "active"    => ( $active == 'userControl' || $active == 'messagesControl' || $active == 'devControl' ) ? " active" : "",
                "icon"      => "",
                "link"      => $GLOBALS ["RELATIVE_TO_ROOT"] . "/User/Account",
                "children"  => array ( )
            ];
        }

        /**
         * @param string $active
         * @return array
         */
        public static function Developer ( $active = '' )
        {
            return
            [
                "id"        => "DevTools",
                "title"     => "Developer Tools",
                "active"    => ( $active == 'devControl' ) ? " active" : "",
                "icon"      => "<i class=\"fas fa-magic\" aria-hidden=\"true\"></i>",
                "link"      => $GLOBALS ["RELATIVE_TO_ROOT"] . "/Dev",
                "children"  => array ( )
            ];
        }

        /**
         * @param string $active
         * @return array
         */
        public static function MyAccount ( $active = '' )
        {
            return
            [
                "id"        => "MyAccount",
                "title"     => "My Account",
                "active"    => ( $active == 'userControl' ) ? " active" : "",
                "icon"      => "<i class=\"far fa-user\" aria-hidden=\"true\"></i>",
                "link"      => $GLOBALS ["RELATIVE_TO_ROOT"] . "/User/Account",
                "children"  => array ( )
            ];
        }

        /**
         * @param string $active
         * @return array
         */
        public static function Messages ( $active = '' )
        {
            return
            [
                "id"        => "Messages",
                "title"     => "Messages",
                "active"    => ( $active == 'messagesControl' ) ? " active" : "",
                "icon"      => "<i class=\"far fa-envelope-open\" aria-hidden=\"true\"></i>",
                "link"      => $GLOBALS ["RELATIVE_TO_ROOT"] . "/User/Messages",
                "children"  => array ( )
            ];
        }

        /**
         * @param string $active
         * @return array
         */
        public static function Logout ( $active = '' )
        {
            return
            [
                "id"        => "Logout",
                "title"     => "Logout",
                "active"    => "",
                "icon"      => "<i class=\"fas fa-sign-out-alt\" aria-hidden=\"true\"></i>",
                "link"      => $GLOBALS ["RELATIVE_TO_ROOT"] . "/Logout",
                "children"  => array ( )
            ];
        }

        /**
         * @param string $active
         * @return array
         */
        public static function Dashboard ( $active = '' )
        {
            return
            [
                "id"        => "Dashboard",
                "title"     => "Dashboard",
                "active"    => ( $active == 'homeControl' ) ? " active" : "",
                "icon"      => "",
                "link"      => $GLOBALS ["RELATIVE_TO_ROOT"] . "/Home",
                "children"  => array ( )
            ];
        }

        /**
         * @param string $active
         * @return array
         */
        public static function Users ( $active = '' )
        {
            return
            [
                "id"        => "Users",
                "title"     => "Users",
                "active"    => ( $active == 'usersControl' ) ? " active" : "",
                "icon"      => "",
                "link"      => $GLOBALS ["RELATIVE_TO_ROOT"] . "/Users/List",
                "children"  => array ( )
            ];
        }


        /**
         * @param string $user_name
         * @param string $active
         * @return array
         */
        public static function getSuperAdminNavigation ( $user_name, $active )
        {
            $main = array ( );
            array_push( $main, self::Home( $active ) );
            array_push( $main, self::Reports( $active ) );
            array_push( $main, self::Statistics( $active ) );
            array_push( $main, self::Help( $active ) );

            $user = self::User( $user_name, $active );
            array_push( $user["children"], self::Developer( $active ) );
            array_push( $user["children"], self::MyAccount( $active ) );
            array_push( $user["children"], self::Messages( $active ) );
            array_push( $user["children"], self::Logout( ) );

            array_push( $main, $user );

            return $main;
        }

        /**
         * @param string $active
         * @return array
         */
        public static function getSuperAdminSubNavigation ( $active )
        {
            $sub = array ( );
            array_push( $sub, self::Dashboard( $active ) );
            array_push( $sub, self::Users( $active ) );

            return $sub;
        }


        /**
         * @param string $user_name
         * @param string $active
         * @return array
         */
        public static function getAdminNavigation ( $user_name, $active )
        {
            $main = array ( );
            array_push( $main, self::Home( $active ) );
            array_push( $main, self::Reports( $active ) );
            array_push( $main, self::Statistics( $active ) );
            array_push( $main, self::Help( $active ) );

            $user = self::User( $user_name, $active );
            array_push( $user["children"], self::MyAccount( $active ) );
            array_push( $user["children"], self::Messages( $active ) );
            array_push( $user["children"], self::Logout( ) );

            array_push( $main, $user );

            return $main;
        }

        /**
         * @param string $active
         * @return array
         */
        public static function getAdminSubNavigation ( $active )
        {
            $sub = array ( );
            array_push( $sub, self::Dashboard( $active ) );
            array_push( $sub, self::Users( $active ) );

            return $sub;
        }


        /**
         * @param string $user_name
         * @param string $active
         * @return array
         */
        public static function getDataAnalystNavigation ( $user_name, $active )
        {
            $main = array ( );
            array_push( $main, self::Home( $active ) );
            array_push( $main, self::Statistics( $active ) );
            array_push( $main, self::Help( $active ) );

            $user = self::User( $user_name, $active );
            array_push( $user["children"], self::MyAccount( $active ) );
            array_push( $user["children"], self::Messages( $active ) );
            array_push( $user["children"], self::Logout( ) );

            array_push( $main, $user );

            return $main;
        }

        /**
         * @param string $active
         * @return array
         */
        public static function getDataAnalystSubNavigation ( $active )
        {
            $sub = array ( );
            array_push( $sub, self::Dashboard( $active ) );

            return $sub;
        }


        /**
         * @param string $user_name
         * @param string $active
         * @return array
         */
        public static function getUserNavigation ( $user_name, $active )
        {
            $main = array ( );
            array_push( $main, self::Home( $active ) );
            array_push( $main, self::Help( $active ) );

            $user = self::User( $user_name, $active );
            array_push( $user["children"], self::MyAccount( $active ) );
            array_push( $user["children"], self::Messages( $active ) );
            array_push( $user["children"], self::Logout( ) );

            array_push( $main, $user );

            return $main;
        }

        /**
         * @param string $active
         * @return array
         */
        public static function getUserSubNavigation ( $active )
        {
            $sub = array ( );
            array_push( $sub, self::Dashboard( $active ) );

            return $sub;
        }

    }