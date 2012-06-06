ezcDocumentEzXmlToRstConverter
==============================

Principe de base
================

Un fichier d'un langage de balisage particulier est transformé en un autre langage de balisage.  
Pour ce faire, nous avons dans les eZ Components un composant particulier, "Document", qui permet de réaliser diverses opérations sur les langages balisés, donc cette conversion.  
- [ToDo]

Problématique
=============

Dans les ezcDocument, il n'y a pas de convertisseur de eZXML en ReStructuredText, pas non plus de convertisseur de ReStructuredText en eZXML.  
Nous voulons créer une classe de conversion contenant deux méthodes :  
        + une méthode qui transforme un eZXML en Rst,    
        + une autre qui transforme un Rst en eZXML.    

Nous voulons également deux scripts indépendants pour la conversion des formats :  
        + un script ezxml2rst.php,    
        + un script rst2ezxml.php.  

On part avec l'avantage d'avoir les deux langages qui sont disponibles (ezcDocumentRst pour le format ReStructuredText et ezcDocumentEzXml pour le format eZXML)  
Nous avons à notre disposition d'autres convertisseurs similaires, héritant de ezcDocumentConverter.  

Un exemple de convertisseur existant :  
exemple : http://ezcomponents.org/docs/api/trunk/Document/ezcDocumentDocbookToRstConverter.html  
ezcDocumentDocbookToRstConverter est une classe du composant Document des eZ Components.  
La responsabilité de la classe ezcDocumentDocbookToRstConverter est de convertir un document au format Docbook en un document au format ReStructuredText. En prenant cette classe comme exemple, nous allons créer un ezcDocumentEzXmlToRstConverter.  
La classe ezcDocumentEzXmlToRstConverter demandée doit convertir un document au format eZXML en un document au format ReStructuredText et réciproquement.  

________________________________________________

Objectifs de réalisations & Contraintes
=======================================

- Concernant la classe :  
Les conversions doivent être symétriques (A -> B -> A). Probablement délicat.  

- Initialement, nous réaliserons un commit pour les composants histoire de conserver une base saine.  
Après seulement, nous pourrons réaliser des commits de notre propre code.  

- l'arborescence du dépôt doit être :  
        eZXML-To-RST-Converter  
            ./src  
            ./test  
            ./doc  
            ./lib   

Dans ./lib nous y mettrons le composant Base et le composant Document des eZ Components.  

/!\ AMBIGUITE DES PROPOS. [ToDo]  
Dans ./lib également : "Une classe, deux méthodes". Avec cette classe, nous ferons un script qui transforme un eZXML en RST et un autre qui transforme un RST en eZXML.  
La classe doit être située dans ./eZXML-To-RST-Converter/src/  

Le code doit n'utiliser que les composants situés dans ./lib, comme si les ezc n'étaient pas installés sur la machine.  

Concernant nos développements, ils doivent se situer dans ./src/, pas besoin de dossier lib/ dans ./src/, les composants étant situés dans ./lib/ comme vu précédemment.  

Nous ne mettrons bien sur pas d'autoload dans le fichier de la classe. Celle-ci doit être bien indépendante (bien que dépendante des classes qui seront considérées toujours comme chargée). La classe n'a pas à savoir où se trouvent les autres composants.  

- Concernant les tests :  
Nous réaliserons des classes de test associées à notre classe, afin de vérifier unitairement ses méthodes.  
Lorsque nous attaquerons les tests, nous ferons un phpunit.xml à la racine du dossier.  
Les éventuels fichiers pour les tests doivent être dans le dossier test, comme dans le projet xmi2code : https://github.com/charlycoste/xmi2code/tree/e78c5d7157127680d02f74288fd28ccca9eedad6/test  

- Objectif secondaire :  
Nous aurons également un objectif secondaire : réaliser rst2pdf.php. Il faudra également un rapport quotidien. Nous commencerons l'objectif secondaire après avoir commencé l'objectif principal et bien cerné les problématiques initiales.

Mode opératoire
===============
On fonctionnera en x temps : d'abord ..., puis ensuite ....

Repository du projet
====================
https://github.com/atierant/eZXML-To-RST-Converter

__________________________________________________________________________________

Documentation
=============

Documentation sur les langages de balisage
------------------------------------------
http://fr.wikipedia.org/wiki/Langage_de_balisage

Documentation sur le langage de balisage eZXML
-----------------------------------------------
http://ezcomponents.org/docs/tutorials/Document#ez-xml  
http://ez.no/doc/ez_publish/technical_manual/4_0/reference/xml_tags  

eZ XML décrit le format de balisage utilisé en interne par eZ Publish pour stocker les données balisées dans des objets spécifiques. Le format est (peu) documenté dans la documentation de eZ Publish.  
Les modules étant souvent personnalisés, et non documentés, donc il pourrait y avoir plusieurs éléments ne sont pas considérés par défaut.

Documentation sur le langage de balisage ReStructuredText
---------------------------------------------------------
http://docutils.sourceforge.net/rst.html  
http://fr.wikipedia.org/wiki/ReStructuredText  

ReStructuredText (RST) est un langage de balisage simple et cohérent, destiné à être facile à lire et à écrire par les humains. Des exemples peuvent être trouvés dans la documentation officielle.

Documentation de Document :
---------------------------
http://ezcomponents.org/docs/api/latest/introduction_Document.html  

Documentation de la partie conversion
-------------------------------------
http://ezcomponents.org/docs/api/trunk/Document_conversion.html  

Documentation sur la classe générique ezcDocumentConverter
----------------------------------------------------------
http://ezcomponents.org/docs/api/trunk/Document/ezcDocumentConverter.html  

A base class for document type converters

Documentation sur la classe de conversion ezcDocumentElementVisitorConverter
----------------------------------------------------------------------------
http://ezcomponents.org/docs/api/trunk/Document/ezcDocumentElementVisitorConverter.html  

Basic converter which stores a list of handlers for each node in the docbook element tree. Those handlers will be executed for the elements, when found.  
The handler can then handle the repective subtree.  
Additional handlers may be added by the user to the converter class.  

Documentation sur une classe de conversion prise en exemple : ezcDocumentDocbookToRstConverter
----------------------------------------------------------------------------------------------
http://ezcomponents.org/docs/api/trunk/Document/ezcDocumentDocbookToRstConverter.html  

Convertisseur Docbook en RST basé sur un mécanisme de callback PHP, pour des transformations extensibles rapides et faciles basées sur php.
Ce convertisseur ne prend pas pleinement en charge la norme Docbook, mais seulement un sous-ensemble couramment utilisé dans le composant Document. S'il y a besoin de transformer pleinement des documents Docbook, le site préconise d''utiliser le ezcDocumentDocbookToRstXsltConverter avec la feuille de style par défaut.


Notes de documentation :
------------------------
_note_1_  
Desc_1 : http://url_1

-------------------------------
_note_2_  
Desc_2 : http://url_2

________________________________


Commentaires sur les classes existantes :
-----------------------------------------

1. Notre classe ezcDocumentEzXmlToRstConverter
----------------------------------------------
- Classe située dans ./lib/ezc/Document/options/converter_ezxml_rst.php
- Avec quoi la peupler au vu de ce qui a été observé sur les classes précédentes ?
- Qu'est-ce qui est pertinent ?
- Qu'est-ce qu'il est possible d'obtenir via xxxx
- Qu'est-ce qu'il est possible d'obtenir via yyyyy
- QUESTION XXXX

-----------------------------------

To Do :
-------

1. Premièrement, prise de connaissance du composant Document.

2. Documenter l'existant :
    + Définitions et explication des langages de balisage
    + Principe du composant Document
    + Langages de balisage pris en charge dans le composant Document
    + Documentation des classes de conversion existantes

3. Doc & Mise en place de notre classe : ses principes, son héritage, ses composants

4. Documentation & mise en place de nos deux scripts indépendants :
    + un script ezxml2rst.php,
    + un script rst2ezxml.php.

4. Mise en place des classes de test associées.

- De manière régulière (tous les soirs), envoyer un commit contenant :
    + ce qui a été analysé & compris, au format Flavored Markdown.
    + le code produit.
