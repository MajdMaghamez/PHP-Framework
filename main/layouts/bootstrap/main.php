<?php namespace main\layouts\bootstrap;

    use main\models\Role;
    use main\layouts\navigation\navigation;

    class main
    {
        private $no_cache   = false;
        private $user_name  = "";
        private $user_role  = "";
        private $user_id    = 0;
        private $parent     = "";
        private $child      = "";

        use navigation;

        /**
         * main constructor.
         * @param string $parent
         * @param string $child
         * @param bool $no_cache
         */
        public function __construct ( $parent = "", $child = "", $no_cache = false )
        {
            if ( isset ( $_SESSION ["USER_NAME"] ) ) $this->user_name = $_SESSION ["USER_NAME"];
            if ( isset ( $_SESSION ["USER_ID"] ) ) $this->user_id = $_SESSION ["USER_ID"];
            if ( isset ( $_SESSION ["USER_ROLE"] ) ) $this->user_role = Role::getRoleName( $_SESSION ["USER_ROLE"] );

            $this->parent = $parent;
            $this->child = $child;
            $this->no_cache = $no_cache;
        }

        public function render_navbar ( )
        {
            $Func = "get" . str_replace (' ', '', $this->user_role ) . "Navigation";
            $NavBar = self::$Func ( $this->user_name, $this->parent );

            $Func = "get" . str_replace ( ' ', '', $this->user_role ) . "SubNavigation";
            $SubNavBar = self::$Func ( $this->child );

            // render the navigation bar

            $html    = "\t\t<nav class=\"navbar navbar-expand-lg navbar-dark bg-dark navbar-fixed-top\">\n";
            $html   .= "\t\t\t<div class=\"container\">\n";
            $html   .= "\t\t\t\t<a class=\"navbar-brand\" href=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/Home\">" . $GLOBALS ["BS_NAME"] . "</a>\n";
            $html   .= "\t\t\t\t\t<button type=\"button\" class=\"navbar-toggler\" data-toggle=\"collapse\" data-target=\"#navbar\" aria-controls=\"navbar\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">\n";
            $html   .= "\t\t\t\t\t\t<span class=\"navbar-toggler-icon\"></span>\n";
            $html   .= "\t\t\t\t\t</button>\n";
            $html   .= "\t\t\t\t<div class=\"collapse navbar-collapse\" id=\"navbar\">\n";
            $html   .= "\t\t\t\t\t<ul class=\"nav navbar-nav ml-auto\">\n";

            foreach ( $NavBar as $index => $element )
            {
                if ( empty ( $element ["children"] ) )
                {
                    $html   .= "\t\t\t\t\t\t<li class=\"nav-item" . $element ["active"] . "\"><a class=\"nav-link\" href=\"" . $element ["link"] . "\">" . $element ["icon"] . " " . $element ["title"] . "</a></li>\n";
                }
                else
                {
                    $html   .= "\t\t\t\t\t\t<li class=\"nav-item dropdown" . $element ["active"] . "\">\n";
                    $html   .= "\t\t\t\t\t\t\t<a href=\"" . $element ["link"] . "\" class=\"nav-link dropdown-toggle\" id=\"" . $element ["id"] . "\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">" . $element ["icon"] . " " . $element ["title"] . "</a>\n";
                    $html   .= "\t\t\t\t\t\t\t<div class=\"dropdown-menu\" aria-labelledby=\"" . $element ["id"] . "\">\n";

                    foreach ( $element ["children"] as $key => $value )
                    {
                        $html   .= "\t\t\t\t\t\t\t\t<a class=\"dropdown-item" . $value ["active"] . "\" href=\"" . $value ["link"] . "\">" . $value ["icon"] . " " . $value ["title"] . "</a>\n";
                    }

                    $html   .= "\t\t\t\t\t\t\t</div>\n";
                    $html   .= "\t\t\t\t\t\t</li>\n";
                }
            }

            $html   .= "\t\t\t\t\t\t<li class=\"nav-item\"><a href=\"javascript:void(0);\" class=\"nav-link\" onClick=\"window.location.reload();\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"For security purposes your session will expire when this time is up, click to extend time\"><span id=\"countdown\"></span></a></li>\n";
            $html   .= "\t\t\t\t\t</ul>\n";
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t</div>\n";
            $html   .= "\t\t</nav>\n";

            // render the sub navigation bar

            $html   .= "\t\t<div class=\"container\">\n";
            $html   .= "\t\t<nav class=\"navbar navbar-expand-lg navbar-light bg-light\">\n";
            $html   .= "\t\t\t<button type=\"button\" class=\"navbar-toggler\" data-toggle=\"collapse\" data-target=\"#sub-navbar\" aria-controls=\"navbar\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">\n";
            $html   .= "\t\t\t\t<span class=\"navbar-toggler-icon\"></span>\n";
            $html   .= "\t\t\t</button>\n";
            $html   .= "\t\t\t<div class=\"collapse navbar-collapse\" id=\"sub-navbar\">\n";
            $html   .= "\t\t\t\t<ul class=\"nav navbar-nav mr-auto\">\n";

            foreach ( $SubNavBar AS $index => $element )
            {
                if ( empty ( $element["children"] ) )
                {
                    $html   .= "\t\t\t\t\t<li class=\"nav-item" . $element ["active"] . "\"><a class=\"nav-link\" href=\"" . $element ["link"] . "\">" . $element ["icon"] . " " . $element ["title"] . "</a></li>\n";
                }
                else
                {
                    $html   .= "\t\t\t\t\t\t<li class=\"nav-item dropdown" . $element ["active"] . "\">\n";
                    $html   .= "\t\t\t\t\t\t\t<a href=\"" . $element ["link"] . "\" class=\"nav-link dropdown-toggle\" id=\"" . $element ["id"] . "\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">" . $element ["icon"] . " " . $element ["title"] . "</a>\n";
                    $html   .= "\t\t\t\t\t\t\t<div class=\"dropdown-menu\" aria-labelledby=\"" . $element ["id"] . "\">\n";

                    foreach ( $element ["children"] as $key => $value )
                    {
                        $html   .= "\t\t\t\t\t\t\t\t<a class=\"dropdown-item" . $value ["active"] . "\" href=\"" . $value ["link"] . "\">" . $value ["icon"] . " " . $value ["title"] . "</a>\n";
                    }

                    $html   .= "\t\t\t\t\t\t\t</div>\n";
                    $html   .= "\t\t\t\t\t\t</li>\n";
                }
            }

            $html   .= "\t\t\t\t</ul>\n";
            $html   .= "\t\t\t</div>\n";
            $html   .= "\t\t</nav>\n";
            $html   .= "\t\t</div>\n";

            return $html;
        }

        public function render_header ( $elements = array ( ), $css = "" )
        {
            $html    = "\t\t<meta charset=\"utf-8\"/>\n";
            $html   .= "\t\t<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"/>\n";

            if ( $this->no_cache )
            {
                $html   .= "\t\t<meta http-equiv=\"cache-control\" content=\"max-age=0\"/>\n";
                $html   .= "\t\t<meta http-equiv=\"cache-control\" content=\"no-cache\"/>\n";
                $html   .= "\t\t<meta http-equiv=\"expires\" content=\"0\"/>\n";
                $html   .= "\t\t<meta http-equiv=\"expires\" content=\"Tue, 01 Jan 1980 1:00:00 GMT\"/>\n";
                $html   .= "\t\t<meta http-equiv=\"pragma\" content=\"no-cache\"/>\n";
            }

            $html   .= "\t\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\"/>\n";

            if ( isset ( $elements ["TITLE"] ) ) { $html .= "\t\t<title>" . $elements ["TITLE"] . "</title>\n"; }

            $html   .= "\t\t<link rel=\"icon\" href=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/img/favicon.png\"/>\n";

            if ( isset ( $elements ["LIBRARIES"] ) ) { $html .= $this->add_to_head ( $elements ["LIBRARIES"] ); } else { $html .= $this->add_to_head ( ); }

            if ( ! empty ( $css ) ) { $html .= "\t\t<style type=\"text/css\">" . $css . "</style>\n"; }

            return $html;
        }

        public function add_to_head ( $lib = array ( ) )
        {
            $html    = "";

            if ( isset ( $lib ["BEFORE"] ) ) { foreach ( $lib ["BEFORE"] as $key => $value ) { $html .= "\t\t<link rel=\"stylesheet\" href=\"" . $value . "\"/>\n"; } }

            // bootstrap css
            $html   .= "\t\t<link rel=\"stylesheet\" href=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/bootstrap/css/bootstrap.min.css\"/>\n";

            // font awesome css
            $html   .= "\t\t<link rel=\"stylesheet\" href=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/fontawesome/web/css/fontawesome-all.min.css\"/>\n";

            // parsley css
            $html   .= "\t\t<link rel=\"stylesheet\" href=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/parsley/parsley.css\"/>\n";

            // autoload css
            $html   .= "\t\t<link rel=\"stylesheet\" href=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/css/autoload.css\"/>\n";

            // jQuery js
            $html   .= "\t\t<script src=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/jQuery/jquery-3.2.1.min.js\"></script>\n";

            // parsley js
            $html   .= "\t\t<script src=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/parsley/parsley.min.js\"></script>\n";

            if ( isset ( $lib ["AFTER"] ) ) { foreach ( $lib ["AFTER"] as $key => $value ) { $html .= "\t\t<link rel=\"stylesheet\" href=\"" . $value . "\"/>\n"; } }

            // IE
            $html   .= "\t\t<!-- [IF lt IE 9]>\n";
            $html   .= "\t\t\t<script src=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/bootstrap/js/html5shiv.min.js\"></script>\n";
            $html   .= "\t\t\t<script src=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/bootstrap/js/respond.min.js\"></script>\n";
            $html   .= "\t\t<![endIF] -->\n";

            return $html;
        }

        public function render_footer ( $elements = array ( ), $JS = "" )
        {
            $html    = "\t\t<footer class=\"footer\">\n";
            $html   .= "\t\t\t<div class=\"container\">\n";
            $html   .= "\t\t\t\t<div class=\"row\">\n";
            $html   .= "\t\t\t\t\t<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4\">\n";
            $html   .= "\t\t\t\t\t\t<p class=\"text-muted\">" . $GLOBALS ["BS_NAME"] . " &reg; " . date ("Y") . " All Rights Reserved.</p>\n";
            $html   .= "\t\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t</div>\n";
            $html   .= "\t\t</footer>\n";

            if ( isset ( $elements ["LIBRARIES"] ) ) { $html .= $this->add_to_foot ( $elements ["LIBRARIES"] ); } else { $html .= $this->add_to_foot ( ); }

            if ( ! empty ( $JS ) ) { $html .= "\t\t<script type=\"text/javascript\">\n" . $JS . "\n\t\t</script>\n"; }

            $html   .= "\t\t<script type=\"text/javascript\">\n";
            $html   .= "\t\t\t\$(document).ready(function ( ){\n";
            $html   .= "\t\t\t\tvar timeout = " . $GLOBALS ["S_TIMEOUT"] . ";\n";
            $html   .= "\t\t\t\tvar expire = timeout.minutes ( ).fromNow ( );\n";
            $html   .= "\t\t\t\tvar upto = expire.toString (\"yyyy/MM/dd HH:mm:ss\");\n";
            $html   .= "\t\t\t\t\$('#countdown').countdown(upto, function (event) {\n";
            $html   .= "\t\t\t\t\t\$(this).html (event.strftime (\"%H :%M :%S\"));\n";
            $html   .= "\t\t\t\t}).on (\"finish.countdown\", function ( ) {\n";
            $html   .= "\t\t\t\t\twindow.location.replace (\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/Logout/TimedOut/\");\n";
            $html   .= "\t\t\t\t});\n\n";
            $html   .= "\t\t\t\t\$('[data-toggle=\"tooltip\"]').tooltip ( );\n";
            $html   .= "\t\t\t});\n";
            $html   .= "\t\t</script>\n";

            return $html;
        }

        public function add_to_foot( $lib = array ( ) )
        {
            $html    = "";

            if ( isset ( $lib ["BEFORE"] ) ) { foreach ( $lib ["BEFORE"] as $key => $value ) { $html .= "\t\t<script src=\"" . $value . "\"></script>\n"; } }

            // popper js
            $html   .= "\t\t<script src=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/bootstrap/js/popper.min.js\"></script>\n";

            // bootstrap js
            $html   .= "\t\t<script src=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/bootstrap/js/bootstrap.min.js\"></script>\n";

            // countdown js
            $html   .= "\t\t<script src=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/jQuery/jquery.countdown.min.js\"></script>\n";

            // date js
            $html   .= "\t\t<script src=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/date/date.js\"></script>\n";

            // autoload js
            $html   .= "\t\t<script src=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/js/autoload.js\"></script>\n";

            if ( isset ( $lib ["AFTER"] ) ) { foreach ( $lib ["AFTER"] as $key => $value ) { $html .= "\t\t<script src=\"" . $value . "\"></script>\n"; } }

            return $html;
        }
    }