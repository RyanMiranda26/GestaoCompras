<?php 
session_start();
include('codigo.php');

if(!$_SESSION || $_SESSION['TIPO'] != 'admin'){
	header("location: despensa.php");
}

$baseDados = new Codigo();

$listaCompras = $baseDados->gerarListaCompras();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Lista Automática de Compras</title>
		<meta charset="utf-8" />

	</head>
	<body>
		<h1>Lista Automática de Compras</h1>
		<a href="despensa.php">Voltar à Despensa</a>
		<br/><br/>
		
		<p>Lista gerada com base nas existências atuais da despensa (abaixo da quantidade mínima) e nos pedidos extra lista já aprovados.</p>
		
		<table border="1">
			<tr>
				<td>Artigo</td>
				<td>Quantidade a Comprar</td>
				<td>Origem</td>
			</tr>
			<?php
			foreach($listaCompras as $dados){
			?>
				<tr>
					<td><?php echo($dados['nome']) ?></td>
					<td><?php echo($dados['quantidade']) ?></td>
					<td><?php echo($dados['origem']) ?></td>
				</tr>
			<?php
			}
			?>
		</table>
	</body>
</html>
