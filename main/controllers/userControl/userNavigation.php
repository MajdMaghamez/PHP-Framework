<?php namespace main\userControl;

    trait userNavigation
    {
        public static function renderNavigationLinks ( $image )
        {
            $tabs   = "\t\t\t\t";
            $path   = explode ( '\\', __CLASS__ );

            $navigation =
            [
                0 =>
                [
                    "label"     => "My Account",
                    "href"      => $GLOBALS ["RELATIVE_TO_ROOT"] . "/User/Account",
                    "class"     => ""
                ],
                1 =>
                [
                    "label"     => "My Password",
                    "href"      => $GLOBALS ["RELATIVE_TO_ROOT"] . "/User/Password",
                    "class"     => ""
                ],
                2 =>
                [
                    "label"     => "Personal Questions",
                    "href"      => $GLOBALS ["RELATIVE_TO_ROOT"] . "/User/Questions",
                    "class"     => ""
                ]
            ];

            switch ( array_pop ( $path ) )
            {
                case 'userAccount': $navigation[0]['class'] = ' active';break;
                case 'userPassword': $navigation[1]['class'] = ' active';break;
                case 'userQuestions': $navigation[2]['class'] = ' active';break;
            }

            $html    = $tabs . "\t<div class=\"card\">\n";

            $html   .= $tabs . "\t\t<div class=\"profile-pic center\">\n";
            $html   .= $tabs . "\t\t\t<img src=\"" . $image . "\" height=\"100\" width=\"100\" alt=\"My Profile Picture\" style=\"border-radius: 100%\" />\n";
            $html   .= $tabs . "\t\t\t<div class=\"editProfilePic\">\n";
            $html   .= $tabs . "\t\t\t\t<button type=\"button\" class=\"btn btn-outline-primary\" data-toggle=\"modal\" data-target=\"#ProfileUploader\"><i class=\"far fa-image\"></i></button>\n";
            $html   .= $tabs . "\t\t\t</div>\n";
            $html   .= $tabs . "\t\t</div><hr/>\n";

            $html   .= $tabs . "\t\t<div class=\"nav flex-column nav-pills\" role=\"tablist\" aria-orientation=\"vertical\">\n";

            foreach ( $navigation as $link => $page )
            {
                $html   .= $tabs . "\t\t\t<a class=\"nav-link" . $page ["class"] . "\" href=\"" . $page ["href"] . "\">" . $page ["label"] . "</a>\n";
            }
            $html   .= $tabs . "\t\t</div><hr/>\n";

            $html   .= $tabs . "\t</div>\n";

            return $html;
        }

        public static function renderProfilePicModal ( )
        {
            $tabs   = "\t\t\t\t\t";

            $html    = $tabs . "\t<div class=\"modal fade\" id=\"ProfileUploader\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"UserProfile\" aria-hidden=\"true\">\n";
            $html   .= $tabs . "\t\t<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">\n";
            $html   .= $tabs . "\t\t\t<div class=\"modal-content\">\n";
            $html   .= $tabs . "\t\t\t\t<div class=\"modal-header\">\n";
            $html   .= $tabs . "\t\t\t\t\t<h5 class=\"modal-title\" id=\"UserProfile\">Edit Profile Picture</h5>\n";
            $html   .= $tabs . "\t\t\t\t\t<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"close\">\n";
            $html   .= $tabs . "\t\t\t\t\t\t<span aria-hidden=\"true\">&times;</span>\n";
            $html   .= $tabs . "\t\t\t\t\t</button>\n";
            $html   .= $tabs . "\t\t\t\t</div>\n";
            $html   .= $tabs . "\t\t\t\t<div class=\"modal-body\">\n";

            $html   .= $tabs . "\t\t\t\t</div>\n";
            $html   .= $tabs . "\t\t\t\t<div class=\"modal-footer\">\n";
            $html   .= $tabs . "\t\t\t\t\t<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>\n";
            $html   .= $tabs . "\t\t\t\t\t<button type=\"submit\" class=\"btn btn-success\">Upload</button>\n";
            $html   .= $tabs . "\t\t\t\t</div>\n";
            $html   .= $tabs . "\t\t\t</div>\n";
            $html   .= $tabs . "\t\t</div>\n";
            $html   .= $tabs . "\t</div>\n";

            return $html;
        }
    }