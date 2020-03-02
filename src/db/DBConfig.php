<?php
namespace SqlDb;
use MySQLi;
class Database{
	
	//Credentials
	private static $servername = "localhost";
	private static $username = "root";
	private static $password = "";
	private static $dbname = "bludata";
	//relative server path to /db directory
	private static $filepath = "http://localhost/SOEN341/src/db/";

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
	
	//safely opens then closes the DB for a single query
	public static function safeQuery($sql){
		$dbconn = Database::getConnection();
		$result = $dbconn->query($sql);
		$dbconn = null;
		return $result;
	}
	
	//performs the query on the specified DB connection
	public static function query($sql,$conn){
		$result = $conn->query($sql);
		return $result;
	}
}
?>
