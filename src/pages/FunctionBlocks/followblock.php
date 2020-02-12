<?php
class followBlock{
	private static $button = 
		"<div id = \"follow_user\">
			<form method=\"FOLLOW\" action=\"followToDB.php\" enctype=\"multipart/form-data\">
				<input type=\"submit\" name=\"follow_user\" value=\"Follow\">
			</form>
		</div>";
	
	public static function follow(){ return self::$button; }
}
?>