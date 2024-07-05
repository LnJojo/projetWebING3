# Omnes Sports

## Description
Omnes Sports est un site web qui permet aux utilisateurs de prendre rendez-vous avec des coachs sportifs spécialisés dans différentes disciplines telles que la musculation, le biking, le football, le basketball, et bien d'autres.

## Fonctionnalités
- Inscription et connexion des utilisateurs
- Prise de rendez-vous avec des coachs sportifs
- Navigation à travers différentes disciplines sportives
- Consultation des informations et des profils des coachs

## Technologies
- PHP
- Bootstrap
- HTML/CSS
- JavaScript
- MySQL (ou autre base de données relationnelle)

## Installation
### Prérequis
- Serveur web (Apache, Nginx, etc.)
- PHP 7.x ou supérieur
- Base de données MySQL

### Étapes d'installation
1. Clonez ce dépôt :
    ```bash
    git clone https://github.com/votre-utilisateur/omnes-sports.git
    cd omnes-sports
    ```

3. Configurez votre base de données :
    - Créez une base de données MySQL
    - Importez les tables nécessaires à partir du fichier `database.sql` (ou similaire) fourni dans le dépôt

4. Configurez les variables d'environnement pour votre base de données dans un fichier `.env` :
    ```env
    DB_HOST=127.0.0.1
    DB_NAME=omnes_sports
    DB_USER=root
    DB_PASS=password
    ```

5. Démarrez votre serveur web et assurez-vous que le site est accessible.

## Utilisation
### Interface de Connexion
Les utilisateurs peuvent se connecter via une interface de connexion simple en entrant leur email, mot de passe, et en sélectionnant leur rôle (Coach ou Utilisateur).

![Connexion](https://github.com/LnJojo/projetWebING3/assets/22354147/ddb6414a-f878-4881-8349-eda90eb8a894)

### Page d'Accueil
La page d'accueil présente les différentes disciplines sportives et des informations sur les événements à venir.

![Accueil](https://github.com/LnJojo/projetWebING3/assets/22354147/86980aad-e219-4155-a531-f2618ed8e890)

### Disciplines Sportives
Les utilisateurs peuvent naviguer à travers différentes disciplines sportives comme la musculation et le fitness.

![Disciplines](https://github.com/LnJojo/projetWebING3/assets/22354147/6e278e77-3f4d-4254-acf1-1879acfdd411)

### Prise de Rendez-vous
Les utilisateurs peuvent prendre rendez-vous avec des coachs en sélectionnant une date et une heure disponibles.

![Rendez-vous](https://github.com/LnJojo/projetWebING3/assets/22354147/fceae298-980a-47a0-877f-259ea5588065)

