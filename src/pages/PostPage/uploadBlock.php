<?php
class uploadBlock{
	private static $form = 
		"<div id = \"submit_post\">
			<form method=\"POST\" action=\"uploadPostToDB.php\" enctype=\"multipart/form-data\">
				<input type=\"file\" name=\"postImage\"><br>
				<input type=\"text\" name=\"postText\" placeholder=\"Your text here.\"><br>
				<input type=\"submit\" name=\"submit_image\" value=\"Upload\">
			</form>
		</div>";
	
	public static function insertForm(){ return self::$form; }
}
?>