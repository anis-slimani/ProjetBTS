<?php
// ---------------------------------------------------------------------------
// Modèle --------------------------------------------------------------------
// ---------------------------------------------------------------------------
// Modèle général : initialisation
include("./modele/initialisation/initialisation.php");
include("./modele/modele_hackathon.php");

// ---------------------------------------------------------------------------
// Modèle spécifique : je charge les outils pour mon controleur

// ---------------------------------------------------------------------------
// Modèle spécifique SESSION : vérifie qu'on est admin
if(
   !isset($_SESSION["typeUser"])
){
   $_SESSION=array();
   $_SESSION["typeUser"]="public";
   $_SESSION["messageErreur"]="";
   header("Location: "."./_index.php");
}
// ---------------------------------------------------------------------------
// Modèle spécifique GET POST : récupérer les données get et post

// il n'y a rien à faire car dans tous les cas, on fait la même chose

// ---------------------------------------------------------------------------
// Controleur ----------------------------------------------------------------
// ---------------------------------------------------------------------------

// dans tous les cas, on fait la même chose :
$_SESSION = array(); // on vide la SESSION
$_SESSION["typeUser"] = "public"; // on repart sur public
$_SESSION["messageErreur"] = ""; 

$hackathons = selectHackathonsToday($bdd);
// ---------------------------------------------------------------------------
// Vue : afficher les résultats ----------------------------------------------
// ---------------------------------------------------------------------------
debug_get_post();

debug('<hr>', '<hr>'); // pour séparer les debug de la page html
include("./views/pages/view_accueil.php");
