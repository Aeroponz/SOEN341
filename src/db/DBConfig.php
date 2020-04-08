<?php
namespace SqlDb;
use MySQLi;
class Database{
	
	//Credentials
	private static $cServername = "localhost";
	private static $cUsername = "root";
	private static $cPassword = "";
	private static $cDBname = "bludata";
	//relative server path to /mDB directory
	private static $cFilepath = "http://localhost/SOEN341/src/db/";

    private static $mDB;
    private $connection;
	
    private function __construct() {
        $this->connection = new MySQLi(
			self::$cServername, 
			self::$cUsername, 
			self::$cPassword, 
			self::$cDBname
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
        if (self::$mDB == null) {
            self::$mDB = new Database();
        }
        return self::$mDB->connection;
    }
	
	public static function getRoot() {
		return self::$cFilepath;
	}
	
	//safely opens then closes the DB for a single query
	public static function safeQuery($iSQL){
		$mDBconn = Database::getConnection();
		$oResult = $mDBconn->query($iSQL);
		$mDBconn = null;
		return $oResult;
	}
	
	//performs the query on the specified DB connection
	public static function query($iSQL,$iConn){
		$oResult = $iConn->query($iSQL);
		return $oResult;
	}
}
?>
