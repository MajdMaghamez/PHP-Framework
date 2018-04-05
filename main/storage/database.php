<?php namespace main\storage;

    class database
    {
        private static $connection = null;

        private static function setConnection ( )
        {
            if ( ! isset ( self::$connection ) )
            {
                try
                {
                    self::$connection = new \PDO ( "mysql:host=" . $GLOBALS ["DB_HOST"] . ";port=" . $GLOBALS ["DB_PORT"] . ";dbname=" . $GLOBALS ["DB_NAME"], $GLOBALS ["DB_USER"], $GLOBALS ["DB_PASS"] );
                    self::$connection->setAttribute ( \PDO::ATTR_ERRMODE, $GLOBALS ["PDO_ERROR"] );
                    self::$connection->query ( 'USE ' . $GLOBALS ["DB_NAME"] );
                }
                catch ( \PDOException $E )
                {
                    error_log( "database error: could not set connection for database: " . $GLOBALS ["DB_NAME"] . ' ' . $E->getMessage(), 0 );
                }
            }
        }

        /**
         * @param $database
         * @return bool
         */
        public static function createDatabase ( $database )
        {
            $connection = mysqli_connect ( $GLOBALS ["DB_HOST"] . ':' .$GLOBALS ["DB_PORT"], $GLOBALS ["DB_USER"], $GLOBALS ["DB_PASS"] );

            if ( ! $connection )
            {
                error_log( "database error: could not set connection for database " . $database, 0 );
            }

            $sql = "CREATE DATABASE IF NOT EXISTS `" . $database . "`;";

            if ( mysqli_query ( $connection, $sql ) )
            {
                $connection->close ( );
                return true;
            }

            return false;
        }

        /**
         * @param string $query
         * @param array $params
         * @return array
         */
        public static function runSelectQuery ( $query, $params = array ( ) )
        {
            self::setConnection ( );

            try
            {
                $statement = self::$connection->prepare ( $query );

                if ( ! empty ( $params ) )
                {
                    foreach ( $params as $key => $value )
                    {
                        switch ( $value ["TYPE"] )
                        {
                            case "BOOL":    $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_BOOL ); break;
                            case "INT":     $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_INT );  break;
                            case "STR":     $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_STR );  break;
                            case "LOB":     $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_LOB );  break;
                            case "NULL":    $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_NULL ); break;
                            default:        $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_NULL ); break;
                        }
                    }
                }

                $statement->execute ( );
                $record_count = $statement->rowCount ( );

                if ( $record_count > 0 )
                    return $statement->fetchAll ( \PDO::FETCH_ASSOC );

            }
            catch ( \PDOException $E )
            {
                error_log( "database error: could not run select query " . $E->getMessage(), 0 );
            }

            return array ( );
        }

        /**
         * @param string $query
         * @param array $params
         * @param string $returnedId
         * @return integer | null
         */
        public static function runInsertQuery ( $query, $params = array ( ), $returnedId = null )
        {
            self::setConnection ( );

            try
            {
                $statement = self::$connection->prepare ( $query );

                if ( ! empty ( $params ) )
                {
                    foreach ( $params as $key => $value )
                    {
                        switch ( $value ["TYPE"] )
                        {
                            case "BOOL":    $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_BOOL ); break;
                            case "INT":     $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_INT );  break;
                            case "STR":     $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_STR );  break;
                            case "LOB":     $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_LOB );  break;
                            case "NULL":    $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_NULL ); break;
                            default:        $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_NULL ); break;
                        }
                    }
                }

                $statement->execute ( );
                return self::$connection->lastInsertId ( $returnedId );
            }
            catch ( \PDOException $E )
            {
                error_log( "database error: could not run insert query " . $E->getMessage(), 0 );
            }

            return null;
        }

        /**
         * @param string $query
         * @param array $params
         * @return integer
         */
        public static function runUpdateQuery ( $query, $params = array ( ) )
        {
            self::setConnection ( );

            try
            {
                $statement = self::$connection->prepare ( $query );

                if ( ! empty ( $params ) )
                {
                    foreach ( $params as $key => $value )
                    {
                        switch ( $value ["TYPE"] )
                        {
                            case "BOOL":    $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_BOOL ); break;
                            case "INT":     $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_INT );  break;
                            case "STR":     $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_STR );  break;
                            case "LOB":     $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_LOB );  break;
                            case "NULL":    $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_NULL ); break;
                            default:        $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_NULL ); break;
                        }
                    }
                }

                $statement->execute ( );
                return $statement->rowCount ( );
            }
            catch ( \PDOException $E )
            {
                error_log( "database error: could not run update query " . $E->getMessage(), 0 );
            }

            return 0;
        }

        /**
         * @param string $query
         * @param array $params
         * @return bool
         */
        public static function runDeleteQuery ($query, $params = array ( ) )
        {
            self::setConnection ( );

            try
            {
                $statement = self::$connection->prepare ( $query );

                if ( ! empty ( $params ) )
                {
                    foreach ( $params as $key => $value )
                    {
                        switch ( $value ["TYPE"] )
                        {
                            case "BOOL":    $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_BOOL ); break;
                            case "INT":     $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_INT );  break;
                            case "STR":     $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_STR );  break;
                            case "LOB":     $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_LOB );  break;
                            case "NULL":    $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_NULL ); break;
                            default:        $statement->bindValue ( $key, $value ["VALUE"], \PDO::PARAM_NULL ); break;
                        }
                    }
                }

                $statement->execute ( );
                return true;
            }
            catch ( \PDOException $E )
            {
                error_log( "database error: could not run update query " . $E->getMessage(), 0 );
            }

            return false;
        }

        /**
         * @param string $query
         * @return bool
         */
        public static function runQuery ( $query )
        {
            self::setConnection ( );

            try
            {
                self::$connection->exec ( $query );
                return true;
            }
            catch ( \PDOException $E )
            {
                error_log( "database error: could not run query " . $E->getMessage(), 0 );
            }
        }

    }