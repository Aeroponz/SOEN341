<?php
class Database{
	
	//Credentials
	private static $servername = "localhost";
	private static $username = "root";
	private static $password = "";
	private static $dbname = "bludata";
	//relative server path to /db directory
	private static $filepath = "http://localhost/Blu/db/";

    private static $db;
    private $connection;
	
    private function __construct() {
        $this->connection = new MySQLi(
			self::$servername, 
			self::$username, 
			self::$password, 
			self::$dbname
		);
		// Check connection
		if ($this->connection->connect_error) {
			die("Connection failed: " . $this->connection->connect_error);
		}
    }

    function __destruct() {
        $this->connection->close();
    }

    public static function getConnection() {
		// Create connection via new Database object
        if (self::$db == null) {
            self::$db = new Database();
        }
        return self::$db->connection;
    }
	
	public static function getRoot() {
		return self::$filepath;
	}
}
?>