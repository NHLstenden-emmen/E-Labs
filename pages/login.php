<h1>Login</h1>
<form method="post">
	<label>naam:</label>
	<input type="text" name="name" required>
	<label>wachtwoord:</label>
	<input type="password" name="password" required>
	<button type="submit">login</button>
</form>

<?php
	$name = $_POST['name'];
	$pass = $_POST['password'];
	$login = $db->login($name,$pass);
	while ($result = $login->fetch_array(MYSQLI_ASSOC)){
		echo $result['name'];
		if ($result['role'] == "docent") {
			exit('hoi');
		}
	}
?>