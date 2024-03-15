<?php
/*
CREATE TABLE Jurys(
	idJury integer auto_increment,
	loginJury varchar(30) unique,
	passwordJury varchar(30), 
	nomJury varchar(30) not null,   
	prenomJury varchar(30) not null,   
	mailJury varchar(30) unique, -- pas de doublon possible : unique : clé secondaire  
	telephoneJury varchar(10),  
	primary key(idJury)
) engine innodb;
*/

/* La fonction selectJuryParId() SELECT un jury à par son id 
 *    et retourne le jury
 * Entrées : 
 *		$bdd : l'objet PDO de la bdd ($reqPHP sera un objet PDOstatement)
 *    $idJury : l'id du hackaton à récupérer
 *	Sorties : 
 *		$objet : le jury (une seule ligne) : objet
*/
function selectJuryConnected($bdd, $loginJury, $passwordJury)
{
   // 0 : on écrit la requête SQL
   $reqSQL = 'SELECT * 
      FROM jurys
      WHERE loginJury = :alias_login
      AND passwordJury = :alias_password
   ';

   // 1 : on fabrique la requête PHP 
   $reqPHP = $bdd->prepare($reqSQL);
   $resultat = $reqPHP->execute(array(
      'alias_login' => $loginJury,
      'alias_password' => $passwordJury,
   ));
   $reqPHP->setFetchMode(PDO::FETCH_CLASS,'Jury');

   // 2 : on récupère les résultats
   $jury = $reqPHP->fetch();

   // 3 : on libère les tables de la requête
   $reqPHP->closeCursor(); // pour finir le traitement

   // 4 : on return le résultat
   return $jury;
}
