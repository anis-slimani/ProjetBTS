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
class Participant
{
   // -------------------------------------------------------
   // attributs d'instance (ou d'objet) en premier
   // C'est une classe métier : classe de la BD : les attributs doivent être ceux de la BD (donc avec _ et pas camel Case)
   private int $idParticipant;
   private string $loginParticipant;
	private string $passwordParticipant;
   private ?string $nomParticipant;
   private ?string $prenomParticipant; 
   private ?string $mailParticipant; 
   private ?string $telephoneParticipant; 
   private ?string $dateDeNaissanceParticipant; 
   private ?string $lienPorteFolioParticipant; 

   // -------------------------------------------------------
   // constructeur
   public function __construct()
   {
      debug(func_num_args(), 'nombre d\'arguments dans le constructeur');
      if (func_num_args() == 0) {
         // on est dans le FETCH_CLASS ou new sans paramètre : ça marche tout seul !!!
      }
      // on peut traiter les autres cas comme on veut :
      // premier cas : new Participant($loginParticipant, $passwordParticipant) 
      else if (func_num_args() == 2) { // on a les 2 arguments dans un tableau
         $this->idParticipant = 0;     // pas d'id : on met 0 en dur
         $this->loginParticipant = func_get_arg(0);       // argument 1 : $loginParticipant
         $this->passwordParticipant = func_get_arg(1); // argument 2 : $passwordParticipant
      }
   }

   // -------------------------------------------------------
   // getter des classes métier (hydratation et ORM): pour tous les attributs
   public function getId(): int
   {
      return $this->idParticipant;
   }
   public function getLogin(): string
   {
      return $this->loginParticipant;
   }
   public function getPassword(): string
   {
      return $this->passwordParticipant;
   }
   public function getNom(): string
   {
      return $this->nomParticipant;
   }
   public function getPrenom(): string
   {
      return $this->prenomParticipant;
   }
   public function getMail(): string
   {
      return $this->mailParticipant;
   }
   public function getTelephone(): string
   {
      return $this->telephoneParticipant;
   }
   public function getDateDeNaissance(): string
   {
      return $this->dateDeNaissanceParticipant;
   }
   public function getLienPorteFolio(): string
   {
      return $this->lienPorteFolioParticipant;
   }

   // -------------------------------------------------------
   // setter des classes métier
   // méthode qui sette les paramètres du Participant
   public function setParticipant(
      int $idParticipant,
      string $loginParticipant,
      string $passwordParticipant
   ): void {
      $this->idParticipant = $idParticipant;
      $this->loginParticipant = $loginParticipant;
      $this->passwordParticipant = $passwordParticipant;
   }

   // -------------------------------------------------------
   // fonction d'affichage
   public function printInfos(): void
   {
      echo "id : " . $this->idParticipant . "<br>";
      echo "Login : " . $this->loginParticipant . "<br>";
      echo "Password : " . $this->passwordParticipant . "<br>";
   }

   // toString normal, type Java
   // on return une chaine qui sera traitée par un echo
   public function toString(): string
   {
      if (
         isset($this->idParticipant) and 
         isset($this->loginParticipant) and 
         isset($this->passwordParticipant)
      ) {
         return
            'id = ' . $this->idParticipant .
            ' - Login = ' . $this->loginParticipant .
            ' - Password = ' . $this->passwordParticipant;
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
