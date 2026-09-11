# Ju Coach Sportif

Application web de coaching sportif e-commerce — Projet DWWM Titre Professionnel Niveau 5.

## Stack technique

- **Back-end** : PHP 8.3 (POO, sans framework)
- **Front-end** : HTML5, CSS3, JavaScript ES6+ (vanilla)
- **BDD relationnelle** : MySQL 8.0
- **Serveur web** : Nginx
- **Conteneurisation** : Docker + Docker Compose
- **Mails** : PHPMailer 6.x
- **Tests** : PHPUnit 11.x

## Déploiement local (développement)

### Prérequis

- Docker Desktop
- Git

### Installation

**1. Cloner le projet**

git clone https://github.com/thomas-bruston/juCoach.git
cd juCoach


**2. Créer le fichier d'environnement**

cp .env.example .env


**3. Lancer les conteneurs**

docker compose up -d

**4. Installer les dépendances**

docker compose exec app composer install


**5. Ouvrir l'application**

- Site : (http://localhost:8081)
- PhpMyAdmin : (http://localhost:8084)

## Comptes de test


 Administrateur  ju@jucoachsportif.com  Test12345! 
 Utilisateur  client@test.com Test12345! 
 Utilisateur  client2@test.com Test12345! 

## Lancer les tests


docker compose exec app ./vendor/bin/phpunit


Projet réalisé dans le cadre du Titre Professionnel DWWM (TP-01280, Millésime 04) @2026
