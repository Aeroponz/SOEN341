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
		if(isset($this->mP_id) && $this->mP_id != ''){
		  $oP_id = $this->mP_id;
		  //echo $p_id; //comment out echo when not debugging
		} else {
			 $oP_id = -1;
		}
		return $oP_id + 0; //ensures a numerical value is returned	
	}

	function AddComment(){
		//Declare variables
		$wU_id = $this->FetchUser();
		$wText = $this->mCommentText;
		$wP_id = $this->FetchPId();
		return $this->CommentToDb($wU_id, $wText, $wP_id);
	}

    function CommentToDb($iU_id, $iText, $iP_id){

        $wSql = null;
        $oCommentType = -1;

        if($iU_id == -1){return $oCommentType = -3;}

        if($iP_id == -1){return $oCommentType = -4;}

        if( isset($iText) & $iText != '' & !ctype_space($iText))
        {
            $wSql = "INSERT INTO comments (p_id, u_id, txt_content) VALUES($iP_id, $iU_id, '$iText')";
            $wResult = Database::safeQuery($wSql);
            if ($wResult) $oCommentType = 1;
        }
        return $oCommentType;
    }
	
	//returns a server path to a page
	function GetRedirectPath($iValue){

		switch($iValue){
		/*no user*/		 case(-3): return '../SignUpPage/signUP.php?source=post';
		/*no p_id*/		 case(-4): return '../viewPostPage/viewPost.php?id= $wP_id&source=noP_id';
		/*no comment*/   case(-1): return '../viewPostPage/viewPost.php?id= $wP_id&source=noComment';
		/*comment success*/ default: return '../viewPostPage/viewPost.php?id= $wP_id';
		}
	}
}
?>