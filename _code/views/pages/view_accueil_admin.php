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
		<table border>
			<tr>
				<th>id</th>
				<th>nom</th>
				<th>date de début</th>
				<th>delete</th>
				<th>select update</th>
				<th>details</th>
			</tr>
			<?php foreach ($hackathons as $hackathon) { ?>
				<tr>
					<td><?php echo $hackathon->getId() ?></td>
					<td><?php echo $hackathon->getNom() ?></td>
					<td><?php echo $hackathon->getDateDebut() ?></td>

					<form action="#" method="POST">
						<input type=hidden name=idHackathon value=<?php echo $hackathon->getId() ?>>
						<td><button type="submit" name=deleteHackathon>delete</button></td>
					</form>

					<form action="#" method="POST">
						<input type=hidden name=idHackathon value=<?php echo $hackathon->getId() ?>>
						<td><button type="submit" name=selectUpdateHackathon>select update</button></td>
					</form>

					<form action="./appel_ctrl_hackathon_details.php" method="POST">
						<input type=hidden name=idHackathon value=<?php echo $hackathon->getId() ?>>
						<td><button type="submit">details</button></td>
					</form>
				</tr>
			<?php } ?>
		</table>
	</main>
	<footer>
		<?php include("./views/include/footer.php"); ?>
	</footer>
</body>

</html>