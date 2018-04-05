<?php namespace main\controllers\devControl;

    use main\controllers\Controller;
    use main\layouts\bootstrap\main as Template;

    class main extends Controller
    {

        /**
         * main constructor.
         * @throws \Exception
         */
        public function __construct ( )
        {
            session_auth ( );
        }

        protected function onGet ( )
        {
            $layoutTemplate = new Template( trim ( basename ( __DIR__ ) ), trim ( basename ( __DIR__ ) ) );

            $html   = "<!DOCTYPE html>\n";
            $html   .= "<html lang=\"en\">\n";
            $html   .= "\t<head>\n";
            $html   .= $layoutTemplate->render_header ( [ "TITLE" => "Developer Main" ] );
            $html   .= "\t</head>\n";
            $html   .= "\t<body>\n";
            $html   .= $layoutTemplate->render_navbar ( );
            $html   .= "\t\t<div class=\"container\">\n";

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