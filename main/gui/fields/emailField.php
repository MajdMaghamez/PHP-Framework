<?php namespace main\gui\fields;

    class emailField extends field
    {
        /**
         * emailField constructor.
         * @param $label
         * @param $name
         * @param $id
         */
        public function __construct ( $label, $name, $id )
        {
            parent::__construct ( $label, $name, $id );

            $this->size         = 40;
            $this->maxLength    = 40;
            $this->value        = "";

            $this->addToClassList ( "form-control" );
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
            $this->value = sanitize_email ( $value );
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

            $html   = $tabs . "\t<input type=\"text\" ";
            $html   .= "class=\"" . implode ( " ", $this->getClassList ( ) ) . "\" ";
            $html   .= "id=\"" . $this->getId ( ) . "\" ";
            $html   .= "name=\"" . $this->getName ( ) . "\" ";
            $html   .= "size=\"" . $this->getSize ( ) . "\" ";
            $html   .= "maxlength=\"" . $this->getMaxLength ( ) . "\" ";
            $html   .= "placeholder=\"" . $this->getPlaceHolder ( ) . "\" ";
            $html   .= "value=\"{value_" . $this->getId ( ) . "}\"\n";
            $html   .= $tabs . "\tdata-parsley-trigger=\"change\" data-parsley-maxlength=\"" . $this->getMaxLength ( ) . "\" ";
            $html   .= "data-parsley-type=\"email\"";
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
                    if ( ! filter_var ( $this->getValue ( ), FILTER_VALIDATE_EMAIL ) )
                    {
                        $this->setError ( "invalid Email!" );
                        return false;
                    }
                }
            }
            else
            {
                if ( ! empty ( $this->getValue ( ) ) )
                {
                    if ( ! filter_var ( $this->getValue ( ), FILTER_VALIDATE_EMAIL ) )
                    {
                        $this->setError ( "invalid Email!" );
                        return false;
                    }
                }
            }

            return true;
        }
    }