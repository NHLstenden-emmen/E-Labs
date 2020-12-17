<head>
<?php
// if(!isset($_GET['id'])){
// echo '<meta http-equiv="refresh" content="0;gebruikersoverzicht"/>';
// }
if(isset($_POST['submit'])){
    $userID = $_SESSION['userid'];
    var_dump($userID);
    $message = $db->DeleteUser($userID);
    echo $message;
    unset($_SESSION['userid']);
}
if(isset($_GET['id'])){
    $userID = $_SESSION['userid'] = $_GET['id'];
    $scu = $db->selectCurrentUsers($userID);
    var_dump($userID);
    var_dump($_SESSION['userid']);
    while($result = $scu->fetch_array(MYSQLI_ASSOC)){
    $name = $result['name'];
    }
?>
<body>
    <div>
        <h2>Account verwijderen</h2>
        <h3>Weet u zeker dat u <?php echo $name;?> wilt verwijderen?</h3>
        <form method="POST" action="accountverwijderen">
            <button type="submit" name="submit" value="Yes">Yes</button>
            <a href="gebruikersoverzicht"><button name="cancel" Value="no">No</button></a>
        </form>
    </div>
</body>
<?php
}
?>
