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
$hackathons = selectHackathons($bdd);
$projets = selectProjets($bdd);

$tab=[];
for($i=0; $i<count($hackathons); $i++){
   $tab[$i]["idHackathon"] = $hackathons[$i]->getId();
   $tab[$i]["nom"] = $hackathons[$i]->getNom();
   $tab[$i]["dateDebut"] = $hackathons[$i]->getDateDebut();
   $tab[$i]["lesProjets"] = [];;
   $cpt=0;
   for($j=0; $j<count($projets); $j++){
      if($hackathons[$i]->getId() == $projets[$j]->getIdHackathon()){
         $tab[$i]["lesProjets"][$cpt]["idProjet"] = $projets[$j]->getId();
         $tab[$i]["lesProjets"][$cpt]["nom"] = $projets[$j]->getNom();
         $tab[$i]["lesProjets"][$cpt]["pdf"] = $projets[$j]->getPdf();
         $tab[$i]["lesProjets"][$cpt]["description"] = $projets[$j]->getDescription();
         $tab[$i]["lesProjets"][$cpt]["retenu"] = $projets[$j]->getRetenu();
         $cpt++;
      }
   }
}

$hackathonsProjetsJSON = json_encode($tab);

// ---------------------------------------------------------------------------
// Vue : afficher les résultats ----------------------------------------------
// ---------------------------------------------------------------------------
debug_get_post();
debug('<hr>', '<hr>'); // pour séparer les debug de la page html
include("./views/pages/view_api.php");
