<?php
$title = 'title';
$date =  date('Y-m-d H:i:s');
$theory = 'theoryy';
$safety = 'safety';
$creater_id = $_SESSION['user_id'];
$logboek = 'logboek';
$method_materials = 'method_materials';
$submitted = '';
$grade = '3';
$year = '1';
$Attachment = '';
$Goal = 'doel';
$Hypothesis = 'Hypothesis';
$message = $db->LabjournaalToevoegen($title, $date, $theory, $safety, $creater_id, $logboek, $method_materials, $submitted, $grade, $year, $Attachment, $Goal, $Hypothesis);
echo $message;
?>