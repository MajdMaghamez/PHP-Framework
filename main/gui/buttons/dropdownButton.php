<?php namespace main\gui\buttons;

    class dropdownButton extends button
    {
        /**
         * dropdownButton constructor.
         * @param string $label
         * @param string $id
         * @param int $type
         * @param array $dropdown
         */
        public function __construct ($label, $id, $type, $dropdown )
        {
            parent::__construct ( $label, $id, $type );

            $this->dropdown = $dropdown;
        }

        /**
         * @return array
         */
        public function getDropdown ( )
        {
            return $this->dropdown;
        }

        /**
         * @param array $dropdown
         */
        public function setDropdown ( $dropdown )
        {
            $this->dropdown = $dropdown;
        }

        /**
         * @return string html
         */
        public function renderBootstrap ( )
        {
            $tabs   = $this->getTabs ( );
            $html   = $tabs;

            if ( $this->isFormItem ( ) ) { $html   .= "<div class=\"form-group\">\n" . $tabs . "\t"; }

            $html   .= "<div class=\"dropdown\">\n";
            $html   .= $tabs . "\t<button type=\"button\" ";
            $html   .= "id=\"" . $this->getId ( ) . "\" class=\"btn ";

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

            $html   .= " dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" ";

            if ( ! empty ( $this->getClickEvent ( ) ) ) { $html   .= "onClick=\"" . $this->getClickEvent ( ) . "\" "; }
            if ( $this->isDisabled ( ) ) { $html   .= "disabled "; }

            $html   .= ">" . $this->getIcon ( ) . " " . $this->getLabel ( ) . "</button>\n";
            $html   .= $tabs . "\t<div class=\"dropdown-menu\" aria-labelledby=\"" . $this->getId ( ) . "\">\n";

            foreach ( $this->getDropdown ( ) as $item => $value )
            {
                $html   .= $tabs . "\t\t<a class=\"dropdown-item\" href=\"" . $value["link"] . "\">" . $value["label"] . "</a>\n";
            }

            $html   .= $tabs . "\t</div>\n" . $tabs . "</div>\n";

            if ( $this->isformItem ( ) ) { $html   .= $tabs . "</div>\n"; }

            return $html;
        }
    }