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

_04 Rendu XHTML :_  

Un raccourci de conversion d'un RST en XHTML a été implémenté, de sorte à ne pas avoir besoin de convertir le RST en Docbook puis le Docbook en XHTML. Cela économise du temps de conversion et permet d'empêcher la perte d'informations pendant les conversions multiples :  

        <?php
        require_once './src/tutorial/autoload.php';
        $document = new ezcDocumentRst();
        $document->loadFile( dirname(__FILE__).'/rst_document.rst' );

        // The internal structure is then transformed to a xhtml document
        $xhtml = $document->getAsXhtml();
        $xml = $xhtml->save();

cf. résultat dans le fichier 04_convert_rst_to_xhtml.html  

_05 Rendu XHTML + Header :_  

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

_06 Modification du rendu XHTML :_  

Il est possible de modifier la sortie générée du visiteur XHTML en créant une classe visiteur personnalisée pour l'AST du RST. La façon la plus simple est probablement d'hériter de l'un des visiteurs XHTML existants et de le réutiliser. Par exemple, on peut corriger l'attribut _'type'_ dans les listes à puces, comme en HTML, attribut qui n'est pas valide en XHTML. On procèdera de la manière suivante :  

        class myDocumentRstXhtmlVisitor extends ezcDocumentRstXhtmlVisitor
        {
            protected function visitBulletList( DOMNode $root, ezcDocumentRstNode $node )
            {
                $list = $this->document->createElement( 'ul' );
                $root->appendChild( $list );

                $listTypes = array(
                    '*'            => 'circle',
                    '+'            => 'disc',
                    '-'            => 'square',
                    "\xe2\x80\xa2" => 'disc',
                    "\xe2\x80\xa3" => 'circle',
                    "\xe2\x81\x83" => 'square',
                );
                // Not allowed in XHTML strict
                $list->setAttribute( 'type', $listTypes[$node->token->content] );

                // Decoratre blockquote contents
                foreach ( $node->nodes as $child )
                {
                    $this->visitNode( $list, $child );
                }
            }
        }

La structure, non adaptée pour les visiteurs standards mais utilisée dans les visiteurs docbook et XHTML, appelle des méthodes spéciales pour chaque type de nœud dans l'AST pour _décorer_ l'AST de manière récursive. La méthode visitBulletList() sera appelée pour tous les nœuds de type _liste à puces_ dans l'AST qui contient les éléments de cette liste. La position courante dans l'arbre DOM XHTML est passée en paramètres de la méthode.  

Pour créer le XHTML, nous créons un nouveau nœud (nouvelle liste (\<ul\>)) dans le DOMNode actuel, on définit le nouvel attribut, et on décore récursivement tous les descendants de ce nœud en utilisant la méthode générale visitNode() pour tous les enfants dans l'AST.  
Pour que les enfants dans l'AST soient également rendus comme des enfants dans l'arbre XML, nous passons le DOMNode que nous venons de créer (\<ul\>) en tant que nouveau nœud racine en paramètres de la méthode visitNode().  

Une fois cette nouvelle classe définie, nous pouvons utiliser le visiteur personnalisé comme indiqué ci-après :  

        <?php
        require_once './src/tutorial/autoload.php';
        $document = new ezcDocumentRst();

        // Load custom Visitor
        require dirname(__FILE__).'/myDocumentRstXhtmlVisitor.php';

        // We define the option xhtmlVisitor with our new visitor class
        $document->options->xhtmlVisitor = 'myDocumentRstXhtmlVisitor';

        $document->loadFile( dirname(__FILE__).'/rst_document.rst' );
        $xhtml = $document->getAsXhtml();
        $xml = $xhtml->save();

Les listes présentes dans le XHTML généré auront alors l'attribut _'type'_ défini.  
cf. résultat dans le fichier 06_convert_rst_to_modified_xhtml.html  

_07 Ecriture d'un document RST :_  

La rédaction d'un document de RST à partir d'un document DocBook existant, ou un objet ezcDocumentDocbook généré à partir d'une autre source, est triviale :

        <?php
        require_once './src/tutorial/autoload.php';

        // Loading the document in Docbook format
        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname(__FILE__).'/docbook.xml' );

        // Converting to RST
        $rst = new ezcDocumentRst();
        $rst->createFromDocbook( $docbook );
        $result = $rst->save();
        
cf. résultat dans le fichier 07_writing_rst.rst  

La classe ezcDocumentDocbookToRstConverter est utilisée pour la conversion en interne. Elle peut également être appelée directement :  

        $converter = new ezcDocumentDocbookToRstConverter();
        $rst = $converter->convert( $docbook );

En utilisant cette classe, on peut configurer le convertisseur à notre guise, ou hériter du convertisseur pour gérer les éléments docbook encore non gérés. Le convertisseur est configuré en utilisant sa propriété option. Les options sont définies dans la classe ezcDocumentDocbookToRstConverterOptions. Nous pouvons par exemple configurer l'en-tête utilisée, les types de listes à puces ou le retour à la ligne.  

_08 Etendre l'écriture d'un document RST :_  

Comme dit précédemment, tous les éléments docbook existants ne sont pas encore manipulés par le convertisseur. Mais son mécanisme  basé sur les handlers permet d'étendre ou de remplacer facilement le comportement existant.  
Reprenons l'exemple précédent sur les adresses. Nous pouvons convertir l'élément docbook <adresse> selon la directive RST inverse _adresse_.

Mon fichier adress.xml

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

Ma classe myAddressElementHandler

        <?php
        class myAddressElementHandler extends ezcDocumentDocbookToRstBaseHandler
        {
            public function handle( ezcDocumentElementVisitorConverter $converter, DOMElement $node, $root )
            {
                $root .= $this->renderDirective( 'address', $node->textContent, array() );
                return $root;
            }
        }

Conversion :

        <?php
        require_once './src/tutorial/autoload.php';

        // Loading the document in Docbook format
        $docbook = new ezcDocumentDocbook();
        $docbook->loadFile( dirname(__FILE__).'/address.xml' );

        // Load custom AddressElementHandler
        require dirname(__FILE__).'/myAddressElementHandler.php';

        // Converting to RST
        $rst = new ezcDocumentRst();

        // Creating the handler
        $converter = new ezcDocumentDocbookToRstConverter();
        $converter->setElementHandler( 'docbook', 'address', new myAddressElementHandler() );

        $rst = $converter->convert( $docbook );
        $result = $rst->save();

Les handlers sont affectés à des éléments XML dans certains espaces de noms, "docbook" dans notre cas. On voit la déclaration de cet espace de noms à la ligne suivante :  

        $converter->setElementHandler( 'docbook', 'address', new myAddressElementHandler() );  

La classe doit hériter de la classe ezcDocumentElementVisitorHandler, classe dont hérite déjà ezcDocumentDocbookToRstBaseHandler, qui fournit des méthodes pratiques pour la création de RST, comme renderDirective() utilisée dans notre exemple.  

Le gestionnaire est appelé dès que l'élément est trouvé dans l'arbre XML DocBook. Dans ce cas, il ajoute au document RST la partie RST générée pour cet élément et peut appeler le handler de conversion général à nouveau pour ses éléments enfants.  

Cet exemple convertit le Docbook XML _adress.xml_ ci-dessus en :  

        ===============
        Address example
        ===============

        .. address:: 
               John Doe
               Some Lane 42

Rendu RST (cf. fichier 08_writing_extended_rst.rst)
