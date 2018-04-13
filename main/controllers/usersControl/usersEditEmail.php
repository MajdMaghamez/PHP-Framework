<?php namespace main\controllers\usersControl;

    use main\models\User;
    use main\gui\guiCreator;
    use main\models\Permission;
    use main\layouts\bootstrap\main;
    use main\controllers\Controller;
    use main\gui\renderer\bootstrapForm;
    use main\frameworkHelper\cacheManager;
    use main\frameworkHelper\fieldsValidator;

    class usersEditEmail extends Controller
    {
        use usersNavigation;
        protected $canAccess    = false;
        protected $canAdd       = false;
        protected $canEdit      = false;

        protected $arrComponents;
        protected $user;

        /**
         * usersEditEmail constructor.
         * @throws \Exception
         */
        public function __construct ( )
        {
            session_auth ( );

            $this->canAccess    = Permission::getUserPermission( $_SESSION ["USER_ID"], "USER_VIEW" );
            $this->canAdd       = Permission::getUserPermission( $_SESSION ["USER_ID"], "USER_ADD" );
            $this->canEdit      = Permission::getUserPermission( $_SESSION ["USER_ID"], "USER_EDIT" );

            $id = intval ( sanitize_integer( getURLParams()[findInURL('Edit')+2], '/^[0-9]+$/' ) );

            if ( $this->canEdit )
            {
                $user = new User( ["ID", $id] );
                if ( ! is_null ( $user->getUser() ) )
                {
                    $this->user = $user;
                }
                else
                {
                    setFlashMessage( 'User Not Found!', '', 4 );
                }

                $Tabs   = "\t\t\t\t\t\t\t\t";
                $components =
                [
                    0 =>
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
                    1 =>
                    [
                        0 =>
                        [
                            "parent"        => "buttons",
                            "class"         => "formButton",
                            "label"         => "Update",
                            "id"            => "update",
                            "type"          => 1,
                            "setClass"      => "right",
                            "setFormItem"   => true,
                            "setTabs"       => $Tabs
                        ]
                    ]
                ];

                $arrComponents = new guiCreator( $components );
                $this->arrComponents = $arrComponents->getContainer ( );
            }
            else
            {
                setFlashMessage( 'Access Denied!', 'You do not have permission to access this page', 4 );
            }
        }

        /**
         * @return string
         */
        protected function preRenderPage ( )
        {
            $formId     = "form-parsley";
            $formMethod = "post";
            $formAction = "{form_action}";
            $formTabs   = "\t\t\t\t\t\t";
            $html       = bootstrapForm::renderInline( $this->arrComponents, $formTabs, $formId, $formMethod, $formAction );
            return $html;
        }

        /**
         * @return string
         */
        protected function renderPage ( )
        {
            $folder = $GLOBALS ["CACHE_FOLDER"] . "/" . basename ( __DIR__ );
            $file   = $folder . "/usersEditEmail.html";
            $errors = false;

            $name   = '';
            $id     = 0;
            if ( isset ( $this->user ) )
            {
                $name = $this->user->getName();
                $id = $this->user->getID();
            }

            $cacheManager   = new cacheManager( $folder, $file );
            if ( ! $cacheManager->isCacheExists ( ) ) { $errors = ! $cacheManager->write( $this->preRenderPage ( ) ); }

            $html    = "\t\t\t<div class=\"row\">\n";
            $html   .= "\t\t\t\t<div class=\"col-md-3 col-lg-3 col-xl-3\">\n";
            $html   .= self::renderNavigationLinks( $this->canAccess, $this->canAdd, $this->canEdit, ["ID" => $id, "NAME" => $name] );
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t<div class=\"col-md-9 col-lg-9 col-xl-9\">\n";
            $html   .= flash_message( "\t\t\t\t\t" );
            $html   .= "\t\t\t\t\t<div class=\"box\">\n";
            $html   .= "\t\t\t\t\t\t<h4><i class=\"fas fa-chevron-circle-right\"></i> Updating Email Address</h4><hr/>\n";
            if ( ! $errors ) { $html .= $cacheManager->read_values( $this->arrComponents, ["{form_action}"], [$GLOBALS["RELATIVE_TO_ROOT"] . "/Users/Edit/Email/" . $id] ); }
            $html   .= "\t\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t</div>\n";

            return $html;
        }

        protected function onGet ( )
        {
            $layoutTemplate = new main ( trim ( basename ( __DIR__ ) ), trim ( basename ( __DIR__ ) ) );

            if ( $this->canEdit )
            {
                if ( isset ( $this->user ) )
                {
                    $this->arrComponents[0][0]->setValue ( $this->user->getEmail() );
                }
            }

            $html    = "<!DOCTYPE html>\n";
            $html   .= "<html lang=\"en\">\n";
            $html   .= "\t<head>\n";
            $html   .= $layoutTemplate->render_header( ["TITLE" => "Edit User Email" ], ".page { margin-top: 15px; }" );
            $html   .= "\t</head>\n";
            $html   .= "\t<body>\n";
            $html   .= $layoutTemplate->render_navbar ( );
            $html   .= "\t\t<div class=\"container page\">\n";
            ( $this->canEdit ) ? $html .= $this->renderPage ( ) : $html .= flash_message( "\t\t\t" );
            $html   .= "\t\t</div>\n";
            $html   .= $layoutTemplate->render_footer( array ( ) );
            $html   .= "\t</body>\n";
            $html   .= "</html>\n";

            echo $html;
        }

        protected function onPost ( )
        {
            if ( $this->canEdit )
            {
                $errors = ! fieldsValidator::validate( $this->arrComponents );
                if ( $errors )
                {
                    setFlashMessage( '', 'Something went wrong, please make a correction and try again', 4 );
                }
                else
                {
                    $errors = ! $this->updateUserEmail ( );
                    if ( ! $errors )
                    {
                        setFlashMessage( '', 'User name has been updated successfully', 3 );
                    }
                }
            }

            $this->onGet();
        }

        /**
         * @return bool
         */
        protected function updateUserEmail ( )
        {
            $email  = $this->arrComponents[0][0]->getValue ( );

            if ( is_null ( $this->user->getUser() ) )
            {
                setFlashMessage( 'User Not found!', '', 4 );
                return false;
            }

            // check if email and new email are the same
            if ( $this->user->getEmail() == $email )
            {
                return true;
            }

            // check if this new email is associated with another user
            $user   = new User( ["EMAIL", $email] );
            if ( ! is_null ( $user->getUser() ) )
            {
                setFlashMessage("Failed!", "This email address is associated with another user", 4 );
                return false;
            }

            // update user email
            return $this->user->setEmail( $email );
        }
    }