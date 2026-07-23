<?php 
session_start();
include('codigo.php');

if(!$_SESSION || $_SESSION['TIPO'] != 'admin'){
	header("location: despensa.php");
}

$baseDados = new Codigo();

$dadosArtigo = $baseDados->listarArtigoAtualizar($_GET['e']);

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Página Principal</title>
		<meta charset="utf-8" />

	</head>
	<body>
		<h2>Editar Artigo da Despensa</h2>
		<form method="post" action="processaForms.php">
			<?php foreach($dadosArtigo as $dados){ ?>
			ID: <input readonly type="text" name="idNovo" value="<?php echo($dados['id'])?>"/>
			Artigo: <input type="text" name="nomeNovo" value="<?php echo($dados['nome'])?>"/>
			Quantidade: <input type="number" min="0" name="quantidadeNova" 
			value="<?php echo($dados['quantidade'])?>"/>
			Quantidade Mínima: <input type="number" min="0" name="quantidadeMinimaNova" 
			value="<?php echo($dados['quantidadeMinima'])?>"/>
			<?php } ?>
			<input type="submit" value="Atualizar" name="atualizarArtigo"/>
		</form>
		<br/>
		<a href="despensa.php">Voltar</a>
	</body>
</html>
