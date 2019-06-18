<?php
$dsn = "mysql:dbname=lesson33_project;host=localhost"; // primeiro parâmetro do PDO, caminho de conexão e nome do banco de dados
$dbuser = "root";                                      // segundo parâmetro do PDO, usuário do banco de dados             
$dbpassword = "";                                      // terceiro parâmetro do PDO, senha do banco de dados

// bloco try catch para exceções
// bloco protegido try (pode ser gerado uma exceção)
try { // tente isso...
  $pdo = new PDO($dsn, $dbuser, $dbpassword); // $pdo recebe um novo objeto PDO(primeiro_parametro, segundo_parametro, terceiro_parametro)
    
// bloco de tratamento caso haja uma exceção
} catch(PDOexception $error) {              // caso exceção, chama PDOexception atribuindo-o á variável $error
	echo "ERROR: ".$error->getMessage();    // printa na tela a mensagem "ERROR" seguida da mensagem do PDOexcepetion
	exit;                                   // interrompe todo o processamento 
}                                  
?>