<?php 
namespace Website;
use SqlDb\Database;
$root = dirname(__FILE__,3);
require_once($root . '/src/db/DBConfig.php'); 
//session_start();

class rating{
	//Author: Jasen Ratnam
	//Default Constructor to be used when creating a new user
    var $mU_id, $mU_id2;
	function withPost()
    {
        $this->mU_id = $_SESSION['userID'];
		$this->mU_id2 = $_POST["u_id2"];
		$this->mP_id = $_REQUEST['p_id'];
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
	
	//get u_id of poster user.
	function fetch_poster() {
		
		if (isset($this->mU_id2)) {
			$loggenOnUser = $this->mU_id2;
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
	
	function liked($iLoggenOnUser,$iP_id){

		$dbconn = Database::getConnection();
		$sql = "SELECT * FROM likes";  
		$result = Database::query($sql, $dbconn);
		
		if ($result->num_rows > 0) {
			// each row
			while($row = $result->fetch_assoc()) {
				
				if($iLoggenOnUser == $row["u_id"]){
					if($iP_id == $row["p_id"]){
						if($row["rating"] == 'y'){
							//liked
							return 1;
						}elseif($row["rating"] == 'n'){
							//disliked
							return 2;
						}
					}	
				}
			}
		} 
		//not rated
		return -1;
		
		$dbconn = null;
	}
	
	function add_like_to_db(){
		$sql = null;
		$u_id =null;
		$u_id2 =null;
		
		$u_id = $this->fetch_user();
		if($u_id == -1){return -3;} //no user
		
		$u_id2 = $this->fetch_poster();
		if($u_id2 == -1){return -4;} //no poster
		
		$p_id = $this->fetch_p_id();
		if($p_id == -1){$value = -4;} 
		
		$ratingRes = 0;
		if($this->liked($u_id, $p_id)==1){ //already liked
			$ratingRes  = 1; //like
			//remove like, no rating done
			$sql = "DELETE FROM likes WHERE u_id= $u_id AND p_id= $p_id";
			Database::safeQuery($sql);
			
			//update post rating
			$sql = "UPDATE posts SET upvote = upvote-1 WHERE p_id= $p_id";
			Database::safeQuery($sql);
			
			//update rating of posters, remove like
			$sql = "UPDATE users SET rating = rating-1 WHERE u_id= $u_id2";
			Database::safeQuery($sql);
			
			
		}
		elseif($this->liked($u_id, $p_id)==2){ //if disliked
			$ratingRes = 2;	//dislike	
			
			//change to like
			$sql = "UPDATE likes SET rating = 'y' WHERE u_id = $u_id AND p_id= $p_id";
			Database::safeQuery($sql);
			
			//update post rating
			$sql = "UPDATE posts SET upvote = upvote+1 WHERE p_id= $p_id";
			Database::safeQuery($sql);
			$sql = "UPDATE posts SET downvote = downvote-1 WHERE p_id= $p_id";
			Database::safeQuery($sql);
			
			//update rating of posters, remove dislike (+1) and add like (+1)
			$sql = "UPDATE users SET rating = rating+2 WHERE u_id= $u_id2";
			Database::safeQuery($sql);
		}
		elseif($this->liked($u_id, $p_id)==-1){//no rating
			$ratingRes = -1; //no rating found
			//add like
			$sql = "INSERT INTO likes (u_id, p_id, rating) VALUES($u_id, $p_id, 'y')";
			Database::safeQuery($sql);
			
			//update post rating
			$sql = "UPDATE posts SET upvote = upvote+1 WHERE p_id= $p_id";
			Database::safeQuery($sql);
			
			//update rating of posters, add like (+1)
			$sql = "UPDATE users SET rating = rating+1 WHERE u_id= $u_id2";
			Database::safeQuery($sql);
		}
		return $ratingRes;
	}
	
	function add_dislike_to_db(){
		$sql = null;
		$u_id =null;
		$u_id2 =null;
		
		$u_id = $this->fetch_user();
		if($u_id == -1){return -3;} //no user
		
		$u_id2 = $this->fetch_poster();
		if($u_id2 == -1){return -4;} //no poster
		
		$p_id = $this->fetch_p_id();
		if($p_id == -1){$value = -4;} 
		
		$ratingRes = 0;
		if($this->liked($u_id, $p_id)==2){ //already disliked
			$ratingRes  = 2; //dislike
			//remove dislike, no rating done
			$sql = "DELETE FROM likes WHERE u_id= $u_id AND p_id= $p_id";
			Database::safeQuery($sql);
			
			//update post rating
			$sql = "UPDATE posts SET downvote = downvote-1 WHERE p_id= $p_id";
			Database::safeQuery($sql);
			
			//update rating of posters
			$sql = "UPDATE users SET rating = rating+1 WHERE u_id= $u_id2";
			Database::safeQuery($sql);
		}
		elseif($this->liked($u_id, $p_id)==1){ //if liked
			$ratingRes = 1;	//liked	
			//change to dislike
			$sql = "UPDATE likes SET rating = 'n' WHERE u_id = $u_id AND p_id= $p_id";
			Database::safeQuery($sql);
			
			//update post rating
			$sql = "UPDATE posts SET downvote = downvote+1 WHERE p_id= $p_id";
			Database::safeQuery($sql);
			$sql = "UPDATE posts SET upvote = upvote-1 WHERE p_id= $p_id";
			Database::safeQuery($sql);
			
			//update rating of posters
			$sql = "UPDATE users SET rating = rating-2 WHERE u_id= $u_id2";
			Database::safeQuery($sql);
		}
		elseif($this->liked($u_id, $p_id)==-1){//no rating
			$ratingRes = -1; //no rating found
			//add like
			$sql = "INSERT INTO likes (u_id, p_id, rating) VALUES($u_id, $p_id, 'n')";
			Database::safeQuery($sql);
			
			//update post rating
			$sql = "UPDATE posts SET downvote = downvote+1 WHERE p_id= $p_id";
			Database::safeQuery($sql);
			
			//update rating of posters
			$sql = "UPDATE users SET rating = rating-1 WHERE u_id= $u_id2";
			Database::safeQuery($sql);
		}
		return $ratingRes;
	}
}
	
?>