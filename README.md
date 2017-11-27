***

## Déploiement de l'application Symfony3

#### 01 - Cloner le projet dans le dossier vide du site

#### 02 - Créer un utilisateur MySQL et la base de données associée.


#### 03 - Installer les dépendances :

```sh
# Installer composer s'il ne l'est pas déjà :
$ php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
$ php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
$ php composer-setup.php --install-dir=bin --filename=composer
$ php -r "unlink('composer-setup.php');"
```

```sh
$ composer install
# Attention : ne pas faire de `composer update` qui modifie les versions
```

Les paramètres à renseigner sont les suivants :
```sh
parameters:
    database_host: 127.0.0.1
    database_port: 3306
    database_name: EDITME
    database_user: EDITME
    database_password: EDITME

    mailer_transport: smtp
    mailer_host: EDITME
    mailer_user: EDITME
    mailer_password: EDITME
```

#### 04 - Créer la base de données :

```sh
$ php bin/console doctrine:schema:create
```

#### 05 - Créer les tables :

```sh
$ php bin/console doctrine:schema:update --force
```

#### 06 - Commande d'import :
```sh
$ php bin/console import:csv Table_Ciqual_2016.csv
```

***

## Informations utiles

### Version de Symfony : 3.4.0

### Version de PHP utilisée en développement : 7.1.8

### DocumentRoot : `./web`

### Modifier les paramètres de l'application :

Chemin relatif du fichier contenant les paramètres à renseigner :
`./app/config/parameters.yml`

### Vérifier la configuration requise pour Symfony3 :
```sh
$ php bin/symfony_requirements
```

### En cas de problème avec le cache Symfony3 :

Suivre ce [tutoriel](http://www.lafabriquedecode.com/blog/2014/05/symfony-2-en-finir-nettoyage-du-cache-via-cacheclear/).