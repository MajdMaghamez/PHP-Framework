<?php namespace main\gui\fields;

    class passwordField extends field
    {
        /**
         * passwordField constructor.
         * @param $label
         * @param $name
         * @param $id
         */
        public function __construct ($label, $name, $id )
        {
            parent::__construct ( $label, $name, $id );

            $this->regex        = "/^[a-zA-Z0-9.-_~!@#%^&]+$/";
            $this->size         = 40;
            $this->maxLength    = 40;
            $this->value        = "";
            $this->equalTo      = "";

            $this->addToClassList ( "form-control" );
        }

        /**
         * @return string
         */
        public function getEqualTo ( )
        {
            return $this->equalTo;
        }

        /**
         * @param string $equalTo
         */
        public function setEqualTo ( $equalTo )
        {
            $this->equalTo = $equalTo;
        }

        /**
         * @return int
         */
        public function getMaxLength ( )
        {
            return $this->maxLength;
        }

        /**
         * @param int $maxLength
         */
        public function setMaxLength ( $maxLength )
        {
            $this->maxLength = $maxLength;
        }

        /**
         * @return string
         */
        public function getRegex ( )
        {
            return $this->regex;
        }

        /**
         * @param string $regex
         */
        public function setRegex ( $regex )
        {
            $this->regex = $regex;
        }

        /**
         * @return int
         */
        public function getSize ( )
        {
            return $this->size;
        }

        /**
         * @param int $size
         */
        public function setSize ( $size )
        {
            $this->size = $size;
        }

        /**
         * @return string
         */
        public function getValue ( )
        {
            return $this->value;
        }

        /**
         * @param string $value
         */
        public function setValue ( $value )
        {
            $this->value = sanitize_string ( $value );
        }

        /**
         * @return string html
         */
        public function renderBootstrapLabel ( )
        {
            $tabs   = $this->getTabs ( );

            $html   = $tabs . "\t<label for=\"" . $this->getId ( ) . "\">";
            $html   .= $this->getIcon ( ) . " ";
            if ( $this->isShowStar ( ) ) { $html   .= "<span class=\"red\">*</span> "; }
            $html   .= $this->getLabel ( ) . "</label>\n";
            return $html;
        }

        /**
         * @return string html
         */
        public function renderBootstrapField ( )
        {
            $tabs   = $this->getTabs ( );

            $html   = $tabs . "\t<input type=\"password\" ";
            $html   .= "class=\"" . implode ( " ", $this->getClassList ( ) ) . "\" ";
            $html   .= "id=\"" . $this->getId ( ) . "\" ";
            $html   .= "name=\"" . $this->getName ( ) . "\" ";
            $html   .= "size=\"" . $this->getSize ( ) . "\" ";
            $html   .= "maxlength=\"" . $this->getMaxLength ( ) . "\" ";
            $html   .= "placeholder=\"" . $this->getPlaceHolder ( ) . "\" ";
            $html   .= "value=\"{value_" . $this->getId ( ) . "}\"\n";
            $html   .= $tabs . "\tdata-parsley-trigger=\"change\" data-parsley-maxlength=\"" . $this->getMaxLength ( ) . "\" ";
            $html   .= "data-parsley-pattern=\"" . $this->getRegex ( ) . "\" ";

            if ( ! empty ( $this->getEqualTo ( ) ) ) { $html   .= " data-parsley-equalto=\"#" . $this->getEqualTo ( ) . "\""; }
            if ( $this->isRequired ( ) ) { $html   .= " data-parsley-required=\"true\" required"; }
            if ( $this->isDisabled ( ) ) { $html   .= " disabled"; }

            $html   .= "/>\n";
            $html   .= $tabs . "\t<span class=\"error\">{error_" . $this->getId ( ) . "}</span>\n";

            return $html;
        }

        /**
         * @return string html
         */
        public function renderBootstrap ( )
        {
            $tabs   = $this->getTabs ( );

            $html   = $tabs . "<div class=\"form-group\">\n";
            $html   .= $this->renderBootstrapLabel ( );
            $html   .= $this->renderBootstrapField ( );
            $html   .= $tabs . "</div>\n";
            return $html;
        }

        /**
         * @return bool
         */
        public function validate ( )
        {
            if ( $this->isRequired ( ) )
            {
                if ( empty ( $this->getValue ( ) ) )
                {
                    $this->setError ( "required field!" );
                    return false;
                }
                else
                {
                    if ( ! preg_match ( $this->getRegex ( ), $this->getValue ( ) ) )
                    {
                        $this->setError ( "invalid character found!" );
                        return false;
                    }
                }
            }
            else
            {
                if ( ! empty ( $this->getValue ( ) ) )
                {
                    if ( ! preg_match ( $this->getRegex ( ), $this->getValue ( ) ) )
                    {
                        $this->setError ( "invalid character found!" );
                        return false;
                    }
                }
            }

            return true;
        }
    }