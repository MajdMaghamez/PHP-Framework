<?php namespace main\controllers\usersControl;

    use main\models\User;
    use main\gui\guiCreator;
    use main\models\Permission;
    use main\layouts\bootstrap\main;
    use main\controllers\Controller;
    use main\gui\renderer\bootstrapForm;
    use main\frameworkHelper\cacheManager;
    use main\frameworkHelper\fieldsValidator;

    class usersEditName extends Controller
    {
        use usersNavigation;
        protected $canAccess    = false;
        protected $canAdd       = false;
        protected $canEdit      = false;

        protected $arrComponents;
        protected $user;

        /**
         * usersEditName constructor.
         * @throws \Exception
         */
        public function __construct ( )
        {
            session_auth ( );

            $this->canAccess    = Permission::getUserPermission( $_SESSION ["USER_ID"], "USER_VIEW" );
            $this->canAdd       = Permission::getUserPermission( $_SESSION ["USER_ID"], "USER_ADD" );
            $this->canEdit      = Permission::getUserPermission( $_SESSION ["USER_ID"], "USER_EDIT" );

            $id = intval ( sanitize_integer( getURLParams()[findInURL('Edit')+1], '/^[0-9]+$/' ) );

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

                $arrComponents  = new guiCreator( $components );
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
            $file   = $folder . "/usersEditName.html";
            $errors = false;

            $name   = '';
            $id     = 0;
            if ( isset ( $this->user ) )
            {
                $name = $this->user->getName();
                $id = $this->user->getID();
            }

            $cacheManager = new cacheManager( $folder, $file );
            if ( ! $cacheManager->isCacheExists ( ) ) { $errors = ! $cacheManager->write( $this->preRenderPage ( ) ); }

            $html    = "\t\t\t<div class=\"row\">\n";
            $html   .= "\t\t\t\t<div class=\"col-md-3 col-lg-3 col-xl-3\">\n";
            $html   .= self::renderNavigationLinks( $this->canAccess, $this->canAdd, $this->canEdit, ["ID" => $id, "NAME" => $name] );
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t<div class=\"col-md-9 col-lg-9 col-xl-9\">\n";
            $html   .= flash_message( "\t\t\t\t\t" );
            $html   .= "\t\t\t\t\t<div class=\"box\">\n";
            $html   .= "\t\t\t\t\t\t<h4><i class=\"fas fa-chevron-circle-right\"></i> Updating Name</h4><hr/>\n";
            if ( ! $errors ) { $html .= $cacheManager->read_values( $this->arrComponents, ["{form_action}"], [$GLOBALS ["RELATIVE_TO_ROOT"] . "/Users/Edit/" . $id] ); }
            $html   .= "\t\t\t\t\t</div>\n";
            $html   .= "\t\t\t\t</div>\n";
            $html   .= "\t\t\t</div>\n";

            return $html;
        }

        protected function onGet ( )
        {
            $layoutTemplate = new main ( trim ( basename ( __DIR__ ) ), trim ( basename( __DIR__ ) ) );

            if ( $this->canEdit )
            {
                if ( isset ( $this->user ) )
                {
                    $this->arrComponents[0][0]->setValue ( $this->user->getFirst() );
                    $this->arrComponents[1][0]->setValue ( $this->user->getLast() );
                }
            }

            $html    = "<!DOCTYPE html>\n";
            $html   .= "<html lang=\"en\">\n";
            $html   .= "\t<head>\n";
            $html   .= $layoutTemplate->render_header ( [ "TITLE" => "Edit User Name" ], ".page { margin-top: 15px; }" );
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
                    $errors = ! $this->updateUserName ( );
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
        protected function updateUserName ( )
        {
            $first  = $this->arrComponents[0][0]->getValue ( );
            $last   = $this->arrComponents[1][0]->getValue ( );

            if ( is_null ( $this->user->getUser() ) )
            {
                setFlashMessage( 'User Not Found!', '', 4 );
                return false;
            }

            $this->user->setFirst( $first );
            $this->user->setLast( $last );

            return true;
        }
    }