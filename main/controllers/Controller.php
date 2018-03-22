<?php namespace main\controllers;

    abstract class Controller
    {
        private $supportedMethods = [ 'GET', 'POST' ];

        public function onRequestStart ( )
        {
            $method = $_SERVER["REQUEST_METHOD"];
            if ( in_array ( $method, $this->supportedMethods, true ) )
            {
                $method = "on" . ucfirst ( strtolower( $method ) );
                $this->$method ( );
            }
            else
            {
                die ( "Unsupported Request! " );
            }
        }

        abstract protected function onGet ( );

        abstract protected function onPost ( );
    }