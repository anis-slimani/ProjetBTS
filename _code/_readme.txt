Architecture
   |- _readme.txt
   | 
   |- modele : la partie base de données 
   |   |- classes métiers : les classes 
   |   |   |- tests_unitaires
   |   |- initialisation : 
   |   |   |- inialisation.php : les initialisation
   |   |   |- tools
   |   |   |   |- connexionBD.php : la connexion à la bd
   |   |   |   |- debug.php : les fonctions de debug
   |   |
   |   |- datas_sql_json
   |   |   |-sql
   |   |   |   |-Create_datababase_hackathon.sql : le code sql de création de la BD 
   |   |   |-json
   |   |       |-pour des fichiers json, inutile dans notre projet
   |
   |- views 
   |   |- les vues
   |
   |- public : les fichiers publics pour le client
   |   |- css
   |   |- img
   |   |- pdf
   |
   |- appel_ctrl_xxx : les controleurs appelés par des formulaires souvent
   |
   |- ctrl_xxx : les controleurs de l'application


On n'utilise pas de front_controleur et de "routeur" : 
   donc tous nos controleurs sont à la racine 
   ce n'est pas très pratique !
   mais écrire un routeur php "à la main", c'est fastidieux et inutile 
      car tous les frameworks (laravel, node-express, flak, ...) proposent des systèmes de routage intégré natif propres et simples.