<?php namespace main\controllers\usersControl;

    use main\models\User;
    use main\models\Role;
    use main\gui\guiCreator;
    use main\models\Permission;
    use main\layouts\bootstrap\main;
    use main\controllers\Controller;
    use main\gui\renderer\bootstrapForm;
    use main\frameworkHelper\cacheManager;
    use main\frameworkHelper\fieldsValidator;

    class usersCreate extends Controller
    {
        use usersNavigation;
        protected $canAccess    = false;
        protected $canEdit      = false;
        protected $canAdd       = false;
        protected $arrComponents;

        /**
         * userCreate constructor.
         * @throws \Exception
         */
        public function __construct ( )
        {
            session_auth ( );

            $this->canAccess = Permission::getUserPermission( $_SESSION["USER_ID"], "USER_VIEW" );
            $this->canAdd    = Permission::getUserPermission( $_SESSION["USER_ID"], "USER_ADD" );
            $this->canEdit   = Permission::getUserPermission( $_SESSION["USER_ID"], "USER_EDIT" );

            if ( $this->canAdd )
            {
                $Tabs       = "\t\t\t\t\t\t\t\t";
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
                                        "setFieldSize"  => 1,
                                        "setTabs"       => $Tabs
                                    ]
                            ],
                        1 =>
                            [
                                0 =>
                                    [
                                        "parent"        => "fields",
                                        "class"         => "textField",
                                        "label"         => "Last Name",
                                        "name"          => "lastname",
                                        "id"            => "lastname",
                                        "setRequired"   => true,
                                        "setFieldSize"  => 1,
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
                                        "setFieldSize"  => 1,
                                        "setTabs"       => $Tabs
                                    ]
                            ],
                        3 =>
                            [
                                0 =>
                                    [
                                        "parent"        => "fields",
                                        "class"         => "selectField",
                                        "label"         => "Choose Role",
                                        "name"          => "role",
                                        "id"            => "role",
                                        "setRequired"   => true,
                                        "setFieldSize"  => 1,
                                        "setTabs"       => $Tabs
                                    ]
                            ],
                        4 =>
                            [
                                0 =>
                                    [
                                        "parent"        => "fields",
                                        "class"         => "passwordField",
                                        "label"         => "Password",
                                        "name"          => "password",
                                        "id"            => "password",
                                        "setFieldSize"  => 1,
                                        "setTabs"       => $Tabs
                                    ]
                            ],
                        5 =>
                            [
                                0 =>
                                    [
                                        "parent"            => "fields",
                                        "class"             => "checkboxField",
                                        "label"             => "Force user to change their password post Login",
                                        "name"              => "forcePassword",
                                        "id"                => "forcePassword",
                                        "setRenderInline"   => true,
                                        "setTabs"           => $Tabs
                                    ]
                            ],
                        6 =>
                            [
                                0 =>
                                    [
                                        "parent"        => "buttons",
                                        "class"         => "formButton",
                                        "label"         => "Add User",
                                        "id"            => "addUser",
                                        "type"          => 1,
                                        "setFormItem"   => true,
                                        "setTabs"       => $Tabs
                                    ]
                            ]
                    ];

                $arrComponents  = new guiCreator( $components );
                $this->arrComponents = $arrComponents->getContainer ( );

                foreach ( self::getRoleList ( ) as $index => $role )
                {
                    $this->arrComponents[3][0]->setOptions ( $role["ID"], $role["NAME"] );
                }
            }
            else
            {
                setFlashMessage( "Access Denied!", "You do not have permission to access this page", 4 );
            }

        }

        /**
         * @return string
         */
        protected function preRenderPage ( )
        {
            $formId     = "form-parsley";
            $formMethod = "post";
            $formAction = $GLOBALS ["RELATIVE_TO_ROOT"] . "/Users/Add";
            $formTabs   = "\t\t\t\t\t\t";
            $html   = bootstrapForm::renderStatic( $this->arrComponents, $formTabs, $formId, $formMethod, $formAction );
            return $html;
        }

        /**
         * @return mixed|string
         */
        protected function renderPage ( )
        {
            $folder = $GLOBALS ["CACHE_FOLDER"] . "/" . basename ( __DIR__ );
            $file   = $folder . "/usersCreate.html";
            $errors = false;

            $cacheManager = new cacheManager( $folder, $file );
            if ( ! $cacheManager->isCacheExists ( ) ) { $errors = ! $cacheManager->write( $this->preRenderPage ( ) ); }

            $html    = "\t\t\t<div class=\"row\">\n";
            $html   .= "\t\t\t\t<div class=\"col-md-3 col-lg-3 col-xl-3\">\n";
            $html   .= self::renderNavigationLinks( $this->canAccess, $this->canAdd, $this->canEdit );
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t<div class=\"col-md-9 col-lg-9 col-xl-9\">\n";
            $html   .= flash_message ( "\t\t\t\t\t" );
            $html   .= "\t\t\t\t\t<div class=\"box\">\n";
            $html   .= "\t\t\t\t\t<h4><i class=\"fas fa-chevron-circle-right\"></i> Adding New User</h4><hr/>\n";
            $html   .= "\t\t\t\t\t<div class=\"row\">\n";
            $html   .= "\t\t\t\t\t\t<div class=\"col-md-6 col-lg-6 col-xl-6\">\n";
            if ( ! $errors ) { $html .=  $cacheManager->read ( $this->arrComponents ); }
            $html   .= "\t\t\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t\t\t<div class=\"col-md-6 col-lg-6 col-xl-6\">\n";
            $html   .= "\t\t\t\t\t\t\t<div id=\"roleDetails\">\n";
            $html   .= "\t\t\t\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t</div>\n";

            return $html;
        }

        protected function onGet ( )
        {
            $layoutTemplate = new main ( trim ( basename ( __DIR__ ) ), trim ( basename ( __DIR__ ) ) );
            $JavaScript     = array ( "LIBRARIES" => [ "AFTER" => [ $GLOBALS ["RELATIVE_TO_ROOT"] . "/assets/js/usersControl/usersCreate.js" ] ] );

            $html   = "<!DOCTYPE html>\n";
            $html   .= "<html lang=\"en\">\n";
            $html   .= "\t<head>\n";
            $html   .= $layoutTemplate->render_header ( [ "TITLE" => "Create A User" ], ".page { margin-top: 15px; } tbody {overflow-y:scroll; height: 100px; width:100%;}" );
            $html   .= "\t</head>\n";
            $html   .= "\t<body>\n";
            $html   .= $layoutTemplate->render_navbar ( );
            $html   .= "\t\t<div class=\"container page\">\n";
            ( $this->canAdd ) ? $html .= $this->renderPage ( ) : $html .= flash_message( "\t\t\t" );
            $html   .= "\t\t</div>\n";
            $html   .= $layoutTemplate->render_footer ( $JavaScript );
            $html   .= "\t</body>\n";
            $html   .= "</html>\n";

            echo $html;
        }

        protected function onPost ( )
        {
            if ( $this->canAdd )
            {
                $errors = ! fieldsValidator::validate( $this->arrComponents );
                if ( $errors )
                {
                    setFlashMessage( '', 'Something went wrong, please make a correction and try again', 4 );
                }
                else
                {
                    $errors = ! $this->addUser ( );
                    if ( ! $errors )
                        setFlashMessage( '', 'User has been created successfully!', 3 );
                }
            }

            $this->onGet();
        }

        protected function addUser ( )
        {
            $Data ['first']      = $this->arrComponents[0][0]->getValue ( );
            $Data ['last']       = $this->arrComponents[1][0]->getValue ( );
            $Data ['email']      = $this->arrComponents[2][0]->getValue ( );
            $Data ['role']       = $this->arrComponents[3][0]->getValue ( );
            $Data ['changePswd'] = intval ( $this->arrComponents[5][0]->isChecked ( ) );

            if ( ! empty ( $this->arrComponents[4][0]->getValue ( ) ) )
            {
                $Data ['password'] = $this->arrComponents[4][0]->getValue ( );
            }
            else
            {
                $Data ['password'] = randomToken();
            }


            // check if user exists
            $User       = new User( [ "EMAIL", $Data ['email'] ] );
            if ( ! is_null ( $User->getUser() ) )
            {
                setFlashMessage( 'Failed!', 'This email address is associated with another user', 4 );
                return false;
            }

            // store user in database and return their ID
            $Data ['id'] = $User->store( $Data );

            if ( $Data ['id'] > 0 )
            {
                // need to send user email with username and password first
                return $User->sendVerificationEmail();
            }

            setFlashMessage ( "Error!", "We were unable to create user account, try again later.", 4 );
            return false;

        }
    }