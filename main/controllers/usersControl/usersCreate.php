<?php namespace main\controllers\usersControl;

    use main\gui\guiCreator;
    use main\models\Permission;
    use main\layouts\bootstrap\main;
    use main\controllers\Controller;
    use main\gui\renderer\bootstrapForm;
    use main\frameworkHelper\cacheManager;

    class usersCreate extends Controller
    {
        use usersNavigation;
        protected $canAccess = false;
        protected $arrComponents;

        /**
         * userCreate constructor.
         * @throws \Exception
         */
        public function __construct ( )
        {
            session_auth ( );

            if ( Permission::getUserPermission( $_SESSION ["USER_ID"], "USER_ADD" ) )
            {
                $this->canAccess = true;
            }
            else
            {
                setFlashMessage( "Access Denied!", "You do not have permission to access this page", 4 );
            }

            $Tabs       = "\t\t\t\t\t\t\t\t\t";
            $components =
            [
                0 =>
                [
                    0 =>
                    [
                        "parent"        => "fields",
                        "class"         => "textField",
                        "label"         => "First Name",
                        "name"          => "firstname",
                        "id"            => "firstname",
                        "setRequired"   => true,
                        "setTabs"       => $Tabs
                    ],
                    1 =>
                    [
                        "parent"        => "fields",
                        "class"         => "textField",
                        "label"         => "Last Name",
                        "name"          => "lastname",
                        "id"            => "lastname",
                        "setRequired"   => true,
                        "setTabs"       => $Tabs

                    ]
                ],
                1 =>
                [
                    0 =>
                    [
                        "parent"        => "fields",
                        "class"         => "selectField",
                        "label"         => "Choose Role",
                        "name"          => "role",
                        "id"            => "role",
                        "setRequired"   => true,
                        "setTabs"       => $Tabs
                    ]
                ],
                2 =>
                [
                    0 =>
                    [
                        "parent"        => "fields",
                        "class"         => "emailField",
                        "label"         => "Email Address",
                        "name"          => "email",
                        "id"            => "email",
                        "setRequired"   => true,
                        "setTabs"       => $Tabs
                    ]
                ],
                3 =>
                [
                    0 =>
                    [
                        "parent"        => "fields",
                        "class"         => "passwordField",
                        "label"         => "Password",
                        "name"          => "password",
                        "id"            => "password",
                        "setTabs"       => $Tabs
                    ]
                ],
                4 =>
                [
                    0 =>
                    [
                        "parent"        => "fields",
                        "class"         => "checkboxField",
                        "label"         => "Force user to change their password post Login",
                        "name"          => "forcePassword",
                        "id"            => "forcePassword",
                        "setRequired"   => true,
                        "setTabs"       => $Tabs
                    ]
                ],
                5 =>
                [
                    0 =>
                    [
                        "parent"        => "buttons",
                        "class"         => "formButton",
                        "label"         => "Add User",
                        "id"            => "addUser",
                        "type"          => 1,
                        "setTabs"       => $Tabs
                    ]
                ]
            ];

            $arrComponents  = new guiCreator( $components );
            $this->arrComponents = $arrComponents->getContainer ( );

            foreach ( self::getRoleList ( ) as $index => $role )
            {
                $this->arrComponents[1][0]->setOptions ( $role["ID"], $role["PHPVAR"] );
            }
        }

        protected function preRenderPage ( )
        {
            $formId     = "form-parsley";
            $formMethod = "post";
            $formAction = $GLOBALS ["RELATIVE_TO_ROOT"] . "/Users/Add";
            $formTabs   = "\t\t\t\t\t\t";
            $html    = "\t\t\t<div class=\"row\">\n";
            $html   .= "\t\t\t\t<div class=\"col-md-3 col-lg-3 col-xl-3\">\n";
            $html   .= self::renderNavigationLinks();
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t<div class=\"col-md-9 col-lg-9 col-xl-9\">\n";
            $html   .= "\t\t\t\t\t<div class=\"box\">\n";
            $html   .= "\t\t\t\t\t<h4><i class=\"fas fa-chevron-circle-right\"></i> Adding A New User</h4><hr/>\n";
            $html   .= bootstrapForm::renderStatic( $this->arrComponents, $formTabs, $formId, $formMethod, $formAction );
            $html   .= "\t\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t</div>\n";

            return $html;
        }

        protected function renderPage ( )
        {
            $folder = $GLOBALS ["CACHE_FOLDER"] . "/" . basename ( __DIR__ );
            $file   = $folder . "/usersCreate.html";
            $errors = false;

            $cacheManager = new cacheManager( $folder, $file );
            if ( ! $cacheManager->isCacheExists ( ) ) { $errors = ! $cacheManager->write( $this->preRenderPage ( ) ); }
            if ( ! $errors ) { return $cacheManager->read ( $this->arrComponents ); }
            return "";
        }

        protected function onGet ( )
        {
            $layoutTemplate = new main ( trim ( basename ( __DIR__ ) ), trim ( basename ( __DIR__ ) ) );

            $html   = "<!DOCTYPE html>\n";
            $html   .= "<html lang=\"en\">\n";
            $html   .= "\t<head>\n";
            $html   .= $layoutTemplate->render_header ( [ "TITLE" => "Create A User" ], ".page { margin-top: 15px; }" );
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

        protected function onPost()
        {
            // TODO: Implement onPost() method.
        }
    }