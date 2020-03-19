<?php 
namespace Website;
use SqlDb\Database;
$Root = dirname(__FILE__,3);
require_once($Root . '/src/db/DBConfig.php'); 
//session_start();

class Comment{
	//Author: Jasen Ratnam
	//Default Constructor to be used when creating a new user
    var $mU_id, $mP_id, $mCommentText;
	function withPost()
    {
        $this->mU_id = $_SESSION['userID'];
        $this->mP_id = $_REQUEST['p_id'];
        $this->mCommentText = $_POST["CommentText"];
    }
	//get u_id from session.
	function FetchUser() {
		
		if (isset($this->mU_id)) {
			$oLoggenOnUser = $this->mU_id;
			//echo "Found User: ", $loggenOnUser, "<br />";
		}else {
			 $oLoggenOnUser = -1;
		}
		return $oLoggenOnUser + 0; //ensures a numerical value is returned	
	}

	function FetchPId() {
		if(isset($this->mP_id) && $this->mP_id !== ''){
		  $oP_id = $this->mP_id;
		  //echo $p_id; //comment out echo when not debugging
		} else {
			 $oP_id = -1;
		}
		return $oP_id + 0; //ensures a numerical value is returned	
	}
	
	function AddCommentToDb(){
		//Declare variables
		$wSql = null;
		$wU_id = $this->FetchUser();
		$wText = $this->mCommentText;
		$wP_id = $this->FetchPId();
		$oCommentType = -1;
		
		if($wU_id == -1){$oCommentType = -3;}
		
		if($p_id == -1){$oCommentType = -4;}
		
		if( isset($wText) & $wText != '' & !ctype_space($wText))
		{
			$wSql = "INSERT INTO comments (p_id, u_id, txt_content) VALUES($wP_id, $wU_id, '$wText')";
			$oCommentType = 1;
			Database::safeQuery($wSql);
		}
		return $oCommentType;
	}
	
	//returns a server path to a page
	function GetRedirectPath($iValue){
		
		$wP_id = $this->FetchPId();
		if($wP_id == -1){$iValue = -4;}
		switch($iValue){
		/*no user*/		 case(-3): return "../SignUpPage/signUP.php?source=post";
		/*no p_id*/		 case(-4): return "../viewPostPage/viewPost.php?id= $wP_id&source=noP_id";
		/*no comment*/   case(-1): return "../viewPostPage/viewPost.php?id= $wP_id&source=noComment";
		/*comment success*/ default: return "../viewPostPage/viewPost.php?id= $wP_id";
		}
		return "../viewPostPage/viewPost.php?id= $wP_id";
	}
}
?>