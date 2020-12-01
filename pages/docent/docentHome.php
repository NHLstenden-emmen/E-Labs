<!DOCTYPE html>
<html>
<head>
  <title> Docenten Pagina </title>
</head>
<body>
    <p>docent home</p>
    <table>
      <tr>
        <th>User ID</th>
        <th>Cijfer</th>
      </tr>
    <?php
    $conn = mysqli_connect("localhost", "root", "", "e-labs")
    if ($conn-> connect_error){
      die("Connection failed:". $conn-> connect_error);
    }

    $sql = "SELECT user_id, lab_journal_id FROM lab_journal_users";
    $result = $conn-> query($sql);

    if (result)-> num_rows > 0) {
      while($row = result-> fetch_assoc()){
        echo "<tr><td>". $row{"user_id"}. "</td><td>". $row{"lab_journal_id"}. "</td></tr>";
      }
      echo "</table>";
    }
    else{
      echo "Geen resultaat";
    }

    $conn-> close();
    ?>  
    </table>
</body
</html>
