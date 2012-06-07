Tutorial du composant _Base_
=================================

Description
-----------

Le composant _Base_ fournit les fonctionnalités de base, telles que le chargement automatique, dont tous les eZ Components ont besoin pour fonctionner correctement. Le composant _Base_ doit être chargé spécifiquement. Base peut charger automatiquement des répertoires externes contenant des classes en dehors des eZ Components.  
Mis à part la fonctionnalité de chargement automatique, le composant _Base_ contient également un certain nombre de classes d'exceptions génériques qui héritent toutes de la classe ezcBaseException.  

Suivi du tutorial
-----------------

_Préchargement des classes :_  

Par défaut, l'autoload des eZ Components charge les classes à la demande. Il est également possible de charger toutes les classes d'un composant d'un seul coup quand une des classes du composant est demandée pour la première fois.  
Ce comportement est modifiable avec le préchargement qui est disponible par le biais des options de la classe ezcBaseAutoloadOptions.  
Le préchargement est activable de la manière suivante :  
  
        <?php
        $options = new ezcBaseAutoloadOptions;
        $options->preload = true;
        ezcBase::setOptions( $options );
        ?> 

On notera que le préchargement n'est pas fait pour les classes d'exceptions.  

_Ajout des répertoires des classes situées à l'extérieur des eZ Components au système de chargement automatique_

Il peut être utile d'ajouter au système de chargement automatique des répertoires contenant des classes personnelles.  
La méthode ezcBase::addClassRepository() peut être utilisée pour effectuer cette tâche.  
Il est nécessaire d'organiser les classes externes que l'on désire charger dans un répertoire spécifique. Une fois fait, il faut s'assurer que les classes et les fichiers * _autoload.php correspondants à ces classes sont nommés et placés selon les explications ci-après. une fois structurés de manière adéquate, on peut appeler addClassRepository() avec les paramètres appropriés avant d'utiliser les classes externes. Ces dernières seront alors chargées par le système de chargement automatique.  

ezcBase::addClassRepository() prend deux arguments:  
        $ basePath est le chemin de base pour le dépôt toute la classe.
        $ autoloadDirPath est le chemin où les fichiers autoload pour ce dépôt se trouvent.  

Les chemins dans les fichiers autoload ne sont pas relatifs au répertoire du package des classes externes, comme spécifié par l'argument $basePath. En d'autres termes, les fichiers contenant les classes ne seront seulement recherchés dans l'emplacement spécifié par l'argument $autoloadDirPath.  

Prenons l'exemple suivant:  

        + Nous avons un répertoire contenant nos classes : "./repos".
        + Les fichiers d'autoload pour ce répertoire sont stockés dans "./repos/autoload".
        + Il y a deux composants dans ce répertoire : «Me» et «You».
        + Le composant "Me" contient des classes "erMyClass1" et "erMyClass2".
        + Le composant "You" contient des classes "erYourClass1" et "erYourClass2".

Dans ce cas, il faut créer les fichiers décits ci-après dans "./repos/autoloads". Le préfixe de _autoload.php («my» et «your») dans le nom du fichier est la première partie du nom de la classe (hors préfixe en minuscules du mon de la classe, ici "er").  

Contenu de _my_autoload.php_:  

        <?php
        return array (
        'erMyClass1' => 'Me/myclass1.php',
        'erMyClass2' => 'Me/myclass2.php',
        );
        ?> 

Contenu de _your_autoload.php_:  

        <?php
        return array (
        'erYourClass1' => 'You/yourclass1.php',
        'erYourClass2' => 'You/yourclass2.php',
        );
        ?> 

Arborescence :  

        ./repos/autoloads/my_autoload.php
        ./repos/autoloads/your_autoload.php
        ./repos/Me/myclass1.php
        ./repos/Me/myclass2.php
        ./repos/You/yourclass1.php
        ./repos/You/yourclass2.php

Pour utiliser le mécanisme de chargement automatique, on utilise le code suivant :  

        <?php
            require_once 'tutorial_autoload.php';
            ezcBase::addClassRepository( './repos', './repos/autoloads' );
            $myVar1 = new erMyClass2();
            $myVar1->toString();
            $yourVar1 = new erYourClass1();
            $yourVar1->toString();
            ?> 

Le code ci-dessus va afficher :  

          Class 'erMyClass2'
          Class 'erYourClass1'

[ToDo]
