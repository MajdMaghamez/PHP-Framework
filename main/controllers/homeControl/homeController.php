<?php namespace main\controllers\homeControl;

    use main\controllers\Controller;
    use main\frameworkHelper\cacheManager;
    use main\layouts\bootstrap\main;

    class homeController extends Controller
    {
        protected $errors = false;
        protected $arrComponents;

        /**
         * homeController constructor.
         */
        public function __construct ( )
        {
            $this->arrComponents = array ( );
        }

        /**
         * @return string
         */
        private function preRenderPage ( )
        {
            $html   = "";
            return $html;
        }

        /**
         * @return string
         */
        private function renderPage ( )
        {
            $folder = $GLOBALS ["CACHE_FOLDER"] . "/" . basename ( __DIR__ );
            $file   = $folder . "/home.html";

            $cacheManager = new cacheManager ( $folder, $file );
            if ( ! $cacheManager->isCacheExists ( ) ) { $this->errors = ! $cacheManager->write ( $this->preRenderPage ( ) ); }
            if ( ! $this->errors ) { return $cacheManager->read ( $this->arrComponents ); }
            return "";
        }

        protected function onGet ( )
        {
            $layoutTemplate = new main ( );

            $html   = "<!DOCTYPE html>\n";
            $html   .= "<html lang=\"en\">\n";
            $html   .= "\t<head>\n";
            $html   .= $layoutTemplate->render_header ( [ "TITLE" => "Home Page" ] );
            $html   .= "\t</head>\n";
            $html   .= "\t<body>\n";
            $html   .= $this->renderPage ( );
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