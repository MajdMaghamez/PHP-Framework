<?php namespace main\gui;

    class guiCreator
    {
        public $container   = array ( );

        /**
         * guiCreator constructor.
         * @param array $componentList
         * @param array $values
         */
        public function __construct ( $componentList )
        {
            foreach ( $componentList as $row => $columns )
            {
                $this->container [$row] = array ( );
                foreach ( $columns as $column => $items )
                {
                    // construct the class
                    $class = "\\main\\gui\\" . $items ["parent"] . "\\" . $items ["class"];

                    switch ( $items ["parent"] )
                    {
                        case "fields":  $object = new $class ( $items ["label"], $items ["name"], $items ["id"] );
                            if ( isset ( $_POST [$object->getId ( )] ) ) { $object->setValue ( $_POST [$object->getId ( )] ); }
                        break;
                        case "links":   $object = new $class ( $items ["href"], $items ["label"] );   break;
                        case "buttons": $object = new $class ( $items ["label"], $items ["id"], $items ["type"] ); break;
                        default:        $object = null; break;
                    }

                    foreach ( $items as $key => $value )
                    {
                        // set additional values
                        if ( preg_match ( "/\Aset[a-zA-Z]+/i", $key ) ) { $object->$key ( $value ); }
                    }

                    array_push ( $this->container [$row], $object );
                }
            }
        }

        /**
         * @return array
         */
        public function getContainer ( )
        {
            return $this->container;
        }
    }