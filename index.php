<?php
    use main\Router;
    require_once $_SERVER ["DOCUMENT_ROOT"] . "/vendor/autoload.php";
    Router::getApplicationRouter( )->handleRequest ( );
?>