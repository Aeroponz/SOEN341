<?php
//Author: Pierre-Alexis Barras <Pyxsys>
$root = dirname(__FILE__, 1);
require_once ($root.'/UploadClass.php');

session_start();
	
	//returns the posted file if it is set and valid.
	//returns 'null' on no file, and "error" on errors.
	function validFile() {
		if(isset($_POST["postImage"])){ //TODO, MAY NEED TO SWAP BETWEEN $_POST AND $_FILES
			if($_FILES["postImage"]["error"] == 0){ //file uploaded succesfully	
				//check if file 12 bytes or larger and an image?
				if( preg_match('/^image\b/',$_FILES["postImage"]["type"]) && filesize($_FILES["postImage"]["tmp_name"]) > 11 ){
					if(exif_imagetype($_FILES["postImage"]["tmp_name"]) > 0 ) {return $_FILES["postImage"];}
				}
			}
			else {return 'BLU::INPUT_EXCEPTION::error';}	
		}
		return null; //no file will return null.
	}
	
	//return the posted text if it is set and valid
	//returns 'null' on no text, and "error" on empty text.
	function validText() {
		//text is set
		if(isset($_POST["postText"])){
			if($_POST["postText"] != ''){return $_POST["postText"];}
			else {return 'BLU::INPUT_EXCEPTION::error';}
		}
		return null;
	}
	
	//script
	$user = Website\Upload::fetch_user();
	$text = validText();
	$file = validFile();
	$fileContent = $_FILES["postImage"];
	
	echo "<input type=\"submit\" <a href=\"#\" onclick=\"history.back();\" value=\"go back\"><br/>";
	
	$output = Website\Upload::add_post_to_db($user,$file,$text,$fileContent);
	$redirect = Website\Upload::get_redirect_path($output);
	echo "<br/>Exit code: ". $output;
	
	
	//redirects user to another page (Ideally where the post is viewable.) if-statement needed for travis.
	if($output != null){header('Location: '.$redirect);}
?>
