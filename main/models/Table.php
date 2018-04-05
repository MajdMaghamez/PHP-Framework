<?php namespace main\models;

    use main\storage\database;
    use main\gui\alerts\alert;
    abstract class Table
    {
        /**
         * Table constructor.
         * @param $table
         * @param $columns
         * @param $primary
         * @param $unique
         */
        public function __construct ( $table, $columns, $primary, $unique )
        {
            $this->table    = $table;
            $this->columns  = $columns;
            $this->primary  = $primary;
            $this->unique   = $unique;

            $this->engine   = "ENGINE=INNODB";
            $this->charset  = "CHARSET=utf8";
            $this->AI       = "AUTO_INCREMENT=1";
            $this->database = $GLOBALS ["DB_NAME"];
        }

        /**
         * @return array
         */
        public function up ( )
        {
            $sql_create = "CREATE TABLE IF NOT EXISTS `" . $this->getTable ( ) . "` (";

            if ( ! empty ( $this->getPrimary ( ) ) )
            {
                foreach ( $this->getColumns ( ) as $key => $value )
                {
                    $sql_create .= implode ( " ", $value ) . ", ";
                }

                $sql_create .= $this->getPrimary ( );
            }
            else
            {
                foreach ( $this->getColumns ( ) as $key => $value )
                {

                    $sql_create .= implode ( " ", $value ) . ", ";
                }

                $sql_create = substr ( $sql_create, 0, -2 );
            }

            if ( ! empty ( $this->getUnique ( ) ) )
            {
                $sql_create .= $this->getUnique ( );
            }

            $sql_create .= ") " . $this->getEngine ( ) . " DEFAULT " . $this->getCharset ( ) . " " . $this->getAI ( ) . ";";

            $results = database::runQuery ( $sql_create );

            if ( $results )
            {
                return [ "TYPE" => 1, "MESSAGE" => "Table creation succeeded!" ];
            }
            else
            {
                return [ "TYPE" => 3, "MESSAGE" => "Table creation failed!" ];
            }
        }

        /**
         * @return array
         */
        public function down ( )
        {
            $sql_delete = "DROP TABLE IF EXISTS `" . $this->getTable ( ) . "`;";
            $results    = database::runQuery ( $sql_delete );

            if ( $results )
            {
                return [ "TYPE" => 1, "MESSAGE" => "Table Dropped Successfully!" ];
            }
            else
            {
                return [ "TYPE" => 3, "MESSAGE" => "Table Could Not Be Dropped!" ];
            }
        }

        public function structure ( )
        {
            $sql_select  = "SELECT `COLUMN_NAME`,`COLUMN_TYPE`,`COLUMN_DEFAULT`,`IS_NULLABLE`, `EXTRA` FROM INFORMATION_SCHEMA.COLUMNS ";
            $sql_select .= "WHERE `TABLE_SCHEMA` ='". $this->getDatabase ( ) . "' AND `TABLE_NAME`='" . $this->getTable ( ) . "';";
            $results     = database::runSelectQuery ( $sql_select );

            print_r ( $results );
        }

        /**
         * @return array
         */
        public function status ( )
        {
            $sql_select	 = "SELECT `COLUMN_NAME`,`COLUMN_TYPE`,`COLUMN_DEFAULT`,`IS_NULLABLE`, `EXTRA` FROM INFORMATION_SCHEMA.COLUMNS ";
            $sql_select	.= "WHERE `TABLE_SCHEMA` ='". $this->getDatabase ( ) . "' AND `TABLE_NAME`='" . $this->getTable ( ) . "';";
            $results	 = database::runSelectQuery ( $sql_select );

            if ( ! empty ( $results ) )
            {
                if ( SizeOf ( $results ) !== SizeOf ( $this->getColumns ( ) ) )
                {
                    return [ "TYPE" => "3", "MESSAGE" => "<span class=\"label label-danger right\"><i class=\"fa fa-exclamation\" aria-hidden=\"true\"></i> Missing or extra columns found</span>" ];
                }
                else
                {
                    foreach ( $results as $key1 => $value1 )
                    {
                        foreach ( $this->getColumns ( ) as $key2 => $value2 )
                        {
                            if ( $value1["COLUMN_NAME"] == $key2 )
                            {
                                if ( $value1["COLUMN_TYPE"] !== $value2["COLUMN_TYPE"] )
                                {
                                    return [ "TYPE" => "3", "MESSAGE" => "<span class=\"label label-danger right\"> Column '" . $value1["COLUMN_NAME"] . "' has an invalid data taype!</span>" ];
                                }
                            }
                        }
                    }
                }
            }
            else
            {
                return [ "TYPE" => "3", "MESSAGE" => "<span class=\"label label-danger right\"><i class=\"fa fa-exclamation\" aria-hidden=\"true\"></i> Table was not found!</span>" ];
            }

            return [ "TYPE" => "1", "MESSAGE" => "<span class=\"label label-success right\">OK</span>" ];
        }

        /**
         * @param $status
         * @return string
         */
        public function render_view_status ($status )
        {
            if ( $status["TYPE"] == 3 )
            {
                $alert	= new alert ( "ERROR!", $status ["MESSAGE"], $status ["TYPE"] );
            }
            else
            {
                $alert	= new alert ( "SUCCESS!", $status ["MESSAGE"], $status ["TYPE"] );
            }

            return $alert->render_bootstrap ( );
        }

        /**
         * @return string
         */
        public function getAI ( )
        {
            return $this->AI;
        }

        /**
         * @param string $AI
         */
        public function setAI ( $AI )
        {
            $this->AI = $AI;
        }

        /**
         * @return string
         */
        public function getCharset ( )
        {
            return $this->charset;
        }

        /**
         * @param string $charset
         */
        public function setCharset ( $charset )
        {
            $this->charset = $charset;
        }

        /**
         * @return mixed
         */
        public function getColumns ( )
        {
            return $this->columns;
        }

        /**
         * @param mixed $columns
         */
        public function setColumns ( $columns )
        {
            $this->columns = $columns;
        }

        /**
         * @return mixed
         */
        public function getDatabase ( )
        {
            return $this->database;
        }

        /**
         * @param mixed $database
         */
        public function setDatabase ( $database )
        {
            $this->database = $database;
        }

        /**
         * @return string
         */
        public function getEngine ( )
        {
            return $this->engine;
        }

        /**
         * @param string $engine
         */
        public function setEngine ( $engine )
        {
            $this->engine = $engine;
        }

        /**
         * @return mixed
         */
        public function getPrimary ( )
        {
            return $this->primary;
        }

        /**
         * @param mixed $primary
         */
        public function setPrimary ( $primary )
        {
            $this->primary = $primary;
        }

        /**
         * @return mixed
         */
        public function getTable ( )
        {
            return $this->table;
        }

        /**
         * @param mixed $table
         */
        public function setTable ( $table )
        {
            $this->table = $table;
        }

        /**
         * @return mixed
         */
        public function getUnique ( )
        {
            return $this->unique;
        }

        /**
         * @param mixed $unique
         */
        public function setUnique ( $unique )
        {
            $this->unique = $unique;
        }
    }