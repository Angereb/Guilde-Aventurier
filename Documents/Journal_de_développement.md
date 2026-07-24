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

### Réalisations

- Création de la connexion à la base de données.
- Création du fichier de configuration de la connexion à la base de données.
- Création de la classe `Utilisateur`.
- Création de la classe `UtilisateurModele` contenant le CRUD des utilisateurs.
- Modification des contrôleurs des pages d'inscription et de connexion afin d'intégrer le système d'authentification.
- Mise en place de l'inscription des utilisateurs.
- Mise en place de la connexion des utilisateurs.
- Redirection des utilisateurs authentifiés vers le Hall.
- Validation du bon fonctionnement du parcours d'authentification.

### Difficultés

- Compréhension des méthodes utilisées par des frameworks tels que Symfony pour gérer les modèles.

### Solutions

- Réalisation d'un exercice guidé afin de décortiquer le fonctionnement des modèles et de créer une version « artisanale » adaptée au projet.

---

## 17 Juillet 2026

### Objectifs

- Construction du header

### Réalisations

- Création d'un fichier Composant entete.php s'affichant uniquement si une session est ouverte
- Création des liens de navigation vers de futur pages 
- Création du système du déconnexion
- Préparation du fichier entete.css

---

## 18 Juillet 2026

### Objectifs

- Génération du visuel du bandeau de tête
- Génération du visuel du hall

### Réalisations

- Création du style css pour l'entête
- Création des boutons non prévu sur la maquette
- Création du style css pour le hall

### Difficultés

- Problème de gestion des boites css avec le flex

### Solutions

- Passage en gestion grid du style css

---

## 19 au 22 Juillet 2026

### Objectifs

- Finaliser le Hall
- Afficher les annonces
- Ajouter la lecture des annonces

### Réalisations

- Développement du modèle Annonce et de AnnonceModele contenant le CRUD
- Création du système de récupération des annonces depuis la base de données
- Limitation de l'affichage aux 6 annonces les plus récentes
- Association du pseudo de l'auteur aux annonces
- Création d'une modale JavaScript pour la création d'une annonce
- Création d'une seconde modale pour la lecture d'une annonce
- Mise en page des annonces sous forme de feuilles punaisées sur le panneau d'affichage
- Finalisation de la première version fonctionnelle du Hall Principal

## 24 Juillet 2026

### Objectifs

- Modifier la banque de donnée pour une meilleur gestion des comptes
- Modifier la méthode de connexion pour ajouter la possibilité de ce connecter via le pseudo

### Réalisations

- Suppression des tables Utilisateurs et Annonces au sein de la BDD
- Mise à jour des tables et du Schema de la BDD
- Modification de la classe Utilisateur
- Modification de la classe UtilisateurModele pour la recherche et la suppression
- Modification du contrôleur de connexion pour ajout du pseudo en tant qu'identifiant valide et vérification de l'état du compte

## Prochaine étape

- 