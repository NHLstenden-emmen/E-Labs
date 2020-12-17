<?php
//check if cookie is set
if(isset($_COOKIE['lang'])) {
	$selectLang = $_COOKIE['lang'];
}
// this is the main language
else {
	setcookie("lang", "nl", time()+3600);
	$selectLang = 'nl';
}

// when the language changes set cookie or change it if it exist
if(!empty(isset($_POST['changelang']))){
	setcookie("lang", $_POST["changelang"], time()+ (3600 * 24 * 30));
	header("Refresh:0");
}
// update users language
if (!empty(isset($_POST['changelang'])) && !empty(isset($_SESSION['user_id']))) {
	$db->updateUsersLanguage($_SESSION['user_id'],$selectLang);
	header("Refresh:0");
}

// de taal uit de database halen inplaats van een cookie.
$pagePath = basename($_SERVER['REQUEST_URI'], '.php');
if (strpos($pagePath, '?') !== false) {   
	$pagePath = substr($pagePath, 0, strpos($pagePath, "?")); 
}
if (strtolower($pagePath) == 'printpdf.php'){
	$lang = include_once '../lang/lang.'.$selectLang.'.php';
}
else{
	$lang = include_once 'lang/lang.'.$selectLang.'.php';
}
?>