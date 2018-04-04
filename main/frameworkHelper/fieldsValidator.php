<?php namespace main\frameworkHelper;

    class fieldsValidator
    {
        /**
         * @param $arrComponents
         * @return bool
         */
        public static function validate ( $arrComponents )
        {
            // validate honey Pot
            if ( isset ( $_POST ["username"] ) )
            {
                if ( ! empty( $_POST ["username"] ) )
                    return false;
            }

            // validate csrf token
            if ( ! isset ( $_POST ["csrf-token"] ) )
            {
                return false;
            }
            else
            {
                if ( $_POST ["csrf-token"] != $_SESSION ["CSRF_TOKEN"] )
                    return false;
            }

            foreach ( $arrComponents as $row => $columns )
            {
                foreach ( $columns as $column => $gui )
                {
                    $Parent = explode( "\\", get_parent_class ( $gui ) );
                    $gui_parent = end ( $Parent );

                    if ( $gui_parent == 'field' )
                    {
                        $gui->setValue ( $_POST [ $gui->getName( ) ] );

                        if ( ! $gui->validate ( ) ) { return false; }
                    }
                }
            }
            return true;
        }
    }