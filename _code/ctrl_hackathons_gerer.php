<?php
/*
   class Hackathon : 
      private int $id;
      private string $nom;
      private string $date_debut; 
*/

// ---------------------------------------------------------------------------
// Modèle --------------------------------------------------------------------
// ---------------------------------------------------------------------------
// Modèle général (pour toutes les pages) : initialisation
include("./modele/initialisation/initialisation.php");

// ---------------------------------------------------------------------------
// Modèle spécifique (pour cette page) : je charge les outils de BD pour mon controleur
include("./modele/modele_hackathon.php");

// ---------------------------------------------------------------------------
// Modèle spécifique SESSION : on regarde l'état de la SESSION
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
$insertHackathon = False;
if (isset($_POST["insertHackathon"])) {
   $dateDebutHackathon = $_POST["dateDebutHackathon"];
   $nomHackathon = $_POST["nomHackathon"];
   debug_ec($dateDebutHackathon, "dateDebutHackathon");
   
   // il faudrait faire des vérifications : 
   // si c'est bon : $Insert = True
   // sinon
   //        $Insert = False
   //        on gère un message d'erreur

   // Vérification de base : si on a saisi quelque chose, c'est gon
   if ($nomHackathon != "" && $dateDebutHackathon != "" )
      $insertHackathon = True; // c'est bon on peut inserter
   debug_ec($insertHackathon, "insertHackathon");
}

// si je viens du modifier du formulaire
$updateHackathon = False;
if (isset($_POST["updateHackathon"])) {
   $dateDebutHackathon = $_POST["dateDebutHackathon"];
   $nomHackathon = $_POST["nomHackathon"];
   $idHackathon = $_POST["idHackathon"];
   $hackathon = new Hackathon($nomHackathon, $dateDebutHackathon);
   // vérifications à envisager...
   // Vérification de base : si on a saisi quelque chose, c'est gon
   if ($nomHackathon != "" && $dateDebutHackathon != "")
      $updateHackathon = True; // c'est bon on peut delete
   debug($updateHackathon, "updateHackathon");
}

// si je viens d'un delete du tableau
$deleteHackathon = False;
if (isset($_POST["deleteHackathon"])) {
   $idHackathon = $_POST["idHackathon"];
   // Pas de vérifications puisque c'est contrôlé par nous 
   $deleteHackathon = True; // c'est bon on peut deleter
}

// si je viens d'un update du tableau (on a sélectionner un update)
$selectUpdateHackathon = False;
if (isset($_POST["selectUpdateHackathon"])) {
   $idHackathon = $_POST["idHackathon"];
   // Pas de vérifications puisque c'est contrôlé par nous 
   $selectUpdateHackathon = True; // c'est bon on peut delete
   debug($selectUpdateHackathon, "selectUpdateHackathon");
}

// ---------------------------------------------------------------------------
// Controleur ----------------------------------------------------------------
// ---------------------------------------------------------------------------

// ---------------------------------------------------------------------------
// Cas particuliers

// si on vient d'un insert : 
if ($insertHackathon == True) {
   $hackathon = new Hackathon($nomHackathon, $dateDebutHackathon);
   $resInsertHackathon = insertHackathon($bdd, $hackathon);
   debug_ec($resInsertHackathon, "resInsertHackathon");
}
// si on vient d'un modifier : 
else if ($updateHackathon == True) {
   $resUpdateHackathon = updateHackathon($bdd, $idHackathon, $hackathon);
   debug($resUpdateHackathon, "resUpdateHackathon");
}
// si on vient d'un delete : 
else if ($deleteHackathon == True) { // true c'est 1
   $resDeleteHackathon = deleteHackathon($bdd, $idHackathon);
   debug($resDeleteHackathon, "resDeleteHackathon");
}
// si on vient d'un select-update : 
else if ($selectUpdateHackathon == True) {
   $hackathonAModifier = selectHackathonParId($bdd, $idHackathon);
   debug($selectUpdateHackathon, "selectUpdateHackathon");
}

// ---------------------------------------------------------------------------
// cas général
$hackathons = selectHackathons($bdd); // $hackathons: c'est une liste d'objets de la classe hHackathon
debug($hackathons, 'hackathons');

// ---------------------------------------------------------------------------
// Vue : afficher les résultats ----------------------------------------------
// ---------------------------------------------------------------------------
debug_get_post();
debug('<hr>', '<hr>'); // pour séparer les debug de la page html
include("./views/pages/view_hackathons_gerer.php");
