<?php

class Codigo{

	private $servidor = "localhost";
	private $nomeBaseDados = "gestaoCompras";
	private $utilizador = "root";
	private $password = "";
	
	public $ligacao;
	
	public function __Construct(){
		try{
			$this->ligacao = new PDO(
				'mysql:host='.$this->servidor.';port=3307;dbname='.$this->nomeBaseDados,
				$this->utilizador,
				$this->password,
				array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
			);
		}catch(PDOException $e){
			echo "ERRO: ".$e->getMessage();
			die();
		}
	}
	
	//Login / Utilizadores
	
	function login($nif, $pass){
		$sql = "SELECT * FROM utilizador WHERE nif = ? and pass = ?";
		$pedido = $this->ligacao->prepare($sql);
		$pedido->bindValue(1, $nif);
		$pedido->bindValue(2, $pass);
		$pedido->execute();
		
		$inf = $pedido->fetchAll();
		
		$total = $pedido->rowCount();
		
		if($total > 0){
			session_start();
			
			foreach($inf as $dados){
				$_SESSION['ID'] = $dados['id'];
				$_SESSION['NOME'] = $dados['nome'];
				$_SESSION['TIPO'] = $dados['tipo'];
			}
			header("location: despensa.php");
		}else{
			header("location: login.php");
		}
	}
	
	function logout(){
		session_start();
		unset($_SESSION);
		session_destroy();
		
		header("location: login.php");
	}
	
	function criarUtilizador($nome, $nif, $pass, $tipo){
		$sql = "INSERT INTO utilizador (nome, nif, pass, tipo) VALUES (?, ?, ?, ?)";
		$pedido = $this->ligacao->prepare($sql);
		$pedido->bindValue(1, $nome);
		$pedido->bindValue(2, $nif);
		$pedido->bindValue(3, $pass);
		$pedido->bindValue(4, $tipo);
		$pedido->execute();
	}
	
	//Artigos da despensa
	
	function listarArtigos(){
		$sql = "SELECT * FROM artigo ORDER BY nome";
		$pedido = $this->ligacao->prepare($sql);
		$pedido->execute();
		
		return $pedido->fetchAll();
	}
	
	function listarArtigoAtualizar($id){
		$sql = "SELECT * FROM artigo WHERE id = ?";
		$pedido = $this->ligacao->prepare($sql);
		$pedido->bindValue(1, $id);
		$pedido->execute();
		
		return $pedido->fetchAll();
	}
	
	function criarArtigo($nome, $quantidade, $quantidadeMinima){
		$sql = "INSERT INTO artigo (nome, quantidade, quantidadeMinima) VALUES (?, ?, ?)";
		$pedido = $this->ligacao->prepare($sql);
		$pedido->bindValue(1, $nome);
		$pedido->bindValue(2, $quantidade);
		$pedido->bindValue(3, $quantidadeMinima);
		$pedido->execute();
	}
	
	function atualizarArtigo($nome, $quantidade, $quantidadeMinima, $id){
		$sql = "UPDATE artigo set nome = ?, quantidade = ?, quantidadeMinima = ? WHERE id = ?";
		$pedido = $this->ligacao->prepare($sql);
		$pedido->bindValue(1, $nome);
		$pedido->bindValue(2, $quantidade);
		$pedido->bindValue(3, $quantidadeMinima);
		$pedido->bindValue(4, $id);
		$pedido->execute();
	}
	
	function apagarArtigo($id){
		$sql = "DELETE FROM artigo WHERE id = ?";
		$pedido = $this->ligacao->prepare($sql);
		$pedido->bindValue(1, $id);
		$pedido->execute();
	}
	

	function diminuirQuantidadeArtigo($id, $quantidadeNova){
		$sql = "SELECT quantidade FROM artigo WHERE id = ?";
		$pedido = $this->ligacao->prepare($sql);
		$pedido->bindValue(1, $id);
		$pedido->execute();
		
		$dados = $pedido->fetch();
		
		// só atualiza se a quantidade nova for inferior à quantidade atual
		if($dados && $quantidadeNova < $dados['quantidade']){
			$sql = "UPDATE artigo SET quantidade = ? WHERE id = ?";
			$pedido = $this->ligacao->prepare($sql);
			$pedido->bindValue(1, $quantidadeNova);
			$pedido->bindValue(2, $id);
			$pedido->execute();
		}
	}
	
	//Pedidos Extra Lista
	
	function criarPedidoExtra($nome, $quantidade, $idUtilizador){
		$sql = "INSERT INTO pedidoExtra (nome, quantidade, idUtilizador, estado, dataPedido) VALUES (?, ?, ?, 'pendente', NOW())";
		$pedido = $this->ligacao->prepare($sql);
		$pedido->bindValue(1, $nome);
		$pedido->bindValue(2, $quantidade);
		$pedido->bindValue(3, $idUtilizador);
		$pedido->execute();
	}
	
	function listarPedidosExtra(){
		$sql = "SELECT pedidoExtra.*, utilizador.nome as nomeUtilizador FROM pedidoExtra
				INNER JOIN utilizador ON pedidoExtra.idUtilizador = utilizador.id
				ORDER BY pedidoExtra.dataPedido DESC";
		$pedido = $this->ligacao->prepare($sql);
		$pedido->execute();
		
		return $pedido->fetchAll();
	}
	
	// Apenas o Administrador pode aprovar/rejeitar pedidos extra lista
	function aprovarPedidoExtra($id){
		$sql = "UPDATE pedidoExtra SET estado = 'aprovado' WHERE id = ?";
		$pedido = $this->ligacao->prepare($sql);
		$pedido->bindValue(1, $id);
		$pedido->execute();
	}
	
	function rejeitarPedidoExtra($id){
		$sql = "UPDATE pedidoExtra SET estado = 'rejeitado' WHERE id = ?";
		$pedido = $this->ligacao->prepare($sql);
		$pedido->bindValue(1, $id);
		$pedido->execute();
	}
	
	//Lista automática de compra
	
	function gerarListaCompras(){
		$lista = array();
		
		$sql = "SELECT nome, quantidade, quantidadeMinima FROM artigo WHERE quantidade < quantidadeMinima";
		$pedido = $this->ligacao->prepare($sql);
		$pedido->execute();
		
		foreach($pedido->fetchAll() as $dados){
			$lista[] = array(
				'nome' => $dados['nome'],
				'quantidade' => $dados['quantidadeMinima'] - $dados['quantidade'],
				'origem' => 'Existências'
			);
		}
		
		$sql = "SELECT nome, quantidade FROM pedidoExtra WHERE estado = 'aprovado'";
		$pedido = $this->ligacao->prepare($sql);
		$pedido->execute();
		
		foreach($pedido->fetchAll() as $dados){
			$lista[] = array(
				'nome' => $dados['nome'],
				'quantidade' => $dados['quantidade'],
				'origem' => 'Pedido Extra'
			);
		}
		
		return $lista;
	}

}
