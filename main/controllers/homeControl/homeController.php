<?php namespace main\controllers\homeControl;

    use main\layouts\bootstrap\main;
    use main\controllers\Controller;
    use main\frameworkHelper\cacheManager;

    class homeController extends Controller
    {
        protected $arrComponents;

        /**
         * homeController constructor.
         * @throws \Exception
         */
        public function __construct ( )
        {
            session_auth ( );

            $this->arrComponents = array ( );
        }

        /**
         * @return string
         */
        private function preRenderPage ( )
        {
            return "";
        }

        /**
         * @return string
         */
        private function renderPage ( )
        {
            $folder = $GLOBALS ["CACHE_FOLDER"] . "/" . basename ( __DIR__ );
            $file   = $folder . "/home.html";
            $errors = false;

            $cacheManager = new cacheManager ( $folder, $file );
            if ( ! $cacheManager->isCacheExists ( ) ) { $errors = ! $cacheManager->write ( $this->preRenderPage ( ) ); }
            if ( ! $errors ) { return $cacheManager->read ( $this->arrComponents ); }
            return "";
        }

        protected function onGet ( )
        {
            $layoutTemplate = new main ( trim ( basename(__DIR__) ), trim ( basename (__DIR__) ) );

            $html   = "<!DOCTYPE html>\n";
            $html   .= "<html lang=\"en\">\n";
            $html   .= "\t<head>\n";
            $html   .= $layoutTemplate->render_header ( [ "TITLE" => "Home Page" ] );
            $html   .= "\t</head>\n";
            $html   .= "\t<body>\n";
            $html   .= $layoutTemplate->render_navbar ( );
            $html   .= "\t\t<div class=\"container\">\n";
            $html   .= $this->renderPage ( );
            $html   .= "\t\t</div>\n";
            $html   .= $layoutTemplate->render_footer ( array ( ) );
            $html   .= "\t</body>\n";
            $html   .= "</html>\n";

            echo $html;
        }

        protected function onPost ( )
        {
            // TODO: Implement onPost() method.
        }

    }