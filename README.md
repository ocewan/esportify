# Esportify

Plateforme web dédiée à l’organisation et à la gestion de tournois e-sport.  
Projet réalisé dans le cadre de l'examen ECF du titre Développeur Web & Web Mobile.

## Présentation du projet

**Esportify** permet à trois types d’utilisateurs (joueur, organisateur, administrateur) de :

- Créer et gérer des événements compétitifs
- S’inscrire, participer, rejoindre des matchs
- Gérer ses favoris, son tableau de bord et son historique
- Visualiser les lives en cours ou à venir
- Utiliser des filtres dynamiques (AJAX), des tableaux de bord interactifs

## Structure du projet

esportify/
├── public/ # Fichiers accessibles (CSS, JS, images)
|── api/ # Requêtes AJAX asynchrones
├── views/ # Vues PHP (admin, orga, joueur)
├── config/ # Connexions à la BDD
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

1. Ouvrir `phpMyAdmin`
2. Créer une base nommée **esportify**
3. Aller dans **Importer**
4. Sélectionner le fichier `data/esportify.sql`
5. Lancer l'importation

### 3. Importer les données MongoDB (base de données noSQL sur les scores)

1. Décompresser `data/esportify.zip`
2. Ouvrir MongoDB Compass
3. Créer une base nommée `esportify`
4. Importer les fichiers `.json` par collection

### 4. Configurer l’accès base de données

Dans `config/db.php`, vérifier les informations de connexion :

```php
<?php
$pdo = new PDO("mysql:host=localhost;dbname=esportify;charset=utf8", "root", "");
```

- Utilisateur par défaut sous WAMP : `root`
- Mot de passe : vide

### 5. Lancer l’application

- Ouvrir un navigateur
- Entrer l’URL suivante :

```
http://localhost/esportify/public/index.php
```

---

## Lien de déploiement

À venir : [https://esportify.monapp.com](https://esportify.monapp.com)

---

## Contenu du dossier `/data`

- `esportify.sql` → création de la base de données relationnelle + données de test
- `esportify_nosql_dump.zip` → collections MongoDB exportées (contient la base de données noSQL avec une collection des scores)
- `README.md` → instructions d'importation

---

## Technologies utilisées

- HTML / CSS / SCSS
- PHP (POO légère)
- JavaScript (vanilla, fetch AJAX)
- MySQL
- MongoDB (pour la partie NoSQL)
- Git / GitHub

---

## Gestion Git (workflow)

- `main` → version stable
- `develop` → branche de développement continue
- `feature/...` → branches de tâches fonctionnelles :
  - `feature/dashboard`
  - `feature/api-cleanup`
  - `feature/deploiement`
  - `feature/final-check`

---

## Auteur

Projet réalisé par **Océane**  
Dans le cadre de l’ECF - Titre professionnel DWWM  
Session : Été 2025
