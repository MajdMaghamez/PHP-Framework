<?php namespace main\controllers\authControl;

    use main\controllers\Controller;

    class LogoutController extends Controller
    {
        protected function onGet()
        {
            session_start ( );
            session_unset ( );

            if ( session_destroy ( ) )
            {
                session_write_close ( );
                setcookie ( session_name ( ), '', 0, '/', $_SERVER ["HTTP_HOST"], $GLOBALS ["SECURE"], true );

                if ( findInURL( 'TimedOut' ) )
                {
                    redirect ( $GLOBALS ["RELATIVE_TO_ROOT"] . "/Login/TimedOut" );
                }

                redirect ( $GLOBALS ["RELATIVE_TO_ROOT"] . "/Login" );
            }
        }

        protected function onPost()
        {
            $this->onGet();
        }

    }