<?php
//Author: Pierre-Alexis Barras <Pyxsys>
ob_start();
require_once ('..\\..\\db\\UploadClass.php');

session_start();
	
	//script
	$wUser = Website\Upload::FetchUser();
	$wText = Website\Upload::ValidText("postText");
	$wFile = Website\Upload::ValidFile("postImage");
	$wFileContent = $_FILES["postImage"];
	
	echo "<input type=\"submit\" <a href=\"#\" onclick=\"history.back();\" value=\"go back\"><br/>";
	
	$wOutput = Website\Upload::AddPostToDB($wUser,$wFile,$wText,$wFileContent);
	$oRedirect = Website\Upload::GetRedirectPath($wOutput);
	echo "<br/>Exit code: ". $wOutput;
	
	//redirects user to another page (Ideally where the post is viewable.) if-statement needed for travis.
	if($wOutput != null){header('Location: '.$oRedirect); exit();}
	ob_end_flush();
?>
