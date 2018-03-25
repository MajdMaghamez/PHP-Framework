<?php namespace main\tests;

    use PHPUnit\Framework\TestCase;
    use PHPUnit\DbUnit\TestCaseTrait;

    abstract class GenericDatabaseTesting extends TestCase
    {
        use TestCaseTrait;

        // only instantiate pdo once for test clean-up/fixture load
        static private $pdo = null;

        // only instantiate PHPUnit\DbUnit\Database\Connection once per test
        private $conn = null;

        final public function getConnection()
        {
            if ($this->conn === null) {
                if (self::$pdo == null) {
                    self::$pdo = new PDO( "mysql:host=" . $GLOBALS ["DB_HOST"] . ";port=" . $GLOBALS ["DB_PORT"] . ";dbname=" . $GLOBALS ["DB_NAME"], $GLOBALS ["DB_USER"], $GLOBALS ["DB_PASS"]  );
                }
                $this->conn = $this->createDefaultDBConnection(self::pdo, $GLOBALS['DB_NAME']);
            }

            return $this->conn;
        }
    }