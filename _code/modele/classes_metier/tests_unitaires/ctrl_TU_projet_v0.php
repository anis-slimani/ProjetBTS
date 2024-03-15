<?php
/* MODELE : les outils de travail : souvent les données */
/* On commence par charger la classe et par définir les fonctions dont on a besoin */
require("../Projet.php");
include("../../initialisation/tools/debug.php"); /* pour permettre les debug dans les classes */

/* CONTROLEUR + VUE */
/* Tests Unitaires : le vrai code
on fait tout les tests.
On va compter le nombre d'erreur.
En cas d'erreur, on affiche :
   le numéro du test
   le code testé
   le résultat attendu
   le résultat obtenu
*/
// On initialise le nombre d'erreurs trouvées
echo "<hr>Résultats des tests unitaires : <br>";
$nbErreurs = 0;

// Test d'instanciation
// Premier test : new Projet("Proj_1", "desc_1", "proj_1.pdf");
$numTest=1;
$projet = new Projet("Proj_1", "desc_1");
// Pour vérifier on teste si on obtient le résultat attendu avec toString()
if($projet->toString()!=
   "id = 0 - Nom = Proj_1 - Description = desc_1"
){
   echo "<code>";
   // numéro du test
   echo "ERREUR test numéro : " . $numTest  . "<br>";
   // ce qu'on a fait
   echo 
      "méthode testée : " .  
      "\$projet = new Projet(\"Proj_1\", \"desc_1\");".
      "<br>";
   // ce qu'on attendait
   echo "résultats attendus : id = 0 - Nom = Proj_1 - Description = desc_1<br>";
   // ce qu'on a obtenu
   echo "résultats obtenus : " . $projet->toString() . "<br>";
   echo "</code><br>";
   // on incrémente le nombre d'erreurs
   $nbErreurs+=1;
}

$numTest=2;
$projet = new Projet(); // 0 paramètre pour le fetch_mode 
if($projet->toString()!=
   "objet vide"
){
   echo "<code>";
   echo "ERREUR test numéro : " . $numTest  . "<br>";
   echo
      "méthode testée : " .  
      "\$projet = new Projet();". 
      "<br>";
   echo "résultats attendus : objet vide<br>";
   echo "résultats obtenus : " . $projet->toString() . "<br>";
   echo "</code><br>";
   $nbErreurs+=1;
}

$numTest=3;
$resultatAttendu = 
   "id = 0 - Nom = Proj_1 - Description = desc_1";
$projet = new Projet(); // 0 paramètre pour le fetch_mode 
$projet->setProjet(0, "Proj_1", "desc_1");// on setProjet forcément après un instanciation vide
if($projet->toString() != $resultatAttendu){
   echo "<code>";
   echo "ERREUR test numéro : " . $numTest  . "<br>";
   echo
      "méthode testée : " . 
      "\$projet->setProjet(0, \"Proj_1\", \"desc_1\");" .
      "<br>";
   echo "résultats attendus : " . $resultatAttendu . "<br>";
   echo "résultats obtenus : " . $projet->toString() . "<br>";
   echo "</code><br>";
   $nbErreurs+=1;
}

/* Après tout les tests, on affiche le bilan */
echo "<hr>";
if($nbErreurs == 0){
   echo "Tests unitaires tous OK";
}
else if ($nbErreurs == 1){
   echo $nbErreurs . " erreur dans les " .$numTest. " tests unitaires";
}
else {
   echo $nbErreurs . " erreurs dans les " .$numTest. " tests unitaires";
}

/* Pour finir on teste le printInfo, qui est un print qu'on ne peut pas tester comme les autres */
echo("<hr>");
echo("Test de printInfos de new Projet(\"Proj_1\", \"desc_1\", \"proj_1.pdf\");");
echo("<br>");
$projet = new Projet("Proj_1", "desc_1", "proj_1.pdf");
$projet->printInfos();