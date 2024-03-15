<?php
// Paramètres pour la BD : à mettre à jour selon les cas
$dbname_global = 'HackathonsFW';
$username_global = 'root';
$password_global = 'root';

/* Commentaires "standards"
	*	Ce que fait la fonction : 
	*		la fonction se connecte à la BD dbname_global et retourne une $bdd
	*  Entrées : 
	*		rien : on se connecte toujours à dbname_global, avec username_global et password_global
	*	Sorties : 
	*		$bdd : la BD : objet PDO
	*		ou NULL si ça n'a pas marché
	*  Remarque : on ne touche pas à cette fonction
*/
function connexionDB(){
	global $dbname_global;
	global $username_global;
	global $password_global;

	// paramètres de la base de donnée
	$sgbdname='mysql';
	$host='localhost';
	$charset='utf8';	
	// dsn : data source name
	$dsn = 
		$sgbdname . 
		':host='.$host . 
		';dbname='.$dbname_global. 
		';charset='.$charset;

	// pour avoir des erreurs SQL plus claires 
	$erreur = array(
  	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  );

	try {
		// connexion à la BD : new PDO
	    $bdd = new PDO($dsn, $username_global, $password_global, $erreur);
	    debug($bdd, 'Connexion réussie !!!');
	    return $bdd;
	} catch (PDOException $e) {
		debug($e->getMessage(), 'Connexion échouée');
		return NULL;
	}
}
?>
