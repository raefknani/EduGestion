
# EduGestion

Application web de gestion universitaire développée
avec Symfony, PHP, Twig, Bootstrap et MySQL.

## Fonctionnalités

### Gestion des notes
- Ajouter une note
- Afficher les notes
- Modifier une note
- Supprimer une note
- Rechercher et filtrer les notes

### Gestion des absences
- Ajouter une absence
- Afficher les absences
- Modifier une absence
- Supprimer une absence
- Rechercher et filtrer les absences

### Gestion des salles
- Ajouter une salle
- Afficher les salles
- Modifier une salle
- Supprimer une salle
- Rechercher et filtrer les salles

## Technologies

- PHP
- Symfony
- Doctrine ORM
- Twig
- Bootstrap 5
- MySQL
- Composer

## Installation

1. Installer PHP, Composer et MySQL.
2. Télécharger ou copier le projet.
3. Ouvrir un terminal dans le dossier du projet.
4. Installer les dépendances :

   composer install

5. Configurer DATABASE_URL dans .env.local.
6. Créer la base de données si nécessaire :

   php bin/console doctrine:database:create

7. Exécuter les migrations :

   php bin/console doctrine:migrations:migrate

8. Démarrer le serveur :

   symfony server:start

## Accès

Accueil : http://127.0.0.1:8000/

Notes : http://127.0.0.1:8000/note/

Absences : http://127.0.0.1:8000/absence/

Salles : http://127.0.0.1:8000/salle/

## Auteur

Projet académique de gestion universitaire.
