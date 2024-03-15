<?php
/*
   class Projet : 
      private int $id;
      private string $nom;
      private string $description; //
      private string $pdf; //
      private bool $retenu; //
      private int $id_hackathon; //
*/

// ---------------------------------------------------------------------------
// 1 : Modèle --------------------------------------------------------------------
// ---------------------------------------------------------------------------
// Modèle général (pour toutes les pages) : initialisation
include("./modele/initialisation/initialisation.php");

// ---------------------------------------------------------------------------
// Modèle spécifique (pour cette page) : je charge les outils de BD pour mon controleur
include("./modele/modele_projet.php");
include("./modele/modele_hackathon.php");

// ---------------------------------------------------------------------------
// Modèle spécifique SESSION : vérifie qu'on est admin
if(
   !isset($_SESSION["typeUser"])
   OR
   $_SESSION["typeUser"]!="admin"
){
   $_SESSION=array();
   $_SESSION["typeUser"]="public";
   $_SESSION["messageErreur"]="accès interdit-retour à l'accueil";
   header("Location: "."./_index.php");
}

// ---------------------------------------------------------------------------
// Modèle spécifique GET POST : récupérer les données get et post
// si je viens de l'insert du formulaire
$insertProjet = False;
if (isset($_POST["insertProjet"])) {
   $nomProjet = $_POST["nomProjet"];
   $descriptionProjet = $_POST["descriptionProjet"];

   
   // il faudrait faire des vérifications : 
   // si c'est bon : $insertProjet = True
   // sinon
   //        $insertProjet = False
   //        on gère un message d'erreur

   // Vérification de base : si on a saisi quelque chose, c'est gon
   if ($nomProjet != "" && $descriptionProjet != "")
      $insertProjet = True; // c'est bon on peut inserter
}

// si je viens du modifier du formulaire
$updateProjet = False;
if (isset($_POST["updateProjet"])) {
   $idProjet = $_POST["idProjet"];
   $nomProjet = $_POST["nomProjet"];
   $descriptionProjet = $_POST["descriptionProjet"];
   $projet = new projet($nomProjet, $descriptionProjet);
   // vérifications à envisager...
   // Vérification de base : si on a saisi quelque chose, c'est gon
   if ($nomProjet != "" && $descriptionProjet != "")
      $updateProjet = True; // c'est bon on peut delete
   debug($updateProjet, "updateProjet");
}

// si je viens d'un delete du tableau
$deleteProjet = False;
if (isset($_POST["deleteProjet"])) {
   $idProjet = $_POST["idProjet"];
   // Pas de vérifications puisque c'est contrôlé par nous 
   $deleteProjet = True; // c'est bon on peut deleter
}

// si je viens d'un update du tableau (on a sélectionner un update)
$selectUpdateProjet = False;
if (isset($_POST["selectUpdateProjet"])) {
   $idProjet = $_POST["idProjet"];
   // Pas de vérifications puisque c'est contrôlé par nous 
   $selectUpdateProjet = True; // c'est bon on peut delete
   debug($selectUpdateProjet, "selectUpdateProjet");
}


// ---------------------------------------------------------------------------
// 2 : Controleur ----------------------------------------------------------------
// ---------------------------------------------------------------------------

// ---------------------------------------------------------------------------
// Cas particuliers

// si on vient d'un insert : 
if ($insertProjet == True) {
   debug("insertProjet");
   $projet = new projet($nomProjet, $descriptionProjet);
   debug($projet, "projet");
   $resInsertProjet = insertProjet($bdd, $projet);
   debug($resInsertProjet, "resInsertProjet");
}
// si on vient d'un modifier : 
else if ($updateProjet == True) {
   $resUpdateProjet = updateProjet($bdd, $idProjet, $projet);
   debug($resUpdateProjet, "resUpdateProjet");
}
// si on vient d'un delete : 
else if ($deleteProjet == True) { // true c'est 1
   $resDeleteProjet = deleteProjet($bdd, $idProjet);
   debug($resDeleteProjet, "resDeleteProjet");
}
// si on vient d'un select-update : 
else if ($selectUpdateProjet == True) {
   $projetAModifier = selectProjetParId($bdd, $idProjet);
   debug($projetAModifier, "projetAModifier");
}

// ---------------------------------------------------------------------------
// cas général
$projets = selectProjets($bdd); // $armes: c'est une liste d'objets de la classe Arme
debug($projets, 'Les objets Projet');

// ---------------------------------------------------------------------------
// 3 : Vue : afficher les résultats ----------------------------------------------
// ---------------------------------------------------------------------------
debug_get_post();
debug('<hr>', '<hr>'); // pour séparer les debug de la page html
include("./views/pages/view_projets_gerer.php");
