<?php

// ---------------------------------------------------------------------------
// Modèle --------------------------------------------------------------------
// ---------------------------------------------------------------------------
// Modèle général (pour toutes les pages) : initialisation
include("./modele/initialisation/initialisation.php");

// ---------------------------------------------------------------------------
// Modèle spécifique (pour cette page) : je charge les outils de BD pour mon controleur
include("./modele/modele_hackathon.php");
include("./modele/modele_projet.php");
include("./modele/modele_participant.php");

// ---------------------------------------------------------------------------
// Modèle spécifique SESSION : initialise la session
if(
   !isset($_SESSION["typeUser"])
){
   $_SESSION=array();
   $_SESSION["typeUser"]="public";
   $_SESSION["messageErreur"]="";
}

// ---------------------------------------------------------------------------
// Modèle spécifique GET POST : récupérer les données get et post
// si je viens de l'insert du formulaire


// ---------------------------------------------------------------------------
// Controleur ----------------------------------------------------------------
// ---------------------------------------------------------------------------

// ---------------------------------------------------------------------------
// Cas particuliers

// ---------------------------------------------------------------------------
// cas général
// on sélectionnera le ou les hackathons en cours
// et peut-être les projet
$hackathons = selectHackathonsENCours($bdd); 
$hackathonsfutur = selectHackathonsFutur($bdd); 


// ---------------------------------------------------------------------------
// Vue : afficher les résultats ----------------------------------------------
// ---------------------------------------------------------------------------
debug_get_post();
debug('<hr>', '<hr>'); // pour séparer les debug de la page html


if ($_SESSION["typeUser"] == "public") {
   include_once("./views/pages/view_accueil.php");
} else if ($_SESSION["typeUser"] == "admin") {
   include_once("./views/pages/view_accueil_admin.php");
} else if ($_SESSION["typeUser"] == "jury") {
   include_once("./views/pages/view_accueil.php");
} else if ($_SESSION["typeUser"] == "participant") {
   include_once("./views/pages/view_accueil_participant.php");
}
      
