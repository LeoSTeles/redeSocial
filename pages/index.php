<?php
include('../config.php');
include('../classes/MySql.php');
session_start();
date_default_timezone_set('America/Sao_Paulo');


if(isset($_GET['logout'])){
	session_destroy();
	header('Location: '.INCLUDE_PATH);
}

if(isset($_GET['user'])){
	header('Location: '.INCLUDE_PATH_PAGES.'menu_usuario.php');
}

if(isset($_GET['home'])){
	header('Location: '.INCLUDE_PATH_PAGES);
}

if(isset($_FILES['foto'])){
	$imagem = $_FILES['foto'];
}else{
	$imagem = "";
}

if(isset($_POST['enviar-post'])){
	$texto = $_POST['texto-post'];
	$data = date("Y-m-d");
	$usuario = $_SESSION['usuario'];
	$postar = new MySql();

	if($postar->validarImagem($imagem) == true AND isset($_FILES['foto'])){
		$postar->salvarPost($texto,$data, $hora, $usuario, $imagem['name']);
		move_uploaded_file($imagem['tmp_name'], BASE_DIR_PAGES.'/uploads/'.$imagem['name']);
		header('Location: '.INCLUDE_PATH_PAGES);
	}else{
		$postar->salvarPost($texto,$data, $hora, $usuario, $imagem);
		header('Location: '.INCLUDE_PATH_PAGES);
	}
	
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Página Inicial</title>
	<link href="../style/css/all.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH_STYLE; ?>style.css">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
</head>
<body>
	<section>
		<header>
			<div class="logo">
				<a href="<?php INCLUDE_PATH ?>?home"><img src="../images/image-index.jpg"></a>
			</div>
			<div class="search-bar">
				<form method="POST">
					<input type="text" name="search" placeholder="Pesquisar" autocomplete="off">
				</form>
			</div>
			<div class="logout">
				<a href="<?php INCLUDE_PATH ?>?logout"><img class="btn-logout" src="../images/logout-btn.png"></a>
			</div>
			<div class="user-menu">
				<a href="<?php INCLUDE_PATH ?>?user"><i class="fas fa-user"><i id="sort-down" class="fas fa-sort-down"></i></i></a>
			</div>
			<div class="img-menu-header">
				<?php $foto = new MySql();?>
				<img src="../uploads/<?php $foto->retornarFoto(); ?>">
			</div>
			<div class="clear"></div>
		</header>
	</section>
	<section>
		<div class="publicacao">
			<form method="POST" enctype="multipart/form-data">
				<h2>Escreva o que quiser</h2>
				<input type="textarea" name="texto-post" placeholder="Digite aqui o que deseja postar..." required>
				<label for='selecao-arquivo'>Foto</label>
				<input id='selecao-arquivo' type='file' name="foto">
				<input type="submit" name="enviar-post" value="Postar">
			</form>
		</div>
	</section>
	<section>
		<div class="postagens">

			<div class="box-postagem">
				<?php
					$postagens = new MySql();
					$postagens->listarPosts();
				?>

			</div>
		</div>
	</section>
	<section class="footer">
		<footer>
			<p>Todos os direitos reservados</p>
		</footer>
	</section>

</body>
</html>