Workflow 

/ ! \ Quand on utilise Docker il faut faire les installation dans le container Docker :
docker exec -ti < Id ContainerName > /bin/bash 

DANS LE CONTAINER DOCKER  : 

Annotations : 
- composer require doctrine/annotations

TWIG : 
- composer require "twig/twig:^2.0"
- composer require symfony/twig-bundle

Comment créer une base de donnée ? 

Doctrine est un ORM (couche d'abstraction à la base de données) pour PHP.
Doctrine est l'ORM par défaut du framework Symfony (depuis la version 1.3 de ce framework). Cependant, son utilisation dans le cadre d'un projet développé avec Symfony est optionnelle.

1. Installer la base donner dans le projet, Symfony   c.à.d  Installer les packtages de Doctrine DANS LE CONTAINER DOCKER  dossier html : 

- composer require doctrine/orm
- composer require symfony/orm-pack  (permet d’avoir les info de la datable dans .env )
- composer require --dev symfony/maker-bundle


2. Configuration de la base de donnée dans .env : 


Dans le fichier .env  Configuration de la base de donnée Exemple pour une connexion MySQL :


/ ! \ Bien mettre les informations sous forme de string
—> https://www.youtube.com/watch?v=tRI6KFNKfFo&ab_channel=YoanDev 


DATABASE_URL="mysql://<USERNAME>:<PASSWORD>@<ACCESS_HOST_URL>:3306/<DATABASE_NAME>?serverVersion=8.0"

DATABASE_URL="mysql://root:ChangeMeLater@mariadb_docker:3306/symfony_db?serverVersion=mariadb-10.7.1"


3. Pour créer une database avec doctrine : 

- php bin/console doctrine:database:create
OU 
- symfony console doctrine:database:create
- symfony console d:d:c
[18:15]
Créer une entité :

symfony console make:entity Product

Nouveau dossier + fichier : 
created: src/Entity/Product.php
created: src/Repository/ProductRepository.php

- Sur les entités on met des Validator pour entretenir la cohérence des données.


On répond aux questions : 


Faire une migration vers la base de donnée : 

Migrations: Creating the Database Tables/Schema

- php bin/console make:migration
- php bin/console doctrine:migrations:migrate

Pour la première création d’entité nous avons notice] Migrating up to DoctrineMigrations\Version20221015225611.
[18:15]
Créer un Controller 

The Symfony MakerBundle  :

Installation : composer require --dev symfony/maker-bundle
https://symfony.com/bundles/SymfonyMakerBundle/current/index.html 



- symfony console make:controller ProductController

Cette commande va créer :
* Un fichier src/Controller/ProductController.php qui sera notre contrôleur
* Un fichier templates/product/index.html.twig qui sera notre vue par défaut

 OU 
- php bin/console make:controller ProductController



https://nouvelle-techno.fr/articles/7-creation-des-controleurs-symfony-6
SymfonyMakerBundle Documentation
Official documentation of SymfonyMakerBundle, a bundle for Symfony applications

7 - Création des contrôleurs (Symfony 6) - Nouvelle-Techno.fr
Dans cette 7ème partie nous allons créer les contrôleurs de notre projet e-commerce.Les contrôleurs vont servir à créer et gérer les “routes” ou les différentes adresses de notre site.Nous avons déjà dans notre projet le MainController dont le code est le suivant<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Abst...