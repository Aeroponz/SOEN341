<?php
namespace Website;
use SqlDb\Database;
require_once ('DBConfig.php');
class Upload{
	
	//Functions
	//Generates a random string
	public static function generate_string($input, $strength = 16) {
		$input_length = strlen($input);
		$random_string = '';
		for($i = 0; $i < $strength; $i++) {
			$random_character = $input[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}
	
		return $random_string;
	}
	
	
	//returns 'y' or 'n' for if there is a #hashtag found in the text.
	public static function check_for_hashtag($text){
		if(preg_match('/\#[a-zA-Z0-9]+/', $text)) return 'y';
		else return 'n';
	}
	
	
	//returns a server path to a page
	public static function get_redirect_path($value){
		
		switch($value){
		/*DB Error*/ 	 case(-4): return "/SOEN341/src/pages/CreatePostPage/createPostPage.php?source=dberror";
		/*no user*/		 case(-3): return "/SOEN341/src/pages/SignUpPage/signUpPage.php?source=post";
		/*no post info*/ case(0): return "/SOEN341/src/pages/CreatePostPage/createPostPage.php?source=empty";
		/*post success*/ default: return "/SOEN341/src/pages/HomePage/HomepageBase.php";
		}
	}
	
	/*records posted information to DB
		//Exit Codes// - $upload_type
			-4 -> Failure: Database error / Bad query;
			-3 -> Failure: no user
			-2 -> Failure: bad file size/type
			-1 -> Failure: error in uploading
			0 -> Failure: no data
			1 -> Sucess: Text only
			2 -> Sucess: Image only
			3 -> Sucess: Image + text
	*/
	public static function add_post_to_db($u_id,$file,$text, $fileContent){
	
		//Declare variables
		$dbconn = null; 	//db connection
		$sql = null;		//query to be passed
		$name = null;		//name of picture (if applicable)
		$upload_type = 0; 	//Return Code
		$result = null; 	//Query result

		//check inputs for errors
		if($u_id == -1){return -3;}
		if($text == "error"){return -1;}
		if($file == "error"){return -2;}
		
		if($text != null){$upload_type += 1;} //text is set
		if($file != null){$upload_type += 2;}
		
		//Build Query for if there is an image uploaded
		if($upload_type >= 2){
			$fileType = explode("/",strtolower($file["type"]));	//[1] will be file extension
			$dbconn = Database::getConnection();
		
			//generates a unique file name
			$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			do{
				$name = "images/".Upload::generate_string($permitted_chars, 16).".".$fileType[1];
				$result = Database::query("SELECT img_path FROM posts WHERE img_path = '$name';", $dbconn);
			}while($result->num_rows > 0);
			$dbconn = null; //close connection
		
			//upload picture into image directory
			if( move_uploaded_file($_FILES["postImage"]["tmp_name"], realpath(dirname(getcwd()))."/db/".$name) ){ 
				echo "success: file uploaded </br>"; 
				if($upload_type == 2){ $sql = "INSERT INTO posts (u_id, img_path) VALUES('$u_id', '$name')"; }
				if($upload_type == 3){ 
					$discover = Upload::check_for_hashtag($text);
					$sql = "INSERT INTO posts (u_id, img_path, txt_content, discoverable) VALUES($u_id, '$name', '$text', '$discover')"; 
				}
			}
			else { 
				echo "fail: file not uploaded </br>";
				return -1;
			}
		}
		
		//Build Query for if only text was submitted
		if($upload_type == 1) { 
			$discover = Upload::check_for_hashtag($text);
			$sql = "INSERT INTO posts (u_id, txt_content, discoverable) VALUES($u_id, '$text','$discover')";
		}
		
		//Insert post into database
		if($upload_type > 0){
			$result = Database::safeQuery($sql);
		}
		
		//check for error in sql result
		if (preg_match('/\berror\b/', $result.strtolower())) {
			$upload_type = -4;
		}
		
		//debug
			echo "TYPE: ". $upload_type ."<br/>";
			echo "QUERY: ". $sql ."<br/>";
			echo "RESULT: ". $result. "<br/>";
			echo "TEXT DATA: ".$text."<br/>";
			echo "FILE DATA:" ."<br/>";
			echo "<pre>";
			print_r($file);
			echo realpath(dirname(getcwd()))."/db/" . $name;
			echo"</pre>";
		
		return $upload_type;
	}
	
}
?>

