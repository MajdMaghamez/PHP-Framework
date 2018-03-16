<?php namespace main\gui\fields;

    class honeyPotField extends field
    {
        /**
         * honeyPotField constructor.
         * @param $label
         * @param $name
         * @param $id
         */
        public function __construct ($label, $name, $id )
        {
            parent::__construct ( $label, $name, $id );

            $this->regex        = "/^[a-zA-Z0-9 .-]*$/";
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
            return ""; // no need to render a label for this field
        }

        /**
         * @return string html
         */
        public function renderBootstrapField ( )
        {
            $tabs   = $this->getTabs ( );

            $html   = $tabs . "\t<input type=\"hidden\" ";
            $html   .= "class=\"" . implode ( " ", $this->getClassList ( ) ) . "\" ";
            $html   .= "id=\"" . $this->getId ( ) . "\" ";
            $html   .= "name=\"" . $this->getName ( ) . "\" ";
            $html   .= "size=\"" . $this->getSize ( ) . "\" ";
            $html   .= "maxlength=\"" . $this->getMaxLength ( ) . "\" ";
            $html   .= "placeholder=\"" . $this->getPlaceHolder ( ) . "\" ";
            $html   .= "value=\"{value_" . $this->getId ( ) . "}\"\n";
            $html   .= $tabs . "\tdata-parsley-trigger=\"change\" data-parsley-maxlength=\"" . $this->getMaxLength ( ) . "\" ";
            $html   .= "data-parsley-pattern=\"" . $this->getRegex ( ) . "\"";
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
            if ( ! empty ( $this->getValue ( ) ) )
            {
                $this->setError ( "error!" );
                return false;
            }

            return true;
        }
    }