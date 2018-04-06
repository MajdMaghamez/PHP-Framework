<?php namespace main\controllers;

    use main\storage\database;
    use main\layouts\bootstrap\main;

    class init extends Controller
    {
        protected $errors = false;

        /**
         * init constructor.
         * @throws \Exception
         */
        public function __construct()
        {
            session_auth ( true );

            if ( ! findInURL ( 'RUN' ) )
            {
                setFlashMessage ( "UNDEFINED METHOD!", "", 4 );
                $this->errors = true;
            }

            if ( ! findInURL ( 'AUTH' ) )
            {
                setFlashMessage ( "UNDEFINED AUTHENTICATION TOKEN!", "", 4 );
                $this->errors = true;
            }
        }

        protected function onGet()
        {
            $layoutTemplate = new main ( );

            $html = "<!DOCTYPE html>\n";
            $html .= "<html lang=\"en\">\n";
            $html .= "\t<head>\n";
            $html .= $layoutTemplate->render_header(["TITLE" => "Application Helper"], ".page { margin-top: 25px; }" );
            $html .= "\t</head>\n";
            $html .= "\t<body>\n";
            $html .= "\t\t<div class=\"container page\">\n";
            $html .= "\t\t\t<div class=\"row justify-content-center\">\n";
            $html .= "\t\t\t\t<div class=\"col-sm-12 col-md-8 col-lg-8 col-xl-8\">\n";
            $html .= flash_message ( "\t\t\t\t\t" );
            $html .= "\t\t\t\t\t<div class=\"box\">\n";
            $html .= $this->process ( );
            $html .= "\t\t\t\t\t</div>\n";
            $html .= "\t\t\t\t</div>\n";
            $html .= "\t\t\t</div>\n";
            $html .= "\t\t</div>\n";
            $html .= $layoutTemplate->render_footer(array());
            $html .= "\t</body>\n";
            $html .= "</html>\n";

            echo $html;
        }

        protected function onPost()
        {
            $this->onGet();
        }

        /**
         * @return string
         */
        protected function process ( )
        {
            if ( $this->errors ) { return ""; }

            $RESULTS = "";
            $RedirectLink = "<a class=\"btn btn-info\" href=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/Login\">Back To Main Page</a>\n";
            $URL = getURLParams ( );

            ! is_null ( findInURL( 'RUN' ) ) ? $RUN = findInURL('RUN' ) + 1 : $RUN = 0;
            ! is_null ( findInURL( 'AUTH' ) )? $AUTH= findInURL( 'AUTH' ) + 1 : $AUTH = 0;

            if ( sanitize_string ( $URL[$AUTH] ) == $GLOBALS ["MACHINE_AUTH"] )
            {
                if ( sanitize_integer ( $URL[$RUN] ) == 1 )
                {
                    $results = database::createDatabase ( $GLOBALS ["DB_NAME"] );

                    if ( $results )
                    {
                        $tables = array_slice ( scandir ( $GLOBALS ["RELATIVE_TO_DIRECTORY"] . "/main/storage/tables/" ), 2 );

                        foreach ( $tables as $key => $value )
                        {
                            $table  = basename ( $GLOBALS ["RELATIVE_TO_DIRECTORY"] . "/main/storage/tables/" . $value, ".php" );
                            $class  = "\\main\\storage\\tables\\" . $table;
                            $class  = new $class ( );
                            $class->up ( );
                        }

                        $seeds = array_slice ( scandir ( $GLOBALS ["RELATIVE_TO_DIRECTORY"] . "/main/storage/seeds/" ), 2 );

                        foreach ( $seeds as $key => $value )
                        {
                            $seed   = basename ( $GLOBALS ["RELATIVE_TO_DIRECTORY"] . "/main/storage/seeds/" . $value, ".php" );
                            $class  = "\\main\\storage\\seeds\\" . $seed;
                            $class  = new $class;
                            $class->seed ( );
                        }

                        $RESULTS .= "<h4>All tables were created & seeded successfully!</h4><hr/><p>" . $RedirectLink . "</p>\n";
                    }
                }
                elseif ( sanitize_integer ( $URL[$RUN] ) == 2 )
                {
                    // clear the cache folder
                    $cache_directory = array_slice ( scandir ( $GLOBALS ["CACHE_FOLDER"] ), 2 );
                    foreach ( $cache_directory as $index => $folder )
                    {
                        if ( $folder !== 'users' )
                        {
                            array_map ( 'unlink', glob ( $GLOBALS ["CACHE_FOLDER"] . "/" . $folder . "/*.html" ) );
                            rmdir ( $GLOBALS ["CACHE_FOLDER"] . "/" . $folder );
                        }

                    }

                    echo "<script type='text/javascript'>alert ( 'APPLICATION CACHE HAS BEEN CLEARED!' );</script>";
                    $RESULTS .= "<h4>Application cache directory has been cleared!</h4><hr/><p>" . $RedirectLink . "</p>\n";
                }
            }
            else
            {
                $RESULTS .= "<h4>FAILED TO AUTHENTICATE!</h4>\n";
            }

            // check if secure directory exists
            if ( ! file_exists ( $GLOBALS ["OFF_WEB_ROOT"] ) )
            {
                if ( ! mkdir ( $GLOBALS ["OFF_WEB_ROOT"], 0777, true ) )
                {
                    $RESULTS .= "<h4>Error: cannot create web root folders</h4>\n";
                }
            }

            // check if error directory exists
            if ( ! file_exists ( $GLOBALS ["ERROR_FOLDER"] ) )
            {
                if ( ! mkdir ( $GLOBALS ["ERROR_FOLDER"], 0777, true ) )
                {
                    $RESULTS .= "<h4>Error: cannot create errors folder</h4>\n";
                }
            }

            // check if html error directory exists
            if ( ! file_exists ( $GLOBALS ["E_HTML_FOLDER"] ) )
            {
                if ( ! mkdir ( $GLOBALS ["E_HTML_FOLDER"], 0777, true ) )
                {
                    $RESULTS .= "<h4>Error: cannot create html errors folder</h4>\n";
                }
            }

            // check if xml error directory exists
            if ( ! file_exists ( $GLOBALS ["E_XML_FOLDER"] ) )
            {
                if ( ! mkdir ( $GLOBALS ["E_XML_FOLDER"], 0777, true ) )
                {
                    $RESULTS .= "<h4>Error: cannot create xml errors folder</h4>\n";
                }
            }

            // check if log directory exists
            if ( ! file_exists ( $GLOBALS ["LOG_FOLDER"] ) )
            {
                if ( ! mkdir ( $GLOBALS ["LOG_FOLDER"], 0777, true ) )
                {
                    $RESULTS .= "<h4>Error: cannot create log folder</h4>\n";
                }
            }

            // check if cache directory exists
            if ( ! file_exists ( $GLOBALS ["CACHE_FOLDER"] ) )
            {
                if ( ! mkdir ( $GLOBALS ["CACHE_FOLDER"], 0777, true ) )
                {
                    $RESULTS .= "<h4>Error: cannot create cache folder</h4>\n";
                }
            }

            // check if session directory exists
            if ( ! file_exists ( $GLOBALS ["S_PATH"] ) )
            {
                if ( ! mkdir ( $GLOBALS ["S_PATH"], 0777, true ) )
                {
                    $RESULTS .= "<h4>Error: cannot create session folder</h4>\n";
                }
            }

            // check if users pictures directory exists
            if ( ! file_exists ( $GLOBALS ["CACHE_FOLDER"] . "/users/" ) )
            {
                if ( ! mkdir ( $GLOBALS ["CACHE_FOLDER"] . "/users/", 0777, true ) )
                {
                    $RESULTS .= "<h4>Error: cannot create users cache directory</h4>\n";
                }
                else
                {
                    file_put_contents ( $GLOBALS ["CACHE_FOLDER"] . "/users/.htaccess", "RewriteEngine off\nOptions -Indexes\n", LOCK_EX );
                }
            }

            return $RESULTS;
        }
    }