<?php

    // Set default time zone
    $GLOBALS ["TIME_ZONE"]      = env ( 'TIME_ZONE' );

    // Set global time zone
    date_default_timezone_set ( $GLOBALS ["TIME_ZONE"] );


    // Set database credentials
    $GLOBALS ["DB_HOST"]        = env( 'DB_HOST' );
    $GLOBALS ["DB_PORT"]        = env( 'DB_PORT' );
    $GLOBALS ["DB_NAME"]        = env( 'DB_NAME' );
    $GLOBALS ["DB_USER"]        = env( 'DB_USER' );
    $GLOBALS ["DB_PASS"]        = env( 'DB_PASS' );

    /*
     * @option ERRMODE_SILENT:      only error code is returned
     * @option ERRMODE_WARNING:     detailed warning is returned
     * @option ERRMODE_EXCEPTION    throws an exception
     */
    $GLOBALS ["PDO_ERROR"]      = \PDO::ERRMODE_EXCEPTION;


    // Set SMTP email credentials
    $GLOBALS ["MAIL_HOST"]      = env ( 'MAIL_HOST' );
    $GLOBALS ["MAIL_PORT"]      = env ( 'MAIL_PORT' );
    $GLOBALS ["MAIL_ENCRYPTION"]= env ( 'MAIL_ENCRYPTION' );
    $GLOBALS ["MAIL_USER"]      = env ( 'MAIL_USER' );
    $GLOBALS ["MAIL_PASS"]      = env ( 'MAIL_PASS' );

    // Support Email
    $GLOBALS ["MAIL_FROM"]      =
        [
            "address"   => env ( 'MAIL_FROM_ADDRESS' ),
            "name"      => env ( 'MAIL_FROM_NAME' )
        ];

    // Business info
    $GLOBALS ["BS_NAME"]        = env ( 'BS_NAME' );
    $GLOBALS ["BS_PHONE"]       = env ( 'BS_PHONE' );
    $GLOBALS ["BS_HOURS"]       = env ( 'BS_HOURS' );

    // Dev info
    $GLOBALS ["DEV_NAME"]       = env ( 'DEV_NAME' );
    $GLOBALS ["DEV_EMAIL"]      = env ( 'DEV_EMAIL' );
    $GLOBALS ["DEV_FOLDER"]     = '';


    // Off web root directory
    $GLOBALS ["OFF_WEB_ROOT"]   = "C:\\xampp\\apache\\secure";

    // Full link URL
    $GLOBALS ["RELATIVE_TO_ROOT"]       = "http://" . $_SERVER ["HTTP_HOST"] . $GLOBALS ["DEV_FOLDER"];

    // Full directory URL
    $GLOBALS ["RELATIVE_TO_DIRECTORY"]  = $_SERVER ["DOCUMENT_ROOT"] . $GLOBALS ["DEV_FOLDER"];


    // Cache location
    $GLOBALS ["CACHE_FOLDER"]   = $GLOBALS ["RELATIVE_TO_DIRECTORY"] . "/cache";


    // Server logs location
    $GLOBALS ["LOG_FOLDER"]     = $GLOBALS ["OFF_WEB_ROOT"] . "/serverLogs";

    // Enable or disable server logging
    $GLOBALS ["LOG_RECORDS"]    = false;


    // Error logs location
    $GLOBALS ["ERROR_FOLDER"]   = $GLOBALS ["OFF_WEB_ROOT"] . "/errorLogs";


    // Enable or disable custom error handler
    $GLOBALS ["ERROR_SYSTEM"]   = false;

    // Error queue location
    $GLOBALS ["ERROR_QUEUE"]    = $GLOBALS ["ERROR_FOLDER"] . "/e_queue.txt";

    // Error html folder
    $GLOBALS ["E_HTML_FOLDER"]  = $GLOBALS ["ERROR_FOLDER"] . "/html";

    // Generate html errors
    $GLOBALS ["E_HTML"]         = false;

    // Error xml folder
    $GLOBALS ["E_XML_FOLDER"]   = $GLOBALS ["ERROR_FOLDER"] . "/xml";

    // Generate xml errors
    $GLOBALS ["E_XML"]          = false;

    // Error throttle time interval ( must be at least 2 digits ) time in seconds
    $GLOBALS ["E_INTERVAL"]     = 300;


    // Set session timeout interval ( must at least be 2 digits ) time in minutes
    $GLOBALS ["S_TIMEOUT"]      = 200;

    // Set session location
    $GLOBALS ["S_PATH"]         = $GLOBALS ["OFF_WEB_ROOT"] . "/sessions";

    // Set how long session cookie lives after user closes their browser, time in seconds
    $GLOBALS ["S_COOKIE_LIFE"]  = 0;


    // Enable public registration
    $GLOBALS ["PUBLIC_REGISTER"]= true;

    // Set maximum login failed attempts
    $GLOBALS ["MAX_FAILED"]     = 5;

    // Set password-reset token expiration, time in minutes
    $GLOBALS ["TOKEN_EXPIRY"]   = 10;

    // Set password-reset allowed time interval, time in minutes
    $GLOBALS ["RESET_TIME"]     = 5;


    // Set robot machine authentication key
    $GLOBALS ["MACHINE_AUTH"]   = "VMiJhPgR43UWdnKXyPFH5E8";


    // Set encryption key
    $GLOBALS ["ENCRYPT_KEY"]    = "8aVpVPmepRvjSATCVeHCCHesrq9Qd9Ea";

    // Set encryption type
    $GLOBALS ["ENCRYPT_TYPE"]   = "aes-256-cbc";

    // Set encryption initialization vector
    $GLOBALS ["IV"]             = hex2bin ( "83b4002851ee81a226de34e6f9512cf4" );

 ?>