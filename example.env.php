<?php
/* 
------------------
How to use secrets savely
- make a var with the secret
$env['TEST'] = 'TEST';

- call the secret on the place where you want to use the secret
<?php echo $env['TEST']; ?>

------------------
*/
$env['DB_CONNECTION'] = 'mysql';
$env['DB_HOST'] = '127.0.0.1';
$env['DB_PORT'] = '3306';
$env['DB_DATABASE'] = 'E-Labs';
$env['DB_USERNAME'] = 'root';
$env['DB_PASSWORD'] = '';
?>