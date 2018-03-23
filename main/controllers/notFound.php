<?php namespace main\controllers;

    use main\layouts\bootstrap\main;
    class notFound extends Controller
    {
        protected function onGet()
        {
            $layoutTemplate = new main ( );
            $html   = "<!DOCTYPE html>\n";
            $html   .= "<html lang=\"en\">\n";
            $html   .= "\t<head>\n";
            $html   .= $layoutTemplate->render_header ( [ "TITLE" => "404 Page Not Found"], ".notFound { margin-top: 15%; } .header { font-size:200px; }" );
            $html   .= "\t</head>\n";
            $html   .= "\t<body>\n";
            $html   .= "\t\t<div class=\"container\">\n";
            $html   .= "\t\t\t<div class=\"row justify-content-center align-items-center\">\n";
            $html   .= "\t\t\t\t<div class=\"col-md-6 col-lg-6 col-xl-6 notFound center\">\n";
            $html   .= "\t\t\t\t\t<h1 class=\"header\">404</h1>\n";
            $html   .= "\t\t\t\t\t<h1>Page Not Found <i class=\"fas fa-exclamation\"></i></h1>\n";
            $html   .= "\t\t\t\t\t<p>The page you have requested cannot be found.</p>\n";
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t</div>\n";
            $html   .= "\t\t</div>\n";
            $html   .= $layoutTemplate->render_footer ( array ( ) );
            $html   .= "\t</body>\n";
            $html   .= "</html>\n";

            echo $html;
        }

        protected function onPost()
        {
            // TODO: Implement onPost() method.
        }
    }