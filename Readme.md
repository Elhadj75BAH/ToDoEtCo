# Description du besoin :

## Corrections d'anomalies :
Une tâche doit être attachée à un utilisateur
Actuellement, lorsqu’une tâche est créée, elle n’est pas rattachée à un utilisateur. Il vous est demandé d’apporter les corrections nécessaires afin qu’automatiquement, à la sauvegarde de la tâche, l’utilisateur authentifié soit rattaché à la tâche nouvellement créée.

Lors de la modification de la tâche, l’auteur ne peut pas être modifié.

Pour les tâches déjà créées, il faut qu’elles soient rattachées à un utilisateur “anonyme”.

### Choisir un rôle pour un utilisateur :
Lors de la création d’un utilisateur, il doit être possible de choisir un rôle pour celui-ci. Les rôles listés sont les suivants :

- rôle utilisateur (ROLE_USER) ;


- rôle administrateur (ROLE_ADMIN).


- Lors de la modification d’un utilisateur, il est également possible de changer le rôle d’un utilisateur.


### Implémentation de nouvelles fonctionnalités :

- Seuls les utilisateurs ayant le rôle administrateur (ROLE_ADMIN) doivent pouvoir accéder aux pages de gestion des utilisateurs.

- Les tâches ne peuvent être supprimées que par les utilisateurs ayant créé les tâches en question.

- Les tâches rattachées à l’utilisateur “anonyme” peuvent être supprimées uniquement par les utilisateurs ayant le rôle administrateur (ROLE_ADMIN).

### Implémentation de tests automatisés :
Il est demandé d’implémenter les tests automatisés (tests unitaires et fonctionnels) nécessaires pour assurer que le fonctionnement de l’application est bien en adéquation avec les demandes.

- Ces tests doivent être implémentés avec PHPUnit ; vous pouvez aussi utiliser Behat pour la partie fonctionnelle.

- Vous prévoirez des données de tests afin de pouvoir prouver le fonctionnement dans les cas explicités dans ce document.

- Il est demandé de fournir un rapport de couverture de code au terme du projet. Il faut que le taux de couverture soit supérieur à 70 %.

######
## Requirements :
- Apache 2.4

- PHP 7.2

- MySQL 5.7

- Composer


## Pour installer ce projet :

1 Clonez le dépôt depuis Github.

2 Installez les dépendances du projet
- composer install


3 N'oubliez pas de remplir le fichier .env de votre base de donnée comme :
- DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7

### Base de données avec doctrine

4 Créer la base de donnée si cette base n'existe pas encore
- bin/console doctrine:database:create

Mettre a jour les entités en base de donnée
- bin/console doctrine:schema:update -f

### Fixture :
5 Lancer les fixtures pour avoir des données de test en base
- bin/console doctrine:fixtures:load

6 Démarrer Votre serveur avec la commande ci-dessous :
- php -S localhost:8000 -t public
- sur votre navigateur écrire l'url :http://localhost:8000/

### Documentation du site :
Pour consulter la documentation  :
- l'url : 

- 


### Compte :
Pour vous connecter, vous pouvez vous inscrire directement depuis la page d'accueil.

Ou Saisir les accès ci-dessous dans la page "se connecter".



    
        Nom d'utilisateur: username0
        Mot de passe : password
    


# Annexe :
- Issues : https://github.com/Elhadj75BAH/TodoEtCo/issues




