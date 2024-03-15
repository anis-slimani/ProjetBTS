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
class Jury
{
   // -------------------------------------------------------
   // attributs d'instance (ou d'objet) en premier
   // C'est une classe métier : classe de la BD : les attributs doivent être ceux de la BD (donc avec _ et pas camel Case)
   private int $idJury;
   private string $loginJury;
	private string $passwordJury;
   private ?string $nomJury;
   private ?string $prenomJury; 
   private ?string $mailJury; 
   private ?string $telephoneJury; 

   // -------------------------------------------------------
   // constructeur
   public function __construct()
   {
      debug(func_num_args(), 'nombre d\'arguments dans le constructeur');
      if (func_num_args() == 0) {
         // on est dans le FETCH_CLASS ou new sans paramètre : ça marche tout seul !!!
      }
      // on peut traiter les autres cas comme on veut :
      // premier cas : new Jury($loginJury, $passwordJury) 
      else if (func_num_args() == 2) { // on a les 2 arguments dans un tableau
         $this->idJury = 0;     // pas d'id : on met 0 en dur
         $this->loginJury = func_get_arg(0);       // argument 1 : $loginJury
         $this->passwordJury = func_get_arg(1); // argument 2 : $passwordJury
      }
   }

   // -------------------------------------------------------
   // getter des classes métier (hydratation et ORM): pour tous les attributs
   public function getId(): int
   {
      return $this->idJury;
   }
   public function getLogin(): string
   {
      return $this->loginJury;
   }
   public function getPassword(): string
   {
      return $this->passwordJury;
   }
   public function getNom(): string
   {
      return $this->nomJury;
   }
   public function getPrenom(): string
   {
      return $this->prenomJury;
   }
   public function getMail(): string
   {
      return $this->mailJury;
   }
   public function getTelephone(): string
   {
      return $this->telephoneJury;
   }

   // -------------------------------------------------------
   // setter des classes métier
   // méthode qui sette les paramètres du Jury
   public function setJury(
      int $idJury,
      string $loginJury,
      string $passwordJury
   ): void {
      $this->idJury = $idJury;
      $this->loginJury = $loginJury;
      $this->passwordJury = $passwordJury;
   }

   // -------------------------------------------------------
   // fonction d'affichage
   public function printInfos(): void
   {
      echo "id : " . $this->idJury . "<br>";
      echo "Login : " . $this->loginJury . "<br>";
      echo "Password : " . $this->passwordJury . "<br>";
   }

   // toString normal, type Java
   // on return une chaine qui sera traitée par un echo
   public function toString(): string
   {
      if (
         isset($this->idJury) and 
         isset($this->loginJury) and 
         isset($this->passwordJury)
      ) {
         return
            'id = ' . $this->idJury .
            ' - Login = ' . $this->loginJury .
            ' - Password = ' . $this->passwordJury;
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
