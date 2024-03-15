<?php
/* MODELE : les outils de travail : souvent les données */
/* On commence par charger la classe et par définir les fonctions dont on a besoin */
require("../Hackathon.php");
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
// Premier test : new Hackathon("Hack_1", "2023-12-20");
$numTest=1;
$hackathon = new Hackathon("Hack_1", "2023-12-23");
// Pour vérifier on teste si on obtient le résultat attendu avec toString()
if($hackathon->toString()!="id = 0 - Nom = Hack_1 - Date de début = 2023-12-23"){
   echo "<code>";
   // numéro du test
   echo "ERREUR test numéro : " . $numTest  . "<br>";
   // ce qu'on a fait
   echo "\$hackathon = new Hackathon(\"Hack_1\", \"2023-12-23\");<br>";
   // ce qu'on attendait
   echo "résultats attendus : id = 0 - Nom = Hack_1 - Date de début = 2023-12-23<br>";
   // ce qu'on a obtenu
   echo "résultats obtenus : " . $hackathon->toString() . "<br>";
   echo "</code><br>";
   // on incrémente le nombre d'erreurs
   $nbErreurs+=1;
}

$numTest=2;
$hackathon = new Hackathon(); // 0 paramètre pour le fetch_mode 
$hackathon->setHackathon(0, "Hack_1", "2023-12-23"); // on setHackathon forcément après un instanciation vide
if($hackathon->toString()!="id = 0 - Nom = Hack_1 - Date de début = 2023-12-23"){
   echo "<code>";
   echo "ERREUR test numéro : " . $numTest  . "<br>";
   echo "\$hackathon = new Hackathon();<br>";
   echo "résultats attendus : objet vide<br>";
   echo "résultats obtenus : " . $hackathon->toString() . "<br>";
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
echo("Test de printInfos de new Hackathon(\"Hack_1\", \"2023-12-23\")<br>");
$hackathon = new Hackathon("Hack_1", "2023-12-23");
$hackathon->printInfos();