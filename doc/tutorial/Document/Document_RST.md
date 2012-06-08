Tutorial du composant _Document_ - Partie RST
=============================================

Description
-----------

http://docutils.sourceforge.net/rst.html  
http://fr.wikipedia.org/wiki/ReStructuredText  

ReStructuredText (RST) est un langage de balisage simple et cohérent, destiné à être facile à lire et à écrire par les humains. Des exemples peuvent être trouvés dans la documentation officielle.  

Suivi du tutorial
-----------------

_00_00_Transformation simple et chargement dans un fichier :_  

        Arbre syntaxique abstrait
        
        En informatique, un arbre syntaxique abstrait (abstract syntax tree, ou AST, en anglais) est un arbre dont les nœuds internes sont marqués par des opérateurs et dont les feuilles (ou nœuds externes) représentent les opérandes de ces opérateurs. Autrement dit, généralement, une feuille est une variable ou une constante.
        
        Un arbre syntaxique abstrait est utilisé par un analyseur syntaxique comme un intermédiaire entre un arbre d'analyse et une structure de données. On l'utilise comme la représentation intermédiaire interne d'un programme informatique pendant qu'il est optimisé et à partir duquel la génération de code est effectuée.

Le document est chargé et parsé en un arbre syntaxique abstrait (ou AST, cf. http://fr.wikipedia.org/wiki/Arbre_syntaxique_abstrait).  
Chaque erreur de parsing ou de compilation sera transformée en une exception, de sorte que l'on soit notifié de ces erreurs.  
Les paramètres de rapport d'erreur peuvent être modifiés comme pour tous les handlers.  
La structure est alors convertie au format Docbook (http://www.docbook.org/)  
Le résultat est retourné sous la forme d'une chaine de caractères.  
Nous pouvons alors éventuellement construire un fichier de sortie. cf. 00_00_convert_rst_docbook_result.xml  

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
        $myDocbookResult = fopen(dirname(__FILE__).'/00_00_convert_rst_docbook_result.xml', 'a+');
        fputs($myDocbookResult, $docbook->save() );
        fclose($myDocbookResult);
        
_00_01_Directives personnalisées :_  

Les directives dans les documents RST sont des éléments optionnels pouvant contenir des paramètres, des options (nommées) et du contenu lui aussi optionnel.  
Le composant _Document_ implémente un sous-ensemble de directives issues du parseur de documents docutils (http://docutils.sourceforge.net/).  
On peut mettre en place des handlers de directives personnalisées ou remplacer les handlers existants par une implémentation personnelle.  
Une directive dans un RST contenant des paramètres, des options et du contenu ressemble à:

        My document
        ===========
        The custom directive:
        .. my_directive:: parameters
            :option: value
            Some indented text...
            

Pour cette directive, on doit enregistrer un handler sur le document RST, de la manière suivante :

        <?php
        $document = new ezcDocumentRst();
        $document->registerDirective( 'my_directive', 'myCustomDirective' );
        $document->loadFile( $from );
        $docbook = $document->getAsDocbook();
        $xml = $docbook->save();
        ?>
        

La classe myCustomDirective hérite de la classe ezcDocumentRstDirective, implémente la méthode de toDocbook().  
Lors du traitement, nous avons accès à l'AST, au contenu de la directive actuelle et au chemin où se trouve le document dans le système de fichiers (nécessaire pour accéder à des fichiers externes).  

_Exemple de directive :_


Voici un exemple complet d'une directive personnalisée, où nous voulons intégrer des adresses dans notre document RST tout en maintenant la sémantique dans le docbook généré :  

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
        ?>


