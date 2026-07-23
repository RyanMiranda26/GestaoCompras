<?php 
session_start();

include('codigo.php');

if(!$_SESSION){
	header("location: login.php");
}

$baseDados = new Codigo();

$listarArtigos = $baseDados->listarArtigos();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Página Principal</title>
		<meta charset="utf-8" />

	</head>
	<body>
		<h1>Gestão de Compras do Supermercado</h1>
		
		Olá <?php echo($_SESSION['NOME']); ?> (<?php echo($_SESSION['TIPO']); ?>) – 
		<a href="processaForms.php?l=0">Logout</a>
		<br/><br/>
		
		<a href="pedidosExtra.php">Ver Pedidos Extra Lista</a>
		<?php if($_SESSION['TIPO'] == 'admin'){ ?>
			| <a href="listaCompras.php">Gerar Lista Automática de Compras</a>
		<?php } ?>
		
		<h2>Artigos existentes na Despensa</h2>
		<table border="1">
			<tr>
				<td>Id</td>
				<td>Artigo</td>
				<td>Quantidade</td>
				<td>Quantidade Mínima</td>
				<?php if($_SESSION['TIPO'] == 'geral'){ ?>
				<td>Indicar Nova Quantidade</td>
				<?php }else{ ?>
				<td>Apagar</td>
				<td>Editar</td>
				<?php } ?>
			</tr>
			<?php
			foreach($listarArtigos as $dados){
			?>
				<tr>
					<td><?php echo($dados['id']) ?></td>
					<td><?php echo($dados['nome']) ?></td>
					<td><?php echo($dados['quantidade']) ?></td>
					<td><?php echo($dados['quantidadeMinima']) ?></td>
					<?php if($_SESSION['TIPO'] == 'geral'){ ?>
					<td>
						<form method="post" action="processaForms.php">
							<input type="hidden" name="idArtigo" value="<?php echo($dados['id']) ?>"/>
							<input type="hidden" name="quantidadeAtual" value="" />
							<input type="number" min="0" max="<?php echo($dados['quantidade']) ?>" onchange="this.form.quantidadeAtual.value=this.value" />
							<input type="submit" name="diminuirQuantidade" value="Atualizar"/>
						</form>
					</td>
					<?php }else{ ?>
					<td><a href="processaForms.php?a=<?php echo($dados['id']) ?>">
						<image src="imagens/apagar.png" height = "30px"/>	
						</a></td>
					<td><a href="editarArtigo.php?e=<?php echo($dados['id']) ?>">
					<image src="imagens/editar.png" height = "30px"/>	
					</a></td>
					<?php } ?>
				</tr>
			<?php
			}
			?>
		</table>
		<br/>
		
		<?php if($_SESSION['TIPO'] == 'geral'){ ?>
		<h2>Pedir Artigo Extra Lista</h2>
		<form method="post" action="processaForms.php">
			Artigo: <input type="text" name="nomeExtra"/>
			Quantidade: <input type="number" min="1" name="quantidadeExtra" value="1"/>
			<input type="submit" value="Pedir" name="pedirExtra"/>
		</form>
		<?php } ?>
		
		<?php if($_SESSION['TIPO'] == 'admin'){ ?>
		<h2>Registar Novo Artigo na Despensa</h2>
		<form method="post" action="processaForms.php">
			Artigo: <input type="text" name="nomeArtigo"/>
			Quantidade: <input type="number" min="0" name="quantidade"/>
			Quantidade Mínima: <input type="number" min="0" name="quantidadeMinima"/>
			<input type="submit" value="Registar" name="registarArtigo"/>
		</form>
		
		<h2>Registar Novo Utilizador</h2>
		<form method="post" action="processaForms.php">
			Nome: <input type="text" name="nome"/>
			NIF: <input type="text" name="nif"/>
			Password: <input type="password" name="pass"/>
			Tipo: 
			<select name="tipo">
				<option value="geral">Geral</option>
				<option value="admin">Administrador</option>
			</select>
			<input type="submit" value="Registar" name="registarUtilizador"/>
		</form>
		<?php } ?>
		
	</body>
</html>
