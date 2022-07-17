# Description du besoin :
![image-todo](https://user-images.githubusercontent.com/52566974/179390495-2fb2343e-9464-49ed-b3cf-e8d6b7779131.png)


## Corrections d'anomalies :
Une tâche doit être attachée à un utilisateur
Actuellement, lorsqu’une tâche est créée, elle n’est pas rattachée à un utilisateur. Il vous est demandé d’apporter les corrections nécessaires afin qu’automatiquement, à la sauvegarde de la tâche, l’utilisateur authentifié soit rattaché à la tâche nouvellement créée.

Lors de la modification de la tâche, l’auteur ne peut pas être modifié.

Pour les tâches déjà créées, il faut qu’elles soient rattachées à un utilisateur “anonyme”.

----
### Choisir un rôle pour un utilisateur :
Lors de la création d’un utilisateur, il doit être possible de choisir un rôle pour celui-ci. Les rôles listés sont les suivants :

- rôle utilisateur (ROLE_USER) ;


- rôle administrateur (ROLE_ADMIN).


- Lors de la modification d’un utilisateur, il est également possible de changer le rôle d’un utilisateur.

---
### Implémentation de nouvelles fonctionnalités :

- Seuls les utilisateurs ayant le rôle administrateur (ROLE_ADMIN) doivent pouvoir accéder aux pages de gestion des utilisateurs.

- Les tâches ne peuvent être supprimées que par les utilisateurs ayant créé les tâches en question.

- Les tâches rattachées à l’utilisateur “anonyme” peuvent être supprimées uniquement par les utilisateurs ayant le rôle administrateur (ROLE_ADMIN).
---
### Implémentation de tests automatisés :
Il est demandé d’implémenter les tests automatisés (tests unitaires et fonctionnels) nécessaires pour assurer que le fonctionnement de l’application est bien en adéquation avec les demandes.

- Ces tests doivent être implémentés avec PHPUnit ; vous pouvez aussi utiliser Behat pour la partie fonctionnelle.

- Vous prévoirez des données de tests afin de pouvoir prouver le fonctionnement dans les cas explicités dans ce document.

- Il est demandé de fournir un rapport de couverture de code au terme du projet. Il faut que le taux de couverture soit supérieur à 70 %.

---
## Requirements :
- Apache 2.4

- PHP 7.2

- MySQL 5.7

- Composer


## Version du projet
 
- symfony 5.4 
---
## Pour installer ce projet :

1 Clonez le dépôt depuis Github.

2 Installez les dépendances du projet

    composer install


3 N'oubliez pas de remplir le fichier .env de votre base de donnée comme :

    DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7

### Base de données avec doctrine
Vous pouvez taper la commande ci-dessous pour créer et charger les fixtures  à la base de données

    composer preparedata

### Base de données avec doctrine manière détaillées

4 Créer la base de donnée si cette base n'existe pas encore

    bin/console doctrine:database:create

Mettre à jour les entités en base de donnée

    bin/console doctrine:schema:update -f

### Fixture :
5 Lancer les fixtures pour avoir des données en base

    bin/console doctrine:fixtures:load

6 Démarrer Votre serveur avec la commande ci-dessous :

    php -S localhost:8000 -t public
- sur votre navigateur écrire l'url :http://localhost:8000/

---
## Préparation tests  :

### Préparer vos données de test en un temps record

Pour créer, mettre à jour et charger les fixtures de la base de données de l'environement de test en une commande :

    composer preparedatatest

Ou bien suivre les étapes de manière détaillées ci-dessous

-----


Pour créer la base de donnée de l'environement de test :

    php bin/console --env=test doctrine:database:create

Créer les tables de l'environement de test

    php bin/console --env=test doctrine:schema:create

### Astuce :

    Une pratique courante consiste à ajouter le _test 
    (suffixe) au nom de la base de données d'origine dans les tests. 
    Si le nom de la base de données en production est
    appelé par exemple, project8. 
    Le nom de la base de données de test 
    pourrait être project8_test.

Pour charger les données que nous avons préparées dans la base de l'environement de test :

    php bin/console --env=test doctrine:fixtures:load

## Les tests Unitaires :
Tapez les commandes ci-dessous 

Pour faire les tests unitaires de l'entité User :

    php bin/phpunit tests/Entity/UserEntityTest.php --testdox

Pour faire les tests unitaires de l'entité Task : 

    php bin/phpunit tests/Entity/TaskTest.php --testdox

## Les tests fonctionnels
Tapez les commandes ci-dessous

Pour le DefaultController : 

    php bin/phpunit tests/Controller/DefaultControllerTest.php --testdox
Pour TaskController :

    php bin/phpunit tests/Controller/TaskControllerTest.php --testdox
Pour le UserController : 

    php bin/phpunit tests/Controller/UserControllerTest.php --testdox

### Compte :
Pour pouvoir vous connecter, vous devez vous inscrire directement depuis la page d'accueil.

Ou Saisir les accès ci-dessous dans la page "se connecter".

Nom d'utilisateur: 

    Username1
Mot de passe : 

    password

### compte admin:

    admin
mot de passe:

    azert123


# Annexe :
- Issues : https://github.com/Elhadj75BAH/TodoEtCo/issues
- Code climate : https://codeclimate.com/github/Elhadj75BAH/ToDoEtCo
- coverage-test ![image-coverage-generate-tests](https://user-images.githubusercontent.com/52566974/179390572-5c79cef5-1fe0-45de-bce9-36812cc3b2b9.png)





