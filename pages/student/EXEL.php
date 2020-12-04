<form action="EXEL.php" enctype="multipart/form-data" method="post">
Select image :
<input type="file" name="file"><br/>
<input type="submit" value="Upload" name="Submit1"> <br/>
 
 
</form>
<?php
$dirname = "gebruikersBestanden/uploads/";
$images = glob($dirname."*.{csv}",GLOB_BRACE);
$num_of_files = 1;



if(isset($_POST['Submit1']))
{ 
$filepath ="gebruikersBestanden/uploads/" . $_FILES["file"]["name"];
 
if(move_uploaded_file($_FILES["file"]["tmp_name"], $filepath)) 
{
echo "File is geupload";
} 
else 
{
echo "Error !!";
}
} 


$dir = "gebruikersBestanden/uploads/";
$dh = opendir($dir);
$last = 0;
$name = "";
while (($file = readdir($dh)) !== false){
    if(is_file($dir.$file)){
        $mt = filemtime($dir.$file);
        if($mt > $last){
            $last = $mt;
            $name = $file;
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
echo "\n</table></body></html>";
?>