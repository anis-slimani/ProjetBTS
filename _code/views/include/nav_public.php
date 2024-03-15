<ul>
   <li><a href="./ctrl_accueil.php">Accueil public</a></li>
   <li><a href="./ctrl_api.php">API</a></li>
</ul>
<div>
   <div>Entrez votre login, password, type d'utilisateur pour vous connecter.</div>
   <form action="appel_ctrl_connexion.php" method="POST">
      <label><?php echo $_SESSION["messageErreur"] ?></label>
      <input type="text" placeholder="login" name="loginUser">
      <input type="password" placeholder="password" name="passwordUser">
      <select name="typeUser">
         <option value="participant">participant</option>
         <option value="jury">jury</option>
         <option value="admin">admin</option>
      </select>
      <button type="submit" name="okConnexion">ok</button>
      <button type="submit" name="okDeconnexion">RAZ</button>
   </form>
   <div>Cliquez sur RAZ pour effacer les messages.</div> 
</div>