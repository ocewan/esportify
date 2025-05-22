# Données de la base pour Esportify

Ce dossier contient les bases de données à importer pour faire fonctionner le projet **Esportify**.

## Base de données relationnelle (MySQL)

**Fichier** : `esportify.sql`

### Pour l’importer :

- Ouvrir **phpMyAdmin**
- Créer une base nommée **esportify**
- Cliquer sur **Importer**
- Choisir le fichier `esportify.sql`
- Laisser les options par défaut et cliquer sur **Exécuter**

## Base de données non relationnelle (MongoDB)

**Fichier** : `esportify.scores.json`  
Contient des collections exportées manuellement depuis MongoDB Compass.

### Pour les utiliser :

- Dans **MongoDB Compass** :
  - Créer une base nommée `esportify`
  - Cliquer sur **+ Create Collection** pour chaque collection
  - Utiliser le bouton **Import** pour le fichier `.json`

## Notes

- Les identifiants et mots de passe de connexion ne sont **pas inclus**.
- Ne pas oublier d’ajuster le fichier `config/db.php` pour correspondre à la base locale.
