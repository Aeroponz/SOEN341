<?php 
namespace Website;
use SqlDb\Database;
$root = dirname(__FILE__,3);
require_once($root . '/src/db/DBConfig.php'); 

class rating{
	//Author: Jasen Ratnam
	//Default Constructor to be used when creating a new user
    var $mU_id, $mU_id2, $mP_id;
	function withPost()
    {
        $this->mU_id = $_SESSION['userID'];
		$this->mU_id2 = $_POST["u_id2"];
		$this->mP_id = $_REQUEST['p_id'];
    }
	
	//get u_id from session.
	function fetch_user() {
		
		if (isset($this->mU_id)) {
			$oLoggenOnUser = $this->mU_id;
		}else {
			 $oLoggenOnUser = -1;
		}
		return $oLoggenOnUser + 0; //ensures a numerical value is returned	
	}
	
	//get u_id of poster user.
	function fetch_poster() {
		
		if (isset($this->mU_id2)) {
			$oLoggenOnUser = $this->mU_id2;
		}else {
			 $oLoggenOnUser = -1;
		}
		return $oLoggenOnUser + 0; //ensures a numerical value is returned	
	}
	
	//get post id
	function fetch_p_id() {
		if(isset($this->mP_id) && $this->mP_id !== ''){
		  $oP_id = $this->mP_id;
		} else {
			 $oP_id = -1;
		}
		return $oP_id + 0; //ensures a numerical value is returned	
	}
	
	//check if post is liked/disliked
	function liked($iLoggenOnUser,$iP_id){

		$wDbConn = Database::getConnection();
		$wSql = "SELECT * FROM likes";  
		$wResult = Database::query($wSql, $wDbConn);
		
		if ($wResult->num_rows > 0) {
			// each row
			while($wRow = $wResult->fetch_assoc()) {
				
				if($iLoggenOnUser == $wRow["u_id"]){
					if($iP_id == $wRow["p_id"]){
						if($wRow["rating"] == 'y'){
							//liked
							return 1;
						}elseif($wRow["rating"] == 'n'){
							//disliked
							return 2;
						}
					}	
				}
			}
		} 
		//not rated
		return -1;
		
		$wDbConn = null;
	}
	
	//add rating to db
	function add_like_to_db(){
		$wSql = null;
		$wU_id =null;
		$wU_id2 =null;
		
		$wU_id = $this->fetch_user();
		if($wU_id == -1){return -3;} //no user
		
		$wU_id2 = $this->fetch_poster();
		if($wU_id2 == -1){return -4;} //no poster
		
		$wP_id = $this->fetch_p_id();
		if($wP_id == -1){return -4;} 
		
		$oRatingRes = 0;
		if($this->liked($wU_id, $wP_id)==1){ //already liked
			$oRatingRes  = 1; //like
			//remove like, no rating done
			$wSql = "DELETE FROM likes WHERE u_id= $wU_id AND p_id= $wP_id";
			Database::safeQuery($wSql);
			
			//update post rating
			$wSql = "UPDATE posts SET upvote = upvote-1 WHERE p_id= $wP_id";
			Database::safeQuery($wSql);
			
			//update rating of posters, remove like
			$wSql = "UPDATE users SET rating = rating-1 WHERE u_id= $wU_id2";
			Database::safeQuery($wSql);
			
			
		}
		elseif($this->liked($wU_id, $wP_id)==2){ //if disliked
			$oRatingRes = 2;	//dislike	
			
			//change to like
			$wSql = "UPDATE likes SET rating = 'y' WHERE u_id = $wU_id AND p_id= $wP_id";
			Database::safeQuery($wSql);
			
			//update post rating
			$wSql = "UPDATE posts SET upvote = upvote+1 WHERE p_id= $wP_id";
			Database::safeQuery($wSql);
			$wSql = "UPDATE posts SET downvote = downvote-1 WHERE p_id= $wP_id";
			Database::safeQuery($wSql);
			
			//update rating of posters, remove dislike (+1) and add like (+1)
			$wSql = "UPDATE users SET rating = rating+2 WHERE u_id= $wU_id2";
			Database::safeQuery($wSql);
		}
		elseif($this->liked($wU_id, $wP_id)==-1){//no rating
			$oRatingRes = -1; //no rating found
			//add like
			$wSql = "INSERT INTO likes (u_id, p_id, rating) VALUES($wU_id, $wP_id, 'y')";
			Database::safeQuery($wSql);
			
			//update post rating
			$wSql = "UPDATE posts SET upvote = upvote+1 WHERE p_id= $wP_id";
			Database::safeQuery($wSql);
			
			//update rating of posters, add like (+1)
			$wSql = "UPDATE users SET rating = rating+1 WHERE u_id= $wU_id2";
			Database::safeQuery($wSql);
		}
		return $oRatingRes;
	}
	
	//add rating to db
	function add_dislike_to_db(){
		$wSql = null;
		$wU_id =null;
		$wU_id2 =null;
		
		$wU_id = $this->fetch_user();
		if($wU_id == -1){return -3;} //no user
		
		$wU_id2 = $this->fetch_poster();
		if($wU_id2 == -1){return -4;} //no poster
		
		$wP_id = $this->fetch_p_id();
		if($wP_id == -1){$value = -4;} 
		
		$oRatingRes = 0;
		if($this->liked($wU_id, $wP_id)==2){ //already disliked
			$oRatingRes  = 2; //dislike
			//remove dislike, no rating done
			$wSql = "DELETE FROM likes WHERE u_id= $wU_id AND p_id= $wP_id";
			Database::safeQuery($wSql);
			
			//update post rating
			$wSql = "UPDATE posts SET downvote = downvote-1 WHERE p_id= $wP_id";
			Database::safeQuery($wSql);
			
			//update rating of posters
			$wSql = "UPDATE users SET rating = rating+1 WHERE u_id= $wU_id2";
			Database::safeQuery($wSql);
		}
		elseif($this->liked($wU_id, $wP_id)==1){ //if liked
			$oRatingRes = 1;	//liked	
			//change to dislike
			$wSql = "UPDATE likes SET rating = 'n' WHERE u_id = $wU_id AND p_id= $wP_id";
			Database::safeQuery($wSql);
			
			//update post rating
			$wSql = "UPDATE posts SET downvote = downvote+1 WHERE p_id= $wP_id";
			Database::safeQuery($wSql);
			$wSql = "UPDATE posts SET upvote = upvote-1 WHERE p_id= $wP_id";
			Database::safeQuery($wSql);
			
			//update rating of posters
			$wSql = "UPDATE users SET rating = rating-2 WHERE u_id= $wU_id2";
			Database::safeQuery($wSql);
		}
		elseif($this->liked($wU_id, $wP_id)==-1){//no rating
			$oRatingRes = -1; //no rating found
			//add like
			$wSql = "INSERT INTO likes (u_id, p_id, rating) VALUES($wU_id, $wP_id, 'n')";
			Database::safeQuery($wSql);
			
			//update post rating
			$wSql = "UPDATE posts SET downvote = downvote+1 WHERE p_id= $wP_id";
			Database::safeQuery($wSql);
			
			//update rating of posters
			$wSql = "UPDATE users SET rating = rating-1 WHERE u_id= $wU_id2";
			Database::safeQuery($wSql);
		}
		return $oRatingRes;
	}
}
	
?>