<?php
/*
CREATE TABLE Projets(
	id integer auto_increment,
	nom varchar(20) not null,
	description text not null,      -- déscription courte du projet
	pdf varchar(20) not null,       -- nom du fichier cachier des charges pdf du projet
	retenu boolean not null,
	id_hackathon integer not null,
	primary key(id)
) engine innodb;
*/

/* La fonction selectProjets() SELECT tous les projets à partir d'un $bdd 
 *    et retourne la liste des projets
 * Entrées : 
 *		$bdd : l'objet PDO de la bdd ($reqPHP sera un objet PDOstatement)
 *	Sorties : 
 *		$hackatons : la liste des hackathons : array PHP d'objets
*/
function selectProjets($bdd)
{
   // 0 : on écrit la requête SQL
   $reqSQL = 'SELECT * 
      FROM projets
   ';

   // 1 : on fabrique la requête PHP 
   $reqPHP = $bdd->prepare($reqSQL);
   $reqPHP->execute();
   $reqPHP->setFetchMode(PDO::FETCH_CLASS,'Projet');

   // 2 : on récupère les résultats
   $hackatons = $reqPHP->fetchAll();

   // 3 : on libère les tables de la requête
   $reqPHP->closeCursor(); // pour finir le traitement

   // 4 : on return le résultat
   return $hackatons;
}

/* La fonction selectProjetParId() SELECT un projet à par son id 
 *    et retourne le projet
 *  Entrées : 
 *		$bdd : l'objet PDO de la bdd ($reqPHP sera un objet PDOstatement)
 *     $idProjet : l'id du hackaton à récupérer
 *	Sorties : 
 *		$projet : le projet (une seule ligne) : objet
*/
function selectProjetParId($bdd, $idProjet)
{
   // 0 : on écrit la requête SQL
   $reqSQL = 'SELECT * 
      FROM projets
      WHERE idProjet = :alias_id
   ';

   // 1 : on fabrique la requête PHP 
   $reqPHP = $bdd->prepare($reqSQL);
   $resultat = $reqPHP->execute(array(
      'alias_id' => $idProjet,
   ));
   $reqPHP->setFetchMode(PDO::FETCH_CLASS,'Projet');

   // 2 : on récupère les résultats
   $projet = $reqPHP->fetch();

   // 3 : on libère les tables de la requête
   $reqPHP->closeCursor(); // pour finir le traitement

   // 4 : on return le résultat
   return $projet;
}

/* La fonction selectProjetsDuHackathon SELECT les projets à par son id 
 *    et retourne le projet
 * Entrées : 
 *		$bdd : l'objet PDO de la bdd ($reqPHP sera un objet PDOstatement)
 *    $idHackathon : l'id du Hackathon des projets à récupérer
 *	Sorties : 
 *		$projets : la liste des projets : array PHP d'objets
*/
function selectProjetsDuHackathon($bdd, $idHackathon)
{
   // 0 : on écrit la requête SQL
   $reqSQL = 'SELECT * 
      FROM projets
      WHERE idHackathon = :alias_hackathon_id
   ';

   // 1 : on fabrique la requête PHP 
   $reqPHP = $bdd->prepare($reqSQL);
   $resultat = $reqPHP->execute(array(
      'alias_hackathon_id' => $idHackathon,
   ));
   $reqPHP->setFetchMode(PDO::FETCH_CLASS,'Projet');

   // 2 : on récupère les résultats
   $projets = $reqPHP->fetchAll();

   // 3 : on libère les tables de la requête
   $reqPHP->closeCursor(); // pour finir le traitement

   // 4 : on return le résultat
   return $projets;
}

/* la fonction insertProjet() ajoute l'objet $projet dans la BD
 * Entrées : 
 *		$bdd : l'objet PDO de la bdd ($reqPHP sera un objet PDOstatement)
 *     $projet : objet de la classe Projet
 *	Sorties : 
 *		$resultat : le nombre de lignes insérées dans la BD
*/
function insertProjet($bdd, $projet)
{


   // 0 : reqSQL : version avec ? qui sera passé en dur
   $reqSQL = 'INSERT INTO projets (idProjet, nomProjet, descriptionProjet, pdfProjet, retenuProjet, idHackathon) 
      VALUES (NULL, :alias_nom, :alias_description, null, 0, null) -- id_hackation à 0 et pas null pour éviter les problèmes
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
         'alias_nom' => $projet->getNom(),
         'alias_description' => $projet->getDescription()
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

/* la fonction deleteProjet() supprime un projet dans la BD à partir de son id
 * Entrées : 
 *		$bdd : l'objet PDO de la bdd ($reqPHP sera un objet PDOstatement)
 *     $idProjet : id du Projet à supprimer
 *	Sorties : 
 *		$resultat : le nombre de lignes délétées dans la BD
*/
function deleteProjet($bdd, $idProjet)
{
   // 0 : reqSQL : version avec ? qui sera passé en dur
   $reqSQL = 'DELETE FROM projets 
      WHERE idProjet = :alias_id
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
         'alias_id' => $idProjet,
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

/* la fonction updateProjet() modifie un projet dans la BD à partir de son id
 *    et à partir d'un nouveau projet
 * Entrées : 
 *		$bdd : l'objet PDO de la bdd ($reqPHP sera un objet PDOstatement)
 *    $idProjet : id du Projet à modifier
 *    $projet : le nouveau projet
 *	Sorties : 
 *		$resultat : le nombre de lignes updatées dans la BD
*/
function updateProjet($bdd, $idProjet, $projet)
{
   // 0 : reqSQL : version avec ? qui sera passé en dur
   $reqSQL = 'UPDATE projets 
      SET 
         nomProjet = :alias_nom,
         descriptionProjet =:alias_description,
         pdfProjet =:alias_pdf
      WHERE idProjet = :alias_id
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
         'alias_id' => $idProjet,
         'alias_nom' => $projet->getNom(),
         'alias_description' => $projet->getDescription(),
         'alias_pdf' => $projet->getPdf()
      ));
      // 3 : on libère les tables de la requête
      $reqPHP->closeCursor();
      // 4 : on return le résultat
      return $resultat;
   } catch (PDOException $e) {
      echo 'Update échoué : ' . $e->getMessage();
      // 3 : on libère les tables de la requête
      $reqPHP->closeCursor();
      // 4 : on return le résultat
      return 0; // $resultat vaut 0 : pas d'insert effectué
   }
}

/* la fonction updateProjetSetHackathon() set un idHackathon au projet
 * Entrées : 
 *		$bdd : l'objet PDO de la bdd ($reqPHP sera un objet PDOstatement)
 *    $idProjet : id du Projet à modifier
 *    $idHackathon : le nouveau idHackathon
 *	Sorties : 
 *		$resultat : le nombre de lignes updatées dans la BD
*/
function updateProjetSetHackathon($bdd, $idProjet, $idHackathon)
{
   // 0 : reqSQL : version avec ? qui sera passé en dur
   $reqSQL = 'UPDATE projets 
      SET 
         idHackathon = :alias_idHackathon
      WHERE idProjet = :alias_idProjet
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
         'alias_idProjet' => $idProjet,
         'alias_idHackathon' => $idHackathon
      ));
      // 3 : on libère les tables de la requête
      $reqPHP->closeCursor();
      // 4 : on return le résultat
      return $resultat;
   } catch (PDOException $e) {
      echo 'Update échoué : ' . $e->getMessage();
      // 3 : on libère les tables de la requête
      $reqPHP->closeCursor();
      // 4 : on return le résultat
      return 0; // $resultat vaut 0 : pas d'insert effectué
   }
}

/* la fonction updateProjetSetRetenu() set un retenu au projet
 * Entrées : 
 *		$bdd : l'objet PDO de la bdd ($reqPHP sera un objet PDOstatement)
 *    $idProjet : id du Projet à modifier
 *    $retenu : le nouveau retenu
 *	Sorties : 
 *		$resultat : le nombre de lignes updatées dans la BD
*/
function updateProjetSetRetenu($bdd, $idProjet, $retenu)
{
   // attention, il faut que retenu soit un int !
   if($retenu==True) $retenu=1; else $retenu=0;
   // 0 : reqSQL : version avec ? qui sera passé en dur
   $reqSQL = 'UPDATE projets 
      SET 
         retenuProjet = :alias_retenu
      WHERE idProjet = :alias_idProjet
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
         'alias_retenu' => $retenu,
         'alias_idProjet' => $idProjet
      ));
      // 3 : on libère les tables de la requête
      $reqPHP->closeCursor();
      // 4 : on return le résultat
      return $resultat;
   } catch (PDOException $e) {
      echo 'Update échoué : ' . $e->getMessage();
      // 3 : on libère les tables de la requête
      $reqPHP->closeCursor();
      // 4 : on return le résultat
      return 0; // $resultat vaut 0 : pas d'insert effectué
   }
}

/* la fonction updateProjetSetPdf() set un pdf au projet
 * Entrées : 
 *		$bdd : l'objet PDO de la bdd ($reqPHP sera un objet PDOstatement)
 *    $idProjet : id du Projet à modifier
 *    $pdf : le nouveau pdf
 *	Sorties : 
 *		$resultat : le nombre de lignes updatées dans la BD
*/
function updateProjetSetPdf($bdd, $idProjet, $pdf)
{

   // 0 : reqSQL : version avec ? qui sera passé en dur
   $reqSQL = 'UPDATE projets 
      SET 
         pdfProjet = :alias_pdf
      WHERE idProjet = :alias_idProjet
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
         'alias_pdf' => $pdf,
         'alias_idProjet' => $idProjet
      ));
      // 3 : on libère les tables de la requête
      $reqPHP->closeCursor();
      // 4 : on return le résultat
      return $resultat;
   } catch (PDOException $e) {
      echo 'Update échoué : ' . $e->getMessage();
      // 3 : on libère les tables de la requête
      $reqPHP->closeCursor();
      // 4 : on return le résultat
      return 0; // $resultat vaut 0 : pas d'insert effectué
   }
}

