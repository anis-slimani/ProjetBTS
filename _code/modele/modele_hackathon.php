<?php
/*
CREATE TABLE Hackathons(
	idHackathon integer auto_increment,     -- auto_increment : numéro automatique
	nomHackathon varchar(30) not null,      -- not null veut dire obligatoire
	dateDebutHackathon datetime not null,
	primary key(idHackathon)
) engine innodb;
*/

/* La fonction selectHackathons() SELECT tous les hackathons à partir d'un $bdd 
 *    et retourne la liste des hackathons
 * Entrées : 
 *		$bdd : l'objet PDO de la bdd ($reqPHP sera un objet PDOstatement)
 *	Sorties : 
 *		$hackathons : la listes des hackathons : array PHP d'objets
*/
function selectHackathons($bdd)
{
   // 0 : on écrit la requête SQL
   $reqSQL = 'SELECT * FROM `hackathons` ';

   // 1 : on fabrique la requête PHP 
   $reqPHP = $bdd->prepare($reqSQL);
   $reqPHP->execute();
   $reqPHP->setFetchMode(PDO::FETCH_CLASS, 'Hackathon');

   // 2 : on récupère les résultats
   $hackathons = $reqPHP->fetchAll();

   // 3 : on libère les tables de la requête
   $reqPHP->closeCursor(); // pour finir le traitement

   // 4 : on return le résultat
   return $hackathons;
}
function selectHackathons2023($bdd)
{
   // 0 : on écrit la requête SQL
   $reqSQL = 'SELECT * FROM `hackathons` WHERE dateDebutHackathon < "2024-01-01 00:00:00" AND dateDebutHackathon > "2023-01-01 00:00:00"';
   

   // 1 : on fabrique la requête PHP 
   $reqPHP = $bdd->prepare($reqSQL);
   $reqPHP->execute();
   $reqPHP->setFetchMode(PDO::FETCH_CLASS, 'Hackathon');

   // 2 : on récupère les résultats
   $hackathons = $reqPHP->fetchAll();

   // 3 : on libère les tables de la requête
   $reqPHP->closeCursor(); // pour finir le traitement

   // 4 : on return le résultat
   return $hackathons;
}
function selectHackathonsToday($bdd)
{
   // 0 : on écrit la requête SQL
   $reqSQL = 'SELECT * FROM `hackathons` WHERE DATE(dateDebutHackathon) = CURDATE()';
   

   // 1 : on fabrique la requête PHP 
   $reqPHP = $bdd->prepare($reqSQL);
   $reqPHP->execute();
   $reqPHP->setFetchMode(PDO::FETCH_CLASS, 'Hackathon');

   // 2 : on récupère les résultats
   $hackathons = $reqPHP->fetchAll();

   // 3 : on libère les tables de la requête
   $reqPHP->closeCursor(); // pour finir le traitement

   // 4 : on return le résultat
   return $hackathons;
}



/* La fonction selectHackathonsAnnee() SELECT tous les hackathons d'une année donnée
 *    et retourne la liste des hackathons
 * Entrées : 
 *		$bdd : l'objet PDO de la bdd ($reqPHP sera un objet PDOstatement)
 *    $annee : l'année donnée
 *	Sorties : 
 *		$hackathons : la listes des hackathons : array PHP d'objets
*/
function selectHackathonsAnnee($bdd, $annee)
{
   // 0 : on écrit la requête SQL
   $reqSQL = 'SELECT * 
      FROM hackathons
      WHERE year(dateDebutHackathon) = :alias_annee
   ';

   // 1 : on fabrique la requête PHP 
   $reqPHP = $bdd->prepare($reqSQL);
   $resultat = $reqPHP->execute(array(
      'alias_annee' => $annee,
   ));
   $reqPHP->setFetchMode(PDO::FETCH_CLASS, 'Hackathon');

   // 2 : on récupère les résultats
   $hackathons = $reqPHP->fetchAll();

   // 3 : on libère les tables de la requête
   $reqPHP->closeCursor(); // pour finir le traitement

   // 4 : on return le résultat
   return $hackathons;
}

/* La fonction selectHackathonParId() SELECT un hackathon à par son id 
 *    et retourne le hackathon
 * Entrées : 
 *		$bdd : l'objet PDO de la bdd ($reqPHP sera un objet PDOstatement)
 *    $idHackathon : l'id du hackaton à récupérer
 *	Sorties : 
 *		$objet : le hackathon (une seule ligne) : objet
*/
function selectHackathonParId($bdd, $idHackathon)
{
   // 0 : on écrit la requête SQL
   $reqSQL = 'SELECT * 
      FROM hackathons
      WHERE idHackathon = :alias_id
   ';

   // 1 : on fabrique la requête PHP 
   $reqPHP = $bdd->prepare($reqSQL);
   $resultat = $reqPHP->execute(array(
      'alias_id' => $idHackathon,
   ));
   $reqPHP->setFetchMode(PDO::FETCH_CLASS, 'Hackathon');

   // 2 : on récupère les résultats
   $hackathon = $reqPHP->fetch();

   // 3 : on libère les tables de la requête
   $reqPHP->closeCursor(); // pour finir le traitement

   // 4 : on return le résultat
   return $hackathon;
}



/* La fonction selectHackathonsEligiblesDuProjet() SELECT tous les hackathons à partir d'un $bdd 
 *    et retourne la liste des hackathons pas encore commencé
 * Entrées : 
 *		$bdd : l'objet PDO de la bdd ($reqPHP sera un objet PDOstatement)
 *	Sorties : 
 *		$hackathons : la listes des hackathons : array PHP d'objets
*/
function selectHackathonsEligiblesDuProjet($bdd)
{
   // 0 : on écrit la requête SQL
   $reqSQL = 'SELECT * 
      FROM hackathons
      WHERE dateDebutHackathon > CURRENT_DATE
   ';

   // 1 : on fabrique la requête PHP 
   $reqPHP = $bdd->prepare($reqSQL);
   $reqPHP->execute();
   $reqPHP->setFetchMode(PDO::FETCH_CLASS, 'Hackathon');

   // 2 : on récupère les résultats
   $hackathons = $reqPHP->fetchAll();

   // 3 : on libère les tables de la requête
   $reqPHP->closeCursor(); // pour finir le traitement

   // 4 : on return le résultat
   return $hackathons;
}

/* la fonction insertHackathon ajoute l'objet $hackathon dans la BD
	*  Entrées : 
	*		$bdd : l'objet PDO de la bdd ($reqPHP sera un objet PDOstatement)
   *     $hackathon : objet de la classe Hackathon
	*	Sorties : 
	*		$resultat : le nombre de lignes insérées dans la BD
*/
function insertHackathon($bdd, $hackathon)
{
   // 0 : reqSQL : version avec ? qui sera passé en dur
   $reqSQL = 'INSERT INTO hackathons (idHackathon, nomHackathon, dateDebutHackathon) 
      VALUES (NULL, :alias_nom, :alias_date_debut)
   ';
   debug($reqSQL, "reqSQL");
   debug($hackathon->getDateDebut(), "getDateDebut");

   // 1 :  prepare et debug
   $reqPHP = $bdd->prepare($reqSQL);
   debug($reqPHP, "reqPHP");

   // 2 : execute : version avec alias dans le reqSQL
   // $resultat c'est le nombre d'insert effectué
   try {
      // connexion à la BD : new PDO
      $resultat = $reqPHP->execute(array(
         'alias_nom' => $hackathon->getNom(),
         'alias_date_debut' => $hackathon->getDateDebut()
      ));
      // 3 : on libère les tables de la requête
      $reqPHP->closeCursor();
      // 4 : on return le résultat
      return $resultat;
   } catch (PDOException $e) {
      echo 'Insert échouée : ' . $e->getMessage();
      // 3 : on libère les tables de la requête
      $reqPHP->closeCursor();
      // 4 : on return le résultat
      return 0; // $resultat vaut 0 : pas d'insert effectué
   }
}

/* la fonction deleteHackathon() supprime un hackathon dans la BD à partir de son id
 * Entrées : 
 *		$bdd : l'objet PDO de la bdd ($reqPHP sera un objet PDOstatement)
 *     $idHackathon : id du Hackathon à supprimer
 *	Sorties : 
 *		$resultat : le nombre de lignes délétées dans la BD
*/
function deleteHackathon($bdd, $idHackathon)
{
   // 0 : reqSQL : version avec ? qui sera passé en dur
   $reqSQL = 'DELETE FROM hackathons 
      WHERE idHackathon = :alias_id
   ';
   debug($reqSQL, "reqSQL");

   // 1 :  prepare et debug
   $reqPHP = $bdd->prepare($reqSQL);
   debug($reqPHP, "reqPHP");

   // 2 : execute : version avec alias dans le reqSQL
   // $resultat c'est le nombre d'insert effectué
   try {
      // connexion à la BD : new PDO
      $resultat = $reqPHP->execute(array(
         'alias_id' => $idHackathon,
      ));
      // 3 : on libère les tables de la requête
      $reqPHP->closeCursor();
      // 4 : on return le résultat
      return $resultat;
   } catch (PDOException $e) {
      echo 'Delete échouée : ' . $e->getMessage();
      // 3 : on libère les tables de la requête
      $reqPHP->closeCursor();
      // 4 : on return le résultat
      return 0; // $resultat vaut 0 : pas d'insert effectué
   }
}

/* la fonction updateHackathon() modifie un hackathon dans la BD à partir de son id
 *    et à partir d'un nouveau hackathon
 * Entrées : 
 *		$bdd : l'objet PDO de la bdd ($reqPHP sera un objet PDOstatement)
 *     $idHackathon : id du Hackathon à supprimer
 *	Sorties : 
 *		$resultat : le nombre de lignes délétées dans la BD
*/
function updateHackathon($bdd, $idHackathon, $hackathon)
{
   // 0 : reqSQL : version avec ? qui sera passé en dur
   $reqSQL = 'UPDATE hackathons 
      SET 
         nomHackathon = :alias_nom,
         dateDebutHackathon =:alias_date_debut
      WHERE idHackathon = :alias_id
   ';
   debug($reqSQL, "reqSQL");

   // 1 :  prepare et debug
   $reqPHP = $bdd->prepare($reqSQL);
   debug($reqPHP, "reqPHP");

   // 2 : execute : version avec alias dans le reqSQL
   // $resultat c'est le nombre d'insert effectué
   try {
      // connexion à la BD : new PDO
      $resultat = $reqPHP->execute(array(
         'alias_nom' => $hackathon->getNom(),
         'alias_date_debut' => $hackathon->getDateDebut(),
         'alias_id' => $idHackathon
      ));
      // 3 : on libère les tables de la requête
      $reqPHP->closeCursor();
      // 4 : on return le résultat
      return $resultat;
   } catch (PDOException $e) {
      echo 'Update échouée : ' . $e->getMessage();
      // 3 : on libère les tables de la requête
      $reqPHP->closeCursor();
      // 4 : on return le résultat
      return 0; // $resultat vaut 0 : pas d'insert effectué
   }
}
