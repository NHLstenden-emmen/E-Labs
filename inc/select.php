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
	$message = $db->updateUsersLanguage($_SESSION['user_id'],$selectLang);
}

// de taal uit de database halen inplaats van een coockie.

$lang = include_once 'lang/lang.'.$selectLang.'.php';
?>