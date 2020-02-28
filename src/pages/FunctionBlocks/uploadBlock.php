<?php
//Author Pierre-Alexis Barras <Pyxsys>

class uploadBlock{
	private static $form = 
		"<div id = \"submit_post\">
			<form method=\"POST\" action=\"/SOEN341/src/db/uploadPostToDB.php\" enctype=\"multipart/form-data\">
				<input type=\"file\" id=\"fileinput\" onchange=\"validateFile();\" name=\"postImage\"><br>
				<input type=\"text\" id=\"textinput\" name=\"postText\" placeholder=\"Your text here.\"><br>
				<input type=\"submit\" id=\"submitbutton\" name=\"submit_image\" value=\"Upload\">
			</form>
		</div>";
	
	public static function insertForm(){ echo self::$form; }
	public static function importScript(){ echo "<script type=\"text/javascript\" src=\"/SOEN341/src/pages/FunctionBlocks/validUpload.js\"></script>";}
}
?>
