# Esportify

Plateforme web dédiée à l’organisation et à la gestion de tournois e-sport.  
Projet réalisé dans le cadre de l'examen ECF du titre Développeur Web & Web Mobile.

## Présentation du projet

Esportify permet à quatre types d’utilisateurs (visiteur, joueur, organisateur, administrateur) de :

- Visiter la plateforme et les évenements disponibles
- Créer et gérer des événements compétitifs
- S’inscrire, participer, rejoindre des matchs
- Gérer ses favoris, son tableau de bord et son historique
- Visualiser les lives en cours ou à venir
- Utiliser des filtres dynamiques (AJAX), des tableaux de bord interactifs

## Structure du projet

esportify/
├── public/ # Fichiers accessibles (CSS, JS, images)
| |── api/ # Requêtes AJAX asynchrones
├── views/ # Vues PHP (admin, orga, joueur, event)
├── config/ # Connexions aux BDD
├── controllers/ # Traitement des formulaires
├── data/ # Fichiers SQL & JSON (bases de données à importer)
├── scripts/ # Fonctions supplémentaires
├── helpers/ # Auth & outils
├── README.md
├── Dockerfile # Image personnalisée
|── docker-compose.yml # Config Docker
└── ...

## Installation du projet en local (environnement de test)

J’ai conteneurisé ce projet via Docker pour simplifier l’installation locale.

### Prérequis importants

- Docker Desktop (et WSL2 activé pour Windows)
  vous pouvez le trouvez sur https://www.docker.com/products/docker-desktop
- Git installé

### 1. Cloner le projet

Ouvrir un terminal puis exécuter :

```bash
git clone https://github.com/ocewan/esportify.git
cd esportify
```

### 2. Lancer les conteneurs Docker

- dans le terminal à la racine du dossier

```bash
docker-compose up --build
```

### 3. Base de données (relationnelle)

- Le script data/esportify.sql est exécuté automatiquement
- un utilisateur esport avec le mot de passe esportpass est crée

### 4. Importer les données MongoDB (base de données noSQL sur les scores)

- dans le terminal il va falloir importer manuellement la base noSQL

```bash
docker exec -it esportify-mongo-1 mongoimport \
  --db esportify \
  --collection scores \
  --file /import/esportify.scores.json \
  --jsonArray
```

- esportify-mongo-1 correspond au nom du conteneur (que l'on peut vérifier avec docker ps)

### 6. Lancer le site

- une fois démarré on peut accéder à l'application
- Ouvrir un navigateur
- Entrer l’URL suivante :

```
http://localhost:8080

```

- pour arrêter le projet

```bash
docker-compose down
```

## Lien de déploiement

Le site web a été déployé sur Always Data et est disponible à l'adresse suivante :

https://ocewan.alwaysdata.net

## Contenu du dossier `/data`

- `esportify.sql` → création de la base de données relationnelle + données de test
- `esportify.scores.json` → collections MongoDB exportées (contient la base de données noSQL avec une collection des scores)
- `README.md` → instructions d'importation

## Contenu du dossier `vendor/`

Le dossier `vendor/` contient les dépendances nécessaires à la connexion MongoDB via PHP, installées avec Composer.  
Bien qu’il ne soit normalement pas versionné, **il est volontairement inclus dans ce projet** pour permettre à l’évaluateur de :

- Tester la partie NoSQL localement sans avoir à réinstaller Composer
- Éviter toute erreur liée à `autoload.php` ou aux classes MongoDB manquantes

Ce dossier n’est pas utilisé sur le serveur AlwaysData, où MongoDB est désactivé automatiquement.

## Dockerfile

Le `Dockerfile` permet de créer un environnement PHP 8.3 avec Apache configuré pour exécuter mon projet.

## Fichier docker-compose.yml

Ce fichier définit trois services :

web, mysql et mongo

- pour les volumes : `dbdata` et `mongodb_data` permettent de conserver les données même si les conteneurs sont supprimés.

## Connexions à la base de données dans Docker

Dans le fichier `docker-compose.yml`, les conteneurs `mysql` et `mongo` sont accessibles via leur nom de service (`mysql` et `mongo`).

# MySQL

La connexion PDO se fait via :

```php
$pdo = new PDO('mysql:host=mysql;port=3306;dbname=esportify', 'esport', 'esportpass');
```

# MongoDB

La connexion se fait via :

$client = new MongoDB\Client("mongodb://mongo:27017");
$scoreCollection = $client->esportify->scores;

## Auteur

Projet réalisé par **Océane**  
Dans le cadre de l’ECF - Titre professionnel DWWM  
Session : Septembre/Octobre 2025
