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
if (
   !isset($_SESSION["typeUser"])
) {
   $_SESSION = array();
   $_SESSION["typeUser"] = "public";
   $_SESSION["messageErreur"] = "";
}

// ---------------------------------------------------------------------------
// Modèle spécifique GET POST : récupérer les données get et post
$apiParAnnee = false;
if (isset($_GET["annee"])) {
   $annee = $_GET["annee"];
   $apiParAnnee = True;
}
$apiParId = false;
if (isset($_GET["idHackathon"])) {
   $idHackathon = $_GET["idHackathon"];
   $apiParId = True;
}

// ---------------------------------------------------------------------------
// Controleur ----------------------------------------------------------------
// ---------------------------------------------------------------------------

// ---------------------------------------------------------------------------
// On récupère le ou les hackathons
if ($apiParAnnee == true) {
   $hackathons = selectHackathonsAnnee($bdd, $annee);
} else if ($apiParId == true) {
   $hackathon = selectHackathonParId($bdd, $idHackathon);
} else {
   $hackathons = selectHackathons($bdd);
}
$projets = selectProjets($bdd);

// si c'est l'api par id
if ($apiParId == true) {
   if ($hackathon == null) {
      $datasPHP = [];
   } else {
      $datasPHP["idHackathon"] = $hackathon->getId();
      $datasPHP["nom"] = $hackathon->getNom();
      $datasPHP["dateDebut"] = $hackathon->getDateDebut();
      $datasPHP["lesProjets"] = [];
      $cpt = 0;
      for ($j = 0; $j < count($projets); $j++) {
         if ($hackathon->getId() == $projets[$j]->getIdHackathon()) {
            $datasPHP["lesProjets"][$cpt]["idProjet"] = $projets[$j]->getId();
            $datasPHP["lesProjets"][$cpt]["nom"] = $projets[$j]->getNom();
            $datasPHP["lesProjets"][$cpt]["pdf"] = $projets[$j]->getPdf();
            $datasPHP["lesProjets"][$cpt]["description"] = $projets[$j]->getDescription();
            $datasPHP["lesProjets"][$cpt]["retenu"] = $projets[$j]->getRetenu();
            $cpt++;
         }
      }
   }
} else {
   $datasPHP = [];
   for ($i = 0; $i < count($hackathons); $i++) {
      $datasPHP[$i]["idHackathon"] = $hackathons[$i]->getId();
      $datasPHP[$i]["nom"] = $hackathons[$i]->getNom();
      $datasPHP[$i]["dateDebut"] = $hackathons[$i]->getDateDebut();
      $datasPHP[$i]["lesProjets"] = [];
      $cpt = 0;
      for ($j = 0; $j < count($projets); $j++) {
         if ($hackathons[$i]->getId() == $projets[$j]->getIdHackathon()) {
            $datasPHP[$i]["lesProjets"][$cpt]["idProjet"] = $projets[$j]->getId();
            $datasPHP[$i]["lesProjets"][$cpt]["nom"] = $projets[$j]->getNom();
            $datasPHP[$i]["lesProjets"][$cpt]["pdf"] = $projets[$j]->getPdf();
            $datasPHP[$i]["lesProjets"][$cpt]["description"] = $projets[$j]->getDescription();
            $datasPHP[$i]["lesProjets"][$cpt]["retenu"] = $projets[$j]->getRetenu();
            $cpt++;
         }
      }
   }
}

$datasJSON = json_encode($datasPHP);

// ---------------------------------------------------------------------------
// Vue : afficher les résultats ----------------------------------------------
// ---------------------------------------------------------------------------
// dire au navigateur qu'on envoit du JSON
header('Content-Type: application/json');

// afficher directement le fichier
echo $datasJSON;
