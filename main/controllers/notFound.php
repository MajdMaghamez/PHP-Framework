<?php namespace main\controllers;

    class notFound extends Controller
    {
        protected function onGet()
        {
            http_response_code (404 );
            redirect( '/404.html' );
        }

        protected function onPost()
        {
            http_response_code( 404 );
            redirect( '/404.html' );
        }
    }