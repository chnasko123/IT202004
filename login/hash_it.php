<?php
$password = "test";
$a = password_hash($password, PASSWORD_BCRYPT);
$b = password_hash($password, PASSWORD_BCRYPT);
echo $a . "<br>";
echo $b . "<br>";

echo 'Does $a == $b?' . ($a == $b?"true":"false");
?>
