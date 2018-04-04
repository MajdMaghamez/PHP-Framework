<?php namespace main\frameworkHelper;

    class cacheManager
    {
        /**
         * cacheManager constructor.
         * @param string $folder
         * @param string $file
         */
        public function __construct ( $folder, $file )
        {
            if ( ! file_exists ( $folder ) ) { mkdir ( $folder, 0777, true ); }
            if ( ! file_exists ( $file ) ) { $this->cache_exists = false; } else { $this->cache_exists = true; }

            $this->folder   = $folder;
            $this->file     = $file;
        }

        /**
         * @return bool
         */
        public function isCacheExists ( )
        {
            return $this->cache_exists;
        }

        /**
         * @param bool $cache_exists
         */
        public function setCacheExists ( $cache_exists )
        {
            $this->cache_exists = $cache_exists;
        }

        /**
         * @return string
         */
        public function getFile ( )
        {
            return $this->file;
        }

        /**
         * @return string
         */
        public function getFolder ( )
        {
            return $this->folder;
        }

        /**
         * @param $arrComponents
         * @param array $extra_keys
         * @param array $extra_values
         * @return mixed
         *
         * @note this function return gui objects without their values
         */
        public function read ( $arrComponents, $extra_keys = array ( ), $extra_values = array ( ) )
        {
            $cached_page    = file_get_contents ( $this->getFile ( ) );
            $keys           = array ( );
            $values         = array ( );

            foreach ( $arrComponents as $row => $columns )
            {
                foreach ( $columns as $column => $gui )
                {
                    $Parent = explode ( "\\", get_parent_class ( $gui ) );
                    $gui_parent = end ( $Parent );

                    if ( $gui_parent == 'field' )
                    {
                        $Self = explode ( "\\", get_class ( $gui ) );
                        $gui_self = end ( $Self );

                        switch ( $gui_self )
                        {
                            case 'selectField':
                                // loop through the selected field options
                                foreach ( $gui->getOptions ( ) as $option => $text )
                                {
                                    array_push ( $keys, "{selected_" . $gui->getId ( ) . "_" . $option . "}" );
                                    array_push ( $values, "" );
                                }
                            break;

                            default:
                                array_push ( $keys, "{value_" . $gui->getId ( ) . "}" );
                                array_push ( $values, "" );
                            break;
                        }

                        array_push ( $keys, "{error_" . $gui->getId ( ) . "}" );
                        array_push ( $values, $gui->getError ( ) );
                    }
                }
            }

            if ( ! empty ( $extra_keys ) )
            {
                foreach ( $extra_keys as $key => $value )
                {
                    array_push ( $keys, $value );
                    array_push ( $values, $extra_values [$key] );
                }
            }

            array_push( $keys, "{value_csrf-token}" );
            array_push( $values, $_SESSION ["CSRF_TOKEN"] );

            return str_replace ( $keys, $values, $cached_page );
        }

        /**
         * @param array $arrComponents
         * @param array $extra_keys
         * @param array $extra_values
         * @return string
         *
         * @note this function return gui objects with their values
         */
        public function read_values ( $arrComponents, $extra_keys = array ( ), $extra_values = array ( ) )
        {
            $cached_page    = file_get_contents ( $this->getFile ( ) );
            $keys           = array ( );
            $values         = array ( );

            foreach ( $arrComponents as $row => $columns )
            {
                foreach ( $columns as $column => $gui )
                {
                    $Parent = explode ( "\\", get_parent_class ( $gui ) );
                    $gui_parent = end (  $Parent );

                    if ( $gui_parent == 'field' )
                    {
                        $Self   = explode ( "\\", get_class ( $gui ) );
                        $gui_self   = end ( $Self );

                        switch ( $gui_self )
                        {
                            case 'selectField':
                                // loop through the selected field options
                                foreach ( $gui->getOptions ( ) as $option => $text )
                                {
                                    array_push ( $keys, "{selected_" . $gui->getId ( ) . "_" . $option . "}" );
                                    if ( $gui->getValue ( ) == $option ) { array_push ( $values, "selected" ); }
                                    else { array_push ( $values, "" ); }
                                }
                            break;

                            default:
                                array_push ( $keys, "{value_" . $gui->getId ( ) . "}" );
                                array_push ( $values, $gui->getValue ( ) );
                            break;
                        }

                        array_push ( $keys, "{error_" . $gui->getId ( ) . "}" );
                        array_push ( $values, $gui->getError ( ) );
                    }
                }
            }

            if ( ! empty ( $extra_keys ) )
            {
                foreach ( $extra_keys as $key => $value )
                {
                    array_push ( $keys, $value );
                    array_push ( $values, $extra_values [$key] );
                }
            }

            array_push( $keys, "{value_csrf-token}" );
            array_push( $values, $_SESSION ["CSRF_TOKEN"] );

            return str_replace ( $keys, $values, $cached_page );
        }

        public function write ( $cache )
        {
            $cache_page = @fopen ( $this->getFile ( ), 'w' ) or die ( "error: unable to cache this page" );

            // lock the file
            if ( flock ( $cache_page, LOCK_EX ) )
            {
                ftruncate ( $cache_page, 0 );
                fwrite ( $cache_page, $cache );
                fflush ( $cache_page );
                flock ( $cache_page, LOCK_UN );
            }
            else
            {
                return false;
            }

            fclose ( $cache_page );

            return true;
        }
    }