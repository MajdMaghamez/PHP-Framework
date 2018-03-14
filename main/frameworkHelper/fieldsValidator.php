<?php namespace main\frameworkHelper;

    class fieldsValidator
    {
        /**
         * @param $arrComponents
         * @return bool
         */
        public static function validate ($arrComponents )
        {
            foreach ( $arrComponents as $row => $columns )
            {
                foreach ( $columns as $column => $gui )
                {
                    if ( method_exists ( $gui, "validate" ) )
                    {
                        if ( ! $gui->validate ( ) ) { return false; }
                    }
                }
            }
            return true;
        }
    }