<?php
include('config.php');
include('classes/MySql.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Rede social de teste</title>
	<link href="<?php INCLUDE_PATH_STYLE; ?>css/all.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php INCLUDE_PATH; ?>style/style.css">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
</head>
<body>
	<div class="login">

		<div class="imagem-login">
			<p><img src="<?php INCLUDE_PATH; ?>images/image-index.jpg"></p>
		</div>
		<div class="box-login">
			<?php
				if(isset($_GET['cadastro'])){
					header('Location: '.INCLUDE_PATH_PAGES.'cadastro.php');
				}

				if(isset($_POST['logar'])){
					$usuario = $_POST['usuario'];
					$senha = $_POST['senha'];

					$logar = new MySql();
					$logar->logar($usuario,$senha);

				}
			?>
			<form method="POST">
				<div>
					<input type="text" name="usuario" placeholder="Usuário">
				</div>

				<div>
					<input type="password" name="senha" placeholder="Senha">
				</div>

				<div>
					<input type="submit" name="logar" value="Entrar">
				</div>
				<div>
					<p>Novo por aqui? <a href="<?php INCLUDE_PATH; ?>?cadastro"><b>Cadastre-se!</b></a></p>
				</div>

			</form>
		</div>
	</div>
</body>
</html>