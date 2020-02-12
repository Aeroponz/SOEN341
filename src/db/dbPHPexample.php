<?php
require_once('../db/DBConfig.php'); //Must have at the top of any file that needs db connection.
require_once('../pages/FunctionBlocks/uploadBlock.php'); //Must have at the top of any page that will be able to post.
require_once('../pages/FunctionBlocks/followBlock.php'); 
?>
<html>
	<head>
		<title>DB_Example_Code_Output</title>
	<body>
		<!-- inserting post upload block -->
		<?php
			echo uploadBlock::insertForm();
		?>
		
		<!-- new part-->
		<!-- inserting follow block -->
		<?php
			echo followblock::follow();
		?>
		<!-- end new part-->
		
		<!-- viewing db contents -->
		<?php
			//connection instance
			$dbconn = Database::getConnection();
			
			//query 1
			$sql = "SELECT u_id, name FROM users";
			$result = $dbconn->query($sql);
			
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					echo "id: " . $row["u_id"]. " - Name: " . $row["name"]. "</br>";
				}
			} else {
				echo "0 results";
			}
			
			//query 2
			$result = $dbconn->query("
				SELECT posts.img_path, posts.txt_content, users.name, posts.posted_on
				FROM posts
				INNER JOIN users ON posts.u_id = users.u_id
				ORDER BY 
					posted_on DESC;
				");
			
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					echo "<h3>".$row["txt_content"]."</h3>";
					if($row["img_path"] != null){
						echo "<img src = \"". Database::getRoot(). $row["img_path"]. "\" /></br>";
						echo "<p>filepath: ". Database::getRoot().$row["img_path"]."</p>";
					}
					echo "<div> -".$row["name"]."</div>";
					echo "</br>";					
				}
			} else {
				echo "0 results";
			}
			
			// **NEW PART** Add followers output
			//query 3
			//fetch account followers
			$sql = "SELECT u_id, follows FROM follow_tbl";
			$result = $dbconn->query($sql);
			
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					echo "User: " . $row["u_id"]. " - Follows: " . $row["follows"]. "</br>";
				}
			} else {
				echo "0 results";
			}
			// **END NEW PART**
			
			//deallocate memory. 
			//MUST BE DONE AFTER YOU'RE FINISHED WITH A DB CONNECTION
			$dbconn = null;
		?>
		
	</body>
</html>
