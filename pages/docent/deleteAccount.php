<?php
if(isset($_POST['submit'])){
    $userID = $_SESSION['userid'];
    $message = $db->DeleteUser($userID);
    echo $message;
    unset($_SESSION['userid']);
}
if(isset($_GET['id'])){
    $userID = $_SESSION['userid'] = $_GET['id'];
    $scu = $db->selectCurrentUsers($userID);
    while($result = $scu->fetch_array(MYSQLI_ASSOC)){
    $name = $result['name'];
    }
?>
<div>
    <h2><?=$lang['DELETEACCOUNT'];?></h2>
    <h3><?php echo $lang['AREYOUSUREDELETE'], $name, $lang['THISUSER'];?></h3>
    <form method="POST" action="deleteaccount">
        <button type="submit" name="submit" value="Yes"><?=$lang['YES'];?></button>
        <a href="useroverview"><button name="cancel" Value="no"><?=$lang['NO'];?></button></a>
    </form>
</div>
<?php } ?>
