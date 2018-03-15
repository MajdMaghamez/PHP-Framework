<?php

    // Get the time of request start
    $_REQUEST ["ON_REQUEST_START"] = microtime ( true );

    // Include application configuration values
    require_once $_SERVER ["DOCUMENT_ROOT"] . "/application.config.php";

    // Include application server override values
    require_once $_SERVER ["DOCUMENT_ROOT"] . "/application.server.php";

    // Global variables
    $_REQUEST ["ALERT_HEAD"]    = "";
    $_REQUEST ["ALERT_TYPE"]    = "";
    $_REQUEST ["ALERT_MSG"]     = "";

    // Class autoloader
    spl_autoload_register ( function ( $class ) {
        require_once ltrim ( $GLOBALS ["DEV_FOLDER"] . "/", "/" ) . str_replace ( "\\", "/", $class ) . ".php";
    } );

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function env ( $key, $default = '' )
    {
        $conf = fopen( __DIR__ . "/.env", 'r' );
        if ( $conf )
        {
            while ( ( $line = fgets( $conf ) ) !== false )
            {
                $var = explode( '=', $line );
                if ( $var [0] == $key )
                {
                    if ( ! empty ( $default ) )
                        return $default;
                    return trim( $var [1]);
                }
            }
        }
        fflush( $conf );
        fclose( $conf );

        return null;
    }

    /**
     * @param $string
     * @return string
     */
    function encrypt ( $string )
    {
        // check if encryption type is supported by the server
        if ( in_array ( $GLOBALS ["ENCRYPT_TYPE"], openssl_get_cipher_methods ( ) ) )
        {
            return openssl_encrypt ( $string, $GLOBALS ["ENCRYPT_TYPE"], $GLOBALS ["ENCRYPT_KEY"], 0, $GLOBALS ["IV"] );
        }
        die ( "error: could not encrypt" );
    }

    /**
     * @param $string
     * @return string
     */
    function decrypt ( $string )
    {
        // check if decryption type is supported by the server
        if ( in_array ( $GLOBALS ["ENCRYPT_TYPE"], openssl_get_cipher_methods ( ) ) )
        {
            return openssl_decrypt ( $string, $GLOBALS ["ENCRYPT_TYPE"], $GLOBALS ["ENCRYPT_KEY"], 0, $GLOBALS ["IV"] );
        }
        die ( "error: could not decrypt" );
    }

    /**
     * @param $password
     * @return bool|string
     */
    function password ($password )
    {
        return password_hash ( $password, PASSWORD_DEFAULT );
    }


    /**
     * @param string $url
     * @return string
     */
    function base64urlEncode ($url )
    {
        return rtrim ( strtr ( base64_encode ( $url ), '+/', '-_' ), '=' );
    }

    /**
     * @param string $url
     * @return bool|string
     */
    function base64urlDecode ($url )
    {
        return base64_decode ( str_pad ( strtr ( $url, '-_', '+/' ), strlen ( $url ) % 4, '=', STR_PAD_RIGHT ) );
    }


    /**
     * @param $string
     * @return mixed|string
     */
    function sanitize_string ( $string )
    {
        $string = trim ( $string );
        $string = stripcslashes ( $string );
        $string = htmlspecialchars ( $string );
        $string = filter_var ( $string, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW );
        $string = filter_var ( $string, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH );
        return $string;
    }

    /**
     * @param $integer
     * @return mixed|string
     */
    function sanitize_integer ( $integer )
    {
        $integer = trim ( $integer );
        $integer = stripslashes ( $integer );
        $integer = htmlspecialchars ( $integer );
        $integer = filter_var ( $integer, FILTER_SANITIZE_NUMBER_INT );
        return $integer;
    }

    /**
     * @param $email
     * @return mixed|string
     */
    function sanitize_email ( $email )
    {
        $email = trim ( $email );
        $email = stripslashes ( $email );
        $email = htmlspecialchars ( $email );
        $email = filter_var ( $email, FILTER_SANITIZE_EMAIL );
        $email = strtolower ( $email );
        return $email;
    }


    /**
     * @return bool
     */
    function defineApplicationVariables ( )
    {
        // clear the cache folder
        $cache_directory = array_slice ( scandir ( $GLOBALS ["CACHE_FOLDER"] ), 2 );
        foreach ( $cache_directory as $index => $folder )
        {
            if ( $folder !== 'images' )
            {
                array_map ( 'unlink', glob ( $GLOBALS ["CACHE_FOLDER"] . "/" . $folder . "/*.html" ) );
                rmdir ( $GLOBALS ["CACHE_FOLDER"] . "/" . $folder );
            }
        }

        // clear the error queue
        $file_handler = @fopen ( $GLOBALS ["ERROR_QUEUE"], "w+" );
        @ftruncate ( $file_handler, 0 );
        @fwrite ( $file_handler, serialize ( ARRAY ( ) ) );
        @fflush ( $file_handler );
        @fclose ( $file_handler );

        return true;
    }

    if ( isset ( $_GET ["RedefineApplicationVariables"] ) )
    {
        defineApplicationVariables ( );
        echo "<script type='text/javascript'>alert ( 'Application variables has been redefined!' );</script>";
    }

    if ( $GLOBALS ["ERROR_SYSTEM"] )
    {
        set_error_handler ( function ( $number, $message, $filename, $line, $variable ) {

        });
    }

    /**
     * @param string $tabs
     * @return string html
     */
    function flash_message ($tabs = "" )
    {
        if ( ! empty ( $_REQUEST ["ALERT_MSG"] ) )
        {
            $alert = new \main\gui\alerts\alert ( $_REQUEST ["ALERT_HEAD"], $_REQUEST ["ALERT_MSG"], $_REQUEST ["ALERT_TYPE"] );
            $alert->setDismiss ( true );
            $alert->setTabs ( $tabs );
            return $alert->renderBootstrap ( );
        }
        return "";
    }

    /**
     * @param bool $public
     * @throws Exception
     */
    function session_auth ($public = false )
    {
        session_start ( );
        session_regenerate_id ( true );
        setcookie ( session_name ( ), session_id ( ), $GLOBALS ["S_COOKIE_LIFE"], '/' );

        if ( isset ( $_SESSION ["TIMEOUT"] ) )
        {
            $current    = new \DateTime ( 'now', new \DateTimeZone ( $GLOBALS ["TIME_ZONE"] ) );
            $session    = new \DateTime ( $_SESSION ["TIMEOUT"], new \DateTimeZone ( $GLOBALS ["TIME_ZONE"] ) );

            if ( $session < $current )
            {
                header ( "location:" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/logout.php?timeout=true" ); exit ( );
            }
            else
            {
                unset ( $_SESSION ["TIMEOUT"] );
                $session = $current->add ( new \DateInterval ( 'PT' . $GLOBALS ["S_TIMEOUT"] . 'M' ) );
                $_SESSION ["TIMEOUT"] = $session->format ( "Y-m-d H:i:s" );

                if ( $public )
                {
                    header ( "location:" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/views/index.php" ); exit ( );
                }
            }

            unset ( $session );
            unset ( $current );
        }
        else
        {
            if ( $public )
            {
                session_unset ( );
                if ( session_destroy ( ) )
                {
                    session_write_close ( );
                    setcookie ( session_name ( ), '', 0, '/' );
                }
            }
            else
            {
                header ( "location:" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/logout.php" ); exit ( );
            }
        }
    }


    /**
     * @return string
     */
    function get_ip ( )
    {
        if          ( isset ( $_SERVER["HTTP_CLIENT_IP"] ) )        return $_SERVER["HTTP_CLIENT_IP"];
        else if     ( isset ( $_SERVER["HTTP_X_FORWARDED_FOR"] ) )  return $_SERVER["HTTP_X_FORWARDED_FOR"];
        else if     ( isset ( $_SERVER["HTTP_X_FORWARDED"] ) )      return $_SERVER["HTTP_X_FORWARDED"];
        else if     ( isset ( $_SERVER["HTTP_FORWARDED_FOR"] ) )    return $_SERVER["HTTP_FORWARDED_FOR"];
        else if     ( isset ( $_SERVER["HTTP_FORWARDED"] ) )        return $_SERVER["HTTP_FORWARDED"];
        else if     ( isset ( $_SERVER["REMOTE_ADDR"] ) )           return $_SERVER["REMOTE_ADDR"];
        else                                                        return "unknown";
    }

    /**
     * @return string
     */
    function get_client_browser ( )
    {
        $agent = $_SERVER ["HTTP_USER_AGENT"];

        if      ( strpos ( $agent, "Opera" ) || strpos ( $agent,"OPR/" ) ) return "Opera";
        else if ( strpos ( $agent, "Edge" ) ) return "Edge";
        else if ( strpos ( $agent, "Chrome" ) ) return "Chrome";
        else if ( strpos ( $agent, "Safari" ) ) return "Safari";
        else if ( strpos ( $agent, "Firefox" ) ) return "Firefox";
        else if ( strpos ( $agent, "MSIE" ) || strpos ( $agent, "Trident/7" ) ) return "Internet Explorer";
        else return "unknown";
    }

    /**
     * @return int|string
     */
    function get_os ( )
    {
        $agent = $_SERVER ["HTTP_USER_AGENT"];
        $operating_systems = array
        (
            'Android'           => 'Android',
            'iPhone'            => 'iPhone',
            'iPod'              => 'iPod',
            'iPad'              => 'iPad',
            'BlackBerry'        => 'BlackBerry',
            'Windows 3.11'      => 'Win16',
            'Windows 95'        => '(Windows 95)|(Win95)|(Windows_95)',
            'Windows 98'        => '(Windows 98)|(Win98)',
            'Windows 2000'      => '(Windows NT 5.0)|(Windows 2000)',
            'Windows XP'        => '(Windows NT 5.1)|(Windows XP)',
            'Windows 2003'      => '(Windows NT 5.2)',
            'Windows Vista'     => '(Windows NT 6.0)|(Windows Vista)',
            'Windows 7'         => '(Windows NT 6.1)|(Windows 7)',
            'Windows 8'         => '(Windows NT 6.2)|(Windows 8)',
            'Windows 8.1'       => '(Windows NT 6.3)|(Windows 8.1)',
            'Windows 10'        => '(Windows NT 10)|(Windows 10)',
            'Windows NT 4.0'    => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
            'Windows ME'        => 'Windows ME',
            'Open BSD'          => 'OpenBSD',
            'Sun OS'            => 'SunOS',
            'Mac OS X'          => 'Macintosh|Mac OS X',
            'Mac OS'            => 'Mac_PowerPC',
            'Ubuntu'            => 'ubuntu',
            'Linux'             => '(Linux)|(X11)',
            'QNX'               => 'QNX',
            'BeOS'              => 'BeOS',
            'OS/2'              => 'OS/2',
            'Search Bot'        => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)'
        );

        foreach ( $operating_systems as $index => $item )
        {
            if ( preg_match ( '@'. $item . '@', $agent ) ) return $index;
        }

        return "unknown";
    }

    register_shutdown_function ( function ( ) {
        $end_time   = microtime ( true );
        $elapsed    = $end_time - $_REQUEST ["ON_REQUEST_START"];
        $short_url  = strtok ( $_SERVER ["REQUEST_URI"], '?' );
        $log        = array
        (
            $GLOBALS ["BS_NAME"],
            $short_url,
            $_SERVER ["REQUEST_URI"],
            $elapsed,
            date ( "m-d-Y h:i:s a" ),
            get_ip ( ),
            get_client_browser ( ),
            get_os ( )
        );

        if ( $GLOBALS ["LOG_RECORDS"] )
        {
            $file_handler = @fopen ( $GLOBALS ["LOG_FOLDER"] . "/serverLog_" . date ( "F_Y" ) . "csv", "a" );
            fputcsv ( $file_handler, $log );
            @fflush ( $file_handler );
            @fclose ( $file_handler );
        }
    } );

    //echo "<a href=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/main/storage/firstLoad.php?RUN=1&AUTH=VMiJhPgR43UWdnKXyPFH5E8" . "\">create database and necessary tables for application to run</a>";
?>
