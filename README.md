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
├── .gitignore
└── ...

## Installation du projet en local (environnement de test)

### Prérequis importants

- Un environnement local installé : **WAMP**, **XAMPP** ou **Laragon**
- PHP version ≥ 7.4
- MySQL (phpMyAdmin recommandé)
- Git installé

### 1. Cloner le projet

Ouvrir un terminal puis exécuter :

```bash
git clone https://github.com/votre-utilisateur/esportify.git
cd esportify
```

Copier le dossier dans le répertoire web de votre environnement local, par exemple :

```bash
C:/wamp64/www/esportify
```

### 2. Importer la base de données (relationnelle)

- Ouvrir `phpMyAdmin`
- Créer une base nommée **esportify**
- Aller dans **Importer**
- Sélectionner le fichier `data/esportify.sql`
- Lancer l'importation

### 3. Importer les données MongoDB (base de données noSQL sur les scores)

- Ouvrir MongoDB Compass
- Etablir la connexion en local
- Dans cette connexion appuyer sur "Créer une base de données"
- Créer une base nommée `esportify`
- Importer les fichiers `.json` par collection (dossier data/)

### 4. Configurer l’accès base de données

Dans `config/db.php`, vérifier les informations de connexion :

```php
<?php
$pdo = new PDO("mysql:host=localhost;dbname=esportify;charset=utf8", "root", "");
```

- Utilisateur par défaut sous WAMP : `root`
- Mot de passe : vide

### 5. Créer un virtual host (exemple sous WAMP)

Pour accéder à l’application avec une URL propre comme http://esportify.local, il est recommandé de créer un Virtual Host.

- Ouvrir WAMP et vérifier que les connexions sont actives (vert)
- Clic gauche sur l'icône WAMP
- Dans Apache aller sur httpd-vhosts.conf
- Ajouter le virtual host en ajoutant tout en bas

```
  <VirtualHost \*:80>
  ServerName esportify.local
  DocumentRoot "C:/wamp64/www/esportify/public"
  <Directory "C:/wamp64/www/esportify/public">
  AllowOverride All
  Require all granted
  </Directory>
  </VirtualHost>
```

- Redémarrer WAMP
- S'assurer que dans notre fichier C:\Windows\System32\drivers\etc\hosts on a :
  127.0.0.1 espotify.local

### 6. Lancer le site

- Ouvrir un navigateur
- Entrer l’URL suivante :

```
http://esportify.local/

```

## Lien de déploiement

Le site web a été déployé sur Always Data et est disponible à l'adresse suivante :

https://ocewan.alwaysdata.net

## Contenu du dossier `/data`

- `esportify.sql` → création de la base de données relationnelle + données de test
- `esportify.scores.json` → collections MongoDB exportées (contient la base de données noSQL avec une collection des scores)
- `README.md` → instructions d'importation

### Contenu du dossier `vendor/`

Le dossier `vendor/` contient les dépendances nécessaires à la connexion MongoDB via PHP, installées avec Composer.  
Bien qu’il ne soit normalement pas versionné, **il est volontairement inclus dans ce projet** pour permettre à l’évaluateur de :

- Tester la partie NoSQL localement sans avoir à réinstaller Composer
- Éviter toute erreur liée à `autoload.php` ou aux classes MongoDB manquantes

Ce dossier n’est pas utilisé sur le serveur AlwaysData, où MongoDB est désactivé automatiquement.

## Auteur

Projet réalisé par **Océane**  
Dans le cadre de l’ECF - Titre professionnel DWWM  
Session : Septembre/Octobre 2025
