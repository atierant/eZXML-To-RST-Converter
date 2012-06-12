Le datatype _XML block_ d'_eZ Publish_
======================================

Résumé
------

Valide et stocke plusieurs lignes de texte formaté.

Description
-----------

Bien qu'il n'existe pas de signes visuels immédiats, le datatype _XML block_ d'_eZ Publish_ se comporte différemment par rapport aux datatypes "text block" classiques. En particulier, il est capable de valider et de stocker plusieurs lignes de texte *formaté*, au lieu de texte simple. Le texte dans un _XML block_ doit être formaté en utilisant une collection de balises prédéfinies. Ces balises contrôlent le balisage HTML du contenu. _eZ Publish_ est livré avec une collection de balises qui couvrent les besoins classiques. En outre, il est également possible d'étendre le système de balisage en créant des balises personnalisées pour les besoins spéciaux.

Le signe "<" signifie le début d'une balise XML. Si on besoin d'insérer un signe "<" dans le texte (par exemple, "3 \< 5"), on doit utiliser l''entité correspondante XML \&lt;.

        3\&lt;5

Depuis la version 3.9 d'_eZ Publish_, il est possible d'entrer directement les entités numériques et les traduire en leur caractère/symbole correspondant lors du rendu du texte. Pour que cela fonctionne, on doit activer l'option de configuration "_AllowNumericEntities_" dans le bloc [InputSettings] " d'un override du fichier _ezxml.ini_.

Par défaut, le datatype prend en charge les balises XML suivantes: 

        Headings
        Bold text
        Italic text
        Unformatted text
        Lists
        Tables
        Hyperlinks
        Anchors
        Object embedding
        Custom tags
        Paragraphs


