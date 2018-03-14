<?php
    use main\Router;
    require_once $_SERVER ["DOCUMENT_ROOT"] . "/application.php";
    Router::getApplicationRouter( )->handleRequest ( );
?>