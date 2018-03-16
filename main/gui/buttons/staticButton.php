<?php namespace main\gui\buttons;

    class staticButton extends button
    {
        /**
         * staticButton constructor.
         * @param string $label
         * @param string $id
         * @param int $type
         */
        public function __construct ($label, $id, $type )
        {
            parent::__construct ( $label, $id, $type );
        }

        /**
         * @return string html
         */
        public function renderBootstrap ( )
        {
            $tabs   = $this->getTabs ( );
            $html   = $tabs;

            if ( $this->isFormItem ( ) ) { $html   .= "<div class=\"form-group\">\n" . $tabs . "\t"; }

            $html   .= "<button type=\"button\" ";
            $html   .= "id=\"" . $this->getId ( ) . "\" ";
            $html   .= "class=\"btn ";

            if ( $this->isOutLine ( ) ) { $html   .= "btn-outline-"; } else { $html   .= "btn-"; }

            switch ( $this->getType ( ) )
            {
                case parent::TYPE_PRIMARY:      $html .= "primary";     break;
                case parent::TYPE_SECONDARY:    $html .= "secondary";   break;
                case parent::TYPE_SUCCESS:      $html .= "success";     break;
                case parent::TYPE_DANGER:       $html .= "danger";      break;
                case parent::TYPE_WARNING:      $html .= "warning";     break;
                case parent::TYPE_INFO:         $html .= "info";        break;
                case parent::TYPE_LIGHT:        $html .= "light";       break;
                case parent::TYPE_DARK:         $html .= "dark";        break;
                default:                        $html .= "primary";     break;
            }

            switch ( $this->getSize ( ) )
            {
                case parent::SIZE_SMALL:        $html .= " btn-sm";     break;
                case parent::SIZE_LARGE;        $html .= " btn-lg";     break;
            }

            if ( ! empty ( $this->getClass ( ) ) ) { $html   .= " " . $this->getClass ( ); }

            $html   .= "\" ";

            if ( ! empty ( $this->getClickEvent ( ) ) ) { $html   .= "onClick=\"" . $this->getClickEvent ( ) . "\" "; }
            if ( $this->isDisabled ( ) ) { $html   .= "disabled "; }

            $html   .= ">" . $this->getIcon ( ) . " " . $this->getLabel ( ) . "</button>\n";

            if ( $this->isformItem ( ) ) { $html   .= $tabs . "</div>\n"; }

            return $html;
        }
    }