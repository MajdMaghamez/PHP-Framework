<?php namespace main\userControl;

    trait userNavigation
    {

        public static function renderNavigationLinks ( $image )
        {
            $tabs   = "\t\t\t\t";
            $path   = explode ( '\\', __CLASS__ );
            $path   = array_pop ( $path );

            $navigation =
            [
                0 =>
                [
                    "label"     => "My Account",
                    "href"      => $GLOBALS ["RELATIVE_TO_ROOT"] . "/User/Account",
                    "class"     => ( $path == 'userAccount' ) ? " active" : ""
                ],
                1 =>
                [
                    "label"     => "My Password",
                    "href"      => $GLOBALS ["RELATIVE_TO_ROOT"] . "/User/Password",
                    "class"     => ( $path == 'userPassword' ) ? " active" : ""
                ],
                2 =>
                [
                    "label"     => "Personal Questions",
                    "href"      => $GLOBALS ["RELATIVE_TO_ROOT"] . "/User/Questions",
                    "class"     => ( $path == 'userQuestions' ) ? " active" : ""
                ]
            ];

            $html    = $tabs . "\t<div class=\"box\">\n";

            $html   .= $tabs . "\t\t<div class=\"profile-pic center\">\n";
            $html   .= $tabs . "\t\t\t<img id=\"imgProfile\" src=\"" . $GLOBALS ["RELATIVE_TO_ROOT"] . "/cache/users/" . $image . "\" height=\"133\" width=\"133\" alt=\"My Profile Picture\" style=\"border-radius: 100%\" />\n";
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
            $html   .= $tabs . "\t\t\t\t\t<div class=\"row\">\n";
            $html   .= $tabs . "\t\t\t\t\t\t<div class=\"col-md-12 col-lg-12 col-xl-12\">\n";
            $html   .= $tabs . "\t\t\t\t\t\t\t<p>Upload an image of size less than 5 MB.<br/><strong>Formats allowed ( PNG, JPG, JPEG, GIF ).</strong></p>\n";
            $html   .= $tabs . "\t\t\t\t\t\t</div>\n";
            $html   .= $tabs . "\t\t\t\t\t</div>\n";
            $html   .= $tabs . "\t\t\t\t\t<div class=\"row\">\n";
            $html   .= $tabs . "\t\t\t\t\t\t<div class=\"col-md-12 col-lg-12 col-xl-12\">\n";
            $html   .= $tabs . "\t\t\t\t\t\t\t<input type=\"file\" id=\"ProPicture\" name=\"ProPicture\" class=\"form-control\" accept=\"image/*\" required autofocus/>\n";
            $html   .= $tabs . "\t\t\t\t\t\t</div>\n";
            $html   .= $tabs . "\t\t\t\t\t</div>\n";
            $html   .= $tabs . "\t\t\t\t</div>\n";
            $html   .= $tabs . "\t\t\t\t<div class=\"modal-footer\">\n";
            $html   .= $tabs . "\t\t\t\t\t<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>\n";
            $html   .= $tabs . "\t\t\t\t\t<button type=\"button\" id=\"upload\" class=\"btn btn-success\">Upload</button>\n";
            $html   .= $tabs . "\t\t\t\t</div>\n";
            $html   .= $tabs . "\t\t\t</div>\n";
            $html   .= $tabs . "\t\t</div>\n";
            $html   .= $tabs . "\t</div>\n";

            return $html;
        }

    }