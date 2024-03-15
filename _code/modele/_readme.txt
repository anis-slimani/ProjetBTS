Le dossier modele correspond au modele du MVC 
   - le dossier classes_metier contient les classes métier : celles de la BD 
      dans ce dossier on trouve les tests unitaires de chaque classe : 
            un controleur de tests unitaires par classe
   - le dossier init qui contient le fichier d'initialisation qui utilise le fichier de connexionDB
   - le dossier datas_sql_json qui contient des codes sql de création de BD et des fichiers JSON
         ces fichiers ne servent pas dans le programme
         le code de création de la BD permet de repartir sur une BD de jeu de tests
         c'est Create_datababase_hackathon.sql qui nous sert pour le projet Hackathon
   - les fichiers de modele 
         modele_hackathon.php contient les fonctions d'accès à la BD
            select_hackathon()
            insert_hackathon()
            etc.
         il y a un fichier modele par classe métier