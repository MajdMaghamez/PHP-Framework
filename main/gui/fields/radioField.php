<?php namespace main\gui\fields;

    class radioField extends field
    {
        /**
         * radioField constructor.
         * @param $label
         * @param $name
         * @param $id
         * @param $value
         */
        public function __construct ($label, $name, $id, $value )
        {
            parent::__construct ( $label, $name, $id );

            $this->checked      = 0;
            $this->value        = $value;
            $this->renderInline = false;

            $this->addToClassList ("form-check-input" );
        }

        /**
         * @return int
         */
        public function isChecked ( )
        {
            return $this->checked;
        }

        /**
         * @param int $checked
         */
        public function setChecked ( $checked )
        {
            $this->checked = $checked;
        }

        /**
         * @return string
         */
        public function getValue ( )
        {
            if ( $this->checked ) return "checked";
            return "";
        }

        /**
         * @param string $value
         */
        public function setValue ( $value )
        {
            if ( $value ) { $this->checked = 1; } else { $this->checked = 0; }
        }

        /**
         * @return bool
         */
        public function isRenderInline ( )
        {
            return $this->renderInline;
        }

        /**
         * @param bool $renderInline
         */
        public function setRenderInline ( $renderInline )
        {
            $this->renderInline = $renderInline;
        }

        /**
         * @return string html
         */
        public function renderBootstrapLabel ( )
        {
            $tabs   = $this->getTabs ( );

            $html   = $tabs . "<label class=\"form-check-label\" for=\"" . $this->getId ( ) . "\">";
            $html   .= $this->getIcon ( ) . " ";
            if ( $this->isShowStar ( ) )  { $html   .= "<span class=\"red\">*</span> "; }
            $html   .= $this->getLabel ( ) . "</label>\n";
            return $html;
        }

        /**
         * @return string html
         */
        public function renderBootstrapField ( )
        {
            $tabs   = $this->getTabs ( );

            $html   = $tabs . "<input type=\"radio\" ";
            $html   .= "class=\"" . implode ( " ", $this->getClassList ( ) ) . "\" ";
            $html   .= "id=\"" . $this->getId ( ) . "\" ";
            $html   .= "name=\"" . $this->getName ( ) . "\" ";
            $html   .= "value=\"" . $this->value . "\" ";
            $html   .= "{value_" . $this->getId ( ) . "} ";
            if ( $this->isRequired ( ) ) { $html   .= "data-parsley-required=\"true\""; }
            if ( $this->isDisabled ( ) ) { $html   .= " disabled"; }
            $html   .= "/>\n";
            return $html;
        }

        /**
         * @return string html
         */
        public function renderBootstrap ( )
        {
            $tabs   = $this->getTabs ( );

            if ( $this->isRenderInline ( ) )
            {
                $html   = $tabs . "<div class=\"form-check form-check-inline\">\n";
            }
            else
            {
                $html   = $tabs . "<div class=\"form-check";
                if ( $this->isDisabled ( ) )
                    $html   .= " disabled";
                $html   .= "\">\n";
            }

            $html   .= $this->renderBootstrapField ( );
            $html   .= $this->renderBootstrapLabel ( );
            $html   .= $tabs . "<span class=\"error\">{error_" . $this->getId ( ) . "}</span>\n";
            $html   .= "</div>\n";
            return $html;
        }

        /**
         * @return bool
         */
        public function validate()
        {
            if ( $this->isRequired ( ) )
            {
                if ( ! $this->isChecked ( ) )
                {
                    $this->setError( "required field!" );
                    return false;
                }
            }

            return true;
        }
    }