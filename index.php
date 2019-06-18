<?php
session_start(); // inicia uma session
require 'config.php';

// se users for vazia e não nula
if(isset($_SESSION['users']) && !empty($_SESSION['users'])) { // se a session['users'] não está vazio nem nulo
  $userId = addslashes($_SESSION['users']);                   // $userId recebe a session['users'] 

  /* Seleciona todas a linhas do banco de dados quando o id do database for igual ao id gerado na session */
  $sql = "SELECT * FROM db_accounts WHERE dba_id = :userid";
  $sql = $pdo->prepare($sql);               // prepara a consulta $sql para o banco de dados
  $sql->bindValue(':userid', $userId);      // :userid (adicionada medidas de seguranças do bindValue) recebe o $userId
  $sql->execute();

  // se existir um usuário com o id (se retornar uma linha ou mais do database)
  if($sql->rowCount() > 0) {                                                     // se a contagem de linhas no $sql for mais que zero (0)
    $userInformations = $sql->fetch();                                           // fetch pega a primera linha que retornar (apenas um valor)
    $userHolder = $userInformations['dba_holder'];                               // a variável $userHolder recebe o holder do database
    $userAgency = $userInformations['dba_agency'];                               // a variável $userAgency recebe o agency do database
    $userAccountRight = substr($userInformations['dba_account'], 0, 5);          // a variável $userAccountRight recebe os 5 primeiros digitos do account do database
    $userAccountLeft = substr($userInformations['dba_account'], 5, 1);           // a variável $userAccountRight recebe o ultimo digito do account do database
    $userBalance = number_format($userInformations['dba_balance'], 2, ",", "."); // a variável $userBalance recebe o balance do database
   
  // se não foi encontrado nenhum usuário com o tal id (se não retornou nenhuma linha)
  } else {
    header("Location: login.php");  // redireciona o usuário para a login.php
    exit;                           // interrompe todo o processamento da página
  }

// caso contrário, o usuário é redirecionado para a login.php
} else { 
    header("Location: login.php");  // redireciona o usuário para a login.php
    exit;                           // interrompe todo o processamento da página
}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>ATM</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <div class="container limiter">
      <div class="indexBody">
        <div class="welcameUser">
          <div>
            <h5><strong>Welcome </strong><?php echo $userHolder; ?></h5> </br>
          </div>

          <div class="button">
            <a href="logout.php" role="button">Logout</a>
          </div>
        </div>

        <div class="indexInfo">
          <div class="indexItens">
            <h6>ag: <?php echo $userAgency; ?></h6> </br>
          </div>

          <div class="indexItens">
            <h6>a/c: <?php echo $userAccountRight."-".$userAccountLeft; ?></h6> </br>
          </div>
        </div>

        <div class="indexBalance">
            <h6>
              Balance:
              <?php 
              if($userBalance < 0.0) {
                echo '<p class="text-danger">';
                echo '$ '.$userBalance; 
                echo '</p>';
              } 
              elseif($userBalance == 0.0) {
                echo '<p class="text-secondary">';
                echo '$ '.$userBalance; 
                echo '</p>';
              } else {
                echo '<p class="text-success">';
                echo '$ '.$userBalance; 
                echo '</p>';
              }
              ?>
            </h6> 
        </div>

        <div class="buttonsBody">
          <div class="">
            <a class="btn btn-success" href="place.php" role="button">Place</a>
          </div>

          <div class="">
            <a class="btn btn-danger" href="cashout.php" role="button">Cash out</a>
          </div>

          <div class="">
            <a class="btn btn-info" href="extract.php" role="button">Extract</a>
          </div>
        </div>

        
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>