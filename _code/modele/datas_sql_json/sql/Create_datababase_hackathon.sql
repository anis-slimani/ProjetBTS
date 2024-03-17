-- ------------------------------------------------------------------------------------
-- Création de la BD : DDL
-- DDL (Data Definition Language) : CREATE - ALTER - DROP

-- Formalisme : 
--
-- On crée le code en CamelCase pour être cohérent avec le PHP
-- Tous les attributs sont suffixés avec le nom de la table pour simplifier le PHP
-- Les clés étrangères et les clés primaires ont le même nom
-- C'est plus lourd mais c'est plus clair
-- Principe général en PHP : camelCase et on suffixe par le nom de la table ou de la classe
-- ---------------------------------------------------------------------------------

-- Graphe des tables + peuplement (nb)
-- 
--     |--Equipes-Participants        Equipes-Jurys
--     |          (18)       \         /   (12)   \
--     |                      \       /            \
--     |                       v     v              \
--     | --------------------  Equipes               |
--     | |                         |(6)              |
--     | |                         |                 | 
--     | |                         v                 |
--     | |        Hackathons    Projets  Hackathons  |
--     | |       Participants      |(4) /  Jurys \   |
--     | |      /    (18)   \      |   /    (4)   \  |
--     v v     v             v     v  v            v v
--   Participants            Hackathons            Jurys
--       (16)                    (2)                (3)
--
--   et la table Administrateurs (1) : on en met un seul
--
-- Liste des tables
--
-- Hackathons(id, nom, date_debut)
-- Participants(id, nom, mail, telephone, date_de_naissance, lien_porte_folio)
-- Jurys(id, nom, prenom, mail, telephone)
--
-- Projets(id, nom, description, pdf, retenu, id_hackathon)
-- Equipes(id, nom, lien_projet, note_projet, classement, id_participant_chef, id_projet)
--
-- Hackathons_Participants(id_hackathon, id_hackathon, id_relatif, date_inscription, competence)
-- Hackathons_Jurys(id_hackathon, id_jury)
-- Equipes_Participants(id_equipe, id_participant)
-- Equipes_Jurys(id_equipe, id_jury, note)

-- ---------------------------------------------------------------------------------
-- Création de la Database

DROP DATABASE if exists HackathonsFW; -- à ne faire qu'avec une BD de jeu de tests
CREATE DATABASE HackathonsFW;
USE HackathonsFW; -- fait rentrer dans la BD Hackathons

-- ---------------------------------------------------------------------------------
-- Création des tables : d'abord les tables sans clés étrangères

-- Hackathons (id, nom, date_debut)
CREATE TABLE Hackathons(
	idHackathon integer auto_increment,     -- auto_increment : numéro automatique
	nomHackathon varchar(30) not null,      -- not null veut dire obligatoire
	dateDebutHackathon datetime not null,
	primary key(idHackathon)
) engine innodb;

CREATE TABLE Jurys(
	idJury integer auto_increment,
	loginJury varchar(30) unique,
	passwordJury varchar(30), 
	nomJury varchar(30) not null,   
	prenomJury varchar(30) not null,   
	mailJury varchar(30) unique, -- pas de doublon possible : unique : clé secondaire  
	telephoneJury varchar(10),  
	primary key(idJury)
) engine innodb;

CREATE TABLE Participants(
	idParticipant integer auto_increment,
	loginParticipant varchar(30) not null unique,
	passwordParticipant varchar(30) not null, 
	nomParticipant varchar(30) not null,   
	prenomParticipant varchar(30) not null,   
	mailParticipant varchar(30) not null unique,   
	telephoneParticipant varchar(10),  
	dateDeNaissanceParticipant date,
	lienPorteFolioParticipant varchar(30),
	primary key(idParticipant)
) engine innodb;

CREATE TABLE Administrateurs(
	idAdministrateur integer auto_increment,
	loginAdministrateur varchar(30) not null unique,
	passwordAdministrateur varchar(30) not null,   
	nomAdministrateur varchar(30) not null,   
	prenomAdministrateur varchar(30),   
	mailAdministrateur varchar(30) not null unique,   
	primary key(idAdministrateur)
) engine innodb;

-- Création des tables : ensuite les tables avec clés étrangères et clé primaire simple

CREATE TABLE Equipes(
	idEquipe integer auto_increment,
	nomEquipe varchar(20) not null,
	lienProjetEquipe varchar(20),        -- lien vers le zip de livraison
	noteProjetEquipe integer,            -- note du projet
	classementEquipe integer,             -- 1e, 2e, 3e ou null
	idParticipantChef integer not null,   -- par défaut l'admin choisit le premier inscrit comme chef
	idProjet integer not null,           
	primary key(idEquipe)
) engine innodb;

CREATE TABLE Projets(
	idProjet integer auto_increment,
	nomProjet varchar(20) not null,
	descriptionProjet text not null,          -- déscription courte du projet
	pdfProjet varchar(100),                   -- nom du fichier cachier des charges pdf du projet, null au début
	retenuProjet boolean not null default 0,  -- faux par défaut : le projet n'est gardé pour un hackathon, 
	idHackathon integer,               -- pas not null : au départ, on crée des projets sans id_hackathon 
	primary key(idProjet)
) engine innodb;

-- Création des tables : enfin les tables avec clés étrangères et clé primaire complexe

CREATE TABLE ParticipantsHackathons(
	idParticipant integer,
	idHackathon integer,
	idRelatifParticipantHackathon integer not null,
	dateInscriptionParticipantHackathon datetime not null,
	competenceParticipantHackathon varchar(30),
	primary key(idHackathon, idParticipant)
) engine innodb;

CREATE TABLE JurysHackathons(
	idJury integer,
	idHackathon integer,
	primary key(idJury, idHackathon)
) engine innodb;

CREATE TABLE JurysEquipes(
	idJury integer,
	idEquipe integer,
	note integer not null,
	primary key(idJury, idEquipe)
) engine innodb;

CREATE TABLE ParticipantsEquipes(
	idParticipant integer,
	idEquipe integer,
	primary key(idParticipant, idEquipe)
) engine innodb;

-- ------------------------------------------------------------------------------
-- Création des données dans les tables de la BD : DML
-- DML (Data Manipulation Language) : INSERT - UPDATE - DELETE
-- ------------------------------------------------------------------------------

-- Liste des tables
--
-- Hackathons(idHackathon, nomHackathon, dateDebutHackathon)
-- Participants(idParticipant, nomParticipant, mailParticipant, telephoneParticipant, dateDeNaissanceParticipant, lienPorteFolioParticipant)
-- Jurys(idJury, nomJury, prenomJury, mailJury, telephoneJury)
--
-- Projets(idProjet, nomProjet, descriptionProjet, pdfProjet, retenuProjet, idHackathon)
-- Equipes(idEquipe, nomEquipe, lienProjetEquipe, noteProjetEquipe, classementEquipe, idParticipantChef, idProjet)
--
-- ParticipantsHackathons(idParticipant, idHackathon, idRelatifParticipantHackathon, dateInscriptionParticipantHackathon, competenceParticipantHackathon)
-- JurysHackathons(idJury, idHackathon)
-- ParticipantsEquipes(idParticipant, idEquipe)
-- JurysEquipes(idJury, idEquipe, note)

-- Création des lignes = tuples

INSERT INTO Hackathons
(idHackathon, nomHackathon, dateDebutHackathon)
VALUES -- 2 hackathons
(1, "hackathon_2023_1", "2023-06-01 09:00:00"),
(2, "hackathon_2023_2", "2023-10-01 09:00:00");

INSERT INTO Administrateurs 
(
	idAdministrateur, 
	loginAdministrateur, passwordAdministrateur,
	nomAdministrateur, prenomAdministrateur,
	mailAdministrateur)
VALUES 
(	1, 
	"root", "root",
	"nom_root_admin", "prenom_root_admin",
	"nom_root_admin@gmail.com"
	
);

INSERT INTO Jurys 
(idJury, nomJury, prenomJury, mailJury, telephoneJury)
VALUES -- 3 jurys, 2 par hackathons, le 1 sur les 2 hackathons
(1, "jury_toto", "p1", "toto@gmail.com", "0607080910"),
(2, "jury_tata", "p2", "tata@gmail.com", null),
(3, "jury_titi", "p1", null, null);

INSERT INTO Jurys 
(
	idJury, loginJury, passwordJury, 
	nomJury, prenomJury, 
	mailJury, telephoneJury
)
VALUES 
(
	4, "root", "root", 
	"nom_root_jury", "prenom_root_jury", 
	"nom_root_jury@gmail.com", null
);

INSERT INTO Projets 
(idProjet, nomProjet, descriptionProjet, pdfProjet, retenuProjet, idHackathon)
VALUES -- 4 projets, 2 par hackathon
(1, "projet 1", "super projet 1", "projet_1.pdf", true, 1),
(2, "projet 2", "super projet 2", "projet_2.pdf", true, 1),
(3, "projet 3", "super projet 3", "projet_3.pdf", true, 2),
(4, "projet 4", "super projet 4", "projet_4.pdf", true, 2);


INSERT INTO JurysHackathons
(idJury, idHackathon)
VALUES -- 4 hackathons_jurys, 2 jurys par hackathons, le 1 sur les 2 hackathons
(1, 1),
(2, 1),
(1, 2),
(3, 2);

-- Participants(idParticipant, nomParticipant, prenomParticipant, mailParticipant, telephoneParticipant, dateDeNaissanceParticipant, lienPorteFolioParticipant)
INSERT INTO Participants 
(	idParticipant, 
	loginParticipant, passwordParticipant, 
	nomParticipant, prenomParticipant, 
	mailParticipant, 
	telephoneParticipant, dateDeNaissanceParticipant, lienPorteFolioParticipant)
VALUES 
(	1,
	"root", "root", 
	"nom_root_participant", "prenom_root_participant", 
	"nom_root_participant@gmail.com", 
	null, null, null
);


-- A FINIR !!!


-- ------------------------------------------------------------------------------
-- Ajout des clés étrangères : DDL : 11
-- 3 relations 1 à plusieurs
-- 4 tables de liaisons : 4 *2 = 8
-- DDL (Data Definition Language) : CREATE - ALTER - DROP
-- ------------------------------------------------------------------------------
-- Ajout des clés étrangères

-- 3 relations 1 à plusieurs
ALTER TABLE Projets
ADD FOREIGN KEY(idHackathon)
REFERENCES Hackathons(idHackathon);

ALTER TABLE Equipes
ADD FOREIGN KEY(idProjet)
REFERENCES Projets(idProjet);

ALTER TABLE Equipes
ADD FOREIGN KEY(idParticipantChef)
REFERENCES Participants(idParticipant);

-- 4 tables de liaison
ALTER TABLE ParticipantsHackathons
ADD FOREIGN KEY(idParticipant)
REFERENCES Participants(idParticipant);

ALTER TABLE ParticipantsHackathons
ADD FOREIGN KEY(idHackathon)
REFERENCES Hackathons(idHackathon);

ALTER TABLE JurysHackathons
ADD FOREIGN KEY(idJury)
REFERENCES Jurys(idJury);

ALTER TABLE JurysHackathons
ADD FOREIGN KEY(idHackathon)
REFERENCES Hackathons(idHackathon);

ALTER TABLE JurysEquipes
ADD FOREIGN KEY(idJury)
REFERENCES Jurys(idJury);

ALTER TABLE JurysEquipes
ADD FOREIGN KEY(idEquipe)
REFERENCES Equipes(idEquipe);

ALTER TABLE ParticipantsEquipes
ADD FOREIGN KEY(idParticipant)
REFERENCES Participants(idParticipant);

ALTER TABLE ParticipantsEquipes
ADD FOREIGN KEY(idEquipe)
REFERENCES Equipes(idEquipe);

-- -------------------------------------------------------------------------------------------
-- Consultation des données dans les tables de la BD : SELECT
-- -------------------------------------------------------------------------------------------

-- On fait un SELECT pour regarder le contenu des tables
SELECT * FROM Hackathons; 
SELECT * FROM Participants; 
SELECT * FROM Jurys; 

SELECT * FROM Projets; 
SELECT * FROM Equipes; 

SELECT * FROM ParticipantsHackathons;
SELECT * FROM JurysHackathons;
SELECT * FROM ParticipantsEquipes;
SELECT * FROM JurysEquipes;


-- On fait un COUNT(*) pour regarder le nombre de tuples des tables
SELECT count(*) FROM Hackathons; 
SELECT count(*) FROM Participants; 
SELECT count(*) FROM Jurys; 

SELECT count(*) FROM Projets; 
SELECT count(*) FROM Equipes; 

SELECT count(*) FROM ParticipantsHackathons;
SELECT count(*) FROM JurysHackathons;
SELECT count(*) FROM ParticipantsEquipes;
SELECT count(*) FROM JurysEquipes;
