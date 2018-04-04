<?php namespace main\gui\renderer;

    use main\gui\fields\csrfField;
    use main\gui\fields\honeyPotField;

    class bootstrapForm
    {
        /**
         * @param array $guiComponents
         * @param string $tabs
         * @param string $id
         * @param string $method
         * @param string $action
         * @return string
         */
        public static function renderStatic ( $guiComponents, $tabs, $id, $method, $action )
        {
            $honeyPot   = new honeyPotField ( "username", "username", "username" );
            $honeyPot->setSize ( 40 );
            $honeyPot->setTabs ( $tabs . "\t\t\t" );

            $csrfToken  = new csrfField ( "", "csrf-token", "csrf-token" );
            $csrfToken->setSize( 50 );
            $csrfToken->setTabs( $tabs . "\t\t\t" );

            $html   = $tabs . "<form id=\"" . $id . "\" ";
            $html   .= "method=\"" . $method . "\" ";
            $html   .= "action=\"" . $action . "\" ";
            $html   .= "enctype=\"application/x-www-form-urlencoded\" ";
            $html   .= "data-parsley-validate=\"\">\n";

            // add honey pot to forms
            $html   .= $tabs . "\t<div class=\"row\">\n";
            $html   .= $tabs . "\t\t<div class=\"col\">\n";
            $html   .= $honeyPot->renderBootstrap ( );
            $html   .= $tabs . "\t\t</div>\n";
            $html   .= $tabs . "\t</div>\n";

            foreach ( $guiComponents as $row => $columns )
            {
                $html   .= $tabs . "\t<div class=\"row\">\n";
                foreach ( $columns as $index => $column )
                {
                    $html   .= $tabs . "\t\t<div class=\"col\">\n";
                    $html   .= $column->renderBootstrap ( );
                    $html   .= $tabs . "\t\t</div>\n";
                }
                $html   .= $tabs . "\t</div>\n";
            }

            // add CSRF TOKEN to forms
            $html   .= $tabs . "\t<div class=\"row\">\n";
            $html   .= $tabs . "\t\t<div class=\"col\">\n";
            $html   .= $csrfToken->renderBootstrap ( );
            $html   .= $tabs . "\t\t</div>\n";
            $html   .= $tabs . "\t</div>\n";

            $html   .= $tabs . "</form>\n";

            return $html;
        }

        /**
         * @param array $guiComponents
         * @param string $tabs
         * @param string $id
         * @param string $method
         * @param string $action
         * @return string
         */
        public static function renderInline ( $guiComponents, $tabs, $id, $method, $action )
        {
            $honeyPot   = new honeyPotField ( "username", "username", "username" );
            $honeyPot->setSize ( 40 );
            $honeyPot->setTabs ( $tabs . "\t\t\t" );

            $csrfToken  = new csrfField ( "", "csrf-token", "csrf-token" );
            $csrfToken->setSize( 50 );
            $csrfToken->setTabs( $tabs . "\t\t\t" );

            $html   = $tabs . "<form id=\"" . $id . "\" ";
            $html   .= "method=\"" . $method . "\" ";
            $html   .= "action=\"" . $action . "\" ";
            $html   .= "enctype=\"application/x-www-form-urlencoded\" ";
            $html   .= "data-parsley-validate=\"\">\n";

            // add honey pot to forms
            $html   .= $tabs . "\t<div class=\"row\">\n";
            $html   .= $tabs . "\t\t<div class=\"col\">\n";
            $html   .= $honeyPot->renderBootstrapLabel ( );
            $html   .= $tabs . "\t\t</div>\n";
            $html   .= $tabs . "\t\t<div class=\"col\">\n";
            $html   .= $honeyPot->renderBootstrapField ( );
            $html   .= $tabs . "\t\t</div>\n";
            $html   .= $tabs . "\t</div>\n";

            foreach ( $guiComponents as $row => $columns )
            {
                $html   .= $tabs . "\t<div class=\"row\">\n";
                foreach ( $columns as $index => $column )
                {
                    if ( method_exists ( $column, "renderBootstrapLabel" ) )
                    {
                        $html   .= $tabs . "\t\t<div class=\"col\">\n";
                        $html   .= $column->renderBootstrapLabel ( );
                        $html   .= $tabs . "\t\t</div>\n";
                    }

                    $html   .= $tabs . "\t\t<div class=\"col\">\n";
                    if ( method_exists ( $column, "renderBootstrapField" ) )
                    {

                        $html   .= $column->renderBootstrapField ( );
                    }
                    else
                    {
                        $html   .= $column->renderBootstrap ( );
                    }
                    $html   .= $tabs . "\t\t</div>\n";
                }
                $html   .= $tabs . "\t</div><br/>\n";
            }

            // add CSRF TOKEN to forms
            $html   .= $tabs . "\t<div class=\"row\">\n";
            $html   .= $tabs . "\t\t<div class=\"col\">\n";
            $html   .= $csrfToken->renderBootstrapLabel ( );
            $html   .= $tabs . "\t\t</div>\n";
            $html   .= $tabs . "\t\t<div class=\"col\">\n";
            $html   .= $csrfToken->renderBootstrapField ( );
            $html   .= $tabs . "\t\t</div>\n";
            $html   .= $tabs . "\t</div>\n";

            $html   .= $tabs . "</form>\n";

            return $html;
        }
    }