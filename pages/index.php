<?php
include('../config.php');
include('../classes/MySql.php');
session_start();


if(isset($_GET['logout'])){
	session_destroy();
	header('Location: '.INCLUDE_PATH);
}

if(isset($_POST['enviar-post'])){
	$texto = $_POST['texto-post'];
	$data = date("Y-m-d");
	$imagem = "";
	$usuario = $_SESSION['usuario'];
	$postar = new MySql();
	$postar->salvarPost($texto,$data, $usuario, $imagem);
	header('Location: '.INCLUDE_PATH_PAGES);
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
				<img src="../images/image-index.jpg">
			</div>
			<div class="search-bar">
				<form method="POST">
					<input type="text" name="search" placeholder="Pesquisar" autocomplete="off">
				</form>
			</div>
			<div class="logout">
				<a href="<?php INCLUDE_PATH ?>?logout"><i class="fas fa-sign-out-alt"></i> Sair</a>
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
			<form method="POST">
				<label><h2>Escreva o que quiser</h2></label>
				<input type="textarea" name="texto-post" placeholder="Digite aqui o que deseja postar..." required>
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