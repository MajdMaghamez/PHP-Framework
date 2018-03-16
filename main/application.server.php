<?php

    // Enable php default error handler ( turn off when using custom handler )
    error_reporting ( E_ALL );

    // Enable or disable displaying errors ( enable is recommended )
    ini_set ( "display_errors", 1 );

    // Enable php to generate html error messages
    ini_set ( "html_errors", 0 );

    // Error log location
    ini_set ( "error_log", $GLOBALS["ERROR_FOLDER"] . "/Errors.log" );

    // Set the max size of log file, once the size reaches its limit, a new file will be generated
    ini_set ( "log_errors_max_len", 1024 );


    // Set session directory location
    ini_set ( "session.save_path", $GLOBALS ["S_PATH"] );

    // Set session garbage collection probability ( numerator )
    ini_set ( "session.gc_probability", 1 );

    // Set session garbage collection divisor ( denominator )
    ini_set ( "session.gc_divisor", 100 );

    // Set session life time ( when to be considered as a garbage collection item )
    ini_set ( "session.gc_maxlifetime", ( $GLOBALS ["S_TIMEOUT"] * 60 ) );

    // Disable session cookie from being accessed by JavaScript ( @param int 1 'disable' )
    ini_set ( "session.cookie_httponly", 1 );

?>