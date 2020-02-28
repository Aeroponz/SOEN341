<?php 
require_once('../db/DBConfig.php'); 
session_start();
	//Author: Jasen Ratnam
	
	global $p_id;
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

	function fetch_p_id() {
		if(isset($_REQUEST["p_id"]) && $_REQUEST["p_id"] !== ''){
		  $p_id = $_REQUEST["p_id"];
		  echo $p_id; //comment out echo when not debugging
		} else {
			 $p_id = -1;
		}
		return $p_id + 0; //ensures a numerical value is returned	
	}
	
	function add_comment_to_db(){
		//Declare variables
		$sql = null;
		$u_id =null;
		$text = null;
		$p_id = null;
		$comment_type = -1;
		
		//Get user
		$u_id = fetch_user(); 
		if($u_id == -1){return -3;}
		
		$p_id = fetch_p_id();
		if($p_id == -1){return -4;}
		
		if( isset($_POST["CommentText"]) & $_POST["CommentText"] != '' & !ctype_space($_POST["CommentText"]))
		{
			$text = $_POST["CommentText"];
			$sql = "INSERT INTO comments (p_id, u_id, txt_content) VALUES($p_id, $u_id, '$text')";
			$comment_type = 1;
			Database::safeQuery($sql);
		}
		return $comment_type;
	}
	
	//returns a server path to a page
	function get_redirect_path($value){
		
		$p_id = fetch_p_id();
		if($p_id == -1){$value = -4;}
		switch($value){
		/*no user*/		 case(-3): return "../pages/SignUpPage/signUP.php?source=post";
		/*no p_id*/		 case(-4): return "../pages/viewPostPage/viewPost.php?id= $p_id&source=noP_id";
		/*no comment*/   case(-1): return "../pages/viewPostPage/viewPost.php?id= $p_id&source=noComment";
		/*comment success*/ default: return "../pages/viewPostPage/viewPost.php?id= $p_id";
		}
		return "../pages/viewPostPage/viewPost.php?id= $p_id";
	}
	
	//script
	$output = add_comment_to_db();
	echo fetch_user();
	echo $output;
	
	header('Location: '.$uri. get_redirect_path($output));
?>