# Gestion des plannings des élèves de Bachelor

## Présentation

Ce projet vise à fournir une application web de gestion des plannings pour les élèves de Bachelor. Il s'agit d'un projet pédagogique réalisé pour mettre en pratique le développement d'une interface web, la connexion à une base de données MySQL et la mise en place de fonctionnalités métiers autour des interventions, des modules et du corps enseignant.

Le dépôt correspond à une version en cours de développement. Certaines fonctionnalités sont déjà reliées à la base de données et utilisables, tandis que d'autres sont encore au stade de maquette ou d'intégration partielle.

## Aperçu fonctionnel cible

À terme, l'application doit permettre de :

- authentifier un utilisateur pour accéder au portail ;
- consulter un calendrier des interventions ;
- gérer les interventions programmées ;
- consulter et filtrer le corps enseignant ;
- consulter et modifier la fiche d'un enseignant ;
- gérer les modules ;
- gérer les types d'intervention.

## Technologies utilisées

Le projet repose actuellement sur :

- HTML
- CSS
- PHP
- MySQL

Outils et ressources associés :

- Figma : <https://www.figma.com/design/AJZ4aDQO3E0v3PW0HmlhmR/Enseignement-sup%C3%A9rieur---light?node-id=0-1&p=f&t=uacK3uZWILZf2u79-0>
- Git
- GitHub : <https://github.com/SlitherSwing/GestionPlanningLicence>

## État d'avancement

Statuts utilisés :

- `opérationnel` : fonctionnalité branchée et exploitable dans le dépôt actuel ;
- `partiel` : fonctionnalité entamée mais incomplète ;
- `maquette` : écran présent surtout pour la structure ou le design ;
- `manquant` : fonctionnalité prévue mais non implémentée à ce jour.

### Authentification et navigation

- `opérationnel` : portail de connexion avec vérification du mot de passe hashé via `password_verify` ;
- `opérationnel` : message d'erreur générique en cas d'identifiants invalides (sécurité par non-divulgation) ;
- `opérationnel` : protection des pages internes via `verifierConnexion()` (redirection vers `index.php` si pas de session) ;
- `opérationnel` : sidebar commune incluse sur toutes les pages protégées avec affichage du profil utilisateur ;
- `opérationnel` : fil d'Ariane sur les principales pages ;
- `manquant` : déconnexion (aucun lien ni script `logout.php` dans le dépôt).

### Corps enseignant

- `opérationnel` : liste des enseignants avec filtres dynamiques (nom, prénom, email) et pagination ;
- `opérationnel` : ajout d'un enseignant via la modale (insertion en `user` + `instructor` avec mot de passe par défaut hashé) ;
- `opérationnel` : fiche enseignant avec modification des informations générales (nom, prénom, email) et validation de l'email ;
- `opérationnel` : onglet "Interventions" de la fiche enseignant, avec filtres date début / date fin / module ;
- `opérationnel` : affichage des modules enseignés sur la fiche ;
- `partiel` : colonne "Nombre d'heures" qui affiche le `hours_count` du module et non un cumul réel par enseignant ;
- `partiel` : champ "Modules enseignés" présent dans la fiche infos mais non traité par le UPDATE serveur ;
- `manquant` : suppression d'un enseignant (aucun bouton ni fonction).

### Calendrier et interventions

- `opérationnel` : consultation du calendrier des interventions (lecture depuis `course`, tri par date décroissante) ;
- `partiel` : page globale des interventions — la liste s'affiche, mais les colonnes "Module" et "Type" affichent les IDs au lieu des noms, et la colonne "Intervenants" affiche "Non défini" en dur ;
- `partiel` : modale d'ajout d'intervention — l'interface est présente mais les sélecteurs de module et de type ne sont pas alimentés ;
- `partiel` : filtres de la page Interventions — les inputs existent mais leurs valeurs ne sont pas exploitées côté serveur ;
- `maquette` : modale de modification d'intervention (présente dans le HTML mais pas reliée à un parcours) ;
- `manquant` : persistance de l'ajout d'une intervention en base (aucune fonction `insertCourse`) ;
- `manquant` : modification d'une intervention (aucune fonction `updateCourse`) ;
- `manquant` : suppression d'une intervention (bouton présent dans la modale mais sans handler).

### Modules

- `partiel` : page de modules — la liste affichée est intégralement statique en HTML, sans lecture en base ;
- `manquant` : ajout d'un module branché à la base (le formulaire de `module-fiche.php` appelle par erreur `insertTypeIntervention` avec un nombre d'arguments incorrect) ;
- `manquant` : modification d'un module ;
- `maquette` : écran de suppression d'un module (`module-supprimer.html` non relié à du code serveur).

### Types d'intervention

- `opérationnel` : liste des types d'intervention chargée depuis `intervention_type` ;
- `opérationnel` : filtrage par nom (recherche LIKE) ;
- `opérationnel` : ajout d'un type d'intervention (insertion en base + validation des champs obligatoires) ;
- `manquant` : modification d'un type existant (la fiche ne charge pas le type ciblé et reste en mode "création") ;
- `maquette` : écran de suppression d'un type d'intervention (`types.intervention.supprimer.html` non relié à du code serveur).


## Démarrer le projet

### Prérequis

- XAMPP avec Apache et MySQL
- un accès à phpMyAdmin ou à un client MySQL
- une base de données locale nommée exactement `Gestion Licence`

### Installation locale

1. Placer le projet dans le dossier `htdocs` de XAMPP.
2. Démarrer Apache et MySQL depuis XAMPP.
3. Créer une base de données nommée `Gestion Licence`.
4. Configurer l'accès MySQL dans `require/credentials.php`.
5. Utiliser `Credentials.example.php` comme modèle de structure si nécessaire.
6. Préparer un jeu d'essai cohérent dans la base de données.
7. Ouvrir le point d'entrée local dans le navigateur.

Point d'entrée local :

- exemple avec l'arborescence actuelle : `http://localhost/projetFinal/projetFinal/public/index.php`
- si le dossier change de nom, adapter l'URL en conséquence

### Configuration de la connexion à la base

Le fichier réellement chargé à l'exécution est [`require/credentials.php`](require/credentials.php).

Un exemple de structure est fourni dans [`Credentials.example.php`](Credentials.example.php).

Important : Il faut adapter `host`, `dbname`, `user` et `password` à votre environnement local !

## Structure du projet

- [`public/`](public/) : point d'entrée web, pages PHP, maquettes HTML, feuilles de style et ressources statiques ;
- [`require/`](require/) : connexion PDO et fonctions de requêtes SQL utilisées par les pages ;
- [`DocumentationTechnique/`](DocumentationTechnique/) : éléments de conception, documentation technique et support visuel de la base.

## Base de données attendue

Le dépôt ne contient actuellement aucun export SQL. Pour comprendre la structure attendue, consulter aussi [`DocumentationTechnique/bdd.png`](DocumentationTechnique/bdd.png).

Tables minimales identifiées dans le code :

- `user` : comptes utilisateurs, identité, rôle et mot de passe ;
- `instructor` : entité enseignant liée à `user` ;
- `module` : modules d'enseignement ;
- `instructor_module` : table de liaison entre enseignants et modules ;
- `course` : interventions planifiées ;
- `course_instructor` : table de liaison entre interventions et enseignants ;
- `intervention_type` : types d'intervention.

Sans ces tables, plusieurs pages du projet ne pourront pas fonctionner.

## Jeu d'essai et authentification

Pour tester l'application, il faut au minimum :

- un utilisateur valide dans la table `user` ;
- une adresse e-mail connue pour se connecter ;
- un mot de passe stocké sous forme hashée compatible avec `password_verify` ;
- des données liées aux enseignants, modules, types d'intervention et interventions pour alimenter les vues.

Le portail de connexion repose sur la vérification PHP du mot de passe hashé. Un mot de passe enregistré en clair ne correspond pas au comportement attendu par le code.

## Ressources et dépendances externes

Le projet utilise également :

- la maquette Figma liée plus haut ;
- le dépôt GitHub pour le suivi du projet ;
- Google Fonts pour la police Poppins ;
- Material Symbols pour certaines icônes.

## Conventions actuellement visibles dans le dépôt

Les conventions observables sont les suivantes :

- séparation des pages publiques dans `public/` ;
- centralisation de la connexion PDO dans `require/credentials.php` ;
- centralisation des requêtes SQL dans `require/requete.php` ;

Ces conventions reflètent l'état actuel du dépôt, sans présumer d'une normalisation encore incomplète.

## Organisation du projet

Le projet a été découpé en sprints hebdomadaires suivis sur GitHub via les `milestones` et les `issues`. Le travail est réalisé en groupe de 4 + 1 élève en observateur, avec répartition des tâches entre les membres de l'équipe.
Enseignants et Intervenants sont égalements présents tout au long du projet afin d'assurer un suivi constant et de nous guider dans nos choix techniques et fonctionnels.
