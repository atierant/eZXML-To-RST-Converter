Tutorial du composant _Document_ - Partie eZ XML
================================================

Description
-----------

http://ezcomponents.org/docs/tutorials/Document#ez-xml  
http://ez.no/doc/ez_publish/technical_manual/4_0/reference/xml_tags  

eZ XML décrit le format de balisage utilisé en interne par eZ Publish pour stocker les données balisées dans des objets spécifiques. Le format est (peu) documenté dans la documentation de eZ Publish.  
Les modules étant souvent personnalisés, et non documentés, il pourrait y avoir des éléments qui ne sont pas considérés par défaut.

Suivi du tutorial
-----------------

_01 Lecture d'un eZ XML :_  

La lecture d'un document formaté en eZ XML se fait de la même manière que pour tous les autres formats :  

        <?php
        require_once './src/tutorial/autoload.php';
        
        // The eZ XML string is actually loaded and parsed into an internal abstract syntax tree
        $document = new ezcDocumentEzXml();
        $document->loadString( '<?xml version="1.0"?>
        <section xmlns="http://ez.no/namespaces/ezpublish3">
            <header>Paragraph</header>
            <paragraph>Some content...</paragraph>
        </section>');
        
        // The internal structure is then transformed back to a docbook document
        $docbook = $document->getAsDocbook();
        
        // The resulting document is returned as a string, so that you can echo or store it
        // echo $docbook->save();
        
        // We store it in a new file
        $myDocbookResult = fopen(dirname(__FILE__).'/01_convert_ezxml_docbook_result.xml', 'a+');
        fputs($myDocbookResult, $docbook->save() );
        fclose($myDocbookResult);

cf. résultat dans le fichier _01_convert_ezxml_docbook_result.xml_  

Comme le montre l'exemple ci-dessus, pour convertir en _Docbook_ on peut simplement utiliser la méthode getAsDocbook().  

_02 manipulation des liens présents dans un document eZ XML :_  

A l'intérieur d'un document _eZ XML_, les URI sont remplacées par des _ID_, qui font référence aux liens situés dans la base de données d'eZ Publish, pour s'assurer que les mises à jour des liens impactent toute la structure. Le remplacement de ces liens est géré par une classe héritant de ezcDocumentEzXmlLinkProvider. Par défaut les URL factices sont ajoutées aux documents.  
Les URL sont soit directement référencées par leur _ID_, soit par un _node-ID_, soi par un _object ID_. Ces paramètres sont transmis au fournisseur de lien, qui devrait alors retourner une URL valide.  

Mon fichier au format eZ XML : myEZXMLFile.xml  

        <?xml version="1.0"?>
        <section xmlns="http://ez.no/namespaces/ezpublish3">
            <header>Paragraph</header>
            <paragraph>Some content, with a <link url_id="1">link</link>.</paragraph>
        </section>

Ma classe myAddressElementHandler (héritant de ezcDocumentEzXmlLinkProvider) :  

        <?php
        class myLinkProvider extends ezcDocumentEzXmlLinkProvider
        {
            public function fetchUrlById( $id, $view, $show_path )
            {
                return 'http://host/path/' . $id;
            }
            
            public function fetchUrlByNodeId( $id, $view, $show_path )
            {
            }
            
            public function fetchUrlByObjectId( $id, $view, $show_path )
            {
            }
        }

Le fournisseur de lien est implémenté ici de manière triviale et arbitraire. Dans la réalité, on peut établir une connexion à la base de données d'eZ Publish pour y récupérer les véritables données requises.  

Conversion avec manipulation des liens :  

        <?php

        require_once './src/tutorial/autoload.php';

        // Load My Link Provider
        require dirname(__FILE__).'/MyLinkProvider.php';

        // The document is actually loaded and parsed into an internal abstract syntax tree
        $document = new ezcDocumentEzXml();

        // The document is actually loaded and parsed into an internal abstract syntax tree
        $document->loadFile( dirname(__FILE__).'/myEZXMLFile.xml' );

        // Set link provider
        $converter = new ezcDocumentEzXmlToDocbookConverter();
        $converter->options->linkProvider = new myLinkProvider();

        // The document is converted
        $docbook = $converter->convert( $document );

        // We store it in a new file
        $myDocbookResult = fopen(dirname(__FILE__).'/02_eZXML_link_handling_result.xml', 'a+');
        fputs($myDocbookResult, $docbook->save() );
        fclose($myDocbookResult);

Cet exemple convertit le eZ XML _myEZXMLFile.xml_ ci-dessus en _Docbook_:  

        <?xml version="1.0"?>
        <!DOCTYPE article PUBLIC "-//OASIS//DTD DocBook XML V4.5//EN" "http://www.oasis-open.org/docbook/xml/4.5/docbookx.dtd">
        <article xmlns="http://docbook.org/ns/docbook">
          <section>
            <title>Paragraph</title>
            <para>Some content, with a <ulink url="http://host/path/1">link</ulink>.</para>
          </section>
        </article>

cf. fichier 02_eZXML_link_handling_result.xml  

On notera que le fournisseur de liens est défini comme une option du convertisseur, comme vu dans le chapitre sur les RST. On peut, tout comme dans le convertisseur pour les RST, créer des handlers pour des éléments eZ XML eZ qui ne sont pas encore supportés.  

_03 Ecriture d'un document eZ XML :_  

Pour écrire un fichier _eZ XML_ on utilise un élément de transition _Docbook_ basé sur du XML, comme indiqué plus en détail dans la conversion _Docbook_ vers _RST_. Pour la conversion des liens, on utilise un objet qui hérite de _ezcDocumentEzXmlLinkConverter_. Cet objet retourne un tableau avec les attributs du lien présent dans le document _eZ XML_.  

Mon fichier au format _Docbook_ : _myDocbookFile.xml_  

        <?xml version="1.0"?>
        <!DOCTYPE article PUBLIC "-//OASIS//DTD DocBook XML V4.5//EN" "http://www.oasis-open.org/docbook/xml/4.5/docbookx.dtd">
        <article xmlns="http://docbook.org/ns/docbook">
          <section>
            <title>Paragraph</title>
            <para>Some content, with a <ulink url="http://host/path/1">link</ulink>.</para>
          </section>
        </article>

Plutôt que d'écrire ma propre casse de conversion d'URL j'utilise dans mon exemple une classe existante de fausse conversion d'URL _ezcDocumentEzXmlDummyLinkConverter_ issue du framework _Document_ et héritant de _ezcDocumentEzXmlLinkConverter_.  

Conversion avec manipulation des liens et écriture :  

        <?php

        require_once './src/tutorial/autoload.php';

        // Load My Link Converter if I have had to write my own class
        //require dirname(__FILE__).'/MyLinkConverter.php';

        // Loading the document in Docbook format
        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname(__FILE__).'/myDocbookFile.xml' );

        // Preparing eZ XML File
        $ezXml = new ezcDocumentEzXml();

        // Set link converter
        $converter = new ezcDocumentDocbookToEzXmlConverter();
        
        // Applying the LinkConverter handler's rule, setting <link url_id="23">link</link> instead of the real read ID
        $converter->options->linkConverter = new ezcDocumentEzXmlDummyLinkConverter();

        // The Docbook document is converted
        $ezXml = $converter->convert( $docbook );

        // Transformation in ez xml file
        $ezXml->createFromDocbook( $docbook );
        $result = $ezXml->save();

        // We store it in a new file
        $myEZXmlResult = fopen(dirname(__FILE__).'/03_myEZXmlFile.xml', 'a+');
        fputs($myEZXmlResult, $result );
        fclose($myEZXmlResult);

Cet exemple convertit le _Docbook_ _myDocbookFile.xml_ ci-dessus en _eZ XML_:  

        <?xml version="1.0"?>
        <section xmlns="http://ez.no/namespaces/ezpublish3" xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/">
          <section>
            <header>Paragraph</header>
            <paragraph>Some content, with a <link url_id="23">link</link>.</paragraph>
          </section>
        </section>

cf. fichier _03_myEZXmlFile.xml_


