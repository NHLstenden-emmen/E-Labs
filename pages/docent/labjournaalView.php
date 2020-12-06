<?php
if(isset($_GET['labjournaal'])) {
	$labjournaal = $_GET['labjournaal'];
} else {
	$labjournaal = 'not found';
}
echo $labjournaal;
?>