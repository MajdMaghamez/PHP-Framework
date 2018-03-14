<?php namespace main\gui\buttons;

    abstract class button
    {
        const TYPE_PRIMARY      = 1;
        const TYPE_SECONDARY    = 2;
        const TYPE_SUCCESS      = 3;
        const TYPE_DANGER       = 4;
        const TYPE_WARNING      = 5;
        const TYPE_INFO         = 6;
        const TYPE_LIGHT        = 7;
        const TYPE_DARK         = 8;

        // bootstrap button size
        const SIZE_NORMAL       = 0;
        const SIZE_SMALL        = 1;
        const SIZE_LARGE        = 2;

        /**
         * button constructor.
         * @param string $label
         * @param string $id
         * @param int $type
         */
        public function __construct ( $label, $id, $type )
        {
            $this->label        = $label;
            $this->id           = $id;
            $this->type         = $type;

            $this->tabs         = "";
            $this->ClickEvent   = "";
            $this->icon         = "";
            $this->class        = "";
            $this->disabled     = false;

            // bootstrap outline style
            $this->outLine      = false;
            $this->formItem     = false;
            // bootstrap button size
            $this->size         = self::SIZE_NORMAL;
        }

        /**
         * @return string
         */
        public function getId ( )
        {
            return $this->id;
        }

        /**
         * @param string $id
         */
        public function setId ( $id )
        {
            $this->id = $id;
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
        public function isDisabled ( )
        {
            return $this->disabled;
        }

        /**
         * @param bool $disabled
         */
        public function setDisabled ( $disabled )
        {
            $this->disabled = $disabled;
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
        public function getClickEvent ( )
        {
            return $this->ClickEvent;
        }

        /**
         * @param string $ClickEvent
         */
        public function setClickEvent ( $ClickEvent )
        {
            $this->ClickEvent = $ClickEvent;
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
         * @return bool
         */
        public function isFormItem ( )
        {
            return $this->formItem;
        }

        /**
         * @param bool $formItem
         */
        public function setFormItem ( $formItem )
        {
            $this->formItem = $formItem;
        }

        /**
         * @return mixed
         */
        abstract public function renderBootstrap ( );
    }