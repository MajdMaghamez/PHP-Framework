<?php namespace main\layouts\bootstrap;

    class main
    {
        protected $no_cache = false;
        protected $navbar = array ( );

        /**
         * main constructor.
         * @param string $parent
         * @param string $child
         * @param bool $no_cache
         */
        public function __construct ($parent = "", $child = "", $no_cache = false )
        {
            if ( isset ( $_SESSION ["USER_NAME"] ) ) { $user_full_name = $_SESSION ["USER_NAME"]; } else { $user_full_name = ""; }

            $this->no_cache = $no_cache;

            $this->navbar =
            [
                0    			=>
                [
                    "ID"        =>  "HOME",
                    "TITLE"		=>	"Home",
                    "ACTIVE"	=>	"",
                    "ICON"		=>	"<i class=\"fas fa-home\" aria-hidden=\"true\"></i>",
                    "LINK"		=>	$GLOBALS ["RELATIVE_TO_ROOT"] . "/Home",
                    "CHILDREN"	=>	ARRAY ( )
                ],
                1        		=>
                [
                    "ID"        =>  "REPORTS",
                    "TITLE"		=>	"Reports",
                    "ACTIVE"	=>	"",
                    "ICON"		=>	"<i class=\"fas fa-chart-bar\" aria-hidden=\"true\"></i>",
                    "LINK"		=>	$GLOBALS ["RELATIVE_TO_ROOT"] . "/views/reports/index.php",
                    "CHILDREN"	=>	ARRAY ( )
                ],
                2      			=>
                [
                    "ID"        =>  "STATISTICS",
                    "TITLE"		=>	"Statistics",
                    "ACTIVE"	=>	"",
                    "ICON"		=>	"<i class=\"fas fa-chart-pie\" aria-hidden=\"true\"></i>",
                    "LINK"		=>	$GLOBALS ["RELATIVE_TO_ROOT"] . "/views/stats/index.php",
                    "CHILDREN"	=>	ARRAY ( )
                ],
                3    			=>
                [
                    "ID"        =>  "HELP",
                    "TITLE"		=>	"Help",
                    "ACTIVE"	=>	"",
                    "ICON"		=>	"<i class=\"fa fa-question-circle\" aria-hidden=\"true\"></i>",
                    "LINK"		=>	$GLOBALS ["RELATIVE_TO_ROOT"] . "/views/help/index.php",
                    "CHILDREN"	=>	ARRAY ( )
                ],
                4            	=>
                [
                    "ID"        =>  "USERMNGMNT",
                    "TITLE"		=> 	$user_full_name,
                    "ACTIVE"	=>	"",
                    "ICON"		=>	"",
                    "LINK"		=>	$GLOBALS ["RELATIVE_TO_ROOT"] . "/views/userMngmnt/index.php",
                    "CHILDREN"	=>
                    [
                        0               =>
                        [
                            "ID"        =>  "SYSADMIN",
                            "TITLE"     =>  "Developer Tools",
                            "ACTIVE"    =>  "",
                            "ICON"      =>  "<i class=\"fas fa-magic\" aria-hidden=\"true\"></i>",
                            "LINK"      =>  $GLOBALS ["RELATIVE_TO_ROOT"] . "/views/sysadmin/index.php"
                        ],
                        1               =>
                        [
                            "ID"        =>  "MYACCOUNT",
                            "TITLE"		=>	"My Account",
                            "ACTIVE"	=> 	"",
                            "ICON"		=>	"<i class=\"far fa-user\" aria-hidden=\"true\"></i>",
                            "LINK"		=>	$GLOBALS ["RELATIVE_TO_ROOT"] . "/views/userMngmnt/index.php"
                        ],
                        2               =>
                        [
                            "ID"        =>  "MESSAGES",
                            "TITLE"		=>	"Messages",
                            "ACTIVE"	=> 	"",
                            "ICON"		=> 	"<i class=\"far fa-envelope-open\" aria-hidden=\"true\"></i>",
                            "LINK"		=> 	$GLOBALS ["RELATIVE_TO_ROOT"] . "/views/messages/index.php"
                        ],
                        3               =>
                        [
                            "ID"        =>  "LOGOUT",
                            "TITLE"		=>	"Logout",
                            "ACTIVE"	=>	"",
                            "ICON"		=>	"<i class=\"fas fa-sign-out-alt\" aria-hidden=\"true\"></i>",
                            "LINK"		=> 	$GLOBALS ["RELATIVE_TO_ROOT"] . "/Logout"
                        ]
                    ]
                ]
            ];

            $this->sub_navbar =
            [
                0    				=>
                [
                    "ID"      		=>  "DASHBOARD",
                    "TITLE"			=>  "Dashboard",
                    "ACTIVE"		=>	"",
                    "ICON"			=>	"",
                    "LINK"			=>	$GLOBALS ["RELATIVE_TO_ROOT"] . "/Home",
                    "CHILDREN"	    =>	ARRAY ( )
                ],
                1        			=>
                [
                    "ID"      		=>	"CLIENTS",
                    "TITLE"			=>	"Clients",
                    "ACTIVE"		=> 	"",
                    "ICON"			=>	"",
                    "LINK"			=> 	$GLOBALS ["RELATIVE_TO_ROOT"] . "/views/clients/index.php",
                    "CHILDREN"	    =>	ARRAY ( )
                ],
                2        			=>
                [
                    "ID"		    => 	"INVENTORY",
                    "TITLE"			=> 	"Inventory",
                    "ACTIVE"		=> 	"",
                    "ICON"			=>	"",
                    "LINK"			=>  $GLOBALS ["RELATIVE_TO_ROOT"] . "/views/inventory/index.php",
                    "CHILDREN"	    =>	ARRAY ( )
                ],
                3            		=>
                [
                    "ID"      		=>	"ADMINISTRATOR",
                    "TITLE"			=> 	"Administrator",
                    "ACTIVE"		=>	"",
                    "ICON"			=> 	"",
                    "LINK"			=> 	$GLOBALS ["RELATIVE_TO_ROOT"] . "/views/admin/index.php",
                    "CHILDREN"	    =>	ARRAY ( )
                ]
            ];

            switch ( $parent )
            {
                case "homeControl"  : $this->navbar [0]["ACTIVE"] = " active"; break;
                case "reports"      : $this->navbar [1]["ACTIVE"] = " active"; break;
                case "stats"        : $this->navbar [2]["ACTIVE"] = " active"; break;
                case "help"         : $this->navbar [3]["ACTIVE"] = " active"; break;
                case "sysadmin"     : $this->navbar [4]["ACTIVE"] = " active"; $this->navbar [4]["CHILDREN"][0]["ACTIVE"] = " active"; break;
                case "userMngmnt"   : $this->navbar [4]["ACTIVE"] = " active"; $this->navbar [4]["CHILDREN"][1]["ACTIVE"] = " active"; break;
                case "messages"     : $this->navbar [4]["ACTIVE"] = " active"; $this->navbar [4]["CHILDREN"][2]["ACTIVE"] = " active"; break;
            }

            switch ( $child )
            {
                case "homeControl"  : $this->sub_navbar [0]["ACTIVE"] = " active"; break;
                case "clients"      : $this->sub_navbar [1]["ACTIVE"] = " active"; break;
                case "inventory"    : $this->sub_navbar [2]["ACTIVE"] = " active"; break;
                case "admin"        : $this->sub_navbar [3]["ACTIVE"] = " active"; break;
            }
        }

        public function render_navbar ( )
        {
            $html    = "\t\t<nav class=\"navbar navbar-expand-lg navbar-dark bg-dark navbar-fixed-top\">\n";
            $html   .= "\t\t\t<div class=\"container\">\n";
            $html   .= "\t\t\t\t<a class=\"navbar-brand\" href=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/Home\">" . $GLOBALS ["BS_NAME"] . "</a>\n";
            $html   .= "\t\t\t\t\t<button type=\"button\" class=\"navbar-toggler\" data-toggle=\"collapse\" data-target=\"#navbar\" aria-controls=\"navbar\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">\n";
            $html   .= "\t\t\t\t\t\t<span class=\"navbar-toggler-icon\"></span>\n";
            $html   .= "\t\t\t\t\t</button>\n";
            $html   .= "\t\t\t\t<div class=\"collapse navbar-collapse\" id=\"navbar\">\n";
            $html   .= "\t\t\t\t\t<ul class=\"nav navbar-nav ml-auto\">\n";

            foreach ( $this->navbar as $index => $element )
            {
                if ( empty ( $element ["CHILDREN"] ) )
                {
                    $html   .= "\t\t\t\t\t\t<li class=\"nav-item" . $element ["ACTIVE"] . "\"><a class=\"nav-link\" href=\"" . $element ["LINK"] . "\">" . $element ["ICON"] . " " . $element ["TITLE"] . "</a></li>\n";
                }
                else
                {
                    $html   .= "\t\t\t\t\t\t<li class=\"nav-item dropdown" . $element ["ACTIVE"] . "\">\n";
                    $html   .= "\t\t\t\t\t\t\t<a href=\"" . $element ["LINK"] . "\" class=\"nav-link dropdown-toggle\" id=\"" . $element ["ID"] . "\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">" . $element ["ICON"] . " " . $element ["TITLE"] . "</a>\n";
                    $html   .= "\t\t\t\t\t\t\t<div class=\"dropdown-menu\" aria-labelledby=\"" . $element ["ID"] . "\">\n";

                    foreach ( $element ["CHILDREN"] as $key => $value )
                    {
                        $html   .= "\t\t\t\t\t\t\t\t<a class=\"dropdown-item" . $value ["ACTIVE"] . "\" href=\"" . $value ["LINK"] . "\">" . $value ["ICON"] . " " . $value ["TITLE"] . "</a>\n";
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

            $html   .= "\t\t<div class=\"container\">\n";
            $html   .= "\t\t<nav class=\"navbar navbar-expand-lg navbar-light bg-light\">\n";
            $html   .= "\t\t\t<button type=\"button\" class=\"navbar-toggler\" data-toggle=\"collapse\" data-target=\"#sub-navbar\" aria-controls=\"navbar\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">\n";
            $html   .= "\t\t\t\t<span class=\"navbar-toggler-icon\"></span>\n";
            $html   .= "\t\t\t</button>\n";
            $html   .= "\t\t\t<div class=\"collapse navbar-collapse\" id=\"sub-navbar\">\n";
            $html   .= "\t\t\t\t<ul class=\"nav navbar-nav mr-auto\">\n";

            foreach ( $this->sub_navbar AS $index => $element )
            {
                if ( empty ( $element["CHILDREN"] ) )
                {
                    $html   .= "\t\t\t\t\t<li class=\"nav-item" . $element ["ACTIVE"] . "\"><a class=\"nav-link\" href=\"" . $element ["LINK"] . "\">" . $element ["ICON"] . " " . $element ["TITLE"] . "</a></li>\n";
                }
                else
                {
                    $html   .= "\t\t\t\t\t\t<li class=\"nav-item dropdown" . $element ["ACTIVE"] . "\">\n";
                    $html   .= "\t\t\t\t\t\t\t<a href=\"" . $element ["LINK"] . "\" class=\"nav-link dropdown-toggle\" id=\"" . $element ["ID"] . "\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">" . $element ["ICON"] . " " . $element ["TITLE"] . "</a>\n";
                    $html   .= "\t\t\t\t\t\t\t<div class=\"dropdown-menu\" aria-labelledby=\"" . $element ["ID"] . "\">\n";

                    foreach ( $element ["CHILDREN"] as $key => $value )
                    {
                        $html   .= "\t\t\t\t\t\t\t\t<a class=\"dropdown-item" . $value ["ACTIVE"] . "\" href=\"" . $value ["LINK"] . "\">" . $value ["ICON"] . " " . $value ["TITLE"] . "</a>\n";
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

            if ( isset ( $lib ["BEFORE"] ) ) { foreach ( $lib ["BEFORE"] as $key => $value ) { $html .= "\t\t" . $value . "\n"; } }

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

            if ( isset ( $lib ["AFTER"] ) ) { foreach ( $lib ["AFTER"] as $key => $value ) { $html .= "\t\t" . $value . "\n"; } }

            // IE
            $html   .= "\t\t<!-- [IF lt IE 9]>\n";
            $html   .= "\t\t\t<script src=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/bootstrap/js/html5shiv.min.js\"></script>\n";
            $html   .= "\t\t\t<script src=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/lib/bootstrap/js/respond.min.js\"></script>\n";
            $html   .= "\t\t<![endIF] -->\n";

            return $html;
        }

        public function render_footer ( $elements = array ( ), $js = "" )
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

            if ( ! empty ( $JS ) ) { $html .= "\t\t<script type=\"text/javascript\">\n" . $JS . "\t\t</script>\n"; }

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

            if ( isset ( $lib ["BEFORE"] ) ) { foreach ( $lib ["BEFORE"] as $key => $value ) { $html .= "\t\t" . $value . "\n"; } }

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

            if ( isset ( $lib ["AFTER"] ) ) { foreach ( $lib ["AFTER"] as $key => $value ) { $html .= "\t\t" . $value . "\n"; } }

            return $html;
        }
    }