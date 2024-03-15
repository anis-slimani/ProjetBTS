<?php
$debug_on = false; // mode debug à false
$debug_ec_on = true; // mode debug en cours à true
$debug_get_post_on = true; // mode debug à true

/* Commentaires "standards"
	*	Ce que fait la fonction : 
	*		la fonction affiche $_GET, $_POST et $_SERVER
	*  Entrées : 
	*		rien
	*	Sorties : 
	*		rien : elle fait de l'affichage (des echo et des print_r)
*/
function debug_get_post()
{
   global $debug_get_post_on; // variable globale 
   if ($debug_get_post_on == true) {
      echo 'GET : ';
      print_r($_GET);
      echo '<br>';

      echo 'POST : ';
      print_r($_POST);
      echo '<br>';

      echo 'SESSION : ';
      print_r($_SESSION);
      echo '<br>';

      echo 'FILE : ';
      print_r($_FILES);
      echo '<br>';

      // echo 'URL : ';
      // print_r($_SERVER['PHP_SELF']);
      // echo '<br/>';
   }
}

/* Ce que fait la fonction : 
	*		la fonction affiche $texte suivi de $variable
	*  Entrées : 
	*		$variable, $texte (chaine vide par défaut)
	*	Sorties : 
	*		rien : elle fait de l'affichage (des echo et des print_r)
*/
function debug($variable, $texte = "")
{
   global $debug_on;
   if ($debug_on == true) {
      echo $texte . " : ";
      print_r($variable);
      echo "<br>";
   }
}

// debug_ec c'est comme debug, mais pour gérer un nouveau débug
// quand ça marche, on le passe à debug
function debug_ec($variable, $texte = "")
{
   global $debug_ec_on;
   if ($debug_ec_on == true) {
      echo $texte . " : ";
      print_r($variable);
      echo "<br>";
   }
}
