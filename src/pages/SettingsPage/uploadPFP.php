<?php
//Author: Pierre-Alexis Barras <Pyxsys>
$root = dirname(__FILE__, 4);
ob_start();
require_once ($root .'src\\db\\UploadClass.php');
require_once ($root .'src\\pages\\FunctionBlocks\\ProfileClass.php');


	session_start();
	echo "<input type=\"submit\" <a href=\"#\" onclick=\"history.back();\" value=\"go back\"><br/>";
	
	//Script
	$wU_id = Website\Upload::FetchUser();
	$wFileStatus = Website\Upload::ValidFile("PFPInput");
	$wFileContent = $_FILES["PFPInput"];
	$wContent = file_get_contents($wFileContent['tmp_name']); //img to bytes
	
	echo "User:" . $wU_id . " - " . $wFileStatus . "<br\>";
	
	$wOutput = Website\Profile::uploadPFP($wU_id, $wFileStatus, $wContent);
	echo "Display: <br/>";
	Website\Profile::DisplayUserPFP($wU_id);
	
	$oRedirect = Website\Upload::GetRedirectPath($wOutput);
	
	
	//Redirect
	if($wOutput != null){header('Location: '.$oRedirect); exit();}
	ob_end_flush();
?>