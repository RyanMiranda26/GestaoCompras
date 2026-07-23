<?php 
session_start();
include('codigo.php');

if(!$_SESSION){
	header("location: login.php");
}

$baseDados = new Codigo();

$listarPedidos = $baseDados->listarPedidosExtra();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Pedidos Extra Lista</title>
		<meta charset="utf-8" />

	</head>
	<body>
		<h1>Pedidos Extra Lista</h1>
		<a href="despensa.php">Voltar à Despensa</a>
		<br/><br/>
		
		<table border="1">
			<tr>
				<td>Id</td>
				<td>Artigo</td>
				<td>Quantidade</td>
				<td>Pedido Por</td>
				<td>Data do Pedido</td>
				<td>Estado</td>
				<?php if($_SESSION['TIPO'] == 'admin'){ ?>
				<td>Aprovar</td>
				<td>Rejeitar</td>
				<?php } ?>
			</tr>
			<?php
			foreach($listarPedidos as $dados){
			?>
				<tr>
					<td><?php echo($dados['id']) ?></td>
					<td><?php echo($dados['nome']) ?></td>
					<td><?php echo($dados['quantidade']) ?></td>
					<td><?php echo($dados['nomeUtilizador']) ?></td>
					<td><?php echo($dados['dataPedido']) ?></td>
					<td><?php echo($dados['estado']) ?></td>
					<?php if($_SESSION['TIPO'] == 'admin'){ ?>
					<td>
						<?php if($dados['estado'] == 'pendente'){ ?>
						<a href="processaForms.php?ap=<?php echo($dados['id']) ?>">Aprovar</a>
						<?php } ?>
					</td>
					<td>
						<?php if($dados['estado'] == 'pendente'){ ?>
						<a href="processaForms.php?rj=<?php echo($dados['id']) ?>">Rejeitar</a>
						<?php } ?>
					</td>
					<?php } ?>
				</tr>
			<?php
			}
			?>
		</table>
	</body>
</html>
