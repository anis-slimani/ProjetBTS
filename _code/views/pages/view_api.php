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
		include_once("./views/include/nav_public.php");
		?>
	</nav>
	<main>
		<h2>Les API</h2>
		<section>
			<h3>Tous les hackathons avec leurs projet : </h3>
			<p><a href="./apiHackathonsProjets.php" target="_blank">./apiHackathonsProjets.php</a></p>
		</section>
		<section>
			<h3>Tous les hackathons avec leurs projet d'une année donnée: </h3>
			<p><a href="./apiHackathonsProjets.php?annee=2024" target="_blank">./apiHackathonsProjets.php?annee=2024</a></p>
			<p><a href="./apiHackathonsProjets.php?annee=2023" target="_blank">./apiHackathonsProjets.php?annee=2023</a></p>
		</section>
		<section>
			<h3>Le hackathon avec ses projets pour un id saisi : </h3>
			<form action="./apiHackathonsProjets.php" target="_blank" method="GET">
				<label for="id">Entrez l'id :</label>
				<input type="number" name="idHackathon" placeholder="id" style="width:100px" required>
				<button type="submit">./apiHackathonsProjets.php?id=l'id saisi</button>
			</form>
		</section>
	</main>
	<footer>
		<?php include("./views/include/footer.php"); ?>
	</footer>
</body>

</html>