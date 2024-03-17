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
        <h3>Voici la liste des nouveaux hackathons : inscrivez vous !</h3>
    </section>
    <?php if (!empty($hackathons)) { ?>
        <table border>
            <tr>
                <th>id</th>
                <th>nom</th>
                <th>date de début</th>
            </tr>
            <?php foreach ($hackathons as $hackathon) { ?>
                <tr>
                    <td><?php echo $hackathon->getId() ?></td>
                    <td><?php echo $hackathon->getNom() ?></td>
                    <td><?php echo $hackathon->getDateDebut() ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?><strong> <?php if(empty($hackathons)) {echo("Pas d'hackathons pour aujourd'hui"); } ?></strong>

</main>
	<footer>
		<?php include("./views/include/footer.php"); ?>
	</footer>
</body>

</html>


