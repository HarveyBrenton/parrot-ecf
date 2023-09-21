# garage_parrot
ECF
un fichier readme.md contenant la démarche à suivre pour l’exécution en local
Ne pas oublier dans ce readme l’explication de la création d’un administrateur
pour le back-office de l’application web

## Présentation
# Projet Garage Automobile - Application Web Vitrine

Ce projet consiste à créer une application web vitrine pour le Garage V. Parrot, mettant en avant la qualité des services proposés par cette entreprise.

## Technologies utilisées

Serveur :
● Version PHP 8.2
● Extension PHP : PDO
● MariaDB (version 10.11)

Pour le front :
● HTML 5
● CSS 3
● JavaScript

pour le back :
● PHP 8.2 sous PDO
● MySQL

## Installation

1. Clonez ce dépôt vers votre machine locale :

   ```shell
   git clone https://github.com/HarveyBrenton/garage_parrot.git

## Fonctionnalités
# US1. Se connecter
'create_database.sql' : contient la base de données + tables.
'injectdata.php' : contient l'alimentation de la base de données.

La création de l'administrateur a été crée à partir du fichier 'injectdata.php' (comme pour pour toutes les autres créations fictives pour alimenter la database).

L'administrateur dispose d'un compte préalablement créé :
email : vincent.parrot@example.com
mot de passe : admin

Vous pouvez également vous connecter en tant qu'employé :
email : john.doe@example.com
mot de passe : employe_1

Seul l'administrateur peut générer un compte pour les employés :
Il dispose d'un tableau de bord Admin avec 3 options : créer un compte employé,
modifier la section 'services' de la page d'accueil' et modifier les horaires d'ouverture.

Pour les employés, une fois connecté, ils peuvent aussi accéder à leur tableau de bord.
Ils disposent de deux options : ajouter un nouveau véhicule et gérer les avis clients.

Les utilisateurs se connectent en utilisant leur adresse e-mail et un mot de passe sécurisé.

# US2. Présenter les services
Les services de réparation automobile proposés par le garage sont affichés sur la page d'accueil et dans une page 'services'.

# US4. Exposer les voitures d'occasion
Le site web présente les voitures d'occasion disponibles à la vente avec des photos, des descriptions détaillées et des informations techniques.
Chaque voiture affiche son prix, une image mise en avant, l'année de mise en circulation et le kilométrage.

# US5. Filtrer la liste des véhicules d’occasion
Un système de filtres permet aux visiteurs de rechercher des véhicules en fonction d'une fourchette de prix, d'un nombre de kilomètres parcourus ou d'une année de mise en circulation.

# US6. Permettre de contacter l'atelier
Les visiteurs peuvent contacter le garage par téléphone (infos en bas de page) ou en utilisant un formulaire de contact en ligne.
Le sujet du formulaire est automatiquement ajusté en fonction du titre de l'annonce.

# US7. Recueillir les témoignages des clients
Les visiteurs peuvent laisser des témoignages composés d'un nom, d'un commentaire et d'une note.
Les témoignages sont modérés par un employé du garage et s'affichent sur la page d'accueil.
Les employés du garage peuvent ajouter ou rejeter des témoignages clients directement depuis leur espace dédié.
