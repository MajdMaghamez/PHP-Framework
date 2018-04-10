<?php namespace main\controllers\devControl\databaseControl;

    use main\models\Role;
    use main\layouts\bootstrap\main;
    use main\controllers\Controller;

    class application extends Controller
    {
        protected $canAccess = true;

        /**
         * application constructor.
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
            $html    = "\t\t\t<nav aria-label=\"breadcrumb\">\n";
            $html   .= "\t\t\t\t<ol class=\"breadcrumb\">\n";
            $html   .= "\t\t\t\t\t<li class=\"breadcrumb-item\"><a href=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/Dev\">Developer Tools</a></li>\n";
            $html   .= "\t\t\t\t\t<li class=\"breadcrumb-item active\" aria-current=\"page\">Application Tables Management</li>\n";
            $html   .= "\t\t\t\t</ol>\n";
            $html   .= "\t\t\t</nav>\n";
            $html   .= "\t\t\t<div class=\"box\">\n";
            $html   .= "\t\t\t\t<div class=\"row\">\n";

            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t</div>\n";

            return $html;
        }

        protected function onGet ( )
        {
            $layoutTemplate = new main ( 'devControl', 'devControl' );

            $html   = "<!DOCTYPE html>\n";
            $html   .= "<html lang=\"en\">\n";
            $html   .= "\t<head>\n";
            $html   .= $layoutTemplate->render_header ( [ "TITLE" => "Developer Application Database Manager" ], ".page { margin-top: 15px; }" );
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

        protected function onPost ( )
        {
            $this->onGet();
        }
    }