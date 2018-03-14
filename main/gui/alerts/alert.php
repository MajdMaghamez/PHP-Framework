<?php namespace main\gui\alerts;

    class alert
    {
        const TYPE_PRIMARY      = 1;
        const TYPE_SECONDARY    = 2;
        const TYPE_SUCCESS      = 3;
        const TYPE_DANGER       = 4;
        const TYPE_WARNING      = 5;
        const TYPE_INFO         = 6;
        const TYPE_LIGHT        = 7;
        const TYPE_DARK         = 8;

        /**
         * alert constructor.
         * @param $header
         * @param $message
         * @param $type [ primary, secondary, success, danger, warning, info, light, dark ]
         */
        public function __construct ( $header, $message, $type )
        {
            $this->header   = $header;
            $this->message  = $message;
            $this->type     = $type;

            $this->link     = array ( );
            $this->tabs     = "";
            $this->dismiss  = true;
        }

        /**
         * @return bool
         */
        public function isDismiss ( )
        {
            return $this->dismiss;
        }

        /**
         * @param bool $dismiss
         */
        public function setDismiss ( $dismiss )
        {
            $this->dismiss = $dismiss;
        }

        /**
         * @return string
         */
        public function getHeader ( )
        {
            return $this->header;
        }

        /**
         * @param string $header
         */
        public function setHeader ( $header )
        {
            $this->header = $header;
        }

        /**
         * @return array
         */
        public function getLink ( )
        {
            return $this->link;
        }

        /**
         * @param array $link
         */
        public function setLink ( $link )
        {
            $this->link = $link;
        }

        /**
         * @return string
         */
        public function getMessage ( )
        {
            return $this->message;
        }

        /**
         * @param string $message
         */
        public function setMessage ( $message )
        {
            $this->message = $message;
        }

        /**
         * @return string
         */
        public function getTabs ( )
        {
            return $this->tabs;
        }

        /**
         * @param string $tabs
         */
        public function setTabs ( $tabs )
        {
            $this->tabs = $tabs;
        }

        /**
         * @return int
         */
        public function getType ( )
        {
            return $this->type;
        }

        /**
         * @param int $type
         */
        public function setType ( $type )
        {
            $this->type = $type;
        }

        /**
         * @return string html
         */
        public function renderBootstrap ( )
        {
            $tabs   = $this->getTabs ( );
            $html   = $tabs . "<div class=\"";

            switch ( $this->getType ( ) )
            {
                case self::TYPE_PRIMARY:    $html .= "alert alert-primary";     break;
                case self::TYPE_SECONDARY:  $html .= "alert alert-secondary";   break;
                case self::TYPE_SUCCESS:    $html .= "alert alert-success";     break;
                case self::TYPE_DANGER:     $html .= "alert alert-danger";      break;
                case self::TYPE_WARNING:    $html .= "alert alert-warning";     break;
                case self::TYPE_INFO:       $html .= "alert alert-info";        break;
                case self::TYPE_LIGHT:      $html .= "alert alert-light";       break;
                case self::TYPE_DARK:       $html .= "alert alert-dark";        break;
                default:                    $html .= "alert alert-info";        break;
            }

            if ( $this->isDismiss ( ) ) { $html .= " alert-dismissible fade show"; }

            $html .= "\" role=\"alert\">\n";

            if ( strlen ( $this->getHeader ( ) ) > 0 ) { $html .= $tabs . "\t<h4 class=\"alert-heading\">" . $this->getHeader ( ) . "</h4>\n"; }

            $html .= $tabs . "\t" . $this->getMessage ( ) . "\n";

            if ( ! empty ( array_filter ( $this->getLink ( ) ) ) )
            {
                $html .= $tabs . "\t<a href=\"" . $this->getLink ( )["URL"] . "\" class=\"alert-link\">" . $this->getLink ( )["NAME"] . "</a>\n";
            }

            if ( $this->isDismiss ( ) )
            {
                $html .= $tabs . "\t<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">\n";
                $html .= $tabs . "\t\t<span aria-hidden=\"true\">&times;</span>\n";
                $html .= $tabs . "\t</button>\n";
            }

            $html .= $tabs . "</div>\n";

            return $html;
        }
    }