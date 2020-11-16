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

switch ($selectLang) {
	case 'en':
	$lang_file = 'lang.en.php';
	break;

	case 'nl':
	$lang_file = 'lang.nl.php';
	break;

	default:
	$lang_file = 'lang.nl.php';

}

include_once 'lang/'.$lang_file;

?>