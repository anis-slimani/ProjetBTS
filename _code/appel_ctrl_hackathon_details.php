<?php
// ---------------------------------------------------------------------------
// Modèle --------------------------------------------------------------------
// ---------------------------------------------------------------------------
// Modèle général : initialisation
include("./modele/initialisation/initialisation.php");

// ---------------------------------------------------------------------------
// Modèle spécifique : je charge les outils pour mon controleur
include("./modele/modele_hackathon.php");
include("./modele/modele_projet.php"); // ça reste à écrire

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

// je viens forcément d'un bouton "détail"
if(isset($_POST["idHackathon"])){
   $idHackathon = $_POST["idHackathon"];
}

// ---------------------------------------------------------------------------
// Controleur ----------------------------------------------------------------
// ---------------------------------------------------------------------------

// forcément on charge le hackathon
$hackathon = selectHackathonParId($bdd, $idHackathon);
// on charge les projets du Hackathon
$projetsDuHackathon = selectProjetsDuHackathon($bdd, $idHackathon);

// ---------------------------------------------------------------------------
// Vue : afficher les résultats ----------------------------------------------
// ---------------------------------------------------------------------------
debug_get_post();
debug('<hr>', '<hr>'); // pour séparer les debug de la page html
include("./views/pages/view_hackathon_details.php");
?>