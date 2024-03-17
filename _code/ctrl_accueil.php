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
$hackathons = selectHackathonsToday($bdd); 

// ---------------------------------------------------------------------------
// Vue : afficher les résultats ----------------------------------------------
// ---------------------------------------------------------------------------
debug_get_post();
debug('<hr>', '<hr>'); // pour séparer les debug de la page html

include_once("./views/pages/view_accueil.php");
