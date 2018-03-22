<?php namespace main\frameworkHelper;

    class fieldsValidator
    {
        /**
         * @param $arrComponents
         * @return bool
         */
        public static function validate ( $arrComponents )
        {
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