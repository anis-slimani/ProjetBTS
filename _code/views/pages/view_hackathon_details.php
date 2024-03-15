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
		<?php include_once("./views/include/nav_admin.php") ?>
	</nav>
	<main>
		<h2>Details du Hackathon n°<?php echo $hackathon->getId() ?></h2>
		<ul>
			<li>Nom : <?php echo $hackathon->getNom() ?></li>
			<li>Date début : <?php echo $hackathon->getDateDebut() ?></li>
		</ul>

		<h2>Les Projets du hackathon</h2>
		<p>Nombre de Projets : <?php echo sizeof($projetsDuHackathon) ?> </p>
		<table border>
			<tr>
				<th>id</th>
				<th>nom</th>
				<th>description</th>
				<th>pdf</th>
				<th>details</th>
			</tr>
			<?php foreach ($projetsDuHackathon as $projet) { ?>
				<tr>
					<td><?php echo $projet->getId() ?></td>
					<td><?php echo $projet->getNom() ?></td>
					<td><?php echo $projet->getDescription() ?></td>
					<td>
						<a href="./public/pdf/<?php echo $projet->getPdf() ?>" target="_blank">
							<?php echo $projet->getPdf() ?>
						</a>
					</td>

					<form action="./appel_ctrl_projet_details.php" method="POST">
						<input type=hidden name=idProjet value=<?php echo $projet->getId() ?>>
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