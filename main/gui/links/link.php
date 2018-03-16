<?php namespace main\gui\links;

    class link
    {
        const TYPE_PRIMARY      = 1;
        const TYPE_SECONDARY    = 2;
        const TYPE_SUCCESS      = 3;
        const TYPE_DANGER       = 4;
        const TYPE_WARNING      = 5;
        const TYPE_INFO         = 6;
        const TYPE_LIGHT        = 7;
        const TYPE_DARK         = 8;

        const SIZE_NORMAL       = 0;
        const SIZE_SMALL        = 1;
        const SIZE_LARGE        = 2;

        /**
         * link constructor.
         * @param string $href
         * @param string $label
         */
        public function __construct ( $href, $label )
        {
            $this->href     = $href;
            $this->label    = $label;

            $this->likeBtn  = false;
            $this->outLine  = false;
            $this->formItem = false;

            $this->size     = self::SIZE_NORMAL;
            $this->type     = self::TYPE_PRIMARY;

            $this->icon     = "";
            $this->class    = "";
            $this->tabs     = "";
        }

        /**
         * @return string
         */
        public function getHref ( )
        {
            return $this->href;
        }

        /**
         * @param string $href
         */
        public function setHref ( $href )
        {
            $this->href = $href;
        }

        /**
         * @return string
         */
        public function getLabel ( )
        {
            return $this->label;
        }

        /**
         * @param string $label
         */
        public function setLabel ( $label )
        {
            $this->label = $label;
        }

        /**
         * @return bool
         */
        public function isLikeBtn ( )
        {
            return $this->likeBtn;
        }

        /**
         * @param bool $likeBtn
         */
        public function setLikeBtn ( $likeBtn )
        {
            $this->likeBtn = $likeBtn;
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
         * @return bool
         */
        public function isOutLine ( )
        {
            return $this->outLine;
        }

        /**
         * @param bool $outLine
         */
        public function setOutLine ( $outLine )
        {
            $this->outLine = $outLine;
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
         * @return string
         */
        public function getClass ( )
        {
            return $this->class;
        }

        /**
         * @param string $class
         */
        public function setClass ( $class )
        {
            $this->class = $class;
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
        public function getIcon ( )
        {
            return $this->icon;
        }

        /**
         * @param string $icon
         */
        public function setIcon ( $icon )
        {
            $this->icon = $icon;
        }

        /**
         * @return bool
         */
        public function isformItem ( )
        {
            return $this->formItem;
        }

        /**
         * @param bool $formItem
         */
        public function setformItem ( $formItem )
        {
            $this->formItem = $formItem;
        }

        /**
         * @return string html
         */
        public function renderBootstrap ( )
        {
            $tabs   = $this->getTabs ( );
            $html   = $tabs;

            if ( $this->isformItem ( ) ) { $html   .= "<div class=\"form-group\">\n" . $tabs . "\t"; }

            $html   .= "<a href=\"" . $this->getHref ( ) . "\" ";
            $html   .= "class=\"card-link";

            if ( $this->isLikeBtn ( ) )
            {
                $html   .= " btn";

                if ( $this->isOutLine ( ) ) { $html   .= " btn-outline-"; } else { $html   .= " btn-"; }

                switch ( $this->getType ( ) )
                {
                    case self::TYPE_PRIMARY:      $html .= "primary";     break;
                    case self::TYPE_SECONDARY:    $html .= "secondary";   break;
                    case self::TYPE_SUCCESS:      $html .= "success";     break;
                    case self::TYPE_DANGER:       $html .= "danger";      break;
                    case self::TYPE_WARNING:      $html .= "warning";     break;
                    case self::TYPE_INFO:         $html .= "info";        break;
                    case self::TYPE_LIGHT:        $html .= "light";       break;
                    case self::TYPE_DARK:         $html .= "dark";        break;
                }

                switch ( $this->getSize ( ) )
                {
                    case self::SIZE_SMALL:        $html .= " btn-sm";     break;
                    case self::SIZE_LARGE;        $html .= " btn-lg";     break;
                }
            }

            if ( ! empty ( $this->getClass ( ) ) ) { $html   .= " " . $this->getClass ( ); }

            $html   .= "\">" . $this->getIcon ( ) . " " . $this->getLabel ( ) . "</a>\n";

            if ( $this->isformItem ( ) ) { $html   .= $tabs . "</div>\n"; }

            return $html;
        }
    }