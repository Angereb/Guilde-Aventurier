# Journal de Développement

## Informations

Ce journal a été rédigé au cour du développement du projet Guilde des Aventuriers un certain temps après le début du développement, les premières dates sont donc approximatives. De plus, en parallèle du développement, des cours ont été suivis pour parfaire mes connaissances.

## 21 Mai 2026

### Objectifs

- Initialisation du projet

### Réalisations

- Cahier des charges
- Début du prototype sur Figma

### Difficultés

- Utilisation de l'outil de dessin sur Figma pour faire du mobilier

### Solutions

- Recherche sur le web de vidéo d'aide a l'utilisation de Figma

---

## 19 Juin 2026

### Objectifs

- Structurer la base du projet

### Réalisations

- Prototype Figma version mobile complet
- Modèle relationnelle sur QuickDBD complet

---

## 20 Juin 2026

### Objectifs

- Préparation de la BDD

### Réalisations

- Création de Utilisateurs.sql
- Création de Annonces.sql

---

## 21 Juin 2026

### Objectifs

- Initialisation de la BDD
- Test de la BDD

### Réalisations

- Création de Schema.sql, comprenant les tables transféré vers phpMyAdmin
- Création de Utilisateurs_Test.sql
- Création de Annonces_Test.sql
- Envoi des tests vers phpMyAdmin
- Suppression de l'utilisateur test pour vérification de la cascade de suppression

---

## 23 Juin 2026

### Objectifs

- Mise en place d'un MVC
- Navigation

### Réalisations

- Création des dossiers Controleurs, Modeles, Vus et Publiques
- Création de index.php
- Création des pages entree.php, secretariat.php, inscription.php, connexion.php et hall.php dans le dossier Vus
- Création des pages accueilcontroleur.php, secretariatcontroleur.php et hallcontroleur.php dans le dossier Controleurs
- Création de calqueprincipale.php
- Initialisation du style dans le fichier style.css

### Difficultés

- Orthographes des informations incorrecte bloquand la navigation

### Solutions

- Faire relire mon code pour trouver les erreurs d'écriture

---

## 24 Juin 2026

### Objectifs

- Organiser la structure du site

### Réalisations

- Création des sous dossiers Accueil, Secretariat et Hall dans Vus
- Création des sous dossiers Accueil, Secretariat et Hall dans Controleurs
- Déplacement du fichiers entree.php dans le dossier Accueil inclus dans le dossier Vus
- Déplacement et renommage du fichiers accueilcontroleur.php en entreecontroleur.php dans le dossier Accueil inclus dans le dossier Controleurs
- Déplacement des fichiers secretariat.php, inscirption.php, connexion.php dans le dossier Secretariat inclus dans le dossier Vus
- Déplacement du fichiers secretariatcontroleur.php dans le dossier Secretariat inclus dans le dossier Controleurs
- Déplacement du fichiers hall.php dans le dossier Hall inclus dans le dossier Vus
- Déplacement hallcontroleur.php dans le dossier Hall inclus dans le dossier Controleurs

---

## 29 Juin 2026

### Objectifs

- Création de la page Entrée

### Réalisations

- Modification de entree.php
- Création de entree.css
- Création des règles responsive mobile pour l'entrée

### Difficultés

- Positionnement des éléments (Titre, Portes, Panneau d'informations)

### Solutions

- Utilisation de FlexBox

---

## 01 Juillet 2026

### Objectifs

- Création de la page Informations

### Réalisations

- Création de information.php
- Création de information.css
- Modification de entree.css et de style.css pour adapter la lisibilité des textes

### Difficultés

- lisibilité du texte sur petit écran

### Solutions

- Ajustement de la taille de police

---

## 03 Juillet 2026

### Objectifs

- Création de la page Secretariat

### Réalisations

- Modification de secretariat.php
- Création de secretariat.css
- Modification de la navigation
- Création des contrôleurs connexioncontroleur.php et inscriptioncontroleur.php
- Initialisation des feuilles de style pour l'inscritption et la connexion
- Création du fichier MELIRE.md

---

## 06 Juillet 2026

### Objectifs

- Documenter le suivi du projet.

### Réalisations

- Création du fichier Journal_de_developpement.md.
- Reconstitution chronologique des principales étapes du projet.

### Difficultés

- Les premières dates étant antérieures à la création du journal, certaines ont dû être estimées.

### Solutions

- Reconstitution de la chronologie à partir des commits Git et de vidéo de suivi du projet.

---

## 07 Juillet 2026

### Objectifs

- Création de la page d'inscription et de connexion

### Réalisations

- Modification de inscription.php et connexion.php
- Création des styles pour inscription.css et connexion.css

---

## 08 au 17 Juillet 2026

### Objectifs

- Développement du système d'authentification

### Réalisation

- Création de la connexion à la BDD
- Création du fichier de configuration pour la connexion à la BDD
- Création du Modèle de classe utilisateur
- Création du Modèle de clasqe utilisateurModele contenant le CRUD d'utilisateur 
- Modification des controleurs des pages d'inscription et de connexion pour intégration de l'authentification

### Difficultés

- Mauvaise comprehension des méthodes employer par des frameworks tel Symfony pour gérer les modèles

### Solutions

- Réalisation d'un exercice guider pour décortiquer la gestion des modèles pour créer une version du système artisanal adaptée au projet

---

## Prochaine étape

- Développement du Hall