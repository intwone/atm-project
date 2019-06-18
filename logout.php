<?php
session_start();

unset($_SESSION['users']);      // destroi a session users
header("Location: index.php");  // redireciona o usuário para a login.php
exit;                           // interrompe todo o processamento 
?>