<?php namespace main\layouts\bootstrap;

    class datatables extends main
    {
        /**
         * datatables constructor.
         * @param string $parent
         * @param string $child
         * @param bool $no_cache
         */
        public function __construct ($parent = "", $child = "", $no_cache = false )
        {
            parent::__construct ( $parent, $child, $no_cache );
        }

        public function add_to_head ( $lib = array ( ) )
        {
            $html   = "";

            if ( isset ( $lib ["BEFORE"] ) ) { foreach ( $lib ["BEFORE"] as $key => $value ) { $html .= "\t\t" . $value . "\n"; } }

            // bootstrap css
            $html   .= "\t\t<link rel=\"stylesheet\" href=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/bootstrap/css/bootstrap.min.css\"/>\n";

            // font awesome css
            $html   .= "\t\t<link rel=\"stylesheet\" href=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/fontawesome/web/css/fontawesome-all.min.css\"/>\n";

            // datatables css
            $html   .= "\t\t<link rel=\"stylesheet\" href=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css\"/>\n";

            // datatables responsive css
            $html   .= "\t\t<link rel=\"stylesheet\" href=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/datatables/Responsive-2.2.1/css/responsive.dataTables.min.css\"/>\n";

            // parsley css
            $html   .= "\t\t<link rel=\"stylesheet\" href=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/parsley/parsley.css\"/>\n";

            // autoload css
            $html   .= "\t\t<link rel=\"stylesheet\" href=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/css/autoload.css\"/>\n";

            // jQuery js
            $html   .= "\t\t<script src=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/jQuery/jquery-3.2.1.min.js\"></script>\n";

            // parsley js
            $html   .= "\t\t<script src=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/parsley/parsley.min.js\"></script>\n";

            // datatables js
            $html   .= "\t\t<script src=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/datatables/DataTables-1.10.16/js/jquery.dataTables.min.js\"></script>\n";

            // datatables responsive js
            $html   .= "\t\t<script src=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/datatables/Responsive-2.2.1/js/dataTables.responsive.min.js\"></script>\n";

            // datatables bootstrap js
            $html   .= "\t\t<script src=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js\"></script>\n";

            if ( isset ( $lib ["AFTER"] ) ) { foreach ( $lib ["AFTER"] as $key => $value ) { $html .= "\t\t" . $value . "\n"; } }

            // IE
            $html   .= "\t\t<!-- [IF lt IE 9]>\n";
            $html   .= "\t\t\t<script src=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/bootstrap/js/html5shiv.min.js\"></script>\n";
            $html   .= "\t\t\t<script src=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/bootstrap/js/respond.min.js\"></script>\n";
            $html   .= "\t\t<![endIF] -->\n";

            return $html;
        }
    }