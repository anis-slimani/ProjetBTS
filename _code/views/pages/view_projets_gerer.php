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
		<h1>Les Projets : </h1>
		<p>Nombre de Projets : <?php echo sizeof($projets) ?> </p>
		<table border>
			<tr>
				<th>id</th>
				<th>nom</th>
				<th>description</th>
				<th>pdf</th>
				<th>retenu</th>
				<th>idHackathon</th>
				<th>delete</th>
				<th>select update</th>
				<th>details</th>
			</tr>
			<?php foreach ($projets as $projet) { ?>
				<tr>
					<td><?php echo $projet->getId() ?></td>
					<td><?php echo $projet->getNom() ?></td>
					<td><?php echo $projet->getDescription() ?></td>
					<?php if ($projet->getPdf() == null) { ?>
						<td></td>
					<?php } else { ?>
						<td><a href="./public/pdf/<?php echo $projet->getPdf() ?>" target="_blank">
								<?php echo $projet->getPdf() ?></a>
						</td>
					<?php } ?>
					<td><?php echo $projet->getRetenu() ?></td>
					<td><?php echo $projet->getIdHackathon() ?></td>

					<form action="#" method="POST">
						<input type=hidden name=idProjet value=<?php echo $projet->getId() ?>>
						<td><button type="submit" name=deleteProjet>delete</button></td>
					</form>

					<form action="#" method="POST">
						<input type=hidden name=idProjet value=<?php echo $projet->getId() ?>>
						<td><button type="submit" name=selectUpdateProjet>select update</button></td>
					</form>

					<form action="./appel_ctrl_projet_details.php" method="POST">
						<input type=hidden name=idProjet value=<?php echo $projet->getId() ?>>
						<td><button type="submit">details</button></td>
					</form>

				</tr>
			<?php } ?>
		</table>
		<h2>
			<?php if (isset($projetAModifier)) {
				echo "Modification du projet n°" . $projetAModifier->getId();
			} else {
				echo "Ajout d'un nouveau projet";
			} ?>
		</h2>
		<form action="#" method="POST">
			<label>Nom : </label>
			<input type=text name=nomProjet value="<?php // des guillemets sur value pour le cas où le getter
																// contient des espaces et la balise php collée aux guillemets
																if (isset($projetAModifier)) {
																	echo $projetAModifier->getNom();
																} ?> ">

			<label>Descritption : </label>
			<input type=text name=descriptionProjet value="<?php if (isset($projetAModifier)) {
																				echo $projetAModifier->getDescription();
																			} ?> ">

			<input type=hidden name=idProjet value="<?php if (isset($projetAModifier)) {
																		echo $projetAModifier->getId();
																	} ?> ">

			<button type="submit" name=<?php
												if (isset($projetAModifier)) echo "updateProjet";
												else echo "insertProjet";
												?>>
				<?php
				if (isset($projetAModifier)) echo "update projet";
				else echo "insert projet";
				?>
			</button>
		</form>

	</main>
	<footer>c
		<?php include("./views/include/footer.php"); ?>
	</footer>
</body>

</html>