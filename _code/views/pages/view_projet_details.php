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
		<h2>Details du Projet n°<?php echo $projet->getId() ?></h2>
		<ul>
			<li>id projet : <?php echo $projet->getId() ?></li>
			<li>Nom projet : <?php echo $projet->getNom() ?></li>
			<li>Description projet : <?php echo $projet->getDescription() ?></li>
			<li>pdf projet: <a href="./public/pdf/<?php echo $projet->getPdf() ?>" target="_blank">
					<?php echo $projet->getPdf() ?>
				</a></li>
			<li>Retenu projet :
				<?php
				if ($projet->getRetenu()) echo "True";
				else echo "False";
				?></li>
			<?php if ($hackathonDuProjet == "") { ?><li>Id Hackathon : null</li><?php } ?>
		</ul>

		<?php if ($hackathonDuProjet != "") { ?>
			<fieldset>
				<h3>=> hackathon du Projet n°<?php echo $projet->getId() ?></h3>
				<ul>
					<li>Id hackathon : <?php echo $hackathonDuProjet->getId() ?></li>
					<li>Nom hackathon : <?php echo $hackathonDuProjet->getNom() ?></li>
					<li>Date début hackathon : <?php echo $hackathonDuProjet->getDateDebut() ?></li>
				</ul>
			</fieldset>
		<?php } ?>

		<?php if (isset($hackathonsEligiblesDuProjet) == false) { ?>
			<h2> Le projet ne peut plus être modifié</h2>
		<?php } else { ?>
			<h2>Ajouter ou changer ou retirer le pdf du projet : </h2>
			<form action="#" method="POST" enctype="multipart/form-data">
				<label>Uploader un fichier : </label>
				<input type=hidden name=idProjet value=<?php echo $projet->getId() ?>>
				<input type="file" name="userfile">
				<button type="submit" name=ajouterPdfProjet>ajouter ou changer le pdf</button>
				<button type="submit" name=retirerPdfProjet>retirer le pdf</button>
			</form>
			<?php if ($hackathonDuProjet != "") { ?>
				<h2>Changer le "retenu" du projet : </h2>
				<form action="#" method="POST">
					<input type=hidden name=idProjet value=<?php echo $projet->getId() ?>>
					<button type="submit" name=inverserRetenuProjet>inverser retenu</button>
				</form>
				<h2>Retirer le hackathon du projet : </h2>
				<form action="#" method="POST">
					<input type=hidden name=idProjet value=<?php echo $projet->getId() ?>>
					<button type="submit" name=retirerHackathonProjet>retirer hackathon</button>
				</form>
			<?php } ?>
			<h2>Les Hackathons éligibles du projet :</h2>
			<p>Nombre de Hackathons éligibles : <?php echo sizeof($hackathonsEligiblesDuProjet) ?> </p>
			<table border>
				<tr>
					<th>id</th>
					<th>nom</th>
					<th>date de début</th>
					<th>sélectionner</th>
					<th>details</th>
				</tr>
				<?php foreach ($hackathonsEligiblesDuProjet as $hackathon) { ?>
					<tr>
						<td><?php echo $hackathon->getId() ?></td>
						<td><?php echo $hackathon->getNom() ?></td>
						<td><?php echo $hackathon->getDateDebut() ?></td>

						<form action="#" method="POST">
							<input type=hidden name=idHackathon value=<?php echo $hackathon->getId() ?>>
							<input type=hidden name=idProjet value=<?php echo $projet->getId() ?>>
							<td><button type="submit" name=selectionerHackathon>sélectionner</button></td>
						</form>

						<form action="./appel_ctrl_hackathon_details.php" method="POST">
							<input type=hidden name=idHackathon value=<?php echo $hackathon->getId() ?>>
							<td><button type="submit">details</button></td>
						</form>
					</tr>
				<?php } ?>
			</table>
		<?php } ?>
	</main>
	<footer>
		<?php include("./views/include/footer.php"); ?>
	</footer>
</body>

</html>