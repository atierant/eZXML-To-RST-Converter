Tutorial du composant _Document_ - Partie RST
=============================================

Description
-----------

http://docutils.sourceforge.net/rst.html  
http://fr.wikipedia.org/wiki/ReStructuredText  

ReStructuredText (RST) est un langage de balisage simple et cohérent, destiné à être facile à lire et à écrire par les humains. Des exemples peuvent être trouvés dans la documentation officielle.  

Suivi du tutorial
-----------------

_01 Transformation simple et chargement dans un fichier :_  

        Arbre syntaxique abstrait
        
        En informatique, un arbre syntaxique abstrait (abstract syntax tree, ou AST, en anglais) est un arbre dont les nœuds internes sont marqués par des opérateurs et dont les feuilles (ou nœuds externes) représentent les opérandes de ces opérateurs. Autrement dit, généralement, une feuille est une variable ou une constante.
        
        Un arbre syntaxique abstrait est utilisé par un analyseur syntaxique comme un intermédiaire entre un arbre d'analyse et une structure de données. On l'utilise comme la représentation intermédiaire interne d'un programme informatique pendant qu'il est optimisé et à partir duquel la génération de code est effectuée.

Le document est chargé et parsé en un arbre syntaxique abstrait (ou AST, cf. http://fr.wikipedia.org/wiki/Arbre_syntaxique_abstrait).  
Chaque erreur de parsing ou de compilation sera transformée en une exception, de sorte que l'on soit notifié de ces erreurs.  
Les paramètres de rapport d'erreur peuvent être modifiés comme pour tous les handlers.  
La structure est alors convertie au format Docbook (http://www.docbook.org/)  
Le résultat est retourné sous la forme d'une chaine de caractères.  
Nous pouvons alors éventuellement construire un fichier de sortie, cf. 01_convert_rst_docbook_result.xml  

        <?php
        require_once './src/tutorial/autoload.php';

        // The document is actually loaded and parsed into an internal abstract syntax tree
        $document = new ezcDocumentRst();

        // Each parsing or compiling error will be transformed into an exception, so that you are noticed about those errors. The error reporting settings can be modified like for all other document handlers
        $document->options->errorReporting = E_PARSE | E_ERROR | E_WARNING;

        $document->loadFile( dirname(__FILE__).'/rst_base_handler.txt' );

        // The internal structure is then transformed back to a docbook document
        $docbook = $document->getAsDocbook();

        // The resulting document is returned as a string, so that you can echo or store it
        // echo $docbook->save();

        // We store it in a new file
        $myDocbookResult = fopen(dirname(__FILE__).'/01_convert_rst_docbook_result.xml', 'a+');
        fputs($myDocbookResult, $docbook->save() );
        fclose($myDocbookResult);

_02 Directives personnalisées :_  

Les directives dans les documents RST sont des éléments optionnels pouvant contenir des paramètres, des options (nommées) et du contenu lui aussi optionnel.  
Le composant _Document_ implémente un sous-ensemble de directives issues du parseur de documents docutils (http://docutils.sourceforge.net/).  
On peut mettre en place des handlers de directives personnalisées ou remplacer les handlers existants par une implémentation personnelle.  
Une directive dans un RST contenant des paramètres, des options et du contenu ressemble à :  

        My document
        ===========
        The custom directive:
        .. my_directive::parameters
            :option:value
            Some indented text...

Pour cette directive, on doit enregistrer un handler sur le document RST, de la manière suivante :  

        <?php
        require_once './src/tutorial/autoload.php';
        
        // Load custom directive
        require dirname(__FILE__).'/AddressDirective.php';
        
        $document = new ezcDocumentRst();
        
        // Registering of the directive located in the class myAddressDirective (extending ezcDocumentRstDirective) of the file AddressDirective.php
        $document->registerDirective( 'address', 'myAddressDirective' );
        
        // Loading and parsing of the document into an internal abstract syntax tree, following the previous directives
        $document->loadFile( dirname(__FILE__).'/RST_adress_directive.txt');
        
        // The internal structure is then transformed back to a docbook document
        $docbook = $document->getAsDocbook();
        
        // The resulting document is returned as a string, so that you can echo or store it
        echo $docbook->save();

cf. résultat dans le fichier 02_convert_with_directives_rst_docbook_result.xml  

La classe myCustomDirective hérite de la classe ezcDocumentRstDirective, implémente la méthode de toDocbook().  
Lors du traitement, nous avons accès à l'AST, au contenu de la directive actuelle et au chemin où se trouve le document dans le système de fichiers (nécessaire pour accéder à des fichiers externes).  

_03 Exemple concret de directives :_  

Voici un exemple complet d'une directive personnalisée. Nous voulons analyser des adresses dans notre document RST tout en maintenant la sémantique dans le docbook généré. Voici le fichier RST que l'on fournit :  

        Address example
        ===============
        
        .. address:: John Doe
            :street: Some Lane 42

La directive implémentée prend ces informations et les transforme en un docbook XML valide en utilisant l'extension DOM.  

        <?php
        class myAddressDirective extends ezcDocumentRstDirective
        {
            public function toDocbook( DOMDocument $document, DOMElement $root )
            {
                $address = $document->createElement( 'address' );
                $root->appendChild( $address );
                if ( !empty( $this->node->parameters ) )
                {
                    $name = $document->createElement( 'personname', htmlspecialchars( $this->node->parameters ) );
                    $address->appendChild( $name );
                }
                if ( isset( $this->node->options['street'] ) )
                {
                    $street = $document->createElement( 'street', htmlspecialchars( $this->node->options['street'] ) );
                    $address->appendChild( $street );
                }
            }
        }

Le nœud AST généré est passé au constructeur de la classe qui visite la directive personnalisée. Il est disponible dans la propriété de la classe $node. Le document DOM complet et le nœud DOM courant sont transmis à la méthode.  
Dans notre cas, nous créons un nœud _adress_ avec les noeuds enfants facultatifs _street_ et _personname_, en fonction de l'existence des valeurs respectives. Après avoir mis en place la directive personnalisée et son handler, on traite le document RST :

        <?php

        require_once './src/tutorial/autoload.php';

        // Load custom directive
        require dirname(__FILE__).'/AddressDirective.php';

        $document = new ezcDocumentRst();

        // Registering of the directive located in the class myAddressDirective (extending ezcDocumentRstDirective) of the file AddressDirective.php
        $document->registerDirective( 'address', 'myAddressDirective' );

        // Loading and parsing of the document into an internal abstract syntax tree, following the previous directives
        $document->loadFile( dirname(__FILE__).'/RST_adress_directive.txt');

        // The internal structure is then transformed back to a docbook document
        $docbook = $document->getAsDocbook();

        // The resulting document is returned as a string, so that you can echo or store it
        // echo $docbook->save();

        // We store it in a new file
        $myDocbookResult = fopen(dirname(__FILE__).'/03_convert_with_directive_rst_docbook_result.xml', 'a+');
        fputs($myDocbookResult, $docbook->save() );
        fclose($myDocbookResult);

Le document de sortie généré :

        <?xml version="1.0"?>
        <article xmlns="http://docbook.org/ns/docbook">
          <section id="address_example">
            <sectioninfo/>
            <title>Address example</title>
            <address>
              <personname> John Doe</personname>
              <street> Some Lane 42</street>
            </address>
          </section>
        </article>
        
cf. résultat dans le fichier 03_convert_with_directive_rst_docbook_result.xml  

_04_Rendu XHTML :_  

Un raccourci de conversion d'un RST en XHTML a été implémenté, de sorte à ne pas avoir besoin de convertir le RST en Docbook puis le Docbook en XHTML. Cela économise du temps de conversion et permet d'empêcher la perte d'informations pendant les conversions multiples:

        <?php
        require_once './src/tutorial/autoload.php';
        $document = new ezcDocumentRst();
        $document->loadFile( dirname(__FILE__).'/rst_document.rst' );

        // The internal structure is then transformed to a xhtml document
        $xhtml = $document->getAsXhtml();
        $xml = $xhtml->save();

cf. résultat dans le fichier 04_convert_rst_to_xhtml.html  

_05_Rendu XHTML + Header :_  

On remarquera l'en-tête du fichier précédemment généré :

        <head>
            <meta content="eZ Components; http://ezcomponents.org" name="generator">
            <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
            <style type="text/css">
            <title>eZ Components - Document</title>
            <meta content="" name="literal">
            <meta content="" name="literal">
        </head>

Le compilateur XHTML par défaut génère des documents XHTML complets, y compris l'en-tête et les méta-données qui s'y trouvent. On peut spécifier un autre compilateur XHTML pour un rendu différent, juste le corps par exemple, ce qui crée tout simplement un élément XHTML block-level, qui peut être intégré dans un code source.

        <?php
        require_once './src/tutorial/autoload.php';
        $document = new ezcDocumentRst();

        // Specify that we only want an in-line xhtml block.
        $document->options->xhtmlVisitor = 'ezcDocumentRstXhtmlBodyVisitor';

        $document->loadFile( dirname(__FILE__).'/rst_document.rst' );

        // The internal structure is then transformed to a xhtml document
        $xhtml = $document->getAsXhtml();
        $xml = $xhtml->save();
        
cf. résultat dans le fichier 05_convert_rst_to_xhtml_block.html  

Il est également possible d'utiliser les directives prédéfinies et personnalisées pour le rendu XHTML. Les directives utilisées lors de la génération du XHTML doivent implémenter l'interface ezcDocumentRstXhtmlDirective (http://ezcomponents.org/docs/api/trunk/Document/ezcDocumentRstXhtmlDirective.html)



