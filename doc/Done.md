07 Juin 2012
============

Rappel des diapos de présentations ezc :  
eZ Components Tutorial : http://talks.php.net/show/ezc-winter09  
eZ Components Perspective : http://talks.php.net/show/ezc-ezconf9  

1. Mise en place de la structure du projet
------------------------------------------

- Importation dans lib/ des librairies Base et Document des eZ Components à partir de celles présentes dans pear  
- Réattribution du propriétaire et des droits d'accès aux fichiers  

2. Documentation sur le composant _Document_
--------------------------------------------

- _Suivi des tutos présents sur le site des eZ Components_  

Localisation du tutorial _Base_ : http://ezcomponents.org/docs/api/trunk/introduction_Base.html  
Localisation du tutorial _Document_ : http://ezcomponents.org/docs/api/trunk/introduction_Document.html  

        + Création d'un répertoire pour les sources du tutos dans src/  
        + Création d'un répertoire de documentation des tutos dans doc/  

J'ai suivi le tuto du composant _Base_ mais je n'ai pas réussi à gérer correctement l'autoload des classes.  
A chaque fois j'obtenais une erreur de référence absente d'un dossier _autoload/_ devant être situé dans les ezc.  
Egalement, une mauvaise gestion de mes chemins (chemin vers le bootstrap dans l'autoload, chemin vers l'autoload dans le tuto, dépendants du chemin d'exécution également) ne m'ont pas permis d'avancer. Je suis passé par une solution intermédiaire alternative :  

        + Création annexe d'un répertoire de travail pour m'initier au composant Document en utilisant les composants présents sous pear

J'en ai profité pour suivre proprement dans ce nouveau répertoire le tutorial des composants _Base_ et _Document_. Là, pas d'erreur de chargement.  

        + Reprise du tuto _Base_

J'ai appris le préchargement ainsi que l'ajout des répertoires de classes situées à l'extérieur des eZ Components au système de chargement automatique.  
(cf. /doc/tutorial/Base/Base.md)  

        + Reprise du tuto _Document_

cf. RST [ToDo]

        + Fin de journée : reprise du projet

Après retour sur l'existant, il s'avère que les ezc issus de pear ne sont pas totalement autonomes.  
Reprise du projet en remplaçant les composants issus de pear par les composants tirés du package téléchargé à cette adresse : http://ezcomponents.org/download  

        + Reprise du tuto _RST_ de _Document_

(cf. /src/tutorial/RST/RST_base_handler.php)

Je fournis un document (rst_base_handler.txt) qui est chargé et parsé dans un arbre suivant une structure abstraite.  
Chaque erreur de parsing ou de compilation est transformée en une exception, de sorte que l'on soit informé.  
Les paramètres de rapport d'erreur peuvent être modifiés comme pour tous les handlers.  
La structure est alors convertie au format Docbook. [Format à documenter]  
Le résultat est retourné sous la forme d'une chaine de caractères.  (cf. /src/tutorial/RST/resultat_console.php)

