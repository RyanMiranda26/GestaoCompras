<?php 
include('codigo.php');
$baseDados = new Codigo();


?>
<!DOCTYPE html>
<html>
	<head>
		<title>Página Login</title>
		<meta charset="utf-8" />

	</head>
	<body>
		<h2>Gestão de Compras - Login:</h2>
		<br  />
		<form method="post" action="processaForms.php">
			NIF: <input type="text" name="utilizador" />
			<br  />
			Pass: <input type="password" name="password"/>
			<br  />
			<input type="submit" name="login" value="Entrar"/>
		</form>
	</body>
</html>
