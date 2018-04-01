<?php namespace main\userControl;

    use main\models\User;
    use main\controllers\Controller;
    use main\frameworkHelper\imageResizer;

    class userProfile extends Controller
    {
        protected $user;

        protected $allowedFormats = [ 'image/jpeg', 'image/jpg', 'image/png', 'image/gif' ];
        protected $maxSize = 5000000; // 5 MB
        protected $json = array ( 'errors' => false );


        /**
         * userProfile constructor.
         * @throws \Exception
         */
        public function __construct ( )
        {
            session_auth ( );
            $this->user = new User( ["ID", $_SESSION ["USER_ID"] ] );
        }

        protected function onGet()
        {
            // TODO: Implement onGet() method.
        }

        protected function onPost()
        {
            // check if there were any errors in uploading the image.
            if ( 0 < $_FILES['upload']['error'] )
            {
               $this->json ['errors'] = true;
               $this->json ['message'] = 'There was an error in uploading profile image!';
               die ( json_encode( $this->json ) );
            }

            // check if file size exceeded the limit
            if ( $_FILES['upload']['size'] > $this->maxSize )
            {
                $this->json ['errors'] = true;
                $this->json ['message'] = 'The image size has exceeded the maximum size limit of 5 MB';
                die ( json_encode( $this->json ) );
            }

            // check if file type is accepted
            if ( ! in_array( $_FILES['upload']['type'], $this->allowedFormats ) )
            {
                $this->json ['errors'] = true;
                $this->json ['message'] = 'This type of image is not allowed to be uploaded';
                die ( json_encode( $this->json ) );
            }

            // get file extension
            $extension = pathinfo( $_FILES['upload']['name'], PATHINFO_EXTENSION );
            $newPicture = pathinfo( $GLOBALS["CACHE_FOLDER"] . "/users/" . $this->user->getProfilePicture(), PATHINFO_FILENAME );

            // setup the image to be processed

            // 1) transfer to off web root directory
            move_uploaded_file( $_FILES['upload']['tmp_name'], $GLOBALS ["OFF_WEB_ROOT"] . "/tmp" . $_FILES['upload']['name'] );

            // 2) set new profile picture name and extension
            $newPic = $GLOBALS["CACHE_FOLDER"] . "/users/" . $newPicture . '.' . $extension;
            $oldPic = $GLOBALS["CACHE_FOLDER"] . "/users/" . $this->user->getProfilePicture();


            $image = new imageResizer( $GLOBALS ["OFF_WEB_ROOT"] . "/tmp" . $_FILES['upload']['name'], null, 100, 100, false, $newPic, true, 100, $oldPic, true );

            if ( $image->process() )
            {
                $picture = $newPicture . '.' . $extension;
                $this->user->setProfilePicture( $picture );
                $this->json['message'] = 'Profile image has been successfully updated';
            }

            die ( json_encode( $this->json ) );
        }
    }