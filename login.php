<?php
session_start();      // inicia uma session
require 'config.php'; // chama o arquivo config.php para utilizar os dados contidos no mesmo

// se agency for vazia e não nula
if(isset($_POST['agency']) && !empty($_POST['agency'])) { // verifica se POST['agency'] não está vazio e com um valor nulo
  $inputAgency = addslashes($_POST['agency']);            // addslashes adiciona barra (\) no input da agency. Motivos de segurança
  $inputAccount = addslashes($_POST['account']);          // addslashes adiciona barra (\) no input da account. Motivos de segurança
  $inputPassword = md5($_POST['password']);               // addslashes adiciona barra (\) no input do password. Motivos de segurança

  /* Seleciona todas a linhas do banco de dados quando a agency, account e password 
  inserido no forms for igual aos dados que constam no banco de dados */
  $sql = "SELECT * FROM db_accounts WHERE dba_agency = :inputagency AND dba_account = :inputaccount AND dba_password = :inputpassword";
  $sql = $pdo->prepare($sql);                         // prepara a consulta $sql para o banco de dados

  // bindValue é um medida de proteção para que o input do usuário não seja feito diretamento na consulta do banco de dados
  $sql->bindValue(':inputagency', $inputAgency);     // :inputagency (adicionada medidas de segurança do bindValue) recebe o $inputAgency       
  $sql->bindValue(':inputaccount', $inputAccount);   // :inputaccount (adicionada medidas de segurança do bindValue) recebe o $inputAccount
  $sql->bindValue(':inputpassword', $inputPassword); // :inputpassword (adicionada medidas de segurança do bindValue) recebe o $inputPassword 
  $sql->execute();                                   // executa a query

  // Verifica se a consulta $sql retornou alguma coisa
  if($sql->rowCount() > 0) {             // se a contagem de linhas no $sql for mais que zero (0)
    $sql = $sql->fetch();                // fetch pega a primera linha que retornar (apenas um valor)
    $_SESSION['users'] = $sql['dba_id']; // a session criada no index.php recebe o id (contido no database) do usuário
    header("Location: index.php" );      // redireciona o usuário para a index.php (area restrita do sistema)
    exit;                                // interrompe todo o processamento da página
  } 
}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>ATM Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <div class="container limiter">
      <div class="loginBody">
        <form action="" method="POST">
            <div class="formItens">
              <h1>BANK OF BRAZIL</h1>
            </div>

            <div class="formItens">
              <label for="agency"><h6>Agency:</h6></label>
              <input type="text" class="form-control" name="agency" id="agency" placeholder="0000" maxlength="4">
            </div>

            <div class="formItens">
              <label for="account"><h6>Account:</h6></label>
              <input type="text" class="form-control" name="account" id="account" placeholder="00000-0" maxlength="6">
            </div>

            <div class="formItens">
              <label for="password"><h6>Password:</h6></label>
              <input type="password" class="form-control" name="password" id="password" placeholder="password" maxlength="8">
            </div>

            <div class="buttonSubmit">
              <button class="btn btn-secondary" type="submit">SIGN IN</button>
            </div>
          </form>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>