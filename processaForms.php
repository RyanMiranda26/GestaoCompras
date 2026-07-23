<?php
session_start();
include('codigo.php');
$baseDados = new Codigo();

//Verificar se está a ser pedido um Login
if(isset($_POST['login'])){
	if(isset($_POST['utilizador']) && isset($_POST['password'])){
		$baseDados->login($_POST['utilizador'], $_POST['password']);
	}
}

//Chamar o logout
if(isset($_GET['l'])){
	$baseDados->logout();
}


if( isset($_POST['registarUtilizador'])){
	if( isset($_POST['nome']) && isset($_POST['nif']) && isset($_POST['pass']) && isset($_POST['tipo'])){
		$baseDados->criarUtilizador($_POST['nome'], $_POST['nif'], $_POST['pass'], $_POST['tipo']);
		
		header("location: despensa.php");
	}
}


if( isset($_POST['registarArtigo'])){
	if( isset($_POST['nomeArtigo']) && isset($_POST['quantidade']) && isset($_POST['quantidadeMinima'])){
		$baseDados->criarArtigo($_POST['nomeArtigo'], $_POST['quantidade'], $_POST['quantidadeMinima']);
		
		header("location: despensa.php");
	}
}


if( isset($_POST['atualizarArtigo'])){
	if( isset($_POST['nomeNovo']) && isset($_POST['quantidadeNova']) && isset($_POST['quantidadeMinimaNova'])){
		$baseDados->atualizarArtigo($_POST['nomeNovo'], $_POST['quantidadeNova'], $_POST['quantidadeMinimaNova'], $_POST['idNovo']);
		
		header("location: despensa.php");
	}
}


if( isset($_GET['a'])){
	$baseDados->apagarArtigo($_GET['a']);
	header("location: despensa.php");
}


if( isset($_POST['diminuirQuantidade'])){
	if( isset($_POST['idArtigo']) && isset($_POST['quantidadeAtual'])){
		$baseDados->diminuirQuantidadeArtigo($_POST['idArtigo'], $_POST['quantidadeAtual']);
		
		header("location: despensa.php");
	}
}


if( isset($_POST['pedirExtra'])){
	if( isset($_POST['nomeExtra']) && isset($_POST['quantidadeExtra'])){
		$baseDados->criarPedidoExtra($_POST['nomeExtra'], $_POST['quantidadeExtra'], $_SESSION['ID']);
		
		header("location: pedidosExtra.php");
	}
}


if( isset($_GET['ap'])){
	$baseDados->aprovarPedidoExtra($_GET['ap']);
	header("location: pedidosExtra.php");
}


if( isset($_GET['rj'])){
	$baseDados->rejeitarPedidoExtra($_GET['rj']);
	header("location: pedidosExtra.php");
}

?>
