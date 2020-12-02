<?php
include('../config.php');
include('../classes/MySql.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>Cadastrar novo usuário</title>
	<link href="../style/css/all.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH_STYLE; ?>style.css">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
</head>
<body>
	<div class="box-cadastro">
		<div class="content-cadastro">
			<form method="POST">
				<?php 
				if(isset($_GET['home'])){
					header('Location: '.INCLUDE_PATH);
				}

				if(isset($_POST['cadastrar'])){
					$nome = $_POST['nome'];
					$usuario = $_POST['usuario'];
					$senha = $_POST['senha'];
					$email = $_POST['email'];
					$imagem = '';

					$cadastro = new MySql();
					$cadastro->cadastrarUsuario($nome, $usuario, $senha, $email, $imagem);
				}
				?>
				<div>
					<a href="<?php echo INCLUDE_PATH; ?>"><i class="fas fa-users"></i></a>
				</div>
				<div>
					<input type="text" name="nome" placeholder="Nome">
				</div>
				<div>
					<input type="text" name="usuario" placeholder="Usuário">
				</div>

				<div>
					<input type="password" name="senha" placeholder="Senha">
				</div>
				<div>
					<input type="text" name="email" placeholder="E-mail">
				</div>
				<div>
					<input type="submit" name="cadastrar" value="Cadastrar!">
				</div>
				<div>
					<p>Já tem uma conta? <a href="<?php INCLUDE_PATH; ?>?home"><b>Faça login!</b></a></p>
				</div>
			</form>
		</div>
	</div>
</body>
</html>