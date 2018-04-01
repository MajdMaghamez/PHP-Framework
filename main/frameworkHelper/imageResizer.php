<?php namespace main\frameworkHelper;

    class imageResizer
    {
        protected $file             = null;
        protected $data             = '';
        protected $width            = 0;
        protected $height           = 0;
        protected $proportional     = false;
        protected $output           = '';
        protected $deleteOriginal   = false;
        protected $quality          = 100;

        protected $Exist            = null;
        protected $deleteIfExists   = true;

        /**
         * imageResizer constructor.
         * @param null $file: you can give the file where the image is located ex: /var/www/html/image.jpg
         * @param string $data: you can give file content such as file_get_contents('image.jpg')
         * @param int $width: desired width
         * @param int $height desired height
         * @param bool $proportional: keep image proportional default = false
         * @param string $output: name of the new file to where to save the image ex: /var/www/html/save/image.jpg
         * @param bool $deleteOriginal: deletes the original image
         * @param int $quality: sets the image quality from 1-100 ( 100 is best quality ) default = 100
         * @param null $Exist: path to destination
         * @param bool $deleteIfExists: delete if a picture with similar name exists at destination
         */
        public function __construct ( $file, $data, $width, $height, $proportional, $output, $deleteOriginal, $quality, $Exist, $deleteIfExists )
        {
            $this->file = $file;
            $this->data = $data;
            $this->width = $width;
            $this->height = $height;
            $this->proportional = $proportional;
            $this->output = $output;
            $this->deleteOriginal = $deleteOriginal;
            $this->quality = $quality;
            $this->Exist = $Exist;
            $this->deleteIfExists = $deleteIfExists;
        }

        /**
         * @return null
         */
        public function getExist()
        {
            return $this->Exist;
        }

        /**
         * @param null $Exist
         */
        public function setExist( $Exist )
        {
            $this->Exist = $Exist;
        }

        /**
         * @return bool
         */
        public function isDeleteIfExists()
        {
            return $this->deleteIfExists;
        }

        /**
         * @param bool $deleteIfExists
         */
        public function setDeleteIfExists( $deleteIfExists )
        {
            $this->deleteIfExists = $deleteIfExists;
        }

        /**
         * @return null
         */
        public function getFile( )
        {
            return $this->file;
        }

        /**
         * @param null $file
         */
        public function setFile( $file )
        {
            $this->file = $file;
        }

        /**
         * @return string
         */
        public function getData( )
        {
            return $this->data;
        }

        /**
         * @param string $data
         */
        public function setData( $data )
        {
            $this->data = $data;
        }

        /**
         * @return int
         */
        public function getWidth( )
        {
            return $this->width;
        }

        /**
         * @param int $width
         */
        public function setWidth( $width )
        {
            $this->width = $width;
        }

        /**
         * @return int
         */
        public function getHeight( )
        {
            return $this->height;
        }

        /**
         * @param int $height
         */
        public function setHeight( $height )
        {
            $this->height = $height;
        }

        /**
         * @return bool
         */
        public function isProportional( )
        {
            return $this->proportional;
        }

        /**
         * @param bool $proportional
         */
        public function setProportional( $proportional )
        {
            $this->proportional = $proportional;
        }

        /**
         * @return string
         */
        public function getOutput( )
        {
            return $this->output;
        }

        /**
         * @param string $output
         */
        public function setOutput( $output )
        {
            $this->output = $output;
        }

        /**
         * @return bool
         */
        public function isDeleteOriginal( )
        {
            return $this->deleteOriginal;
        }

        /**
         * @param bool $deleteOriginal
         */
        public function setDeleteOriginal( $deleteOriginal )
        {
            $this->deleteOriginal = $deleteOriginal;
        }

        /**
         * @return int
         */
        public function getQuality( )
        {
            return $this->quality;
        }

        /**
         * @param int $quality
         */
        public function setQuality( $quality )
        {
            $this->quality = $quality;
        }

        /**
         * @return bool
         */
        public function process ( )
        {
            if ( $this->getHeight() <= 0 && $this->getWidth() <= 0 ) return false;
            if ( $this->getFile() === null && $this->getData() === null ) return false;

            // setting default and meta
            $info       = $this->getFile() !== null ? getimagesize( $this->getFile() ) : getimagesizefromstring( $this->getData() );
            $image      = '';

            $final_w    = 0;
            $final_h    = 0;

            list ( $old_w, $old_h ) = $info;

            $crop_w     = 0;
            $crop_h     = 0;


            // calculating proportionality
            if ( $this->isProportional() )
            {
                if      ( $this->getWidth() == 0 )  $factor = $this->getHeight() / $old_h;
                else if ( $this->getHeight() == 0 ) $factor = $this->getWidth() / $old_w;
                else                                $factor = min ( $this->getWidth() / $old_w, $this->getHeight() / $old_h );

                $final_w    = round ( $old_w * $factor );
                $final_h    = round ( $old_h * $factor );
            }
            else
            {
                $final_w    = ( $this->getWidth() <= 0 ) ? $old_w : $this->getWidth();
                $final_h    = ( $this->getHeight() <= 0 ) ? $old_h : $this->getHeight();

                $width_x    = $old_w / $this->getWidth();
                $height_x   = $old_h / $this->getHeight();

                $x          = min ( $width_x, $height_x );
                $crop_w     = ( $old_w - $this->getWidth() * $x ) / 2;
                $crop_h     = ( $old_h - $this->getHeight() * $x ) / 2;
            }

            // loading image to memory according to type
            switch ( $info[2] )
            {
                case IMAGETYPE_JPEG     : $this->getFile() !== null ? $image = imagecreatefromjpeg( $this->getFile( ) ) : $image = imagecreatefromjpeg( $this->getData( ) );    break;
                case IMAGETYPE_JPEG2000 : $this->getFile() !== null ? $image = imagecreatefromjpeg( $this->getFile( ) ) : $image = imagecreatefromjpeg( $this->getData( ) );    break;
                case IMAGETYPE_PNG      : $this->getFile() !== null ? $image = imagecreatefrompng( $this->getFile( ) ) : $image = imagecreatefrompng( $this->getData( ) );      break;
                case IMAGETYPE_GIF      : $this->getFile() !== null ? $image = imagecreatefromgif( $this->getFile( ) ) : $image = imagecreatefromgif( $this->getData( ) );      break;
                default : return false;
            }

            // resizing / re-sampling / transparency -preserving magic
            $image_resized  = imagecreatetruecolor( $final_w, $final_h );
            if ( $info[2] == IMAGETYPE_GIF || $info[2] == IMAGETYPE_PNG )
            {
                $transparency = imagecolortransparent($image);
                $palletSize = imagecolorstotal($image);

                if ( $transparency >= 0 && $transparency < $palletSize )
                {
                    $trans_color    = imagecolorsforindex($image, $transparency);
                    $transparency   = imagecolorallocate($image_resized, $trans_color['red'], $trans_color['green'], $trans_color['blue']);
                    imagefill( $image_resized, 0, 0, $transparency );
                    imagecolortransparent($image_resized, $transparency);
                }
                else if ( $info[2] == IMAGETYPE_PNG )
                {
                    imagealphablending($image_resized, false);
                    $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
                    imagefill($image_resized, 0, 0, $color);
                    imagesavealpha($image_resized, true);
                }
            }

            imagecopyresampled($image_resized, $image, 0, 0, $crop_w, $crop_h, $final_w, $final_h, $old_w -2 * $crop_w, $old_h -2 * $crop_h);

            // deleting original
            if ( $this->isDeleteOriginal() )
                @unlink( $this->getFile() );

            // preparing a method of providing result
            switch ( strtolower( $this->getOutput() ) )
            {
                case 'browser':
                    $mime = image_type_to_mime_type($info[2]);
                    header('Content-type: $mim' );
                    $this->setOutput( null );
                    break;

                case 'file':
                    $this->setOutput($this->getFile());
                    break;

                case 'return':
                    return $image_resized;
                    break;

                default:
                    break;
            }

            // writing image according to type to the output destination and image quality
            switch ( $info[2] )
            {
                case IMAGETYPE_GIF      : imagegif($image_resized, $this->getOutput()); break;
                case IMAGETYPE_JPEG     : imagejpeg($image_resized, $this->getOutput(), $this->getQuality()); break;
                case IMAGETYPE_JPEG2000 : imagejpeg($image_resized, $this->getOutput(), $this->getQuality()); break;
                case IMAGETYPE_PNG      : $this->setQuality(9 - (int)((0.9 * $this->getQuality())/10.0));
                imagepng($image_resized, $this->getOutput(), $this->getQuality()); break;

                default:
                    return false;
            }

            // check if the destination has a picture with similar name
            if ( $this->isDeleteIfExists() )
            {
                if ( file_exists( $this->getExist ( ) ) )
                    @unlink( $this->getExist() );
            }

            return true;
        }

    }