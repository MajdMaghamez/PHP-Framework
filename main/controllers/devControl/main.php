<?php namespace main\controllers\devControl;

    use main\models\Role;
    use main\controllers\Controller;
    use main\layouts\bootstrap\main as Template;

    class main extends Controller
    {
        protected $canAccess = true;

        /**
         * main constructor.
         * @throws \Exception
         */
        public function __construct ( )
        {
            session_auth ( );

            if ( ! Role::isSuperAdmin ( $_SESSION ["USER_ID"] ) )
            {
                $this->canAccess = false;
                setFlashMessage ( "Access Denied!", "You do not have permission to access this page.", 4 );
            }

        }

        /**
         * @return string
         */
        protected function renderPage ( )
        {
            $html    = "\t\t\t<div class=\"box\">\n";
            $html   .= "\t\t\t\t<div class=\"row\">\n";
            $html   .= "\t\t\t\t\t<div class=\"col\">\n";
            $html   .= "\t\t\t\t\t\t<p><i class=\"fas fa-database fa-lg\"></i> Database Tools</p>\n";
            $html   .= "\t\t\t\t\t\t<ul class=\"list-group\">\n";
            $html   .= "\t\t\t\t\t\t\t<a class=\"list-group-item list-group-item-action\" href=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/Dev/Database/System\">System Tables Management</a>\n";
            $html   .= "\t\t\t\t\t\t\t<a class=\"list-group-item list-group-item-action\" href=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/Dev/Database/Application\">Application Tables Management</a>\n";
            $html   .= "\t\t\t\t\t\t</ul>\n";
            $html   .= "\t\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t\t<div class=\"col\">\n";
            $html   .= "\t\t\t\t\t\t<p><i class=\"fas fa-cogs fa-lg\"></i> System Tools</p>\n";
            $html   .= "\t\t\t\t\t\t<ul class=\"list-group\">\n";
            $html   .= "\t\t\t\t\t\t\t<a class=\"list-group-item list-group-item-action\" href=\"\">Monitor Error System</a>\n";
            $html   .= "\t\t\t\t\t\t\t<a class=\"list-group-item list-group-item-action\" href=\"\">Monitor Caching System</a>\n";
            $html   .= "\t\t\t\t\t\t\t<a class=\"list-group-item list-group-item-action\" href=\"\">View Active Users</a>\n";
            $html   .= "\t\t\t\t\t\t</ul>\n";
            $html   .= "\t\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t\t<div class=\"col\">\n";
            $html   .= "\t\t\t\t\t\t<p><i class=\"fas fa-server fa-lg\"></i> Server Tools</p>\n";
            $html   .= "\t\t\t\t\t\t<ul class=\"list-group\">\n";
            $html   .= "\t\t\t\t\t\t\t<a class=\"list-group-item list-group-item-action\" href=\"\">Monitor CPU Usage</a>\n";
            $html   .= "\t\t\t\t\t\t\t<a class=\"list-group-item list-group-item-action\" href=\"\">Monitor Ram Usage</a>\n";
            $html   .= "\t\t\t\t\t\t</ul>\n";
            $html   .= "\t\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t</div>\n";

            return $html;
        }

        protected function onGet ( )
        {
            $layoutTemplate = new Template( trim ( basename ( __DIR__ ) ), trim ( basename ( __DIR__ ) ) );

            $html   = "<!DOCTYPE html>\n";
            $html   .= "<html lang=\"en\">\n";
            $html   .= "\t<head>\n";
            $html   .= $layoutTemplate->render_header ( [ "TITLE" => "Developer Main" ], ".page { margin-top: 15px; }" );
            $html   .= "\t</head>\n";
            $html   .= "\t<body>\n";
            $html   .= $layoutTemplate->render_navbar ( );
            $html   .= "\t\t<div class=\"container page\">\n";
            ( $this->canAccess ) ? $html .= $this->renderPage ( ) : $html .= flash_message( "\t\t\t" );
            $html   .= "\t\t</div>\n";
            $html   .= $layoutTemplate->render_footer ( array ( ) );
            $html   .= "\t</body>\n";
            $html   .= "</html>\n";

            echo $html;
        }

        protected function onPost()
        {
            $this->onGet();
        }
    }