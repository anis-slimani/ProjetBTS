<?php
//démarrer la session
session_start();

// Debug 
include_once("./modele/initialisation/tools/debug.php");

// Modèle : charger les classes
spl_autoload_register(function ($class_name) {
   include './modele/classes_metier/' . $class_name . '.php';
});

// Modèle : charger la BD
include("./modele/initialisation/tools/connexionDB.php");
$bdd = connexionDB(); // connexion "automatique" à la BD BD_personnages_armes

// Modèle : définir des variables globales
$copyright = "moi";