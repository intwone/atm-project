<?php
session_start();
require 'config.php';

$operationType = 1;

if(isset($_POST['addValue']) && !empty($_POST['addValue'])) {
  $valueAdded = addslashes(str_replace(",", ".", $_POST['addValue']));
  $valueAdded = floatval($valueAdded);

  $sql = "INSERT INTO db_historic (dbh_idAccount, dbh_type, dbh_value, dbh_operationDate) VALUES (:dbh_idaccount, :dbh_operationtype, :dbh_value, NOW())";
  $sql = $pdo->prepare($sql);
  $sql->bindValue(':dbh_idaccount', $_SESSION['users']);
  $sql->bindValue(':dbh_operationtype', $operationType);
  $sql->bindValue(':dbh_value', $valueAdded);
  $sql->execute();

  $sql = "UPDATE db_accounts SET dba_balance = dba_balance - :attvalue WHERE dba_id = :id";
	$sql = $pdo->prepare($sql);
	$sql->bindValue('attvalue', $valueAdded);
	$sql->bindValue(':id', $_SESSION['users']);
	$sql->execute();


  header("Location: index.php");
  exit;
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
			<div class="placeBody">
				<div>
						<h4>Type a value</h4>    
				</div>

				<form method="POST">
					<div class="inputValues">
						<div class="">
							<label class="" for="value"><h6>Value ($):</h6></label>
						</div>

						<div>
							<input type="text" name="addValue" id="addValue" pattern="[0-9.,]{1,}" placeholder="only numbers">
						</div>
					</div>

					<div class="addValue">
						<button class="btn btn-danger" type="submit">Send value</button>
						<a class="btn btn-info" href="index.php" role="button">Back</a>
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