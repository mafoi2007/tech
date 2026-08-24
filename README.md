# 📘 Application de Gestion des Notes Scolaires

## 📌 Description
Cette application permet de gérer efficacement les notes des élèves dans un établissement scolaire. Elle offre des fonctionnalités pour l'enregistrement, la consultation, la modification et l'analyse des performances académiques.

## 🎯 Objectifs
- Faciliter la gestion des notes des élèves
- Automatiser les calculs de moyennes
- Permettre un suivi académique clair et structuré
- Offrir une interface simple pour les enseignants

## ⚙️ Fonctionnalités principales
- Ajout d'élèves
- Enregistrement des notes
- Modification et suppression des notes
- Calcul automatique des moyennes
- Classement des élèves
- Génération de bulletins

## 🏗️ Technologies utilisées
- Langage : PHP
- Framework : Aucun
- Base de données : MySQL
- Frontend : HTML, CSS, JavaScript

## 🚀 Installation
1. Cloner le dépôt :
```bash
git clone https://github.com/mafoi2007/guefigue.git
```
2. Accéder au dossier :
```bash
cd votre-projet
```
3. Installer les dépendances :
```bash
composer install
npm install
```
4. Configurer le fichier .env
5. Lancer le serveur :
```bash
php artisan serve
```

## 🧑‍🏫 Utilisation
## A LA PREMIERE UTILISATION
- Renommer le fichier inc/firstConnexion.done.php en firstConnexion.php
- Créer une base de données comportant le nom souhaité de l'application
- Aller adapter ce nom dans le fichier inc/connect.inc.php à la ligne 6
- A la première connexion, remplir les informations de base nécessaires.
## A PARTIR DES AUTRES UTILISATIONS
- Se connecter en tant qu'administrateur ou enseignant
- Ajouter des élèves
- Saisir les notes par matière
- Consulter les résultats et moyennes

## 📂 Structure du projet
- `app/` : logique métier
- `routes/` : gestion des routes
- `resources/views/` : interfaces utilisateur
- `database/` : migrations et seeds

## 🔐 Sécurité
- Authentification des utilisateurs
- Gestion des rôles (admin, enseignant)

## 🤝 Contribution
Les contributions sont les bienvenues !
1. Forker le projet
2. Créer une branche
3. Faire vos modifications
4. Soumettre une Pull Request

## 📄 Licence
Ce projet est sous licence MIT.

## 📞 Contact
Pour toute question ou suggestion, contactez le développeur
NYAMBI NGIKWA Richard : 
--> mafoi2007@gmail.com
--> +237675400828

## NOTES DE VERSION

v1.1.0
Ajout de la fonctionnalité de traitement des notes annuelles

v1.1.1
L'appui sur la touche Entree permet de passer d'une note à une autre et non plus de valider le formulaire

v1.1.2
Possiblité d'exporter les notes annuelles d'une classe en fichier EXCEL
Edition des bulletins annuels
Améllioration du traitement des notes annuelles