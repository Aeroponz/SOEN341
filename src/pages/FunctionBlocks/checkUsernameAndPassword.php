<?php 
	function checkUsername($username){
		if(!preg_match("/[^\w\.\-]/", $username))
			return true;
		else
			return false;
	}
	function checkPassword($password){
		if(preg_match("/^(?=.*\d)(?=.*[A-Za-z])(?=.*[_\W]).{6,}$/",$_POST['password']))
			return true;
		else
			return false;
	}
?>