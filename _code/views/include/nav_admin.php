<ul>
   <li><a href="./ctrl_accueil.php">Accueil admin</a></li>
   <li><a href="./ctrl_hackathons_gerer.php">Gérer Hackathons</a></li>
   <li><a href="./ctrl_projets_gerer.php">Gérer Projet</a></li>
   <li><a href="./ctrl_hackathons_gerer2023.php">Gérer Hackathons 2023</a></li>

   
</ul>
<div>
   <form action="appel_ctrl_deconnexion.php" method="POST">
      <label><?php echo $_SESSION["loginUser"] . " est connecté comme " . $_SESSION["typeUser"]?></label>
      <button type="submit">Déconnexion</button>
   </form>
</div>