<?php

    use main\storage\database;
    require_once $_SERVER ["DOCUMENT_ROOT"] . "/application.php";

    if ( ( isset ( $_GET ["RUN"] ) ) && ( sanitize_integer ( $_GET ["RUN"] ) == 1 ) )
    {
        if ( sanitize_string ( $_GET ["AUTH"] ) == $GLOBALS ["MACHINE_AUTH"] )
        {
            $results = database::createDatabase ( $GLOBALS ["DB_NAME"] );

            if ( $results )
            {
                $directory = array_slice ( scandir ( $GLOBALS ["RELATIVE_TO_DIRECTORY"] . "/main/storage/tables/" ), 2 );

                foreach ( $directory as $key => $value )
                {
                    $table = basename ( $GLOBALS ["RELATIVE_TO_DIRECTORY"] . "/main/storage/tables/" . $value, ".php" );
                    $class = "\\main\\storage\\tables\\" . $table;
                    $class = new $class ( );
                    $class->up ( );
                }

                echo "TABLES WERE CREATED SUCCESSFULLY, CHECK IF YOU NEED TO RUN SCRIPTS TO POPULATE TABLES WITH DATA;";
            }
            else
            {
                die ( "AUTHENTICATION FAILED!" );
            }
        }
        else
        {
            die ( "UNDEFINED METHOD" );
        }
    }

    // check if secure directory exists
    if ( ! file_exists ( $GLOBALS ["OFF_WEB_ROOT"] ) )
    {
        if ( ! mkdir ( $GLOBALS ["OFF_WEB_ROOT"], 0777, true ) )
        {
            die ( "error: cannot create web root folders" );
        }
    }

    // check if error directory exists
    if ( ! file_exists ( $GLOBALS ["ERROR_FOLDER"] ) )
    {
        if ( ! mkdir ( $GLOBALS ["ERROR_FOLDER"], 0777, true ) )
        {
            die ( "error: cannot create errors folder" );
        }
    }

    // check if html error directory exists
    if ( ! file_exists ( $GLOBALS ["E_HTML_FOLDER"] ) )
    {
        if ( ! mkdir ( $GLOBALS ["E_HTML_FOLDER"], 0777, true ) )
        {
            die ( "error: cannot create html errors folder" );
        }
    }

    // check if xml error directory exists
    if ( ! file_exists ( $GLOBALS ["E_XML_FOLDER"] ) )
    {
        if ( ! mkdir ( $GLOBALS ["E_XML_FOLDER"], 0777, true ) )
        {
            die ( "error: cannot create xml errors folder" );
        }
    }

    // check if log directory exists
    if ( ! file_exists ( $GLOBALS ["LOG_FOLDER"] ) )
    {
        if ( ! mkdir ( $GLOBALS ["LOG_FOLDER"], 0777, true ) )
        {
            die ( "error: cannot create log folder" );
        }
    }

    // check if cache directory exists
    if ( ! file_exists ( $GLOBALS ["CACHE_FOLDER"] ) )
    {
        if ( ! mkdir ( $GLOBALS ["CACHE_FOLDER"], 0777, true ) )
        {
            die ( "error: cannot create cache folder" );
        }
    }

    // check if session directory exists
    if ( ! file_exists ( $GLOBALS ["S_PATH"] ) )
    {
        if ( ! mkdir ( $GLOBALS ["S_PATH"], 0777, true ) )
        {
            die ( "error: cannot create session folder" );
        }
    }
?>