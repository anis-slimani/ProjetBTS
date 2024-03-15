<!DOCTYPE html>
<html lang="fr">

<head>
	<?php include_once("./views/include/head.php") ?>
</head>

<body>
	<header>
		<?php include_once("./views/include/header.php") ?>
	</header>
	<nav>
		<?php
		if ($_SESSION["typeUser"] == "public") {
			include_once("./views/include/nav_public.php");
		} else if ($_SESSION["typeUser"] == "admin") {
			include_once("./views/include/nav_admin.php");
		} else if ($_SESSION["typeUser"] == "jury") {
			include_once("./views/include/nav_jury.php");
		} else if ($_SESSION["typeUser"] == "participant") {
			include_once("./views/include/nav_participant.php");
		}
		?>
	</nav>
	<main>
		<h2>Accueil : à faire !</h2>
		<section>
			<h3>Voici la liste des nouveaux hackathons : incrivez vous !</h2>
		</section>
	</main>
	<footer>
		<?php include("./views/include/footer.php"); ?>
	</footer>
</body>

</html>