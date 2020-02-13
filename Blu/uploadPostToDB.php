<?php 
require_once('../db/DBConfig.php'); 
session_start();
?>

<?php
	//Author: Pierre-Alexis Barras <Pyxsys>
	
		// get current user id
		 if (isset($_SESSION["userID"])) {
			 $loggenOnUser = $_SESSION["userID"];
			 echo "Found User: ", $loggenOnUser, "<br />";
		 } else {
			 $loggenOnUser = " a public user";
		 }
	
	$u_id = $loggenOnUser; 
	
	$redirect_path = 'HomepageBase.php';
	
	//Declare variables
	$dbconn = null;
	$sql = null;
	$name = null;
	$text = null;
	$upload_type = 0;  
	
	//Functions
	//Generates a random string
	$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	function generate_string($input, $strength = 16) {
		$input_length = strlen($input);
		$random_string = '';
		for($i = 0; $i < $strength; $i++) {
			$random_character = $input[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}
	
		return $random_string;
	}
	
	//[$upload_type key]
	//-2 -> bad file size/type
	//-1 -> error in uploading: failure
	//0 -> no data: failure
	//1 -> text only
	//2 -> image only
	//3 -> image + text
	
	if( isset($_POST["postText"]) & $_POST["postText"] != ''){$upload_type += 1; $text = $_POST["postText"];} //text is set
	if($_FILES["postImage"]["error"] == 0){ //file uploaded succesfully		
		//Is file 12 bytes or larger and an image?
		if( preg_match('/^image\b/',$_FILES["postImage"]["type"]) && filesize($_FILES["postImage"]["tmp_name"]) > 11 ){
			if(exif_imagetype($_FILES["postImage"]["tmp_name"]) > 0 ) $upload_type += 2; 
		}
		else {$upload_type = -2;}
	} 
	
	//If there is an image uploaded
	if($upload_type >= 2){
		
		$fileType = explode("/",strtolower($_FILES["postImage"]["type"]));	//[1] will be file extension
		$dbconn = Database::getConnection();
		
		//generates a unique file name
		do{
			$name = "images/".generate_string($permitted_chars, 16).".".$fileType[1];
			$result = $dbconn->query("SELECT img_path FROM posts WHERE img_path = '$name';");
		}while($result->num_rows > 0);
		$dbconn = null;
	
		//upload picture into image directory
		if( move_uploaded_file($_FILES["postImage"]["tmp_name"], realpath(dirname(getcwd()))."/db/".$name) ){ 
			echo "success: file uploaded </br>"; 
			if($upload_type == 2){ $sql = "INSERT INTO posts (u_id, img_path) VALUES($u_id, '$name')"; }
			if($upload_type == 3){ $sql = "INSERT INTO posts (u_id, img_path, txt_content) VALUES($u_id, '$name', '$text')"; }
		}
		else { 
			echo "fail: file not uploaded </br>";
			$upload_type = -1;
		}
	}
	
	//If only text was submitted
	if($upload_type == 1) { $sql = "INSERT INTO posts (u_id, txt_content) VALUES($u_id, '$text')";}
	
	//Insert post into database
	if($upload_type > 0){
		$dbconn = Database::getConnection();
		$dbconn->query($sql);
		$dbconn = null;		
	}
	
	//debug
		echo $upload_type ."<br>";
		echo $sql ."<br>";
		echo "text data: ".$text."<br>";
		echo "file data:" ."<br>";
		echo "<pre>";
		print_r($_FILES);
		echo realpath(dirname(getcwd()))."/db/" . $name;
		echo"</pre>";
	
	//redirects user to another page (Ideally where the post is viewable.)
	header('Location: '.$uri. $redirect_path);
?>