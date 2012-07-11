10 & 11 Juillet 2012
============

- Compréhension d'un visiteur d'objet
Apprentissage de ce qu'est un visiteur, essaie d'implémentation d'une classe visiteur pour les fichiers au format ezXML

[...]

29 Juin 2012
============

- Tests des fonctions de la classe de conversion 
cf. src/project/EzcDocumentEzXmlToRstConverter

Apprentissage de DOM Document de php (tests de parsage sur divers fichiers xml...)

28 Juin 2012
============

- Tests des fonctions de la classe de conversion 
cf. src/project/EzcDocumentEzXmlToRstConverter

Utilisation de DOM Document de php :
        + tests de parsage sur divers fichiers xml
        + tests de validation suivant des dtd/xsd
        + recherche d'une dtd/xsd valide sur le format ezxml

27 Juin 2012
============

- Modification de la classe de conversion 
cf. src/project/EzcDocumentEzXmlToRstConverter

Repérage des failles de conversion, sur le balisage customisé.
Apprentissage de l'utilisation de DOM Document de php (Article intéressant sur PHP Solutions N°7, 08/2010)

26 Juin 2012
============

- Modification de la classe de conversion 
cf. src/project/EzcDocumentEzXmlToRstConverter

- Recherche du XSD du eZ XML :
        + http://doc.ez.no/doc/Extensions/eZ-Publish-extensions/eZ-XML-Export/eZ-XML-Export-1.3-user-manual/Content-class-definition-configuration

- Mise en place d'interfaces ezcDocumentRstEzXmlDirective et ezcDocumentRstEzXmlTextRole pour la prise en charge des directives et des rôles lors de la conversion  
cf. src/project/interfaces/  

25 Juin 2012
============

        + Mise à jour du script de conversion, création de la classe de conversion

Je m'appuie sur la classe ezcDocumentRst, surtout sa partie getAsXhtml()  

22 Juin 2012
============

        + Apprentissage des directives et rôles du format RST

Identification des Directives et rôles particuliers pouvant poser problème lors de la conversion du RST en Docbook.  
Analyse du document http://docutils.sourceforge.net/docs/ref/rst/directives.html  

21 Juin 2012
============

        + Rédaction de la documentation sur le format RST

cf. /doc/documentation/RST  

Je suis en cours de documentation (au format RST) du langage RST.  
Gist temporaire de travail : https://gist.github.com/ce256e1f88501af4b942  

20 Juin 2012
============

        + Rédaction de la documentation sur le format RST

cf. /doc/documentation/RST  

Je suis en cours de documentation (au format RST) du langage RST.  
Gist temporaire de travail : https://gist.github.com/ce256e1f88501af4b942  

19 Juin 2012
============

        + Rédaction de la documentation sur le format RST

cf. /doc/documentation/RST  

Je suis en cours de documentation (au format RST) du langage RST.  
Gist temporaire de travail : https://gist.github.com/ce256e1f88501af4b942  

18 Juin 2012
============

        + Rédaction de la documentation sur le format RST

cf. /doc/documentation/RST  

Je suis en cours de documentation (au format RST) du langage RST.  
Gist temporaire de travail : https://gist.github.com/ce256e1f88501af4b942  

15 Juin 2012
============

        + Suite & fin de la rédaction de la documentation sur les balises supportées par le format _eZ XML_

cf. /doc/documentation/eZXML/XMLTags  

Suite & fin de la documentation (au format RST) des différentes balises (XML Tags) supportées par un XML block.  
Localisation du fichier : /doc/documentation/eZXML/XMLTags/XML_tags.rst  

        + Rédaction de la documentation sur le format RST

cf. /doc/documentation/RST  

Je suis en cours de documentation (au format RST) du langage RST.  
Gist temporaire de travail : https://gist.github.com/ce256e1f88501af4b942  

14 Juin 2012
============

        + Rédaction de la documentation sur les balises supportées par le format _eZ XML_

cf. /doc/documentation/eZXML/XMLTags  

sources :  
XML tags : http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Reference/XML-tags  

Je suis en cours de documentation (au format RST) des différentes balises (XML Tags) supportées par un XML block.  
Gist temporaire de travail : https://gist.github.com/fc7aacb33a9949dcfffe  


13 Juin 2012
============

        + Suite & fin de la rédaction de la documentation sur le format _eZ XML_

cf. /doc/documentation/eZXML  

Fin de la documentation (au format RST) du XML block.  
Localisation du fichier : /doc/documentation/eZXML/XMLBlock/XML_block.rst  

        + Préparation de l'espace de travail pour le projet

Essai de scripts de test, analyse des erreurs.
cf. /src/project/

12 Juin 2012
============

        + Rédaction de la documentation sur le format _eZ XML_

cf. /doc/documentation/eZXML  

sources :  
XML block : http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Reference/Datatypes/XML-block  
XML tags : http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Reference/XML-tags  

Je suis en cours de documentation (au format RST) du format eZ XML : son balisage, sa manipulation, sa sémentique...  
Gist temporaire de travail : https://gist.github.com/9b401b94fbe6b685edb1  

Découverte du logiciel de conversion de formats Pandoc : http://johnmacfarlane.net/pandoc/index.html  
Approfondissement de la connaissance du format RST : http://docutils.sourceforge.net/docs/user/rst/quickref.html  

11 Juin 2012
============

        + Rédaction du tuto _eZ XML_ de _Document_

cf. /src/tutorial/ezc/Document/eZXML/
cf. /doc/tutorial/Document/Document_eZ_Xml.md

J'ai effectué et rédigé le tutorial concernant la manipulation des fichiers eZ XML et leur transformation en Docbook.
J'ai également appris à transformer certains éléments pour conserver l'information, comme la transformation d'URL par exemple.

D'autre part, j'ai identifié certains problèmes de conversion sémantique.
cf. /doc/tutorial/Document/Document_Conversion.md

08 Juin 2012
============

        + Reprise du tuto _RST_ de _Document_

cf. /src/tutorial/ezc/Document/RST/
cf. /doc/tutorial/Document/Document_RST.md

J'ai effectué et rédigé le tutorial concernant la manipulation des fichiers RST et leur transformation en Docbook & XHTML.
J'ai également appris à ajouter des directives de transformation et à créer des directives d'écriture d'un document XML en RST.

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

