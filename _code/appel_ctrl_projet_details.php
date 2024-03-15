<?php
// ---------------------------------------------------------------------------
// Modèle --------------------------------------------------------------------
// ---------------------------------------------------------------------------
// Modèle général : initialisation

include("./modele/initialisation/initialisation.php");

// ---------------------------------------------------------------------------
// Modèle spécifique : je charge les outils pour mon controleur
include("./modele/modele_hackathon.php");
include("./modele/modele_projet.php");

// ---------------------------------------------------------------------------
// Modèle spécifique SESSION : vérifie qu'on est admin
if (
   !isset($_SESSION["typeUser"])
   or
   $_SESSION["typeUser"] != "admin"
) {
   $_SESSION = array();
   $_SESSION["typeUser"] = "public";
   $_SESSION["messageErreur"] = "accès interdit-retour à l'accueil";
   header("Location: " . "./_index.php");
}

// ---------------------------------------------------------------------------
// Modèle spécifique GET POST : récupérer les données get et post

// D'où qu'on vienne (détail ou selectionner), on a un idProjet dans le POST

if (isset($_POST["idProjet"])) {
   // il n'y à vérifier car : c'est un post et on a rien saisi
   $idProjet = $_POST["idProjet"];
} else { // l'entrée est par l'url : retour à l'accueil

   $_SESSION = array();
   $_SESSION["typeUser"] = "public";
   $_SESSION["messageErreur"] = "accès interdit-retour à l'accueil";
   header("Location: " . "./_index.php");
}

// si je viens du selectioner
$selectionerHackathon = False;
if (isset($_POST["selectionerHackathon"])) {
   $idHackathon = $_POST["idHackathon"];
   $selectionerHackathon = True;
}

// si je viens d'un inverser retenu du projet
$inverserRetenuProjet = False;
if (isset($_POST["inverserRetenuProjet"])) {
   $idProjet = $_POST["idProjet"];
   // Pas de vérifications puisque c'est contrôlé par nous 
   $inverserRetenuProjet = True; // c'est bon on peut delete
   debug($inverserRetenuProjet, "inverserRetenuProjet");
}

// si je viens d'un retirer hacakthon du projet
$retirerHackathonProjet = False;
if (isset($_POST["retirerHackathonProjet"])) {
   $idProjet = $_POST["idProjet"];
   // Pas de vérifications puisque c'est contrôlé par nous 
   $retirerHackathonProjet = True; // c'est bon on peut delete
   debug($retirerHackathonProjet, "retirerHackathonProjet");
}

// si je viens d'un ajouter pdf du projet
$ajouterPdfProjet = False;
if (isset($_POST["ajouterPdfProjet"])) {
   $idProjet = $_POST["idProjet"];
   // Pas de vérifications puisque c'est contrôlé par nous 
   $ajouterPdfProjet = True; // c'est bon on peut delete
   debug($ajouterPdfProjet, "ajouterPdfProjet");
}

// si je viens d'un retirer pdf du projet
$retirerPdfProjet = False;
if (isset($_POST["retirerPdfProjet"])) {
   $idProjet = $_POST["idProjet"];
   // Pas de vérifications puisque c'est contrôlé par nous 
   $retirerPdfProjet = True; // c'est bon on peut delete
   debug($retirerPdfProjet, "retirerPdfProjet");
}

// ---------------------------------------------------------------------------
// Controleur ----------------------------------------------------------------
// ---------------------------------------------------------------------------

// on commence par faire les petits update :
if ($selectionerHackathon == True) {
   updateProjetSetHackathon($bdd, $idProjet, $idHackathon);
} else if ($inverserRetenuProjet == True) {
   $projet = selectProjetParId($bdd, $idProjet);
   updateProjetSetRetenu($bdd, $idProjet, !$projet->getRetenu());
} else if ($retirerHackathonProjet == True) {
   $projet = selectProjetParId($bdd, $idProjet);
   updateProjetSetRetenu($bdd, $idProjet, 0);
   updateProjetSetHackathon($bdd, $idProjet, null);
} else if ($ajouterPdfProjet == True) {
   // on va uploader un fichier
   // on peut améliorer la XU avec du javascript (demander à chatgpt)
   $projet = selectProjetParId($bdd, $idProjet);
   $pdfProjet = $_FILES['userfile']['name'];
   $tmpDir = $_FILES['userfile']['tmp_name'];
   $res = move_uploaded_file($tmpDir, "./public/pdf/" . $pdfProjet);
   if ($res)
      $msgUpload = "Upload a réussi";
   else
      $msgUpload = "L\'upload a échoué";
   debug($msgUpload, '$msgUpload');

   updateProjetSetPdf($bdd, $idProjet, $pdfProjet);
   debug(selectProjetParId($bdd, $idProjet), "projet pdf modifié");
} else if ($retirerPdfProjet == True) {
   $projet = selectProjetParId($bdd, $idProjet);
   updateProjetSetPdf($bdd, $idProjet, null);
   debug(selectProjetParId($bdd, $idProjet), "projet pdf retiré");
}

// forcément on charge le projet
$projet = selectProjetParId($bdd, $idProjet);
debug(selectProjetParId($bdd, $idProjet), "projet à afficher");
//on récupère l'idHackathon du projet
$idHackathonDuProjet = $projet->getIdHackathon();
// on charge le hackathon correspondant
$hackathonDuProjet = selectHackathonParId($bdd, $idHackathonDuProjet);

// on vérifie si le projet est modifiable : s'il n'a pas de hackathon 
// ou si son hachathon n'a pas commencé getDateDebut > dateDuJour
// on ressort avec des $hackathonsEligiblesDuProjet ou pas 
// Attention au format : c'est celui de la BD : on compare des string
$dateDuJour = (new DateTime())->format('Y-m-d');
debug($dateDuJour, "today : ");

if (
   ($hackathonDuProjet != "") // il existe hackathon sur le projet
   and
   ($hackathonDuProjet->getDateDebut() < $dateDuJour)
) {
   // on ne peut pas modifier le projet
   debug($dateDuJour, "dateDuJour");
   debug($hackathonDuProjet, "hackathonDuProjet");
   debug($hackathonDuProjet->getDateDebut(), "dateDebut Hackathon");
   debug($hackathonDuProjet->getDateDebut() < $dateDuJour, "getDateDebut< date du jour");
} else {
   // on peut modifier le projet
   $hackathonsEligiblesDuProjet = selectHackathonsEligiblesDuProjet($bdd);
}

// ---------------------------------------------------------------------------
// Vue : afficher les résultats ----------------------------------------------
// ---------------------------------------------------------------------------
debug_get_post();
debug('<hr>', '<hr>'); // pour séparer les debug de la page html
include("./views/pages/view_projet_details.php");
