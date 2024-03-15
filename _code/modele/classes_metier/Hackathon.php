<?php
/*
CREATE TABLE Hackathons(
	idHackathon integer auto_increment,     -- auto_increment : numéro automatique
	nomHackathon varchar(30) not null,      -- not null veut dire obligatoire
	dateDebutHackathon datetime not null,
	primary key(idHackathon)
) engine innodb;
*/
class Hackathon
{
   // -------------------------------------------------------
   // attributs d'instance (ou d'objet) en premier
   // C'est une classe métier : classe de la BD : les attributs doivent être ceux de la BD (donc avec _ et pas camel Case)
   private int $idHackathon;
   private string $nomHackathon;
   private string $dateDebutHackathon; // quel type pour la date ?
         // on pourrait mettre une date et une heure, date et time dans le formulaire

   // -------------------------------------------------------
   // constructeur
   public function __construct()
   {
      debug(func_num_args(), 'nombre d\'arguments dans le constructeur');
      if (func_num_args() == 0) {
         // on est dans le FETCH_CLASS ou new sans paramètre : ça marche tout seul !!!
      }
      // on peut traiter les autres cas comme on veut :
      // premier cas : new Hackathon($nom, $date_debut) 
      else if (func_num_args() == 2) { // on a les 2 arguments dans un tableau
         $this->idHackathon = 0;     // pas d'id : on met 0 en dur
         $this->nomHackathon = func_get_arg(0);       // argument 1 : $nom
         $this->dateDebutHackathon = func_get_arg(1); // argument 2 : $date_debut
      }
   }

   // -------------------------------------------------------
   // getter des classes métier (hydratation et ORM): pour tous les attributs
   public function getId(): int
   {
      return $this->idHackathon;
   }
   public function getNom(): string
   {
      return $this->nomHackathon;
   }
   public function getDateDebut(): string
   {
      return $this->dateDebutHackathon;
   }

   // -------------------------------------------------------
   // setter des classes métier
   // méthode qui sette les paramètres du Hackathon
   public function setHackathon(
      int $idHackathon,
      string $nomHackathon,
      string $dateDebutHackathon
   ): void {
      $this->idHackathon = $idHackathon;
      $this->nomHackathon = $nomHackathon;
      $this->dateDebutHackathon = $dateDebutHackathon;
   }

   // -------------------------------------------------------
   // fonction d'affichage
   public function printInfos(): void
   {
      echo "id : " . $this->idHackathon . "<br>";
      echo "Nom : " . $this->nomHackathon . "<br>";
      echo "Date de début : " . $this->dateDebutHackathon . "<br>";
   }

   // toString normal, type Java
   // on return une chaine qui sera traitée par un echo
   public function toString(): string
   {
      if (
         isset($this->idHackathon) and 
         isset($this->nomHackathon) and 
         isset($this->dateDebutHackathon)
      ) {
         return
            'id = ' . $this->idHackathon .
            ' - Nom = ' . $this->nomHackathon .
            ' - Date de début = ' . $this->dateDebutHackathon;
      } else {
         return 'objet vide';
      }
   }

   // -------------------------------------------------------
   // les autres fonctions = responsabilités de la classe

}

/* Commentaires techniques sur le FETCH_CLASS
Quand on va utliser un FETCH_CLASS dans le SQL pour l'ROM (object-relationel-mapping)
   c'est facile avec le setFetchMode()
   le seule problème, c'est pour le constructeur de la classe

Constructeur FETCH_CLASS, exemple avec la classe Arme(id, nom, puissance)
	si 0 arg : c'est un fetch_class
		si on fait un new avec rien, ça marche et ça passe par là (le cas 0 argument):
         ça crée un objet avec tous les attributs de la table SQL 
		il faudrait trouver un truc !!!
		   peut-être mettre des valeurs par défaut : id=0, nom="", puissance="0"
		   Non !!! Si on fait ça, ça écrase de fetch_class
		Donc, on n'a pas de solution.
		   On va se doter d'un setArme(nom, puissance) qui sette à 0, nom, puissance une arme et qu'on utilse quand on fait un new Arme() sans paramètre. Mais, à nous de l'utiliser pour que l'objet soit propre.
	sinon si 2 arg : 
		on met l'id à 0
		on vérifie les types pour vérifier que c'est cohérent (fonction gettype) 
		on met les puissances négatives à 0 
		si ce n'est pas cohérent, on met nom="", puissance="0"
	sinon si 3 arg : on a les 3 paramètres
		idem qu'avec 2 avec l'id en plus, qui doit être >=0.
	sinon si : // plus que 3 arguments
		on fait comme si c'était 3 : les 3 premiers
	On pourrait générer une erreur si on n'a pas le bon type ou pas le bon nombre de paramètres, mais c'est compliqué inutilement.
   */
