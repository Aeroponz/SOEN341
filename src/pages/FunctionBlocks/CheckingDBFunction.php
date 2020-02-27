<?php 
	require_once('../../db/DBConfig.php');
	function checkingDB($query){
		$dbconnection = Database::getConnection();
		$result = $dbconnection->query($query);
		return $result;
			
	}
?>