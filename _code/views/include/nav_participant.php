<ul>
   <li><a href="./ctrl_accueil.php">Accueil participant</a></li>
</ul>
<div>
   <form action="appel_ctrl_deconnexion.php" method="POST">
      <label><?php echo $_SESSION["loginUser"] . " est connecté comme " . $_SESSION["typeUser"]?></label>
      <button type="submit">Déconnexion</button>
   </form>
</div>