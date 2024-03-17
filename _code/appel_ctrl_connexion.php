<?php
// ---------------------------------------------------------------------------
// Modèle --------------------------------------------------------------------
// ---------------------------------------------------------------------------
// Modèle général : initialisation
include("./modele/initialisation/initialisation.php");

// ---------------------------------------------------------------------------
// Modèle spécifique : je charge les outils de BD pour mon controleur
include("./modele/modele_administrateur.php");
include("./modele/modele_jury.php");
include("./modele/modele_participant.php");
include("./modele/modele_hackathon.php");

// ---------------------------------------------------------------------------
// Modèle général SESSION : initialiser la SESSION 
if(
   !isset($_SESSION["typeUser"]) // c'est vrai à l'entrée dans le site
){
   $_SESSION=array();
   $_SESSION["typeUser"]="public";
   $_SESSION["messageErreur"]="";
   header("Location: "."./_index.php");
}

// ---------------------------------------------------------------------------
// Modèle spécifique GET POST : récupérer les données get et post

// je viens du ok du login
$okConnexion = False;
if (isset($_POST["okConnexion"])) {
   $_SESSION["loginUser"] = $_POST["loginUser"];
   $_SESSION["passwordUser"] = $_POST["passwordUser"];
   $_SESSION["typeUser"] = $_POST["typeUser"];

   // vérifications à envisager : 
   // htmlspecialchars(), htmlentities(), trim(), 
   // on considère qu'on a tenté la connexion dans tous les cas : 
   //   on vérifiera dans le controleur si ça passe
   $okConnexion = True;
}

// je viens du déconnexion du login
$okDeconnexion = False;
if (isset($_POST["okDeconnexion"])) {
   $okDeconnexion = True;
}


// ---------------------------------------------------------------------------
// Controleur ----------------------------------------------------------------
// ---------------------------------------------------------------------------

if ($okConnexion == True) {
   // on charge l'administrateur de la BD correpondans au login et au password
   $administrateurConnected = selectAdministrateurConnected($bdd, $_SESSION["loginUser"], $_SESSION["passwordUser"]);
   $juryConnected = selectJuryConnected($bdd, $_SESSION["loginUser"], $_SESSION["passwordUser"]);
   $participantConnected = selectParticipantConnected($bdd, $_SESSION["loginUser"], $_SESSION["passwordUser"]);
   debug($_SESSION["typeUser"], "typeUser");
   debug($administrateurConnected, "administrateurConnected");
   debug($juryConnected, "juryConnected");
   debug($participantConnected, "participantConnected");
   if(
      ($administrateurConnected != null AND $_SESSION["typeUser"] == "admin") 
   OR ($juryConnected != null           AND $_SESSION["typeUser"] == "jury")
   OR ($participantConnected != null    AND $_SESSION["typeUser"] == "participant")
   ){
      // on a un admin et typeUser = admin, il n'y a pas d'erreur
      $_SESSION["messageErreur"] = "";
   } 
   else {
      // si on n'a pas d'admin ou si typeUser n'est pas admin : on retourne en typeUser public
      $_SESSION["messageErreur"] = "echec de connexion";
      $_SESSION["typeUser"] = "public";
   }
}
if ($okDeconnexion == True) {
   $_SESSION=array();
   $_SESSION["typeUser"] = "public";
   $_SESSION["messageErreur"] = "";
}

$hackathons = selectHackathonsToday($bdd);
// ---------------------------------------------------------------------------
// Vue : afficher les résultats ----------------------------------------------
// ---------------------------------------------------------------------------
debug_get_post();
debug('<hr>', '<hr>'); // pour séparer les debug de la page html
include("./views/pages/view_accueil.php");
