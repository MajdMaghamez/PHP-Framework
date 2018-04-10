<?php namespace main\controllers\devControl\databaseControl;

    use main\models\Role;
    use main\layouts\bootstrap\main;
    use main\controllers\Controller;

    class system extends Controller
    {
        protected $canAccess = true;
        protected $tables = array ( );
        protected $status = array ( );

        /**
         * system constructor.
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

            $tables = array_slice ( scandir ( $GLOBALS ["RELATIVE_TO_DIRECTORY"] . "/main/storage/tables/" ), 2 );
            foreach ( $tables as $table => $name )
            {
                $class = "\\main\\storage\\tables\\" . pathinfo ( $name, PATHINFO_FILENAME );

                $class = new $class ( );
                array_push ( $this->tables, $class );

                $status= $class->status ( );
                array_push ( $this->status, $status );
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
            $html   .= "\t\t\t\t\t<li class=\"breadcrumb-item active\" aria-current=\"page\">System Tables Management</li>\n";
            $html   .= "\t\t\t\t</ol>\n";
            $html   .= "\t\t\t</nav>\n";

            $html   .= "\t\t\t<div id=\"system\">\n";

            foreach ( $this->tables as $table => $class )
            {
                $html   .= "\t\t\t\t<div class=\"card\">\n";
                $html   .= "\t\t\t\t\t<div class=\"card-header\" id=\"heading" . $table . "\">\n";
                $html   .= "\t\t\t\t\t\t<h5 class=\"mb-0\">\n";
                $html   .= "\t\t\t\t\t\t\t<button class=\"btn btn-link collapsed\" data-toggle=\"collapse\" data-target=\"#collapse" . $table . "\" aria-expanded=\"true\" aria-controls=\"collapse" . $table . "\">\n";
                $html   .= "\t\t\t\t\t\t\t\t" . pathinfo ( get_Class ( $class ) , PATHINFO_FILENAME ) . "\n";
                $html   .= "\t\t\t\t\t\t\t</button><span class=\"right\">" . $this->status [$table]["MESSAGE"] . "</span>\n";
                $html   .= "\t\t\t\t\t\t</h5>\n";
                $html   .= "\t\t\t\t\t</div>\n";

                $html   .= "\t\t\t\t\t<div id=\"collapse" . $table . "\" class=\"collapse\" aria-labelledby=\"heading" . $table . "\" data-parent=\"system\">\n";
                $html   .= "\t\t\t\t\t\t<div class=\"card-body table-responsive-sm table-sm\">\n";
                $html   .= "\t\t\t\t\t\t\t<table class=\"table table-hover table-striped\">\n";
                $html   .= "\t\t\t\t\t\t\t\t<thead class='thead-dark'>\n";
                $html   .= "\t\t\t\t\t\t\t\t\t<tr>\n";
                $html   .= "\t\t\t\t\t\t\t\t\t\t<th scope='col'>Row</th>\n";
                $html   .= "\t\t\t\t\t\t\t\t\t\t<th scope='col'>Column</th>\n";
                $html   .= "\t\t\t\t\t\t\t\t\t\t<th scope='col'>Data Type</th>\n";
                $html   .= "\t\t\t\t\t\t\t\t\t\t<th scope='col'>Default Value</th>\n";
                $html   .= "\t\t\t\t\t\t\t\t\t\t<th scope='col'>Extra</th>\n";
                $html   .= "\t\t\t\t\t\t\t\t\t\t<th scope='col'>Is Null</th>\n";
                $html   .= "\t\t\t\t\t\t\t\t\t</tr>\n";
                $html   .= "\t\t\t\t\t\t\t\t</thead>\n";
                $html   .= "\t\t\t\t\t\t\t\t<tbody>\n";

                // keeps count of table rows
                $TableRowCounter = 1;

                foreach ( $class->getColumns ( ) as $index => $column )
                {
                    $html   .= "\t\t\t\t\t\t\t\t\t<tr>\n";
                    $html   .= "\t\t\t\t\t\t\t\t\t\t<td>" . $TableRowCounter . "</td>\n";
                    $html   .= "\t\t\t\t\t\t\t\t\t\t<td>" . $index . "</td>\n";
                    $html   .= "\t\t\t\t\t\t\t\t\t\t<td>" . $column ["COLUMN_TYPE"] . "</td>\n";
                    $html   .= "\t\t\t\t\t\t\t\t\t\t<td>" . $column ["COLUMN_DEFAULT"] . "</td>\n";
                    $html   .= "\t\t\t\t\t\t\t\t\t\t<td>" . $column ["EXTRA"] . "</td>\n";
                    ($column ["IS_NULLABLE"] == 'null') ? $html   .= "\t\t\t\t\t\t\t\t\t\t<td><i class=\"far fa-check-square\"></i></td>\n" : $html   .= "\t\t\t\t\t\t\t\t\t\t<td><i class=\"far fa-square\"></i></td>\n";
                    $html   .= "\t\t\t\t\t\t\t\t\t</tr>\n";

                    $TableRowCounter++;
                }

                $html   .= "\t\t\t\t\t\t\t\t</tbody>\n";
                $html   .= "\t\t\t\t\t\t\t</table>\n";
                $html   .= "\t\t\t\t\t\t</div>\n";
                $html   .= "\t\t\t\t\t</div>\n";
                $html   .= "\t\t\t\t</div>\n";
            }

            $html   .= "\t\t\t</div>\n";

            return $html;
        }

        protected function onGet ( )
        {
            $layoutTemplate = new main ( 'devControl', 'devControl' );

            $html   = "<!DOCTYPE html>\n";
            $html   .= "<html lang=\"en\">\n";
            $html   .= "\t<head>\n";
            $html   .= $layoutTemplate->render_header ( [ "TITLE" => "Developer System Database Manager" ], ".page { margin-top: 15px; }" );
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