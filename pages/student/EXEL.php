
<?php
if (isset($_GET['id'])) {
	$getLabjournaal = $db->getLabjournaal($_GET['id'], $_SESSION['user_id']);
	while ($result = $getLabjournaal->fetch_array(MYSQLI_ASSOC)){ 
		if ($result["submitted"] == 0) {
		?>
		
				<?php 
				$file = $result['Attachment'];
				echo $file;
				echo "<br>";
							echo "<html><body><table>\n\n";
								$f = fopen($file, "r");
								while (($line = fgetcsv($f)) !== false) {
										echo "<tr>";
										foreach ($line as $cell) {
												echo "<td style='border: 1px solid black;'>" . htmlspecialchars($cell) . "</td>";
										}
										echo "</tr>\n";
								}
								fclose($f);
								echo "\n</table></body></html>";
				
				?>
		
		
		<?php
		}}
	} else {
	echo $message;
}
		?>





<?php
/*$dir = "gebruikersBestanden/uploads/";
$dh = opendir($dir);
$last = 0;
$name = "";


while (($file = readdir($dh)) !== false){
    if(is_file($dir.$file)){
        $mt = filemtime($dir.$file);
        if($mt > $last){
            $last = $mt;
            $name = $file;
			echo $name;
			echo "<br><br>";
        }
    }
}
closedir($dh);

echo "Last modified file: $name";

echo "<html><body><table width='100%' border='1'>\n\n";
$f = fopen("gebruikersBestanden/uploads/".$name, "r");
while (($line = fgetcsv($f)) !== false) {
        echo "<tr>";
        foreach ($line as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
        }
        echo "</tr>\n";
}
fclose($f);
echo "\n</table></body></html>";*/

?>




