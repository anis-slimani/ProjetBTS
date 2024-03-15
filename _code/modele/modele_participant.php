<?php
/*
CREATE TABLE Participants(
	idParticipant integer auto_increment,
	loginParticipant varchar(30) not null unique,
	passwordParticipant varchar(30) not null, 
	nomParticipant varchar(30) not null,   
	prenomParticipant varchar(30) not null,   
	mailParticipant varchar(30) not null unique,   
	telephoneParticipant varchar(10),  
	dateDeNaissanceParticipant date,
	lienPorteFolioParticipant varchar(30),
	primary key(idParticipant)
) engine innodb;
*/

/* La fonction selectParticipantParId() SELECT un participant par son id 
 *    et retourne le participant
 * Entrées : 
 *		$bdd : l'objet PDO de la bdd ($reqPHP sera un objet PDOstatement)
 *    $idParticipant : l'id du participant à récupérer
 *	Sorties : 
 *		$objet : le participant (une seule ligne) : objet
*/
function selectParticipantConnected($bdd, $loginParticipant, $passwordParticipant)
{
   // 0 : on écrit la requête SQL
   $reqSQL = 'SELECT * 
      FROM participants
      WHERE loginParticipant = :alias_login
      AND passwordParticipant = :alias_password
   ';

   // 1 : on fabrique la requête PHP 
   $reqPHP = $bdd->prepare($reqSQL);
   $resultat = $reqPHP->execute(array(
      'alias_login' => $loginParticipant,
      'alias_password' => $passwordParticipant,
   ));
   $reqPHP->setFetchMode(PDO::FETCH_CLASS,'Participant');

   // 2 : on récupère les résultats
   $participant = $reqPHP->fetch();

   // 3 : on libère les tables de la requête
   $reqPHP->closeCursor(); // pour finir le traitement

   // 4 : on return le résultat
   return $participant;
}
