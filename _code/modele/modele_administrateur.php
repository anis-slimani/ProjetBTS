<?php
/*
CREATE TABLE Administrateurs(
	idAdministrateur integer auto_increment,     -- auto_increment : numéro automatique
	nomAdministrateur varchar(30) not null,      -- not null veut dire obligatoire
	dateDebutAdministrateur datetime not null,
	primary key(idAdministrateur)
) engine innodb;
*/

/* La fonction selectAdministrateurParId() SELECT un administrateur à par son id 
 *    et retourne le administrateur
 * Entrées : 
 *		$bdd : l'objet PDO de la bdd ($reqPHP sera un objet PDOstatement)
 *    $idAdministrateur : l'id du hackaton à récupérer
 *	Sorties : 
 *		$objet : le administrateur (une seule ligne) : objet
*/
function selectAdministrateurConnected($bdd, $loginAdministrateur, $passwordAdministrateur)
{
   // 0 : on écrit la requête SQL
   $reqSQL = 'SELECT * 
      FROM administrateurs
      WHERE loginAdministrateur = :alias_login
      AND passwordAdministrateur = :alias_password
   ';

   // 1 : on fabrique la requête PHP 
   $reqPHP = $bdd->prepare($reqSQL);
   $resultat = $reqPHP->execute(array(
      'alias_login' => $loginAdministrateur,
      'alias_password' => $passwordAdministrateur,
   ));
   $reqPHP->setFetchMode(PDO::FETCH_CLASS,'Administrateur');

   // 2 : on récupère les résultats
   $administrateur = $reqPHP->fetch();

   // 3 : on libère les tables de la requête
   $reqPHP->closeCursor(); // pour finir le traitement

   // 4 : on return le résultat
   return $administrateur;
}
