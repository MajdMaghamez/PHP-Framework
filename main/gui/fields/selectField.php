<?php namespace main\gui\fields;

    use main\storage\database;
    class selectField extends field
    {
        /**
         * selectField constructor.
         * @param $label
         * @param $name
         * @param $id
         * @param int $groupId
         * @param string $table
         */
        public function __construct ( $label, $name, $id, $groupId = 0, $table = "selectfield_options" )
        {
            parent::__construct ( $label, $name, $id );

            $this->value    = "";

            $this->groupId  = $groupId;
            $this->options  = array ( );
            $this->table = $table;

            if ( $groupId > 0 ) { $this->get_query_options ( ); }
            $this->addToClassList ( "form-control" );
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
            $this->value = $value;
        }

        /**
         * @return array
         */
        public function getOptions ( )
        {
            return $this->options;
        }

        /**
         * @param int $id
         * @param string $text
         */
        public function setOptions ( $id, $text )
        {
            $this->options [$id] = $text;
        }

        /**
         * @return int
         */
        public function getGroupId ( )
        {
            return $this->groupId;
        }

        /**
         * @param int $groupId
         */
        public function setGroupId ( $groupId )
        {
            $this->groupId = $groupId;
            if ( $groupId > 0 ) { $this->get_query_options ( ); }
        }

        /**
         * @return string
         */
        public function getTable ( )
        {
            return $this->table;
        }

        /**
         * @param string $table
         */
        public function setTable ( $table )
        {
            $this->table = $table;
        }

        private function get_query_options ( )
        {
            $table      = $this->getTable ( );
            $groupId    = $this->getGroupId ( );

            $select_sql = "SELECT `SELECTION`, `TEXT` FROM `" . $table . "` where `GROUP_ID` = :GROUP_ID;";
            $sql_params = array ( ":GROUP_ID" => [ "TYPE" => "INT", "VALUE" => $groupId ] );
            $results    = database::runSelectQuery ( $select_sql, $sql_params );

            if ( isset ( $results ) ) { foreach ( $results as $key => $value ) { $this->setOptions ( $value ["SELECTION"], $value ["TEXT"] ); } }
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

            $html   = $tabs . "\t<select ";
            $html   .= "class=\"" . implode ( " ", $this->getClassList ( ) ) . "\" ";
            $html   .= "id=\"" . $this->getId ( ) . "\" ";
            $html   .= "name=\"" . $this->getName ( ) . "\" ";

            if ( $this->isRequired ( ) )
            {
                $html   .= "data-parsley-range=\"[" . min ( array_keys ( $this->getOptions ( ) ) ) . "," . max ( array_keys ( $this->getOptions ( ) ) ) . "]\" ";
                $html   .= "data-parsley-required=\"true\"";
            }
            if ( $this->isDisabled ( ) ) { $html   .= " disabled"; }
            $html   .= ">\n";

            $html   .= $tabs . "\t\t<option value=\"0\"> --- Please Select --- </option>\n";
            foreach ( $this->getOptions ( ) as $key => $value )
            {
                $html   .= $tabs . "\t\t<option value=\"" . $key . "\"{selected_" . $this->getId ( ) . "_" . $key . "}>" . $value . "</option>\n";
            }

            $html   .= $tabs . "\t</select>\n";
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
                if ( ! is_numeric ( $this->getValue ( ) ) )
                {
                    $this->setError( "invalid selection" );
                    return false;
                }
                else
                {
                    if ( $this->getValue ( ) <= 0 )
                    {
                        $this->setError( "required field!" );
                        return false;
                    }
                }
            }
            else
            {
                if ( $this->getValue ( ) !== "" )
                {
                    if ( ! is_numeric ( $this->getValue ( ) ) )
                    {
                        $this->setError( "invalid selection" );
                        return false;
                    }
                }
            }

            return true;
        }
    }