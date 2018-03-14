<?php namespace main\gui\renderer;

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
            $html   = $tabs . "<form id=\"" . $id . "\" ";
            $html   .= "method=\"" . $method . "\" ";
            $html   .= "action=\"" . $action . "\" ";
            $html   .= "enctype=\"application/x-www-form-urlencoded\" ";
            $html   .= "data-parsley-validate=\"\">\n";

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
            $html   = $tabs . "<form id=\"" . $id . "\" ";
            $html   .= "method=\"" . $method . "\" ";
            $html   .= "action=\"" . $action . "\" ";
            $html   .= "enctype=\"application/x-www-form-urlencoded\" ";
            $html   .= "data-parsley-validate=\"\">\n";

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
                $html   .= $tabs . "\t</div>\n";
            }

            $html   .= $tabs . "</form>\n";

            return $html;
        }
    }