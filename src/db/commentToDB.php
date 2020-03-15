<?php 
namespace Website;
use SqlDb\Database;
$root = dirname(__FILE__,3);
require_once($root . '/src/db/DBConfig.php'); 
//session_start();

class comment{
	//Author: Jasen Ratnam
	//Default Constructor to be used when creating a new user
    var $mU_id, $mP_id, $mCommentText, $mRedir, $mroot;
	function withPost()
    {
        $this->mU_id = $_SESSION['userID'];
        $this->mP_id = $_REQUEST['p_id'];
        $this->mCommentText = $_POST["CommentText"];
		$this->mroot = dirname(__FILE__,3); 
    }
	//get u_id from session.
	function fetch_user() {
		
		if (isset($this->mU_id)) {
			$loggenOnUser = $this->mU_id;
			//echo "Found User: ", $loggenOnUser, "<br />";
		}else {
			 $loggenOnUser = -1;
		}
		return $loggenOnUser + 0; //ensures a numerical value is returned	
	}

	function fetch_p_id() {
		if(isset($this->mP_id) && $this->mP_id !== ''){
		  $p_id = $this->mP_id;
		  //echo $p_id; //comment out echo when not debugging
		} else {
			 $p_id = -1;
		}
		return $p_id + 0; //ensures a numerical value is returned	
	}
	
	function add_comment_to_db(){
		//Declare variables
		$sql = null;
		$u_id = $this->fetch_user();
		$text = $this->mCommentText;
		$p_id = $this->fetch_p_id();
		$comment_type = -1;
		
		if($u_id == -1){$comment_type -3;}
		
		if($p_id == -1){$comment_type -4;}
		
		if( isset($text) & $text != '' & !ctype_space($text))
		{
			$sql = "INSERT INTO comments (p_id, u_id, txt_content) VALUES($p_id, $u_id, '$text')";
			$comment_type = 1;
			Database::safeQuery($sql);
		}
		return $comment_type;
	}
	
	//returns a server path to a page
	function get_redirect_path($value){
		
		$p_id = $this->fetch_p_id();
		if($p_id == -1){$value = -4;}
		switch($value){
		/*no user*/		 case(-3): return "../SignUpPage/signUP.php?source=post";
		/*no p_id*/		 case(-4): return "../viewPostPage/viewPost.php?id= $p_id&source=noP_id";
		/*no comment*/   case(-1): return "../viewPostPage/viewPost.php?id= $p_id&source=noComment";
		/*comment success*/ default: return "../viewPostPage/viewPost.php?id= $p_id";
		}
		return "../viewPostPage/viewPost.php?id= $p_id";
	}
}
?>