<?php

class MySql{
	private static $pdo;

	public static function conectar(){
		try{
			self::$pdo = new PDO('mysql:host='.HOST.';dbname='.DATABASE,USER,PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			return self::$pdo;
		}catch(Exception $e){
			echo "<h2>Erro ao logar no banco de dados</h2>";
		}

	}

	/*FUNÇÕES DE USUÁRIO*/
	/*/////////////////////////////////////////////////////////////////////////*/
	public static function logar($usuario,$senha){
		$db = MySql::conectar();
		$sql = "SELECT * FROM users WHERE usuario = ? AND senha = ?";
		$query = $db->prepare($sql);
		$query->execute(array($usuario,$senha));
		if($query->rowCount() == 1){
			session_start();
			header('Location: '. INCLUDE_PATH_PAGES);
			$_SESSION['logado'] = true;
			$_SESSION['usuario'] = $usuario;
			$_SESSION['senha'] = $senha;
		}else{
			echo '<div class=erro-box><i class="far fa-times-circle"></i>Dados incorretos!</div>';
		}
	}

	public static function cadastrarUsuario($nome, $usuario, $senha, $email, $imagem){
		$pdo = new PDO('mysql:host='.HOST.';dbname='.DATABASE,USER,PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$sql = "INSERT INTO users(id, nome, usuario, senha, email, imagem) VALUES (NULL, ?, ?, ?, ?, ?)";
		$query = $pdo->prepare($sql);
		$query->execute(array($nome, $usuario, $senha, $email, $imagem));
		if($query->rowCount() == 1){
			header('Location: '. INCLUDE_PATH);
		}else{
			echo "Erro ao cadastrar o usuário";
		}
	}

	public static function retornarFoto(){
		$pdo = new PDO('mysql:host='.HOST.';dbname='.DATABASE,USER,PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$usuario = $_SESSION['usuario'];
		$senha = $_SESSION['senha'];
		$sql = "SELECT * FROM users WHERE usuario = ? AND senha = ?";
		$query = $pdo->prepare($sql);
		$query->execute(array($usuario, $senha));
		if($query->rowCount() == 1){
			$result = $query->fetch(PDO::FETCH_ASSOC);
			$imagem = $result['imagem'];
			echo $imagem;
		}
	}

	/*FUNÇÕES DE POSTAGENs*/
	/*/////////////////////////////////////////////////////////////////////////*/

	public static function salvarPost($texto,$data,$usuario,$imagem){
		$pdo = new PDO('mysql:host='.HOST.';dbname='.DATABASE,USER,PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$sql = "INSERT INTO posts(id, postagem, data, user, imagem) VALUES (NULL, ?, ?, ?, ?)";
		$query = $pdo->prepare($sql);
		$query->execute(array($texto,$data, $usuario, $imagem));
		if($query->rowCount() == 1){
			return true;
			header('Location: '.INCLUDE_PATH_PAGES);
			die();
		}else{
			return false;
		}
	}


	public static function listarPosts(){
		/*Organização do código de retornar imagem*/
		$pdo = new PDO('mysql:host='.HOST.';dbname='.DATABASE,USER,PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$usuario = $_SESSION['usuario'];
		$senha = $_SESSION['senha'];
		$sql = "SELECT * FROM users WHERE usuario = ? AND senha = ?";
		$query = $pdo->prepare($sql);
		$query->execute(array($usuario, $senha));
		if($query->rowCount() == 1){
			$result = $query->fetch(PDO::FETCH_ASSOC);
			$img = $result['imagem'];
		}
		/*Postagem em execução */
		$usuario = $_SESSION['usuario'];
		$senha = $_SESSION['senha'];
		$pdo = new PDO('mysql:host='.HOST.';dbname='.DATABASE,USER,PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$sql = "SELECT * FROM posts ORDER BY data desc";
		$query = $pdo->prepare($sql);
		$query->execute(array($usuario));
		while($result = $query->fetch(PDO::FETCH_ASSOC)){
			$nome = $result['user'];
			$data = $result['data'];
			$imagem = $result['imagem'];
			$postagem = $result['postagem'];
			
			if($imagem ==""){
				echo "<div class= info-post><div class=imagem-retorno><img src= '../uploads/$img' ></div><div class=nome-usuario>$usuario</div></div>";
				echo "<div class=texto-post>$postagem</div>";
				echo "<div class =data-post> $data </div>";
			}else{
				echo "<div class= info-post><div class=imagem-retorno><img src= '../uploads/$imagem' ></div><div class=nome-usuario>$usuario</div></div>";
				echo "<img class='imagem-post' src= '../uploads/$imagem' >";
				echo "<div class=texto-post>$postagem</div>";
				echo "<div class =data-post> $data </div>";
			}
		}

		}
	}
?>
