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

---

## 24 Juillet 2026

### Objectifs

- Modifier la banque de donnée pour une meilleur gestion des comptes
- Modifier la méthode de connexion pour ajouter la possibilité de ce connecter via le pseudo

### Réalisations

- Suppression des tables Utilisateurs et Annonces au sein de la BDD
- Mise à jour des tables et du Schema de la BDD
- Recréation des tables Utilisateurs et Annonces suivant la nouvelle structure
- Modification de la classe Utilisateur
- Modification de la classe UtilisateurModele pour la recherche et la suppression
- Modification du contrôleur de connexion pour ajout du pseudo en tant qu'identifiant valide et vérification de l'état du compte

---

## 25 et 27 Juillet 2026

### Objectifs

- Réalisation de la page "Mon Compte" permettant les modifications des informations utilisateur

### Réalisations

- Création de la vus, du contrôleur, du css et du JS de la page "Mon Compte"
- Création d'un ensemble de formulaires pour la modification des informations de pseudo du compte, nom de la compagnie, email du compte et mot de passe du compte
- Création d'un ensemble de modales obligeant la vérification via mot de passe pour modifier les informations sensibles du compte
- Création des règles css de la page et des modales

---

## 28, 30 et 31 Juillet 2026

### Objectifs

- Ajout de l'option de suppression dans la page mon compte
- Réalisation de la page "Administration" permettant aux administrateur de gérer les rôles et les accès au site

### Réalisations

- Ajout du bouton "Supprimer" et de la modale de vérification avant suppression d'un compte, avec un message d'avertissement
- Modifications du contrôleur pour ajouter la fonction de suppression de compte
- Modification du Modèle Utiisateur pour ajouter le setteur de suppression
- Ajout des règles css pour le bouton "Supprimer" et la modale de vérification avant suppression d'un compte
- Ajout d'une nouvelle fonctionde recherche dans UtilisateursModèle, permettant de récupérer une liste de compagnie du même nom
- Création de la page Administrateur, contenant un formulaire de recherche, et une modale de modification des rôles et du soft-delete via formulaires chekbox
- Blocage des modifications en cas de tentative d'auto-modification d'un administrateur

---

## 01 Août 2026

### Objectifs

- Ajout des fonctionnalités de modification et de suppression des annonces dans le hall

### Réalisations

- Refonte de la logique de gestion des formulaires du contrôleur du hall
- Ajout des boutons "Modifier" et "Supprimer" dans la modale de lecture des annonces
- Ajout des modales de modification d'annonces et de suppression d'annonces

---

## 02 Août au 22 Septembre 2026

- Le projet a été en pause pendant toute cette période pour la réalisation d'une évaluation en cours de formation (ECF) sur le sujet "Vite et Gourmand".
- Je me suis servi des connaissances acquises sur le projet Guilde des Aventuriers comme base de travail pour réaliser l'ECF, et l'ECF m'a amené à m'améliorer sur le développement en pointant un certain nombre de lacunes.
- Le projet Guide des Aventuriers va devoir subir une refonte technique suivant les connaissances et les retours de l'ECF.

---

## 23 au 25 Septembre 2026

### Objectifs

- Amélioration du cadrage du projet

### Réalisations

- Création d'un fichier de présentation du projet plus complet que le cahier des charges de départ
- Tableau des fonctionnalités
- Définition de certaines règles interne au projet dans les notes d'intentions 
- Méthode Merise complet (MCD et MLD réalisés avec Looping, MPD à venir)
- Trello de suivi du projet
- Calendrier prévisionnel

---

## 27 au 30 Septembre 2026

### Objectifs

- Reprise du prototypage

### Réalisations

- Document de charte graphique complet
- Mise à jour des mockups mobile déjà fait
- Création des wireframes desktop et comparatif avec wareframe mobile pour les pages d'inscription/connexion, Hall et fiche de personnage
- Création des mockups desktop

---

## 01 Octobre 2026

### Objectifs

- Refonte de la base de données suivant MCD revu et corrigé

### Réalisations

- Modifications des tables Utilisateurs et Annonces
- Création de toutes les tables manquantes
- Ajout de "CHECK" de vérifications des données

---

## 02 Octobre 2026

### Objectifs

- Test des tables en SQL

### Réalisations

- Création de plusieurs fichiers de tests des tables SQL avec des cas valides et des cas invalides
- Test des tables sur phpMyAdmin
- Prise de note des résultats pour les différents tests invalides

### Difficultés

- Lors d'un test de contenu d'une annonce vide, la base a validé le test car elle n'était pas en mode strict et a inscrit une chaîne vide alors que le contenu est défini en NOT NULL
- Problèmes sur ma manière de nommer les tables, MariaDB ne prend pas en compte les majuscules

### Solutions

- Ajout d'un CHECK pour vérifier que la valeur n'est pas vide
- Modification des noms des tables composés en snake_case

---

## 03 au 05 Octobre

### Objectifs

- Intégration de Docker

### Réalisations

- Suivi des cours sur les conteneurs sur la plateforme STUDI
- Installation de Docker Desktop
- Activation du WSL 2 nécessaire à Docker Desktop
- Création du Dockerfile propre au projet
- Création du docker-compose.yml (service site, service bdd et service phpmyadmin)
- Création des variables d'environnement (non versionné) et modification de la configuration locale
- Création d'un fichier d'exemple d'environnement

### Difficultés

- Virtualisation non détectée
- Problème de chemin lié à Linux qui n'accepte pas les \
- Documentation du cours erronée
- Schéma non exécuté

### Solutions

- Activation de la fonctionnalité WSL de Windows
- Changement des chemins avec des / remplaçant les \
- Recherche de documentations sur internet
- Analyse des logs du service de bdd et réinitialisation du volume

---

## 05 et 06 Octobre

### Objectifs

- Perfectionnement et modification des anciens modèles

### Réalisations

- Modification de la classe BaseDeDonnees pour adaptation à l'environnement Docker
- Création d'un ModeleBase pour rassembler les fonctions communes aux modèles
- Correction des modèles d'objets pour correspondre à la nouvelle base de données
- Correction, factorisation et hydratation des modèles (fonction CRUD)

---

## 07 Octobre

### Objectifs

- Création des modèles de classe d'objets (pour les nouveaux objets)

### Réalisations

- Création des classes d'objets pour les caractéristiques, les maîtrises, les équipements, les compétences, les aventuriers et les relations entre utilisateurs
- Modification des tables équipements et compétences pour accepter la valeur null pour les modificateurs (la gestion du calcul gérera le cas du null)
- Ajout du CHECK pour le statut des relations

---

## 08 et 09 Octobre

### Objectifs

- Création des modèles CRUD 

### Réalisations

- Création d'une classe de base pour les modèles de liaison ayant 0 ou 1 paramètre supplémentaire
- Création des classes de modèle de liaison
- Création des classes de modèle pour les objets

---

## 10 Octobre

### Objectifs

- Sécurisation des accès aux différents dossiers du site
- Reprise de la page d'entrée du site

### Réalisations

- Ajout de la prise en compte des .htaccess dans Dockerfile
- Création d'un .htaccess spécifique à la racine du projet
- Création de plusieurs .htaccess en mode "Require all denied" pour tous les dossiers dont l'accès ne doit pas être possible directement
- Modification du calqueprincipale.php pour y adjoindre la gestion du style.css et entete.css
- Ajout d'un versionnement des fichiers css et js via filemtime()
- Ajout de la balise viewport
- Modification du style général avec les règles établies sur figma et les nouvelles polices téléchargées pour hébergement local
- Création d'un fichier pour séparer le contenu des informations de l'accueil de son contenant
- Modification de entree.php avec ajout des labels des liens et un aside réservé pour la version desktop
- Modification du entree.css, passage en mode grid, passage des images en .svg, adaptation de l'ensemble, ajout d'une media query pour la version desktop
- Modification de informations.php avec remplacement du texte par un lien vers le fichier de contenu et ajout du label pour le lien de retour vers l'entrée
- Modification du informations.css, passage des images en .svg

### Difficultés

- Les images en .svg ne s'adaptaient pas correctement aux espaces

### Solutions

- Redimensionnement des portes sur Figma pour correspondre à hauteur = 4xlargeur
- Annulation de la préservation du ratio pour le panneau d'information directement dans le svg

---

## 11 et 12 Octobre

### Objectifs

- Reprise des pages liées au secrétariat

### Réalisations

- Réorganisation des formulaires sur des fichiers à part pour permettre l'import sur différentes pages (page simple et page double)
- Ajout et configuration du jeton CSRF (httponly, samesite, secure)
- Création d'un script JS général inclus dans le calque principal pour l'affichage et la suppression des messages d’erreur liés aux formulaires
- Création des validations JS pour les formulaires de connexion et d'inscription
- Mise à jour des styles CSS pour le secrétariat, la connexion et l'inscription, avec passage en .svg des images et media query pour le secrétariat
- Création du style CSS pour la page rassemblant inscription et connexion pour la version desktop

### Difficultés

- les images SVG gardent leurs proportions et ne remplissent pas les zones prévues pour les anciens PNG (bureau, livres).

### Solutions

- Utilisation d'une zone mesurée (container-type)

---

## 13 et 14 Octobre

### Objectifs

- Reprise de la page du hall
- Reprise du menu du site

### Réalisations

- Ajout des vérifications de jeton CSRF pour les formulaires des annonces
- Ajout des messages liés aux validations JS des champs
- Réorganisation du fichier hall.js et ajout de la validation JS pour les formulaires du hall
- Modification de l'agencement des divisions pour gestion des emplacements via un grid-template-areas
- Mise à jour du css du hall avec les images en .svg et version desktop
- Modification du menu avec passage de la déconnexion de lien vers un formulaire vérifiant le jeton CSRF avant déconnexion
- Mise à jour du style du menu d'en-tête
- Ajout d'un redirection vers le hall pour les utilisateurs connecté tentant d'accedé aux pages précédent la connexion

### Difficultés

- Problème de zonage des espaces entre mobile et desktop pour le hall
- Chevauchement entre les boutons du menu et le retour au hall (en position absolue)

### Solutions

- Organisation des zones via grid-template-areas et nommage des zones pour définir leurs positions respectives entre mobile et desktop
- Ajout d'un second media query pour les écrans les plus petits, reduisant la taille des icônes du menu

---

## 14 et 15 Octobre

### Objectifs

- Création d'un affichage spécifique pour les notifications de succès et d'erreur

### Réalisations

- Création d'un composant notification.php inclus dans le calque principal
- Stylisation du composant de notification, avec animation de déroulement pour le parchemin et différenciation entre succès et erreur et respect de la réduction des animations des utilisateurs
- Programmation d'un temps d'affichage maximum pour la notification de succès et d'une méthode de fermeture pour les deux notifications en JavaScript
- Modification de la gestion des messages d'erreur dans les précédents contrôleurs et ajout de messages de succès

---

## 15 et 16 Octobre

### Objectifs

- Reprise de la page Mon compte

### Réalisations

- Modification de la vue de Mon compte avec rassemblement des modifications du pseudo, du nom de la compagnie et de l'adresse e-mail en un seul formulaire, suppression des modales inutiles, ajout des jetons CSRF, ajout des champs pour les messages de la validation js
- Ajout d'une fonction pour anonymiser les comptes dans le modèle utilisateur via une transaction supprimant les aventuriers, les déblocages de compétences et les relations et modifiant le pseudo par "Anonyme-UUID", le nom de compagnie par "Compagnie dissoute", l'e-mail par "anonyme-uuid@guilde.invalid" et le mot de passe par une valeur alératoire hachée.
- Modification du contrôleur de Mon compte, ajout de la vérification des jetons CSRF, fusion des modifications pseudo, nom de compagnie et adresse e-mail, ajout de la destruction du cookie de session, ajout des messages de réussite des formulaires, passage du message d'erreur dans le système de notification
- Ajout des validations JS pour les différents champs des formulaires
- Mise à jour de moncompte.css avec passage des images en .svg, media query pour le desktop et ajustement des modales

---

## 16 Octobre

### Objectifs

- Reprise de la page Administration

### Réalisations

- Modification de la vue de la page Administration avec tableau pour le résultat des recherches, modification de l'intitulé de l'état, ajout du message de validation js pour la recherche, ajout des jetons CSRF
- Ajout des libellés des rôles dans l'objet utilisateur
- Modification du contrôleur de la page Administration avec tri des résultats de la recherche pour exclure les comptes supprimés, vérification des jetons CSRF, contrôle de l'état supprimé des comptes modifiés, ajout des messages d'erreur et de succès dans le système de notification, ajout du rôle utilisateur garanti
- Modification du fichier JavaScript pour la page Administration avec validation js du champ de recherche, et adaptation des check sur l'état actif
- Mise à jour de administrateur.css avec passage des images en .svg, media query pour le desktop, stylisation du tableau des utilisateurs trouvés

---

## 17 Octobre

### Objectifs

- Créer la page de gestion des relations

### Réalisations

- Ajout du chemin vers le contrôleur dans l'index
- Création du contrôleur de la liste de contacts avec récupération automatique de tous les contacts de l'utilisateur de la session, gestion du formulaire pour sélectionner un pseudo à demander en ami ou à bloquer, des formulaires de modifications des états des relations
- Pour une demande de contact vers un utilisateur ayant bloqué le demandeur de contact, ce dernier reçoit un message lui signifiant que la demande de contact a bien été envoyée, même si ce n'est pas réellement le cas pour protéger le choix de son contact de l'avoir bloqué
- Création de la vue avec affichage d'un champ pour saisir un pseudo à demander en ami ou à bloquer, affichage d'un tableau comprenant toutes les relations du compte et des boutons conditionnés selon l'état de la relation et permettant de changer l'état de la relation, et affichage d'un message en cas où aucune relation n'est trouvée pour l'utilisateur
- Création d'une validation js pour le champ de sélection des pseudos à demander en ami ou à bloquer
- Création du style css de la page semblable à celui de la page administrateur

---

## 19 Octobre

### Objectifs

- Ajout d'une base de données NoSQL MongoDB
- Ajout des Modèles pour la messagerie

### Réalisations

- Ajout dans docker-compose.yml des services pour MongoDB et son lecteur Mongo-express
- Ajout dans le Dockerfile des extensions pour MongoDB et Composer
- Récupération de la bibliothèque de MongoDB
- Protection des chemins d'accès des nouveaux éléments et mise sous .gitignore du dossier "vendor"
- Création d'une classe pour la connexion à la base de données NoSQL
- Création d'une classe d'objet Message avec validation via setteurs (nécessaire étant donné que MongoDB n'a pas de schéma ni de contrainte de données)
- Création d'un modèle de classe MessageModele avec les fonctions permettant de créer, lire, modifier l'état de lecture et supprimer un ou plusieurs messages
- Ajout dans la fonction anonymiser() de UtilisateurModele de la suppression de tous les messages dont l'utilisateur est le destinataire

---

## 20 Octobre

### Objectifs

- Création de la page de messagerie

### Réalisations

- Ajout du chemin d'accès vers le contrôleur de la messagerie dans l'index
- Création du contrôleur de la messagerie, avec récupération des amis et rivaux pour avoir un accès rapide à leurs pseudos, récupération des messages, gestion du formulaire de rédaction de message, du bouton de suppression de messages, et de la fonction javascript transformant l'état d'un message à la lecture
- Création de la vue avec affichage d'un champ de saisie de pseudo pouvant récupérer les pseudos de la liste de contact (amis et rivaux), modale pour la rédaction du message, affichage des messages dans un tableau (expéditeur, titre, état) avec en plus un bouton pour la suppression du message, modale pour la lecture du message après clic sur le titre dans le tableau
- Création d'un fichier javascript pour gestion des modales, validation js des champs de rédaction de message, remplissage de la modale de lecture, utilisation d'un fetch pour changement dynamique d'état des messages
- Création du style css de la page de messagerie en récupérant la base de la page liste d'amis, et des modales de la page du hall avec correction du style des modales des quatre pages semblables (hall, mon compte, administration et messagerie)

### Difficultés

- Récupération de la réussite du changement d'état
- Contrainte de protection de la vie privée

### Solutions

- Passage de la réussite de la gestion du contrôleur du formulaire de changement d'état en format JSON pour que le fetch puisse le lire et dynamiquement modifier l'état du message visible
- Acceptation visuelle (message de succès) de l'envoi d'un message à une personne ayant bloqué l'expéditeur alors qu'aucun message n'est envoyé, et blocage de l'envoi vers un destinataire bloqué par l'expéditeur

---

## 21 Octobre au 01 Novembre

### Objectifs

- Ajout d'une nouvelle sorte de données : la zone d'effet des compétences
- Création des pages bibliothèque

### Réalisations

- Ajout dans le schéma SQL d'une table zones_effets qui est liée à la table compétences en tant que clé étrangère de cette dernière
- Création de l'objet ZoneEffet avec ses setters et getters
- Création du modèle ZoneEffetModele avec les fonctions nécessaires pour créer, lire, modifier et supprimer des zones d'effet de la base de données
- Modification de l'objet Competence et du modèle CompetenceModele pour inclure l'obligation d'avoir une zoneEffetId pour les compétences actives uniquement
- Création du contrôleur et de la vue d'entrée de la bibliothèque avec la navigation vers la création des données de la bibliothèque, la zone des équipements et la zone des compétences
- Création du css de l'entrée de la bibliothèque avec découpe en grid-template-area pour séparer et nommer les zones
- Création de la vue de la page de création de la bibliothèque avec une modale pour créer ou modifier les zones d'effet, une modale pour créer des équipements, une modale pour créer des maîtrises et une modale pour créer des compétences
- Création d'un fichier javascript lié à la page de création qui vérifie les différents champs des formulaires de création, remplit les informations des zones d'effet à modifier avec une fonction particulière pour les directions, ajoute dynamiquement des champs, générés via un template, pour les prérequis et modificateurs principaux des équipements et des compétences et permet l'ouverture et la fermeture des modales
- Création du contrôleur de la page de création avec gestion des formulaires, avec pour particularité la détection permettant de savoir si l'on crée une nouvelle zone d'effet ou si l'on modifie une zone d'effet existante, des transactions pour les équipements et les compétences avec des boucles sur les champs dynamiques
- Création du fichier css pour la page de création avec comme particularité la disposition en cercle des directions pour la modale des zones d'effet, la transformation des boutons de livres (en mobile) vers des pupitres (en desktop) avec changement de disposition et remplacement visuel du champ de fichier par un label mis en forme comme un bouton, le champ restant accessible au clavier, avec le nom du fichier affiché en dessous par JavaScript pour une meilleure lisibilité
- Création de la page de choix de catégorie des équipements, avec des liens générés à partir de la constante des catégories de l'objet Equipement, une bibliothèque à quatre étagères en mobile et une rangée de meubles répétés en desktop
- Choix d'un contrôleur par livre (équipements et compétences) plutôt qu'un contrôleur commun, la logique des deux livres étant trop différente
- Création du livre des équipements d'une catégorie, avec pour chaque équipement ses prérequis, ses modificateurs et ses caractéristiques secondaires, affiché en pages grâce aux colonnes CSS et feuilleté avec des flèches en JavaScript (une page en mobile, une double page en desktop)
- Ajout d'une modale de modification et de suppression des équipements réservée aux administrateurs, pré-remplie à partir de données JSON (interface JsonSerializable sur l'objet Equipement), avec un fichier JavaScript chargé uniquement pour les administrateurs
- Modification d'un équipement dans une transaction, en supprimant puis en recréant ses liaisons (ajout d'une fonction de suppression de toutes les liaisons dans ModeleLiaison), et suppression d'un équipement s'appuyant sur les ON DELETE CASCADE de la base
- Création d'une classe de service pour les compétences permettant le classement des compétences dans des recueils en fonction de leurs prérequis.
- Création de la page de sélection de recueils de compétences avec pour particularité de n’afficher les bibliothèques que si des recueils sont visibles et si l'utilisateur a bien débloqué une compétence dans ce recueil ou si il est administrateur
- Organisation des recueils en bibliothèques de trois et en rangées de quatre (array_chunk), affichées une bibliothèque à la fois en mobile (display: contents sur les rangées) et une rangée à la fois en desktop, avec des flèches gauche/droite ou haut/bas selon l'écran (matchMedia)
- Création de la page d'affichage du livre des compétences sous le même modèle que celui des équipements avec vérification des compétences affichables selon déblocage
- Ajout de JsonSerializable sur l'objet Competence, et regroupement du JavaScript de navigation des deux livres dans un fichier commun
- Envoi du bouton de suppression sans passer par la validation JavaScript du formulaire (event.submitter)

### Difficultés

- Affichage des icônes récupérées en base de données pour les zones d'effet
- Affichage de la sélection des directions des zones d'effet
- Récupération des informations d'un objet aux propriétés privées pour le JavaScript
- Affichage d'un nombre variable d'équipements par page selon la taille de l'écran
- Décalage progressif des pages à chaque clic sur les flèches
- Éléments positionnés (plume, flèche de retour) mal placés ou basculés sur une autre page du livre
- Pages dépassant la hauteur de l'écran selon sa taille
- Nombre de recueils variable, dépendant des maîtrises et des caractéristiques utilisées
- Restriction des compétences visibles selon le compte connecté

### Solutions

- Vérifications de la présence d'une icône, suivie de la création d’une URI de données en base64
- Définition des directions de la zone d'effet via un fieldset incluant des checkbox par direction valide
- Implémentation de l'interface JsonSerializable, avec une fonction jsonSerialize() indiquant les données à convertir
- Envoi de tous les équipements de la catégorie, répartis en pages par les colonnes CSS (column-count, break-inside: avoid)
- Mesure exacte de la largeur avec getBoundingClientRect() et calcul du numéro de page avant un scrollTo(), au lieu d'additionner des distances arrondies
- Séparation du décor (le livre) et de la zone qui défile, et positionnement de chaque élément par rapport au bon parent
- Ajout d'une niche (container-type: size) pour dimensionner les meubles sur la place réellement disponible, au lieu de la hauteur de l'écran
- Classement calculé à partir des prérequis par une classe de service, sans colonne supplémentaire en base, et affichage des seuls recueils non vides
- Filtrage dans la classe de service à partir de la table de déblocage, l'administrateur voyant tout et les compétences de base restant visibles par tous

---

## 22 Octobre

### Objectifs

- Mise à jour de sécurité

### Réalisations

- Découverte d'une faille de sécurité de PHP via un cas extérieur au site, prise de renseignement sur le problème de sécurité (failles CVE-2026-109618 et CVE-2026-109619, https://www.php.net/archive/2026.php#2026-10-21-5)
- Modification de la version docker de PHP apache vers une version comblant la faille de sécurité et passage vers une version dont les mises à jour de sécurité iront au-delà du 31/12/2026 (passage de php:8.2.12-apache à php:8.4.27-apache)
- Fixation de la version de l’extension MongoDB (2.5.5)
- Tour complet des pages pour vérifications de compatibilité avec la nouvelle version de php

---

## 01 au 08 Novembre

### Objectifs

- Création de la Taverne
- Mise en place des règles d'évolution des aventuriers
- Création de la fiche de création d'aventurier
- Création du magasin, réutilisable pour le dortoir

### Réalisations

- Création de la page de la taverne avec sa vue dirigeant vers la fiche de création d'aventurier, son contrôleur, et son css ayant une disposition mobile et une disposition desktop
- Création d'un fichier de configuration qui reprend les bases de l’évolution des caractéristiques principales, maîtrises et caractéristiques secondaires
- Création d'une classe Regles regroupant les calculs fixes (coût en PC d'une caractéristique ou d'une maîtrise par paliers, PV et PE de base), lisant ses valeurs dans le fichier de configuration
- Ajout d'une fonction rechercherTous() dans EquipementModele
- Création du contrôleur de la fiche de création d'aventurier, qui récupère toutes les informations des caractéristiques, maîtrises, compétences, zones d'effet et équipements, avec un chargement unique des noms des caractéristiques et des maîtrises, rangés par identifiant, pour éviter une requête par prérequis et par modificateur
- Réutilisation de la classe ClassementCompetences pour indiquer le recueil de chaque compétence sur la fiche
- Ajout de l'interface JsonSerializable aux classes Competence et Equipement, pour transmettre les données au JavaScript avec json_encode (avec les options JSON_HEX pour sécuriser l'insertion dans une balise script)
- Création de la vue de la fiche : nom, icône avec aperçu, caractéristiques secondaires dans des balises output, lignes de caractéristiques et de maîtrises avec boutons ±1 et ±10, tiroirs d'équipements par catégorie, liste des compétences, total des PC et bouton de signature
- Création de la vue du magasin, incluse dans une modale de la fiche, avec filtres par catégorie, caractéristique et maîtrise, catalogue, panier et total
- Création du JavaScript du magasin, séparé de celui de la fiche pour être réutilisé dans le dortoir : filtrage du catalogue, ajout au panier, modification de la quantité, suppression, coût par ligne et total, annulation, et renvoi du panier à la fiche par une fonction de rappel à la validation
- Création du JavaScript de la fiche :
  - affichage de l'inventaire dans les tiroirs de chaque catégorie au retour du magasin
  - modification des valeurs par les boutons et par la saisie, bornées entre le minimum et le maximum des règles
  - blocage de la touche Entrée dans les champs pour éviter un envoi accidentel
  - affichage des compétences dont les prérequis sont atteints, avec leurs modificateurs, recalculé à chaque changement de valeur
  - calcul du coût total en PC (caractéristiques et maîtrises par paliers, équipements selon leur prix et leur quantité)
  - calcul des caractéristiques secondaires, avec les bonus des compétences passives débloquées, y compris leurs bonus de Robustesse pour les PV et les PE
  - envoi du panier dans un champ caché au format JSON
  - validation du nom, de l'icône et des valeurs avant l'envoi, avec les bornes lues dans les règles
- Modification de la fonction ajouter() d'AventurierModele pour qu'elle retourne l'identifiant du nouvel aventurier
- Traitement du formulaire de création :
  - vérification des caractéristiques (toutes présentes, existantes, entières et dans les bornes des règles) et des maîtrises (existantes, entières et dans les bornes)
  - décodage et vérification de la structure du panier JSON
  - recalcul côté serveur des compétences atteintes, sans faire confiance au navigateur
  - transaction unique : création de l'aventurier, liaisons des caractéristiques, maîtrises, équipements (en inventaire) et compétences, puis déblocage pour le compte des compétences à prérequis non encore débloquées, avec retour en arrière complet en cas d'erreur
- Création du style css de la page de la feuille d'aventurier en version mobile et desktop, avec l'image de fond utilisant une copie de la feuille utilisée sur d'autres pages, mais avec un preserveAspectRatio="none", l'icône de l'aventurier intégrée dans un octogone créé via clip-path et avec un défilement interne des colonnes en desktop
- Création du style css de la modale du magasin en version mobile et desktop, avec un défilement du panier en mobile

---

## Prochaine étape

- Dortoir