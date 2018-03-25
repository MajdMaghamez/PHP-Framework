<?php namespace main\models;

    use main\storage\database;

    abstract class Seeder
    {
        protected $table;
        protected $insertable;
        protected $bag;

        /**
         * Seeder constructor.
         * @param string $table
         * @param array $insertable
         * @param array $bag
         */
        public function __construct ($table, $insertable, $bag )
        {
            $this->table        = $table;
            $this->insertable   = $insertable;
            $this->bag          = $bag;
        }

        public function seed ( )
        {
            $sql_insert = "TRUNCATE TABLE " . $this->table . "; INSERT INTO " . $this->table . " ( " . implode ( ',', $this->insertable ) . " ) VALUES ";
            $sql_insert.= " ( " . implode( ',', $this->bag [0] ) . " ) ";

            for ( $i = 1; $i < sizeOf ( $this->bag ); $i++ )
            {
                $sql_insert .= " ,( " . implode( ',', $this->bag [$i] ) . " )";
            }

            $sql_insert.= ";";
            $sql_result = database::runInsertQuery ( $sql_insert );

            if ( $sql_result > 0 )
                return true;
            return false;
        }
    }