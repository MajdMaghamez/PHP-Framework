<?php namespace main\gui\fields;

    abstract class field
    {
        // bootstrap field size
        const SIZE_NORMAL       = 0;
        const SIZE_SMALL        = 1;
        const SIZE_LARGE        = 2;

        /**
         * field constructor.
         * @param string $label
         * @param string $name
         * @param string $id
         */
        public function __construct ( $label, $name, $id )
        {
            $this->label        = $label;
            $this->name         = $name;
            $this->id           = $id;

            $this->Required     = false;
            $this->showStar     = false;
            $this->Disabled     = false;

            $this->icon         = "";
            $this->placeHolder  = "";
            $this->error        = "";

            $this->Fieldsize    = self::SIZE_NORMAL;
            $this->class        = "";
            $this->classList    = array ( );

            $this->tabs         = "";
        }

        /**
         * @return bool
         */
        public function isDisabled ( )
        {
            return $this->Disabled;
        }

        /**
         * @param bool $Disabled
         */
        public function setDisabled ( $Disabled )
        {
            $this->Disabled = $Disabled;
        }

        /**
         * @return bool
         */
        public function isRequired ( )
        {
            return $this->Required;
        }

        /**
         * @param bool $Required
         */
        public function setRequired ( $Required )
        {
            $this->Required = $Required;
            $this->setShowStar ( $Required );
        }

        /**
         * @return string
         */
        public function getError ( )
        {
            return $this->error;
        }

        /**
         * @param string $error
         */
        public function setError ( $error )
        {
            $this->error = $error;

            $this->addToClassList( "is-invalid" );
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
         * @return string
         */
        public function getName ( )
        {
            return $this->name;
        }

        /**
         * @param string $name
         */
        public function setName ( $name )
        {
            $this->name = $name;
        }

        /**
         * @return string
         */
        public function getPlaceHolder ( )
        {
            return $this->placeHolder;
        }

        /**
         * @param string $placeHolder
         */
        public function setPlaceHolder ( $placeHolder )
        {
            $this->placeHolder = $placeHolder;
        }

        /**
         * @return bool
         */
        public function isShowStar ( )
        {
            return $this->showStar;
        }

        /**
         * @param bool $showStar
         */
        public function setShowStar ( $showStar )
        {
            $this->showStar = $showStar;
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
            $array = explode ( " ", $class );
            foreach ( $array as $key => $value )
            {
                $this->addToClassList ( $value );
            }
        }

        /**
         * @return int
         */
        public function getFieldsize ( )
        {
            return $this->Fieldsize;
        }

        /**
         * @param int $Fieldsize
         */
        public function setFieldsize ( $Fieldsize )
        {
            $this->Fieldsize = $Fieldsize;

            switch ( $Fieldsize )
            {
                case self::SIZE_SMALL: $this->addToClassList ( "form-control-sm" ); break;
                case self::SIZE_LARGE: $this->addToClassList ( "form-control-lg" ); break;
            }
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
         * @return array
         */
        public function getClassList ( )
        {
            return $this->classList;
        }

        /**
         * @param string $class
         */
        public function addToClassList ( $class )
        {
            array_push ( $this->classList, $class );
        }

        abstract public function validate ( );

        abstract public function renderBootstrapLabel ( );

        abstract public function renderBootstrapField ( );

        abstract public function renderBootstrap ( );
    }