<?php
$root = dirname(__FILE__, 1);
require_once ($root.'$UploadClass.php');
//Author: Pierre-Alexis Barras <Pyxsys>
	
	//get u_id from session.
	function fetch_user() {
		
		if (isset($_SESSION["userID"])) {
			$loggenOnUser = $_SESSION["userID"];
			echo "Found User: ", $loggenOnUser, "<br />";
		}else {
			 $loggenOnUser = -1;
		}
		return $loggenOnUser + 0; //ensures a numerical value is returned	
	}
	
	//returns the posted file if it is set and valid.
	//returns 'null' on no file, and "error" on errors.
	function validFile() {
		if(isset($_POST["postText"])){
			if($_FILES["postImage"]["error"] == 0){ //file uploaded succesfully		
				//check if file 12 bytes or larger and an image?
				if( preg_match('/^image\b/',$_FILES["postImage"]["type"]) && filesize($_FILES["postImage"]["tmp_name"]) > 11 ){
					if(exif_imagetype($_FILES["postImage"]["tmp_name"]) > 0 ) {return $_FILES["postImage"];}
				}
			}
			else {return "error";}	
		}
		return null; //no file will return null.
	}
	
	//return the posted text if it is set and valid
	//returns 'null' on no text, and "error" on empty text.
	function validText() {
		//text is set
		if(isset($_POST["postText"])){
			if($_POST["postText"] != ''){return $_POST["postText"];}
			else {return "error";}
		}
		return null;
	}
	
	$user = fetch_user();
	$text = validText();
	$file = validFile();
	
	//script
	$output = Upload::add_post_to_db($user,$file,$text);
	echo fetch_user();
	echo $output;

	//redirects user to another page (Ideally where the post is viewable.)
	header('Location: '.$uri. Upload::get_redirect_path($output));
?>
